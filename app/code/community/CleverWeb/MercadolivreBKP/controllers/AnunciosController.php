<?php

class CleverWeb_Mercadolivre_AnunciosController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction(){
    	// "Fetch" display
        //$this->loadLayout();
     
        //$this->_addContent($this->getLayout()->createBlock('mercadolivre/Adminhtml_Anuncios'));
        //$this->_addContent($this->getLayout()->getBlock('anuncios_grid'));
		//$this->getLayout()->getBlock('anuncios_grid')->setCollectionsProducts($this->getRequest()->getPost('collections_products', null));
        //$this->getLayout()->getBlock('head')->setTitle($this->__('Gerenciamento do Anúncio')); 
		
		//$block = $this->getLayout()->createBlock('core/template')->setTemplate('cleverweb/pagseguro/form/pay.phtml')->toHtml();
		//$this->getResponse()->setBody($block);
		
		/*
		$response = 'value'; //dynamic value to pass in block
		Mage::app()->getLayout()->createBlock('core/template')
		    ->setTemplate('mercadolivre/status.phtml')
		    ->toHtml();
		*/
		
        // "Output" display
        //$this->renderLayout();
		
		
		$this->loadLayout()
                ->_addContent(
                $this->getLayout()
                ->createBlock('adminhtml/template')
                ->setTemplate('cleverweb_ml/anuncios.phtml'))
                ->renderLayout();
			
				
		//$this->getResponse()->setBody(
        //    $this->getLayout()->createBlock('mercadolivre/Adminhtml_Anuncios_Grid')->toHtml()
        //);
				
    }

	public function testes(){
		return 'aqui';
	}
		
}