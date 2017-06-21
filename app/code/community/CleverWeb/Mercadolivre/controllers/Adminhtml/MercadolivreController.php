<?php
/*
 * Desenvolvido por: Mauro Lacerda
 * http://www.cleverweb.com.br
 */
class CleverWeb_Mercadolivre_Adminhtml_MercadolivreController extends Mage_Adminhtml_Controller_action
{

 protected function _initAction() {
  $this->loadLayout()
   ->_setActiveMenu('mercadolivre/items')
   ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
  
  return $this;
 }   
 
 public function indexAction() {
  $this->_initAction()
   ->renderLayout();
 }

 public function editAction() {
  $id     = $this->getRequest()->getParam('id');
  $model  = Mage::getModel('mercadolivre/product')->load($id);

  if ($model->getId() || $id == 0) {
   $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
   if (!empty($data)) {
    $model->setData($data);
   }

   Mage::register('mercadolivre_data', $model);

   $this->loadLayout();
   $this->_setActiveMenu('mercadolivre/items');

   $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
   $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

   $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

   $this->_addContent($this->getLayout()->createBlock('mercadolivre/adminhtml_mercadolivre_edit'))
    ->_addLeft($this->getLayout()->createBlock('mercadolivre/adminhtml_mercadolivre_edit_tabs'));

   $this->renderLayout();
  } else {
   Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mercadolivre')->__('Item does not exist'));
   $this->_redirect('*/*/');
  }
 }
 
 public function newAction() {
  $this->_forward('edit');
 }
 
 public function saveAction() {
  if ($data = $this->getRequest()->getPost()) {
   
	   /*
	   if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {    
	    try { 
	     $uploader = new Varien_File_Uploader('filename');
	              $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
	     $uploader->setAllowRenameFiles(false);
	     $uploader->setFilesDispersion(false);
	     $path = Mage::getBaseDir('media') . DS ;
	     $uploader->save($path, $_FILES['filename']['name'] );
	     
	    } catch (Exception $e) {        
	          }       
	      $data['filename'] = $_FILES['filename']['name'];
	   }
	    */ 
	   $imagem = $this->getRequest()->getPost('imagem'); 
	   $product_id = $this->getRequest()->getPost('product_id');
	   $categoria1 = $this->getRequest()->getPost('categoria1');
	   $categoria2 = $this->getRequest()->getPost('categoria2');
	   $categoria3 = $this->getRequest()->getPost('categoria3');
	   $categoria4 = $this->getRequest()->getPost('categoria4');
	   $categoria5 = $this->getRequest()->getPost('categoria5');
	   $categoria6 = $this->getRequest()->getPost('categoria6');
	   $categoria7 = $this->getRequest()->getPost('categoria7');
	   $title = $this->getRequest()->getPost('title');
	   $plano = $this->getRequest()->getPost('type');
	   $price = $this->getRequest()->getPost('price');
	   $quantidade = $this->getRequest()->getPost('quantidade');
	   $template_id = $this->getRequest()->getPost('template_id');
	   $content = $this->getRequest()->getPost('content');
	   
	   
	   
	   Mage::getSingleton('admin/session')->setImagemMl($imagem);
	   Mage::getSingleton('admin/session')->setProductIdMl($product_id);
	   Mage::getSingleton('admin/session')->setCategoria1Ml($categoria1);
	   Mage::getSingleton('admin/session')->setCategoria2Ml($categoria2);
	   Mage::getSingleton('admin/session')->setCategoria3Ml($categoria3);
	   Mage::getSingleton('admin/session')->setCategoria4Ml($categoria4);
	   Mage::getSingleton('admin/session')->setCategoria5Ml($categoria5);
	   Mage::getSingleton('admin/session')->setCategoria6Ml($categoria6);
	   Mage::getSingleton('admin/session')->setCategoria7Ml($categoria7);
	   Mage::getSingleton('admin/session')->setTitleMl($title);
	   Mage::getSingleton('admin/session')->setPlanoMl($plano);
	   Mage::getSingleton('admin/session')->setPriceMl($price);
	   Mage::getSingleton('admin/session')->setQuantidadeMl($quantidade);
	   Mage::getSingleton('admin/session')->setTemplateidMl($template_id);
	   Mage::getSingleton('admin/session')->setContentMl($content);
	   
	   
	   $model = Mage::getModel('mercadolivre/product');  
	   $model->setData($data)
	    ->setId($this->getRequest()->getParam('id'));
	   
	   try {
			    if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
			     $model->setCreatedTime(now())
			      ->setUpdateTime(now());
			    } else {
			     $model->setUpdateTime(now());
			    }
				    
			    $model->save();
				$lastId = $model->getId();
				if($lastId!='' && is_numeric($lastId)){
					$resource = Mage::getSingleton('core/resource');
					$writeConnection = $resource->getConnection('core_write');
					$table = $resource->getTableName('mercadolivre/product');
					$query = "UPDATE {$table} SET product_id = '{$product_id}' WHERE entity_id = ".(int)$lastId;
					$writeConnection->query($query);
				}
												
				
			    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('mercadolivre')->__('Item was successfully saved'));
			    Mage::getSingleton('adminhtml/session')->setFormData(false);
				
				$_helper = Mage::helper('mercadolivre');
	  			$_helper->loginMl();
				
			    if ($this->getRequest()->getParam('back')) {
			     $this->_redirect('*/*/edit', array('id' => $lastId));
			     return;
			    }
			    $this->_redirect('*/*/');
	    		return;
	   } catch (Exception $e) {
	                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
	                Mage::getSingleton('adminhtml/session')->setFormData($data);
	                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
	                return;
	   }
   }else{
   		$urll = Mage::helper('core/url')->getCurrentUrl();
		$code = Mage::app()->getRequest()->getParam('code');
		if (strpos($urll, '?') !== false && $code!='') {
				Mage::getSingleton('admin/session')->setCodeMl($code);			
				$urll = Mage::helper('core/url')->getHomeUrl().'mercadolivre/adminhtml_mercadolivre/save/key/'.Mage::app()->getRequest()->getParam('key').'/';
				header('Location:'.$urll);
				exit();
		}
	   	$code = ($code!='' ? $code :  Mage::getSingleton('admin/session')->getCodeMl());
		if($code!=''){
			//$urlLogin = self::getLoginUrl(Mage::helper('core/url')->getCurrentUrl());
			//echo $urlLogin.'<br />';
			
			$imagem = Mage::getSingleton('admin/session')->getImagemMl();
			$product_id = Mage::getSingleton('admin/session')->getProductIdMl();
			$categoria1 = Mage::getSingleton('admin/session')->getCategoria1Ml();
			$categoria2 = Mage::getSingleton('admin/session')->getCategoria2Ml();
			$categoria3 = Mage::getSingleton('admin/session')->getCategoria3Ml();
			$categoria4 = Mage::getSingleton('admin/session')->getCategoria4Ml();
			$categoria5 = Mage::getSingleton('admin/session')->getCategoria5Ml();
			$categoria6 = Mage::getSingleton('admin/session')->getCategoria6Ml();
			$categoria7 = Mage::getSingleton('admin/session')->getCategoria7Ml();
			$title = Mage::getSingleton('admin/session')->getTitleMl();
			$plano = Mage::getSingleton('admin/session')->getPlanoMl();
			$price = Mage::getSingleton('admin/session')->getPriceMl();
			$quantidade = Mage::getSingleton('admin/session')->getQuantidadeMl();
			$template_id = Mage::getSingleton('admin/session')->getTemplateidMl();
			$content = Mage::getSingleton('admin/session')->getContentMl();
			
			$price = number_format($price, 2, '.', '');
			$quantidade = number_format($quantidade, 0, '.', '');
			
			$_helper = Mage::helper('mercadolivre');
			$meli = $_helper->getMeli();
			$user = $meli->authorize($code, Mage::helper('core/url')->getCurrentUrl());
			
			if($categoria1!=''){
				$categoria = $categoria1;
			}
			if($categoria2!=''){
				$categoria = $categoria2;
			}
			if($categoria3!=''){
				$categoria = $categoria3;
			}
			if($categoria4!=''){
				$categoria = $categoria4;
			}
			if($categoria5!=''){
				$categoria = $categoria5;
			}
			if($categoria6!=''){
				$categoria = $categoria6;
			}
			if($categoria7!=''){
				$categoria = $categoria7;
			}
			
			if($template_id!='' && is_numeric($template_id)){
				$collectionPages = Mage::getModel('cms/page')->getCollection()->addFieldToFilter('is_active', 1)->addFieldToFilter('page_id', $template_id);
				foreach($collectionPages as $pages){
					$str_descc = $pages["content"];
					if($str_descc!=''){
						$str_Imageag = '<img src="'.$imagem.'" />';
						
						$content = str_replace('[description]', $content, $str_descc);
						$content = str_replace('[title]', $title, $content);
						$content = str_replace('[image]', $str_Imageag, $content);
					}
				}
			}
			
			$item = array(
			  "title" => $title,
			  "category_id" => $categoria,
			  "price" => $price,
			  "currency_id" => "BRL",
			  "available_quantity" => $quantidade,
			  "buying_mode" => "buy_it_now",
			  "listing_type_id" => $plano,
			  "condition" => "new",
			  "description" => $content,
			  "pictures" => array(
				array(
				  "source" => $imagem
				)
			  )
			);
			$search = $meli->post('/items', $item, array('access_token' => $user['body']->access_token));
			$statusRetorno1 = $search->status;
			$statusRetorno2 = $search[body]->status;
			$statusRetorno = ($statusRetorno1!='' ? $statusRetorno1 : $statusRetorno2);
			
			$IdMercadoLivre = $search[body]->id;
			$retorno = json_encode($search);
			$strMensagemRetorno = "Anúncios realizado no mercado livre - ".$IdMercadoLivre;
			if(is_numeric($statusRetorno)){
				if((int)$statusRetorno==400){
					$strMensagemRetorno = $search->cause[0]->message;
					if(trim($strMensagemRetorno)==''){
						$strMensagemRetorno = $search[body]->cause[0]->message;
					}
				}elseif((int)$statusRetorno==403){
					$strMensagemRetorno = $search->message;
					if(trim($strMensagemRetorno)==''){
						$strMensagemRetorno = $search[body]->message;
					}
				}
			}
			
			if($IdMercadoLivre!=''){
				$resource = Mage::getSingleton('core/resource');
				$writeConnection = $resource->getConnection('core_write');
				$table = $resource->getTableName('mercadolivre/product');
				$query = "UPDATE {$table} SET ml_id = '{$IdMercadoLivre}' WHERE product_id = ".(int)$product_id;
				$writeConnection->query($query);
			}else{
				$resource = Mage::getSingleton('core/resource');
				$writeConnection = $resource->getConnection('core_write');
				$table = $resource->getTableName('mercadolivre/product');
				$query = "DELETE FROM {$table} WHERE product_id = ".(int)$product_id;
				$writeConnection->query($query);
			}
			
			//echo $retorno.' - '.$code;
			//echo $strMensagemRetorno;
			//exit();
			
			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('mercadolivre')->__($strMensagemRetorno));
			Mage::getSingleton('adminhtml/session')->setFormData(false);
			if ($this->getRequest()->getParam('back')) {
			     $this->_redirect('*/*/edit', array('id' => $product_id));
			     return;
			}
			$this->_redirect('*/*/');
	    	return;
		}
   }
   Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mercadolivre')->__('Unable to find item to save'));
   $this->_redirect('*/*/');
 }
 
 public function deleteAction() {
  if( $this->getRequest()->getParam('id') > 0 ) {
   try {
    $model = Mage::getModel('mercadolivre/product');
     
    $model->setId($this->getRequest()->getParam('id'))
     ->delete();
      
    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
    $this->_redirect('*/*/');
   } catch (Exception $e) {
    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
   }
  }
  $this->_redirect('*/*/');
 }

    public function massDeleteAction() {
        $webIds = $this->getRequest()->getParam('mercadolivre');
        if(!is_array($webIds)) {
   Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($webIds as $webId) {
                    $web = Mage::getModel('mercadolivre/product')->load($webId);
                    $web->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($webIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
 
    public function massStatusAction()
    {
        $webIds = $this->getRequest()->getParam('mercadolivre');
        if(!is_array($webIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($webIds as $webId) {
                    $web = Mage::getSingleton('mercadolivre/mercadolivre')
                        ->load($webId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($webIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}