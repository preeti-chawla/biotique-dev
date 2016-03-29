<?php

//Procedure 1
$installer = $this;
/* @var $installer Mage_Customer_Model_Entity_Setup */

$installer->startSetup();

$installer->addAttribute(
        'customer', 'profession', array(
    'group' => 'Default',
    'type' => 'varchar',
    'label' => 'Profession',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'required' => 0,
    'visible_on_front' => 1,
    'used_for_price_rules' => 0,
    'adminhtml_only' => 1,
        )
);

//Mage::getSingleton('eav/config')->getAttribute('customer', 'profession')
//        ->setData('used_in_forms', array('adminhtml_customer'))->save();


$installer->endSetup();

////Procedure 2
//$installer = $this;
//$installer->startSetup();
//
//
//$installer->addAttribute("customer", "profession", array(
//    "type" => "varchar",
//    "backend" => "",
//    "label" => "Profession",
//    "input" => "text",
//    "visible" => true,
//    "required" => false,
//    "default" => "",
//    "frontend" => "",
//    "unique" => false,
//    "note" => ""
//));
//
//$attribute = Mage::getSingleton("eav/config")->getAttribute("customer", "profession");
//
//$used_in_forms = array();
//
//$used_in_forms[] = "adminhtml_customer";
//$attribute->setData("used_in_forms", $used_in_forms)
//        ->setData("is_used_for_customer_segment", true)
//        ->setData("is_system", 0)
//        ->setData("is_user_defined", 1)
//        ->setData("is_visible", 0)
//        ->setData("sort_order", 100);
//
//$attribute->save();
//
//$installer->endSetup();