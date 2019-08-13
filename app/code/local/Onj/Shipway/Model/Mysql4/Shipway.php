<?php

class Onj_Shipway_Model_Mysql4_Shipway extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the shipway_id refers to the key field in your database table.
        $this->_init('shipway/shipway', 'shipway_id');
    }
}