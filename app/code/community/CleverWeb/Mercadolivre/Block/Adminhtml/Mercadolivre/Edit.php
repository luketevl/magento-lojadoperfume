<?php
/*
 * Desenvolvido por: Mauro Lacerda
 * http://www.cleverweb.com.br
 */
class CleverWeb_Mercadolivre_Block_Adminhtml_Mercadolivre_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
    public function __construct(){
        parent::__construct();                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'mercadolivre';
        $this->_controller = 'adminhtml_mercadolivre';
        
        $this->_updateButton('save', 'label', Mage::helper('mercadolivre')->__('Savar'));
        $this->_updateButton('delete', 'label', Mage::helper('mercadolivre')->__('Excluir'));
  
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
		
		
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('mercadolivre_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'mercadolivre_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'mercadolivre_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
            /*
			var categoria1 = document.getElementById('categoria1');
			categoria1.addEventListener('change', function () {  
			    
			});
			*/
        ";
    }

    public function getHeaderText(){
        if( Mage::registry('mercadolivre_data') && Mage::registry('mercadolivre_data')->getId() ) {
            return Mage::helper('mercadolivre')->__("Editar Anúncio '%s'", $this->htmlEscape(Mage::registry('mercadolivre_data')->getTitle()));
        } else {
            return Mage::helper('mercadolivre')->__('Adicionar Anúncio');
        }
    }
}