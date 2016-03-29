<?php

$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('biotique_ingredients/banner');
if ($installer->getConnection()->isTableExists($tableName) != true) {
	$table = $installer->getConnection()
				->newTable($tableName)
				->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
					'identity' => true,
					'unsigned' => true,
					'nullable' => false,
					'primary' => true,
				), null)
				->addColumn('ingredient_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
					'nullable' => true,
				), 'name')
				->addColumn('alias', Varien_Db_Ddl_Table::TYPE_TEXT, 50, array(
					'nullable' => true,
				), 'alias')
				->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, 200, array(
					'nullable' => true,
				), null)
				->addColumn('small_image', Varien_Db_Ddl_Table::TYPE_VARCHAR, 200, array(
					'nullable' => true,
				))
				->addColumn('large_image', Varien_Db_Ddl_Table::TYPE_VARCHAR, 200, array(
					'nullable' => true,
				), null)
				->setComment('Ingredient order');
	$installer->getConnection()->createTable($table);
}


$installer->endSetup();