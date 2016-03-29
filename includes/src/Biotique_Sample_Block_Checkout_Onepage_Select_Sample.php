<?php

class Biotique_Sample_Block_Checkout_Onepage_Select_Sample extends Mage_Checkout_Block_Onepage_Abstract
{
    public function getSamples()
    {
    	$samps = array();
		$collection = Mage::getModel('sample/products')->getCollection()
				->addFieldToFilter('status', 1)
				->setOrder('name','ASC');

		$selSamples = Mage::getSingleton('core/session')->getSampleOrders();
		$selSamples = @unserialize($selSamples);
		if(!is_array($selSamples)) $selSamples = array();

		foreach ($collection as $sample) {
			$samps[] = array(
				'id' => $sample->getId(),
				'name' => $sample->getName(),
				'img' => Mage::getBaseUrl('media') . 'sample/' . $sample->getImage(),
				'checked' => in_array($sample->getId(), $selSamples) ? 1 : 0
			);
		}
    	return $samps;
    }
}
