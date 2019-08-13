<?php
class Company_Shipwa_Block_Adminhtml_Shipwa extends Mage_Adminhtml_Block_Widget
{
  public function __construct()
  {
   parent::__construct();
    $this->setTemplate('shipway/shipway.phtml');
		 $this->setFormAction(Mage::getUrl('*/*/showdetails'));
    $this->_controller = 'adminhtml_shipwa';
    $this->_blockGroup = 'shipwa';

    //$this->_headerText = Mage::helper('shipwa')->__('Item Manager');
    //$this->_addButtonLabel = Mage::helper('shipwa')->__('Add Item');
   
  }
}