<?php

class Cw_Ml_Adminhtml_SellerController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init action breadcrumbs and active menu
     */
    protected function _initAction() {
       
    }

    /**
     * index action 
     */
    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

     /**
     * seller grid action for AJAX request
     */
    public function gridAction()
    {
    	/*
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('marketplace/adminhtml_seller_grid')->toHtml()
        );
		*/
    }

   
}
