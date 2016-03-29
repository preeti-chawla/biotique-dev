<?php

$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('sample/orders');
if ($installer->getConnection()->isTableExists($tableName) != true) {
	$table = $installer->getConnection()
				->newTable($tableName)
				->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
					'identity' => true,
					'unsigned' => true,
					'nullable' => false,
					'primary' => true,
				), 'Category Banner Id')
				->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
					'nullable' => true,
				))
				->addColumn('sample', Varien_Db_Ddl_Table::TYPE_TEXT, 200, array(
					'nullable' => true,
				), 'serialized sample ids')
				->setComment('Sample Order Ids');
	$installer->getConnection()->createTable($table);
}

$installer->endSetup();