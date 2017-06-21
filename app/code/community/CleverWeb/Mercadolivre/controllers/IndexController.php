<?php
/*
 * Desenvolvido por: Mauro Lacerda
 * http://www.cleverweb.com.br
 */
class CleverWeb_Mercadolivre_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction(){
	  $this->loadLayout();     
	  $this->renderLayout();
    }
}