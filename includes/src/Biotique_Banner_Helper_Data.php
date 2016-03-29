<?php

class Biotique_Banner_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function slider()
	{
	$resource = Mage::getSingleton('core/resource');
    $readConnection = $resource->getConnection('core_read');
    $query = 'SELECT * FROM ' . $resource->getTableName('bio_banner_slider');
    $results = $readConnection->fetchAll($query);
	return $results;
	}
	public function inner_banner($innerSlider)
	{
	$resource = Mage::getSingleton('core/resource');
    $readConnection = $resource->getConnection('core_read');
	    $table = $resource->getTableName('bio_banner_catbanner');
	 $query = 'SELECT * FROM ' . $table . ' WHERE category_id = '.$innerSlider.' LIMIT 1';
    
    $results = $readConnection->fetchAll($query);
  
	return $results;
	}
	
	public function inner_product($innerSlider)
	{
	$resource = Mage::getSingleton('core/resource');
    $readConnection = $resource->getConnection('core_read');
	    $table = $resource->getTableName('bio_banner_prodbanner');
	 $query = 'SELECT * FROM ' . $table . ' WHERE category_id = '.$innerSlider.' LIMIT 1';
    
    $results = $readConnection->fetchAll($query);
  
	return $results;
	}
	
	
}