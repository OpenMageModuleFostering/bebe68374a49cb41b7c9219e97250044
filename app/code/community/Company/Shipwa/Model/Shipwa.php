<?php

class Company_Shipwa_Model_Shipwa extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('shipwa/shipwa');
    }
}