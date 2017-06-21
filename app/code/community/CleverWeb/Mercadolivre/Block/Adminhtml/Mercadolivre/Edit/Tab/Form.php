<?php

class CleverWeb_Mercadolivre_Block_Adminhtml_Mercadolivre_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm() {
      $form = new Varien_Data_Form();
      $this->setForm($form);
	  
	  
	  $code = Mage::app()->getRequest()->getParam('code');
	  $key = Mage::app()->getRequest()->getParam('key');
	  
	  if ( Mage::getSingleton('adminhtml/session')->getMercadolivreData() ){
        $form_data = Mage::getSingleton('adminhtml/session')->getMercadolivreData();
        Mage::getSingleton('adminhtml/session')->setMercadolivreData(null);
      }else if ( Mage::registry('mercadolivre_data') ) {
        $form_data = Mage::registry('mercadolivre_data');  
      }
	  
	  
	  $_helper = Mage::helper('mercadolivre');
	  $_helper->loginMl();
	  	  
	  $baseUrlHome = Mage::helper('core/url')->getHomeUrl();
	  $categoria1 = Mage::app()->getRequest()->getParam('categoria1');
	  $categoria2 = Mage::app()->getRequest()->getParam('categoria2');
	  $categoria3 = Mage::app()->getRequest()->getParam('categoria3');
	  $categoria4 = Mage::app()->getRequest()->getParam('categoria4');
	  $categoria5 = Mage::app()->getRequest()->getParam('categoria5');
	  $categoria6 = Mage::app()->getRequest()->getParam('categoria6');
	  $categoria7 = Mage::app()->getRequest()->getParam('categoria7');
	  $produto = Mage::app()->getRequest()->getParam('produto');
	  $mlId = $form_data->getData('ml_id');
	  
	  $produto = ($produto!='' && is_numeric($produto) ? $produto : $form_data->getData('product_id'));
	   
	  if( empty($form_data->getData('categoria1')) && $categoria1!='' ){
        $form_data->setData('categoria1', $categoria1);
      }
	  if( empty($form_data->getData('categoria2')) && $categoria2!='' ){
        $form_data->setData('categoria2', $categoria2);
      }
	  if( empty($form_data->getData('categoria3')) && $categoria3!='' ){
        $form_data->setData('categoria3', $categoria3);
      }
	  if( empty($form_data->getData('categoria4')) && $categoria4!='' ){
        $form_data->setData('categoria4', $categoria4);
      }
	  if( empty($form_data->getData('categoria5')) && $categoria5!='' ){
        $form_data->setData('categoria5', $categoria5);
      }
	  if( empty($form_data->getData('categoria6')) && $categoria6!='' ){
        $form_data->setData('categoria6', $categoria6);
      }
	  if( empty($form_data->getData('categoria7')) && $categoria7!='' ){
        $form_data->setData('categoria7', $categoria7);
      }
	  if( empty($form_data->getData('product_id')) && $produto!='' ){
        $form_data->setData('product_id', $produto);
      }
	 
	 if($produto!='' && is_numeric($produto)){
	 	$objModelProd = Mage::getModel('mercadolivre/product')->getOneProduct($produto);		
		$descri = $objModelProd->getDescription();	
		$str_preco = $objModelProd->getPrice();
		$int_quantidade = Mage::getModel('cataloginventory/stock_item')->loadByProduct($produto)->getQty();
		$str_titulo = $objModelProd->getName();
			
		if($mlId!=''){
		 	$meli = $_helper->getMeli();
			$search = $meli->get('/items?ids='.$mlId.'');
			$obj_desc = $meli->get("/items/" . $mlId . "/descriptions");
			$descri = $obj_desc['body'][0]->text;
			$urlLinkMl = $obj_desc['body'][0]->url;
			$categoriaId = $search['body'][0]->category_id;
			$listCateg = $meli->get("/categories/" . $categoriaId);
			//echo $descri;
			//echo '<br><br>';
			//print_r($obj_desc);			
		    $form_data->setData('type', $search['body'][0]->listing_type_id);
			$str_preco = $search['body'][0]->price;
			$int_quantidade = $search['body'][0]->initial_quantity;
			$str_titulo = $search['body'][0]->title;
		    
		 }
		 
		 
		if( empty($form_data->getData('title')) ){
	        $form_data->setData('title', $str_titulo);
	    }
		if( empty($form_data->getData('price')) ){
	        $form_data->setData('price', $str_preco);
	    }
		if( empty($form_data->getData('quantidade')) ){
	        $form_data->setData('quantidade', $int_quantidade);
	    }
		if( empty($form_data->getData('content')) ){
	        $form_data->setData('content', $descri);
	    }
		if( empty($form_data->getData('imagem')) ){
	        $form_data->setData('imagem', $objModelProd->getImageUrl());
	    }
		
	 }
	 
	 
	    
	
     $fieldset = $form->addFieldset('mercadolivre_form', array('legend'=>Mage::helper('mercadolivre')->__('Informações')));
    
	 $fieldset->addField('imagem', 'hidden', array(
	          'class'     => 'required-entry',
	          'name'      => 'imagem',
	      ));
	
	 $fieldset->addField('product_id', 'select', array(
          'label'     => Mage::helper('mercadolivre')->__('Produto'),
          'name'      => 'product_id',
          'required'  => true,
          'onchange' => "location.href='".$baseUrlHome."mercadolivre/adminhtml_mercadolivre/new/key/".$key."/code/".$code."/produto/'+this.value;",
          'values'    => Mage::getModel('mercadolivre/product')->getOptionArray(),
      ));
	  
	  if($mlId!=''){
	  	foreach ($listCateg as $categs):
			for($conts=0;$conts<count($categs->path_from_root);$conts++){
				
				$form_data->setData('categoria'.($conts+1), $categs->path_from_root[$conts]->id);
				
			  	$fieldset->addField('categoria'.($conts+1), 'select', array(
			          'label'     => Mage::helper('mercadolivre')->__('Categoria '.($conts+1)),
			          'name'      => 'categoria'.($conts+1),
			          'required'  => true,
			          'onchange' => "location.href='".$baseUrlHome."mercadolivre/adminhtml_mercadolivre/new/key/".$key."/code/".$code."/produto/".$produto."/categoria1/'+this.value;",       
			          'values'    => array(
					  	array('value' => $categs->path_from_root[$conts]->id, 'label' => $categs->path_from_root[$conts]->name)
					  ),
			      ));
			}
		endforeach;
	  }
	  
	  if($produto!=''){
	  	if($mlId==''){
		  $fieldset->addField('categoria1', 'select', array(
	          'label'     => Mage::helper('mercadolivre')->__('Categoria'),
	          'name'      => 'categoria1',
	          'required'  => true,
	          'onchange' => "location.href='".$baseUrlHome."mercadolivre/adminhtml_mercadolivre/new/key/".$key."/code/".$code."/produto/".$produto."/categoria1/'+this.value;",       
	          'values'    => Mage::helper('mercadolivre')->getCategoriasArray(),
	      ));
		  	  
		  if($categoria1!=''){
			  $fieldset->addField('categoria2', 'select', array(
		          'label'     => Mage::helper('mercadolivre')->__('Categoria 2'),
		          'name'      => 'categoria2',
		          'onchange' => "location.href='".$baseUrlHome."mercadolivre/adminhtml_mercadolivre/new/key/".$key."/code/".$code."/produto/".$produto."/categoria1/".$categoria1."/categoria2/'+this.value;",
		          'values'    => Mage::helper('mercadolivre')->getCategoriasArray($categoria1),
		      ));
		  }
		  if($categoria2!=''){
			  $fieldset->addField('categoria3', 'select', array(
		          'label'     => Mage::helper('mercadolivre')->__('Categoria 3'),
		          'name'      => 'categoria3',
		          'onchange' => "location.href='".$baseUrlHome."mercadolivre/adminhtml_mercadolivre/new/key/".$key."/code/".$code."/produto/".$produto."/categoria1/".$categoria1."/categoria2/".$categoria2."/categoria3/'+this.value;",
		          'values'    => Mage::helper('mercadolivre')->getCategoriasArray($categoria2),
		      ));
		  }
		  if($categoria3!=''){
			  $fieldset->addField('categoria4', 'select', array(
		          'label'     => Mage::helper('mercadolivre')->__('Categoria 4'),
		          'name'      => 'categoria4',
		          'onchange' => "location.href='".$baseUrlHome."mercadolivre/adminhtml_mercadolivre/new/key/".$key."/code/".$code."/produto/".$produto."/categoria1/".$categoria1."/categoria2/".$categoria2."/categoria3/".$categoria3."/categoria4/'+this.value;",
		          'values'    => Mage::helper('mercadolivre')->getCategoriasArray($categoria3),
		      ));
		  }
		  
		  if($categoria4!=''){
			  $fieldset->addField('categoria5', 'select', array(
		          'label'     => Mage::helper('mercadolivre')->__('Categoria 5'),
		          'name'      => 'categoria5',
		          'onchange' => "location.href='".$baseUrlHome."mercadolivre/adminhtml_mercadolivre/new/key/".$key."/code/".$code."/produto/".$produto."/categoria1/".$categoria1."/categoria2/".$categoria2."/categoria3/".$categoria3."/categoria4/".$categoria4."/categoria5/'+this.value;",
		          'values'    => Mage::helper('mercadolivre')->getCategoriasArray($categoria4),
		      ));
		  }
		  
		  if($categoria5!=''){
			  $fieldset->addField('categoria6', 'select', array(
		          'label'     => Mage::helper('mercadolivre')->__('Categoria 6'),
		          'name'      => 'categoria6',
		          'onchange' => "location.href='".$baseUrlHome."mercadolivre/adminhtml_mercadolivre/new/key/".$key."/code/".$code."/produto/".$produto."/categoria1/".$categoria1."/categoria2/".$categoria2."/categoria3/".$categoria3."/categoria4/".$categoria4."/categoria5/".$categoria5."/categoria6/'+this.value;",
		          'values'    => Mage::helper('mercadolivre')->getCategoriasArray($categoria5),
		      ));
		  }
		  
		  if($categoria6!=''){
			  $fieldset->addField('categoria7', 'select', array(
		          'label'     => Mage::helper('mercadolivre')->__('Categoria 7'),
		          'name'      => 'categoria7',
		          'values'    => Mage::helper('mercadolivre')->getCategoriasArray($categoria6),
		      ));
		  }
		  
		  
		  
		 }  
	      $fieldset->addField('title', 'text', array(
	          'label'     => Mage::helper('mercadolivre')->__('Title'),
	          'class'     => 'required-entry',
	          'required'  => true,
	          'name'      => 'title',
	      ));
		  
		  $fieldset->addField('type', 'select', array(
	          'label'     => Mage::helper('mercadolivre')->__('Plano'),
	          'name'      => 'type',
	          'required'  => true,
	          'values'    => CleverWeb_Mercadolivre_Model_System_Config_Source_Type::optSelectArray(),
	      ));
		  
		  
	      $fieldset->addField('price', 'text', array(
	          'label'     => Mage::helper('mercadolivre')->__('Valor'),
	          'class'     => 'required-entry',
	          'required'  => true,
	          'name'      => 'price',
	      ));
			
	      $fieldset->addField('quantidade', 'text', array(
	          'label'     => Mage::helper('mercadolivre')->__('Quatidade'),
	          'class'     => 'required-entry',
	          'required'  => true,
	          'name'      => 'quantidade',
	      ));
	     
		  $fieldset->addField('template_id', 'select', array(
			     'label'     => Mage::helper('mercadolivre')->__('Template'),
			     'name'      => 'template_id',
			     'values'    => Mage::getModel('mercadolivre/product')->getPagesArray(),
		  ));
		 
	      $fieldset->addField('content', 'editor', array(
	          'name'      => 'content',
	          'label'     => Mage::helper('mercadolivre')->__('Content'),
	          'title'     => Mage::helper('mercadolivre')->__('Content'),
	          'style'     => 'width:700px; height:500px;',
	          'wysiwyg'   => false,
	          'required'  => true,
	      ));
	  }
      if ( Mage::getSingleton('adminhtml/session')->getMercadolivreData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getMercadolivreData());
          Mage::getSingleton('adminhtml/session')->setMercadolivreData(null);
      } elseif ( Mage::registry('mercadolivre_data') ) {
          $form->setValues(Mage::registry('mercadolivre_data')->getData());
      }
      return parent::_prepareForm();
  }
}