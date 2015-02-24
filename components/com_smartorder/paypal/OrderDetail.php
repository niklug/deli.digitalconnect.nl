<?php
/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */


class OrderDetail {

    const TYPE_ITEM = 'I';
    const TYPE_TOPPING = 'T';

    private $id;
    private $order_id;
    private $basketgroup;
    private $type;
    private $count;
    private $name;
    private $price;
    private $discount_price;
    private $category_name;
    private $status;
    private $vat_percent;

    public function getId() {
        return $this->id;
    }

    public function getOrderId() {
        return $this->order_id;
    }

    public function getBasketGroup() {
        return $this->basketgroup;
    }

    public function getType() {
        return $this->type;
    }

    public function isItem() {
        return strtoupper($this->getType()) === self::TYPE_ITEM;
    }

    public function isTopping() {
        return strtoupper($this->getType()) === self::TYPE_TOPPING;
    }

    public function getCount() {
        return $this->count;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return round($this->price, 2);
    }

    public function getDiscountPrice() {
        return round($this->discount_price, 2);
    }

    public function getCategoryName() {
        return $this->category_name;
    }

    public function getStatus() {
        return $this->status;
    }

    public function hasVat() {
        return !empty($this->vat_percent);
    }

    public function getVatPercent() {
        return $this->vat_percent;
    }

    public function getVat() {
        return round($this->hasVat()
            ? $this->getPrice() * ($this->getVatPercent() / 100.0)
            : 0, 2);
    }

    public function getTotalGross() {
        $gross = $this->getPrice();
        if ($this->hasVat()) {
            $gross += $this->getVat();
        }
        $gross *= $this->getCount();
    }
}