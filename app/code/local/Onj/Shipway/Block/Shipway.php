<?php
class Onj_Shipway_Block_Shipway extends Mage_Core_Block_Template
{
	  protected function _prepareLayout()
		{
		 $this->setFormAction(Mage::getUrl('*/*/showdetails'));
			return parent::_prepareLayout();
		}
    
     
}