<?php

$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('banner/slider');
if ($installer->getConnection()->isTableExists($tableName) != true) {
	$table = $installer->getConnection()
				->newTable($tableName)
				->addColumn('home_sid', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
					'identity' => true,
					'unsigned' => true,
					'nullable' => false,
					'primary' => true,
				), 'Home Slider Id')
				->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 200, array(
					'nullable' => true,
				), 'name')
				->addColumn('image', Varien_Db_Ddl_Table::TYPE_TEXT, 200, array(
					'nullable' => true,
				), 'image path')
				->addColumn('slider_link', Varien_Db_Ddl_Table::TYPE_TEXT, 200, array(
					'nullable' => true,
				), 'slider link')
				->addColumn('slider_order', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
					'nullable' => false,
					'unsigned' => true,
				), 'Base Order')
				->setComment('Home page slider');
	$installer->getConnection()->createTable($table);
}


$tableName = $installer->getTable('banner/catbanner');
if ($installer->getConnection()->isTableExists($tableName) != true) {
	$table = $installer->getConnection()
				->newTable($tableName)
				->addColumn('catbanner_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
					'identity' => true,
					'unsigned' => true,
					'nullable' => false,
					'primary' => true,
				), 'Category Banner Id')
				->addColumn('category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
					'nullable' => true,
				))
				->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 200, array(
					'nullable' => true,
				), 'banner title')
				->addColumn('subtitle', Varien_Db_Ddl_Table::TYPE_TEXT, 200, array(
					'nullable' => true,
				), 'banner subtitle')
				->addColumn('image', Varien_Db_Ddl_Table::TYPE_TEXT, 200, array(
					'nullable' => true,
				), 'image path')
				->addColumn('inherit', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(
					'nullable' => true,
				), 'Parent Inherit')
				->setComment('Category Banner');
	$installer->getConnection()->createTable($table);
}

$installer->endSetup();