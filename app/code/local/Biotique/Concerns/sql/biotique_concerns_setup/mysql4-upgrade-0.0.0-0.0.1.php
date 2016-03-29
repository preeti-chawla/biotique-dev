<?php

$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('biotique_concerns/match');
if ($installer->getConnection()->isTableExists($tableName) != true) {
	$table = $installer->getConnection()
				->newTable($tableName)
				->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
					'identity' => true,
					'unsigned' => true,
					'nullable' => false,
					'primary' => true,
				), null)
				->addColumn('category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
					'nullable' => true,
				), 'name')
				->addColumn('concern_ids', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
					'nullable' => true,
				), 'Concerns')
				->setComment('Category Concerns');
	$installer->getConnection()->createTable($table);
}


$installer->endSetup();