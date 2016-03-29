<?php

class Biotique_Sample_Model_System_Config_Source_Gift extends Mage_Core_Model_Abstract
{
    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Show')),
            array('value' => 0, 'label'=>Mage::helper('adminhtml')->__('Do not show')),
        );
    }
}