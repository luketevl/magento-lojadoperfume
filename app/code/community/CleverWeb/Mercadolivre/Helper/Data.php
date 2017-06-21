<?php
/*
 * Desenvolvido por: Mauro Lacerda
 * http://www.cleverweb.com.br
 */
 
require_once(Mage::getBaseDir('lib') . '/MercadoLivre/meli.php');

class CleverWeb_Mercadolivre_Helper_Data extends Mage_Core_Helper_Abstract{
	public static function auth($code,$url){
        // $url = Mage::getBaseUrl().'../mlapp.php';
         $session = self::getSession();
        if(isset($session['access_token'])){
            $meli = self::getMeli();
        }else{
            $session = array();
            $session['access_token'] = "";
            $session['expires_in'] = "";
            $session['refresh_token']  = "";
            $meli = self::getMeli();            
        }
        if($code || $session['access_token']) {
            // If code exist and session is empty
            if($code && !($session['access_token'])) {
                // If the code was in get parameter we authorize
                $user = $meli->authorize($code, $url);
                // var_dump($user);                
                // Now we create the sessions with the authenticated user
                $session['access_token'] = $user['body']->access_token;
                $session['expires_in'] = time() + $user['body']->expires_in;
                $session['refresh_token'] = $user['body']->refresh_token;
            } else {
                // We can check if the access token in invalid checking the time
                if($session['expires_in'] < time()) {
                    try {
                        // Make the refresh proccess
                        $refresh = $meli->refreshAccessToken();

                        // Now we create the sessions with the new parameters
                        $session['access_token'] = $refresh['body']->access_token;
                        $session['expires_in'] = time() + $refresh['body']->expires_in;
                        $session['refresh_token'] = $refresh['body']->refresh_token;
                    } catch (Exception $e) {
                        echo "Exception: ",  $e->getMessage(), "\n";
                    }
                }
            }           
            // $session['meli'] = $meli;
            Mage::getSingleton('admin/session')->setMLSession($session);
        }
    }

	public static function getLoginUrl($url){
        //$url = Mage::helper('adminhtml')->getUrl('mercadolivre/adminhtml_mercadolivre/*');
        $meli = self::getMeli();
        return $meli->getAuthUrl($url);
    }

	public static function isLogged(){
        $session = self::getSession();
        if(!$session['access_token'])
            return false;
        else{
            if($session['expires_in'] < time()) {
                    try {
                        $meli = self::getMeli();
                        // Make the refresh proccess
                        $refresh = $meli->refreshAccessToken();

                        // Now we create the sessions with the new parameters
                                                
                        $session['access_token'] = $refresh['body']->access_token;
                        $session['expires_in'] = time() + $refresh['body']->expires_in;
                        $session['refresh_token'] = $refresh['body']->refresh_token;
						
						Mage::getSingleton('admin/session')->setAccessToken($refresh['body']->access_token);
					    Mage::getSingleton('admin/session')->setExpiresIn(time() + $refresh['body']->expires_in);
					    Mage::getSingleton('admin/session')->setRefreshToken($refresh['body']->refresh_token);
						
						
                    } catch (Exception $e) {
                        echo "Exception: ",  $e->getMessage(), "\n";
                    }
                }
            return true;
        }
        
    }

	public static function getMeli(){
        $session = self::getSession();        
        //if(isset($session['access_token'])){
        //    $meli = new Meli(self::getAppid(),self::getSecretkey(), Mage::getSingleton('admin/session')->getAccessToken(), Mage::getSingleton('admin/session')->getRefreshToken());
        //}else{
            $meli = new Meli(self::getAppid(),self::getSecretkey());
        //}        
        return $meli;
    }

	public static function getSession(){
        return  Mage::getSingleton('admin/session')->getMLSession();
    }
	
	public static function getAppid(){
		//return '3283941090673231';
		return Mage::getStoreConfig('mercadolivre/general/app_id',Mage::app()->getStore());
	}
	
	public static function getSecretkey(){
		//return 'f69OvYyWuyI9Qty0POwfrq0NY5EalwNj';
		return Mage::getStoreConfig('mercadolivre/general/secret_key',Mage::app()->getStore());
	}
	
	
	public static function getCategoriasArray($cat=''){
		$meli = self::getMeli();
		$params = array();
		if($cat==''){
			$result = $meli->get('/sites/MLB/categories', $params);
			$cont = 0;	   
			foreach ($result as $searchItem):
				if($cont == 0){
					//print_r($searchItem);
						$strvaloresCategs[] = array('value' => '', 'label' => 'Selecione');
					foreach ($searchItem as $searchItem2):
						$strvaloresCategs[] = array('value' => $searchItem2->id, 'label' => $searchItem2->name);					
					endforeach;
				} 
				$cont = $cont + 1;
			endforeach;
		}else{
			$result = $meli->get('/categories/'.$cat, $params);
			$strvaloresCategs[] = array('value' => '', 'label' => 'Selecione');
			foreach ($result['body']->children_categories as $searchItem):
				$strvaloresCategs[] = array('value' => $searchItem->id, 'label' => $searchItem->name);
			endforeach;
		}
		return $strvaloresCategs;
	}

	public static function loginMl(){
		$code = Mage::app()->getRequest()->getParam('code');
		if(self::isLogged()){
		  	//echo 'Logado';
		}else{	  	
		  	$urll = Mage::helper('core/url')->getCurrentUrl();
			if (strpos($urll, '?') !== false) {
				$urll = str_replace('?', '', $urll);
				$urll = str_replace('=', '/', $urll);
				header('Location:'.$urll);
				exit();
			}
		  	//echo 'Não Logado: '.$_helper->getLoginUrl(Mage::helper('core/url')->getCurrentUrl());	  	
			if($code!=''){
				//ok
			}else{
			  	$urlLogin = self::getLoginUrl(Mage::helper('core/url')->getCurrentUrl());
				header('Location:'.$urlLogin);
				exit();
			}
		}
	}
	
}