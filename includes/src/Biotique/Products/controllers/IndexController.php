<?php

class Biotique_Products_IndexController extends Mage_Core_Controller_Front_Action
{

	public function indexAction()
	{
		//Loading current layout
		
		$this->loadLayout();

		$thirdchildBlock = Mage::app()->getLayout()
		    ->createBlock('page/html_pager','product_list_toolbar_pager');

		$secchildBlock = Mage::app()->getLayout()
		    ->createBlock('catalog/product_list_toolbar','product_list_toolbar')
		    ->setToolbarBlockName('product_list_toolbar')
		    ->setTemplate('catalog/product/list/toolbar.phtml')
		    ->setChild('bio_tpplbar',$thirdchildBlock);

		$block = Mage::app()->getLayout()
		    ->createBlock('catalog/product_list','home')
		    ->setCategoryId(2)
		    ->setTemplate('catalog/product/list.phtml')
		    ->setChild('bio_tpplbar',$secchildBlock);

    	$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}

}