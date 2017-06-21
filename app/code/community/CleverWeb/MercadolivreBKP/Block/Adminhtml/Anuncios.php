<?php
class CleverWeb_Mercadolivre_Block_Adminhtml_Anuncios extends Mage_Adminhtml_Block_Widget_Grid_Container{
    public function __construct(){
    	
        $this->_blockGroup = 'mercadolivre';
        $this->_controller = 'adminhtml_anuncios';
        $this->_headerText = 'Anúncios - Mercado Livre';
        $this->_addButtonLabel = 'Criar novo anúncios';
        parent::__construct();
    }

    protected function _prepareLayout(){
    	echo 'aqui';
        $this->setChild( 'grid',
            $this->getLayout()->createBlock( $this->_blockGroup.'/' . $this->_controller . '_grid',
                $this->_controller . '.grid')->setSaveParametersInSession(true) );
        return parent::_prepareLayout();
    }



}