<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */


class InstantPaymentNotification {

    const TABLE = '#__smartorder_paypal_ipn';

    const STATUS_PENDING = 'pending';        // waits to be verified by paypal
    const STATUS_VERIFIED = 'verified';      // paypal verified
    const STATUS_INVALID = 'invalid';        // paypal rejected
    const STATUS_FRAUD = 'fraud';            // smartorder rejected
    const STATUS_DUPLICATE = 'duplicate';    // duplicate of a closed TX
    const STATUS_CLOSED = 'closed';          // successful TX

    const PAYMENT_STATUS_COMPLETED = 'Completed';

    private $id;
    private $datetime;
    private $ip;
    private $txn_id;
    private $payer_email;
    private $payer_id;
    private $first_name;
    private $last_name;
    private $mc_gross;
    private $raw;
    private $payment_status;
    private $status;
    private $comment;

    public function init() {
        if (!$this->isSaved()) {
            $this->datetime = new DateTime();
            $this->ip = $_SERVER['REMOTE_ADDR'];
            $this->status = self::STATUS_PENDING;
        }
    }

    public function getId() {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getDatetime() {
        return $this->datetime;
    }

    public function getIp() {
        return $this->ip;
    }

    public function getTxnId() {
        return $this->txn_id;
    }

    public function getPayerEmail() {
        return $this->payer_email;
    }

    public function getPayerId() {
        return $this->payer_id;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function getMcGross() {
        return $this->mc_gross;
    }

    public function getPaymentStatus() {
        return $this->payment_status;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getComment() {
        return $this->comment;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function isSaved() {
        return !empty($this->id);
    }

    public function getRawData() {
        return json_decode($this->raw, true);
    }

    public function setRawData($data) {
        $this->raw = json_encode($data);
    }

    public function isPending() {
        return $this->status == self::STATUS_PENDING;
    }

    public function isVerified() {
        return $this->status == self::STATUS_VERIFIED
            || $this->status == self::STATUS_FRAUD
            || $this->status == self::STATUS_DUPLICATE
            || $this->status == self::STATUS_CLOSED;
    }

    public function isInvalid() {
        return $this->status == self::STATUS_INVALID;
    }

    public function isFraud() {
        return $this->status == self::STATUS_FRAUD;
    }

    public function isDuplicate() {
        return $this->status == self::STATUS_DUPLICATE;
    }

    public function isClosed() {
        return $this->status == self::STATUS_CLOSED;
    }

    public function isPaymentCompleted() {
        return $this->payment_status == self::PAYMENT_STATUS_COMPLETED;
    }

    public function approve(PayPalSettings $settings, array $data = null) {
        if ($this->isSaved()) {
            throw new Exception('Only unsaved notifications can be approved.');
        }
        if ($data === null) {
            $data = $_POST;
        }
        $this->fill($data);
        $this->save();
        if (!$this->verify($settings)) {
            $this->setComment('PayPal did not verify this notification.');
            $this->save();
            return;
        }
        if (!$this->checkMerchant($settings->getBusiness())) {
            $this->status = self::STATUS_FRAUD;
            $this->setComment('Business mismatch.');
            $this->save();
            return;
        }
        $order = $this->getOrder();
        if (empty($order)) {
            $this->status = self::STATUS_FRAUD;
            $this->setComment('Order not foud.');
            $this->save();
            return;
        }
        if (!$this->checkOrder($order)) {
            $this->status = self::STATUS_FRAUD;
            $this->setComment('Order details do not match.');
            $this->save();
            return;
        }
        foreach ($this->getDuplicates() as $duplicate) {
            if ($duplicate instanceof InstantPaymentNotification && $duplicate->isClosed()) {
                $this->status = self::STATUS_DUPLICATE;
                $this->setComment('Duplicate transaction.');
                $this->save();
                return;
            }
        }
        if (!$this->isPaymentCompleted()) {
            $this->setComment('Payment not completed.');
            $this->save();
            return;
        }
        $this->setComment('Approved: '.$order->getId());
        $this->close();
        $this->save();
    }

    public function verify(PayPalSettings $settings) {
        if (!$this->isSaved()) {
            throw new Exception('This notification has not been stored yet.');
        }
        if (!$this->isPending()) {
            throw new Exception('This notification has been already verified before.');
        }
        $uri = Zend_Uri::factory(PayPal::SCHEME);
        $uri->setHost($settings->isSandboxMode() ? PayPal::HOST_DEVELOPMENT : PayPal::HOST_PRODUCTION);
        $uri->setPort(PayPal::PORT);
        $uri->setPath(PayPal::PATH);
        $client = new Zend_Http_Client($uri, array(
            'adapter' => 'Zend_Http_Client_Adapter_Socket',
            'httpversion' => '1.0',
            'ssltransport' => 'ssl'
        ));
        $client->setMethod(Zend_Http_Client::POST);
        $client->setParameterPost('cmd', '_notify-validate');
        foreach ($this->getRawData() as $key => $value) {
            $client->setParameterPost($key, $value);
        }
        $client->request();
        $lastResponse = $client->getLastResponse();
        if ($lastResponse instanceof Zend_Http_Response && $lastResponse->isSuccessful()) {
            $response = $lastResponse->getBody();
            switch (strtolower($response)) {
                case self::STATUS_VERIFIED:
                    $this->status = self::STATUS_VERIFIED;
                    break;
                case self::STATUS_INVALID:
                    $this->status = self::STATUS_INVALID;
                    break;
                default:
            }
        }
        return $this->isVerified();
    }

    public function getDuplicates() {
        if (empty($this->txn_id)) {
            throw new Exception('Unable to find duplicates: no transaction ID available.');
        }
        $db = JFactory::getDBO();
        return $db->setQuery(sprintf('SELECT * FROM %s WHERE txn_id LIKE %s', self::TABLE, $db->quote($this->txn_id)))->loadObjectList('', get_class());
    }

    public function getOrder() {
        $data = $this->getRawData();
        if (!array_key_exists('custom', $data)) {
            return null;
        }
        return Order::load(intval($data['custom']));
    }

    public function checkOrder(Order $order) {
        $data = $this->getRawData();
        return $order->getTotalGrossIncludingShipping() != floatval($data['mc_gross']);
    }

    public function checkMerchant($business) {
        $data = $this->getRawData();
        $businessMatches = array_key_exists('business', $data) && $data['business'] == $business;
        $idMatches = array_key_exists('receiver_id', $data) && $data['receiver_id'] == $business;
        $emailMatches = array_key_exists('receiver_email', $data) && $data['receiver_email'] == $business;
        return $businessMatches || $idMatches || $emailMatches;
    }

    public function fill(array $data) {
        $filtered = array();
        foreach ($data as $key => $value) {
            $filtered[$key] = stripslashes($value);
        }
        $this->setRawData($filtered);
        $colData = array_intersect_key($filtered, get_object_vars($this));
        unset($colData['datetime']);
        unset($colData['ip']);
        unset($colData['raw']);
        unset($colData['status']);
        unset($colData['comment']);
        foreach ($colData as $key => $value) {
            $this->$key = $value;
        }
    }

    public function save() {
        $db = JFactory::getDBO();
        if ($this->isSaved()) {
            $updates = array();
            foreach (get_object_vars($this) as $column => $value) {
                if ($value instanceof  DateTime) {
                    $value = $value->format('Y-m-d H:i:s');
                }
                $updates[] = sprintf('%s=%s', $column, $db->quote($value));
            }
            $db->setQuery(sprintf('UPDATE %s SET %s WHERE id = %d', self::TABLE, implode(',', $updates), $this->id));
            $db->query();
        } else {
            $columns = array();
            $values = array();
            foreach (get_object_vars($this) as $column => $value) {
                if ($value instanceof  DateTime) {
                    $value = $value->format('Y-m-d H:i:s');
                }
                $columns[] = $column;
                $values[] = $db->quote($value);
            }
            $db->setQuery(sprintf('INSERT INTO %s (%s) VALUES (%s)', self::TABLE, implode(',', $columns), implode(',', $values)));
            $db->query();
            $this->id = $db->insertid();
        }
    }

    public function close() {
        if (!$this->isVerified()) {
            throw new Exception('Only verified notifications can be closed.');
        }
        $this->status = self::STATUS_CLOSED;
    }

    public static function findValid($txnId) {
        if (empty($txnId)) {
            throw new Exception('txnId is empty.');
        }
        $db = JFactory::getDBO();
        return $db->setQuery(sprintf('SELECT * FROM %s WHERE txn_id = %d AND payment_status = %s AND status = %s',
                self::TABLE,
                $db->quote($txnId),
                $db->quote(self::PAYMENT_STATUS_COMPLETED),
                $db->quote(self::STATUS_CLOSED)))->loadObject(get_class());
    }
}