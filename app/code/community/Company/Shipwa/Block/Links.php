<?php class Company_Shipwa_Block_Links extends Mage_Page_Block_Template_Links_Block
{
    /**
     * Position in link list
     * @var int
     */
    protected $_position = 120;

    /**
     * @return string
     */
    protected function _toHtml()
    {
        $text = $this->_createLabel($this->_getItemCount());
        $this->_label = $text;
        $this->_title = $text;
        $this->_url = $this->getUrl('wishlist');
        return parent::_toHtml();
    }
    protected function _getItemCount()
    {
        //this method should contain the logic to return the number you need
        return 5;
    }
    //this generated the label
    protected function _createLabel($count)
    {
        if ($count > 1) {
            return $this->__('My Label (%d items)', $count);
        } else if ($count == 1) {
            return $this->__('My Label (%d item)', $count);
        } else {
            return $this->__('My Label');
        }
    }
}

?>