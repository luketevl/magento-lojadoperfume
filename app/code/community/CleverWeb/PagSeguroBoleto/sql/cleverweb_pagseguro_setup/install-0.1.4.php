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
 

