<?php
class Company_Shipwa_Block_Shipwa extends Mage_Core_Block_Template
{
	 protected function _prepareLayout()
		{
		 $this->setFormAction(Mage::getUrl('*/*/showdetails'));
			return parent::_prepareLayout();
		}
    
}