<?php
$installer = $this;
$installer->startSetup();
$attribute  = array(
    'type'                       => 'int',
    'label'                      => 'Include in Footer',
    'input'                      => 'select',
    'source'                     => 'eav/entity_attribute_source_boolean',
    'default'                    => '0',
    'sort_order'                 => 10,
    'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'group'                      => 'General Information',
);
$installer->addAttribute('catalog_category', 'bottom_description', $attribute);
$installer->endSetup();
?>