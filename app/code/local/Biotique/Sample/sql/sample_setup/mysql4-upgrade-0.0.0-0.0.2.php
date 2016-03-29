<?php

$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('sample/products');
if ($installer->getConnection()->isTableExists($tableName) != true) {
	$table = $installer->getConnection()
				->newTable($tableName)
				->addColumn('sample_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
					'identity' => true,
					'unsigned' => true,
					'nullable' => false,
					'primary' => true,
				), 'Sample Id')
				->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 200, array(
					'nullable' => true,
				), 'name')
				->addColumn('image', Varien_Db_Ddl_Table::TYPE_VARCHAR, 200, array(
					'nullable' => true,
				), 'image path')
				->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
					'nullable' => false,
					'unsigned' => true,
				), 'Base Order')
				->addColumn('status', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 200, array(
					'nullable' => true,
					'default' => 0
				), 'image path')
				->setComment('Home page sample');
	$installer->getConnection()->createTable($table);
}

$installer->endSetup();