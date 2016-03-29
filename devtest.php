<?php

function prr($res_arr)
{
	echo '<pre>';
	print_R($res_arr);
	echo '</pre>';
}

function pec($res_str)
{
	echo '<br/> - ' . $res_str;
}

require_once 'app/Mage.php';
Mage::app();


//$configValue = Mage::getStoreConfig('sectionName/groupName/fieldName');

$res = Mage::getStoreConfig('tab1/rules/giftrule_2');
prr($res);