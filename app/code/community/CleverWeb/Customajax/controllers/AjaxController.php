<?php
class CleverWeb_Customajax_AjaxController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
    	$chaveadm = $_POST['chaveadm'];
    	$_helper = Mage::helper('cleverweb_pagseguro');
		$emailVendedorPrincipal = $_helper->getSelerMail();
		
		$autorizacaoXml = $_helper->getAutozacaoAdm($chaveadm,$emailVendedorPrincipal);
		$autorizacaoObj = simplexml_load_string($autorizacaoXml);
		$autorizacaoCod = $autorizacaoObj->code;
		$urlAceita = $_helper->getURLaceitarvendedor($autorizacaoCod);
		echo '<a href="'.$urlAceita.'">Aqui</a>';
		 		 
		/*
        $this->loadLayout();
        $this->renderLayout();
		*/
    }
}