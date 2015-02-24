<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */


class Order {

    private $id;
    private $datetime;
    private $status;
    private $user_id;
    private $user_name;
    private $user_email;
    private $user_address;
    private $user_phone;
    private $user_note;
    private $shipping_costs;

    /**
     * @var array
     */
    private $basketGroups;

    /**
     * @var OrderStatus
     */
    private $statusInstance;

    public function init() {
        if (!empty($this->id)) {
            $this->loadDetails();
            $this->loadStatusInstance();
        }
    }

    public function getId() {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getDatetime() {
        return new DateTime($this->datetime);
    }

    /**
     * @return OrderStatus
     */
    public function getStatus() {
        return $this->statusInstance;
    }

    public function isInStatus($statusName) {
        return $this->getStatus()->getName() === $statusName;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getUserName() {
        return $this->user_name;
    }

    public function getUserEmail() {
        return $this->user_email;
    }

    public function getUserAddress() {
        return $this->user_address;
    }

    public function getUserPhone() {
        return $this->user_phone;
    }

    public function getUserNote() {
        return $this->user_note;
    }

    public function getBasketGroups() {
        return $this->basketGroups;
    }

    public function getShippingCosts() {
        return round($this->shipping_costs, 2);
    }

    public function getTotalGross() {
        $total = 0;
        foreach ($this->basketGroups as $group) {
            foreach ($group as $detail) {
                if ($detail instanceof OrderDetail) {
                    $total += $detail->getTotalGross();
                }
            }
        }
        return $total;
    }

    public function getTotalGrossIncludingShipping() {
        return $this->getTotalGross() + $this->getShippingCosts();
    }

    public function setShippingCosts($shipping_costs) {
        $this->shipping_costs = $shipping_costs;
    }

    public function updateStatus($newStatus) {
        $db = JFactory::getDBO();
        $status = $db->setQuery('SELECT * FROM #__smartorder_orders_status WHERE name LIKE '.$db->quote($newStatus))->loadObject('OrderStatus');
        if ($status == null) {
            throw new Exception('No status with name: '.$newStatus);
        }
        $db->setQuery(sprintf('UPDATE #__smartorder_orders SET status = %d WHERE id = %d', $status->getId(), $this->getId()));
        $db->query();
    }

    private function loadDetails() {
        $this->basketGroups = array();
        $db = JFactory::getDBO();
        $details = $db->setQuery(sprintf('SELECT * FROM #__smartorder_orders_details WHERE order_id = %d ORDER BY basketgroup ASC, type ASC', $this->getId()))->loadObjectList('', 'OrderDetail');
        foreach ($details as $detail) {
            if ($detail instanceof OrderDetail) {
                if (!array_key_exists($detail->getBasketGroup(), $this->basketGroups)) {
                    $this->basketGroups[$detail->getBasketGroup()] = array();
                }
                $this->basketGroups[$detail->getBasketGroup()][] = $detail;
            }
        }
    }

    private function loadStatusInstance() {
        $db = JFactory::getDBO();
        $this->statusInstance = $db->setQuery(sprintf('SELECT * FROM #__smartorder_orders_status WHERE id = %d', $this->status))->loadObject('OrderStatus');
    }

    /**
     * @param int $id
     * @return Order
     */
    public static function load($id) {
        $db = JFactory::getDBO();
        $order = $db->setQuery(sprintf('SELECT * FROM #__smartorder_orders WHERE id = %d', intval($id)))->loadObject('Order');
        $order->init();
        return $order;
    }
}