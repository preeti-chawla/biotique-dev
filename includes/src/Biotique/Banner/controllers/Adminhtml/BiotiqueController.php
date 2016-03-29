<?php

class Biotique_Banner_Adminhtml_BiotiqueController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		return $this->renderLayout();
	}
} 