<?php
/**
 * Cybage Marketplace Plugin
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * It is available on the World Wide Web at:
 * http://opensource.org/licenses/osl-3.0.php
 * If you are unable to access it on the World Wide Web, please send an email
 * To: Support_Magento@cybage.com.  We will send you a copy of the source file.
 *
 * @category   Marketplace Plugin
 * @package    Cybage_Marketplace
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 */

$this->startSetup();
$this->addAttribute('customer', 'company_publickeypagseguro', array(
    'type' => 'varchar',
    'input' => 'text',
    'label' => 'Chave Pública PagSeguro',
    'global' => true,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'default' => '',
    'visible_on_front' => true,
));
$this->addAttribute('customer', 'company_emailpagseguro', array(
    'type' => 'varchar',
    'input' => 'text',
    'label' => 'E-mail do PagSeguro',
    'global' => true,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'default' => '',
    'visible_on_front' => true,
));
$this->endSetup();