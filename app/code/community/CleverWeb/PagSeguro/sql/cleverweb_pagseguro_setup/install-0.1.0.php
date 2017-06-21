<?php
/**
 * Clever Web - Mauro Lacerda
 *

 *
 * @category   Pagseguro
 * @package    CleverWeb_PagSeguro
 * @copyright  Copyright (c) 2017 Clever Web
 */

$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE `{$installer->getTable('sales/quote_payment')}` 
ADD `creditcardholdername` VARCHAR( 255 ) NOT NULL,
ADD `dtanascimento` VARCHAR( 255 ) NOT NULL,
ADD `strcpftit` VARCHAR( 255 ) NOT NULL,
ADD `strdddtelfone` VARCHAR( 255 ) NOT NULL,
ADD `creditcardnumber` VARCHAR( 255 ) NOT NULL,
ADD `creditcardcvv` VARCHAR( 255 ) NOT NULL,
ADD `creditcardduedatemonth` VARCHAR( 255 ) NOT NULL,
ADD `creditcardduedateyear` VARCHAR( 255 ) NOT NULL,
ADD `strparcelas` VARCHAR( 255 ) NOT NULL;
ADD `strnmcartao` VARCHAR( 255 ) NOT NULL;
ADD `meuhash` VARCHAR( 255 ) NOT NULL;
ADD `tokenpagamento` VARCHAR( 255 ) NOT NULL;
  
ALTER TABLE `{$installer->getTable('sales/order_payment')}` 
ADD `creditcardholdername` VARCHAR( 255 ) NOT NULL,
ADD `dtanascimento` VARCHAR( 255 ) NOT NULL,
ADD `strcpftit` VARCHAR( 255 ) NOT NULL,
ADD `strdddtelfone` VARCHAR( 255 ) NOT NULL,
ADD `creditcardnumber` VARCHAR( 255 ) NOT NULL,
ADD `creditcardcvv` VARCHAR( 255 ) NOT NULL,
ADD `creditcardduedatemonth` VARCHAR( 255 ) NOT NULL,
ADD `creditcardduedateyear` VARCHAR( 255 ) NOT NULL,
ADD `strparcelas` VARCHAR( 255 ) NOT NULL;
ADD `strnmcartao` VARCHAR( 255 ) NOT NULL;
ADD `meuhash` VARCHAR( 255 ) NOT NULL;
ADD `tokenpagamento` VARCHAR( 255 ) NOT NULL;
");
$installer->endSetup();
 
/*
$this->startSetup();
// We have to create these columns so that our new fields show up in the sales_flat_order_payment table
// We don't need to create these columns for the quote payment table as the data is copied from the form
// To the quote object in code - it's then converted to an order payment object.
$this->getConnection()->addColumn(
	// getTable returns the name of the table as a string
	$this->getTable('sales/order_payment'),
	'check_no',
	array(
		// Use TYPE_TEXT instead of TYPE_VARCHAR, as it's deprecated and will throw an error
		// Adding a length will make it as varchar
		'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
		'nullable' => true,
		'default' => null,
		// Comment must be provided
		'comment' => 'Check Number',
		'length' => 100			
	)
);
$this->getConnection()->addColumn(
	$this->getTable('sales/order_payment'),
	'check_date',
	array(
		'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
		'nullable' => true,
		'default' => null,
		'comment' => 'Check Date',
		'length' => 255
	)
);
$this->endSetup();
*/
