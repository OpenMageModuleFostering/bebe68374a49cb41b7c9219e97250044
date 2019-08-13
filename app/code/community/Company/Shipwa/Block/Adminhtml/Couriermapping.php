<?php

class Company_Shipwa_Block_Adminhtml_Couriermapping extends Mage_Adminhtml_Block_Widget
{

 public function __construct()
  {
  
 
  parent::__construct();
    $this->setTemplate('shipwa/couriermapping.phtml');
    $this->setFormAction(Mage::getUrl('*/*/savecouriermapp'));

    $this->_controller = 'adminhtml_shipwa';
    $this->_blockGroup = 'shipwa';
   


}

}


?>