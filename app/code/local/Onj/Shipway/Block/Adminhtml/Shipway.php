<?php
class Onj_Shipway_Block_Adminhtml_Shipway extends Mage_Adminhtml_Block_Widget
{
  public function __construct()
  {
  
 
  parent::__construct();
    $this->setTemplate('shipway/shipway.phtml');
    $this->setFormAction(Mage::getUrl('*/*/showdetails'));
	
	

    $this->_controller = 'adminhtml_shipway';
    $this->_blockGroup = 'shipway';
   
  }
}