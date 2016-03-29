<?php

class Biotique_Sample_Helper_Checkout extends Mage_Core_Helper_Abstract
{
	public function getCheckoutSteps()
	{
        $steps = array(); // custom steps
        $_steps = array(); // original steps

        // get steps from Mage_Checkout_Block_Onepage;
        if($block = Mage::app()->getLayout()->getBlock('checkout.onepage')){
			$_steps = $block->getSteps();
        }

        foreach ($_steps as $stepId => $step) {
        	if($stepId == 'billing'){
        		// if first then unset its allow method and insert sample
        		$steps['select_sample'] = array(
        			'label'=> 'Select Samples',
        			'is_show' => 1,
        			'allow' => 1
        		);
        		unset($step['allow']);
        	}
        	$steps[$stepId] = $step;
        }
        //echo '<pre>';print_R($steps);exit;
        return $steps;
	}

	public function getActiveStep()
	{
		return Mage::getSingleton('customer/session')->isLoggedIn() ? 'select_sample' : 'login';
	}
}