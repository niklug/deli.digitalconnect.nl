<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */


class OrderStatus {

    const STATUS_NEW = 'New order';
    const STATUS_CLOSED = 'Closed order';
    const STATUS_PAYMENT_PENDING = 'Payment pending';
    const STATUS_PAYMENT_CANCELLED = 'Payment cancelled';
    const STATUS_PAYMENT_SUCCESSFUL = 'Payment successful';

    private $id;
    private $name;
    private $ordering;
    private $fontcolor;

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getOrdering() {
        return $this->ordering;
    }

    public function getFontColor() {
        return $this->fontcolor;
    }
}