<?php

class Biotique_Ingredients_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		$this->loadLayout();

		if ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')) {
	    	$breadcrumbs->addCrumb('home', array(
	    		'label'=>$this->__('Home'), 
	    		'title'=>$this->__('Home'), 
	    		'link'=> Mage::getBaseUrl()
	    	));

	    	$breadcrumbs->addCrumb('ingredient', array(
	    		'label'=> $this->__('Ingredient'), 
	    		'title'=> $this->__('Ingredient'), 
	    		'link'=> Mage::helper('core/url')->getCurrentUrl()
	    	));
	    }

	    $this->getLayout()->getBlock('head')->setTitle($this->__('Ingredients'));

		return $this->renderLayout();
	}
}