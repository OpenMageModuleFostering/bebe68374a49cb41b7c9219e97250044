<?php

class Onj_Shipway_Block_Adminhtml_Couriermapping extends Mage_Adminhtml_Block_Widget
{

 public function __construct()
  {
  
 
  parent::__construct();
    $this->setTemplate('shipway/couriermapping.phtml');
    $this->setFormAction(Mage::getUrl('*/*/savecouriermapp'));

    $this->_controller = 'adminhtml_shipway';
    $this->_blockGroup = 'shipway';
   


}

}


?>