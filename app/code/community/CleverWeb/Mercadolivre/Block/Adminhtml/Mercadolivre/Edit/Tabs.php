<?php

class CleverWeb_Mercadolivre_Block_Adminhtml_Mercadolivre_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('mercadolivre_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('mercadolivre')->__('Informações do item'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('mercadolivre')->__('Informações do item'),
          'title'     => Mage::helper('mercadolivre')->__('Geral'),
          'content'   => $this->getLayout()->createBlock('mercadolivre/adminhtml_mercadolivre_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}