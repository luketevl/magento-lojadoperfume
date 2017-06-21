<?php
 
$installer = $this;
 
$installer->startSetup();
 
$installer->run("

ALTER TABLE  `mgiy_ml_product` ADD  `template_id` int(11) NOT NULL;
 
");
 
$installer->endSetup();

