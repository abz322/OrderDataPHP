<?php
/**
 * Created by PhpStorm.
 * User: Abdassami
 * Date: 02/06/15
 * Time: 12:52
 */

namespace c_order;


class class_Order {

    private $domain;
    private $emailAddress;
    private $orderNumber;
    private $orderValue;

    //The getters and setters are used to store and retrieve orders in the private variables
    public function setOrder($dom, $ema, $orN, $orV){
        $this->domain = $dom;
        $this->emailAddress = $ema;
        $this->orderNumber = $orN;
        $this->orderValue = $orV;
    }

    public function getDomain(){
        return $this->domain;
    }

    public function getEmail(){
        return $this->emailAddress;
    }

    public function getOrderNumber(){
        return $this->orderNumber;
    }

    public function getOrderValue(){
        return $this->orderValue;
    }
}