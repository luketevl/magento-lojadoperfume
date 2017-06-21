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

$installer->addAttribute("order", "meuhash", array("type"=>"varchar"));
$installer->addAttribute("quote", "meuhash", array("type"=>"varchar"));

$installer->addAttribute("order", "tokenpagamento", array("type"=>"varchar"));
$installer->addAttribute("quote", "tokenpagamento", array("type"=>"varchar"));

$installer->endSetup();
 

