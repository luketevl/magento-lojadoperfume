<?php

class CleverWeb_Mercadolivre_Model_Product extends Mage_Core_Model_Abstract{
	protected $_options = array();
	protected $_optionsPages = array();
	
    public function _construct(){
        parent::_construct();
        $this->_init('mercadolivre/product');
    }
	
	 public function getOptionArray(){
        $collection = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*')
		->addAttributeToFilter('seller_id', array('null' => true))
		->addAttributeToFilter('status', 1);
		$this->_options[] = array(
		       'label' => 'Selecione',
		       'value' => ''
		);
		foreach($collection as $product){
			$this->_options[] = array(
		           'label' => $product->getName(),
		           'value' => $product->getEntityId()
		     );
		}
        return $this->_options;
    }
	
	public function getPagesArray(){		
		$collectionPages = Mage::getModel('cms/page')->getCollection()->addFieldToFilter('is_active', 1)->addFieldToFilter('content_heading', 'mercadolivre');
		
		$this->_optionsPages[] = array(
		       'label' => 'Selecione',
		       'value' => ''
		);
		
		foreach($collectionPages as $pages){
			$this->_optionsPages[] = array(
		           'label' => $pages["title"],
		           'value' => $pages["page_id"]
		     );
		}
		
        return $this->_optionsPages;
	}
	
	public function getOneProduct($productId){
		$product = Mage::getModel('catalog/product')->getCollection()
        ->addAttributeToFilter('entity_id', $productId)
        ->addAttributeToSelect('*')
        ->getFirstItem();
		return $product;
		/*
		$this->_price = $product->getPrice();
		$this->_qtd = $product->getQty();
		$this->_shortDescription = $product->getShortDescription(); 
		$this->_name = $product->getName(); 
		$this->_specialPrice = $product->getSpecialPrice(); 
		$this->_productUrl = $product->getProductUrl(); 
		$this->_imageUrl = $product->getImageUrl(); 
		$this->_smallImageUrl = $product->getSmallImageUrl(); 
		$this->_thumbnailUrl = $product->getThumbnailUrl(); 
		*/
	}
	
}