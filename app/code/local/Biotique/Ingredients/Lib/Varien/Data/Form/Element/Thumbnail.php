<?php
/**
 * Category form input image element
 *
 * @category   Varien
 * @package    Varien_Data
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Biotique_Ingredients_Lib_Varien_Data_Form_Element_Thumbnail extends Varien_Data_Form_Element_Abstract
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->setType('file');
    }


    public function getElementHtml()
    {
        $html = '';

        if ((string)$this->getValue()) {
            $url = $this->_getUrl();

            if( !preg_match("/^http\:\/\/|https\:\/\//", $url) ) {
                $url = Mage::getBaseUrl('media') . 'ingredients/'.$url;
            }

            $html = '<a href="' . $url . '"'
                . ' onclick="imagePreview(\'' . $this->getHtmlId() . '_image\'); return false;">'
                . '<img src="' . $url . '" id="' . $this->getHtmlId() . '_image" title="' . $this->getValue() . '"'
                . ' alt="' . $this->getValue() . '" height="104" class="small-image-preview v-middle" />'
                . '</a> ';
        }
        $this->setClass('input-file');
        $html .= parent::getElementHtml();
        $html .= $this->_getDeleteCheckbox();

        return $html;
    }

    protected function _getDeleteCheckbox()
    {
        $html = '';
        return $html;
    }


    protected function _getHiddenInput()
    {
        return '<input type="hidden" name="' . parent::getName() . '[value]" value="' . $this->getValue() . '" />';
    }


    protected function _getUrl()
    {
        return $this->getValue();
    }


    public function getName()
    {
        return  $this->getData('name');
    }
}
