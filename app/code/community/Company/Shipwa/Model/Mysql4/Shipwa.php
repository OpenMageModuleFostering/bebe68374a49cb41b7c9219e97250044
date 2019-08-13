<?php

class Company_Shipwa_Model_Mysql4_Shipwa extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the shipwa_id refers to the key field in your database table.
        $this->_init('shipwa/shipwa', 'shipwa_id');
    }
}