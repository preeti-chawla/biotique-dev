<?php

class Biotique_Banner_Adminhtml_BannerController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		$this->_setActiveMenu('biotique/banner');
		return $this->renderLayout();
	}
} 