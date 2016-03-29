<?php
class Display_Displaymodule_IndexController extends Mage_Adminhtml_Controller_Action
{ 
    public function indexAction()
    {
		$this->loadLayout();
		$read = Mage::getSingleton('core/resource')->getConnection('core_read');
		$result = $read->fetchAll("SELECT * FROM `query_hotel`");
		$block = $this->getLayout()->createBlock('Mage_Core_Block_Template', 'blocks.display-block',array('template' => 'enquiry/display-block.phtml'))->assign('data', $result);
		$this->_addContent($block);
		$this->_setActiveMenu('display_menu')->renderLayout();     
    }  
}