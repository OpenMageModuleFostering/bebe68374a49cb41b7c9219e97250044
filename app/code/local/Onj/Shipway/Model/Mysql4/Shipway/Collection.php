<?php

class Onj_Shipway_Model_Mysql4_Shipway_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('shipway/shipway');
    }
}