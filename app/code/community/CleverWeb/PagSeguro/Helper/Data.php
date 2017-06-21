<?php
/**
 * Clever Web - Mauro Lacerda
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL).
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Correio
 * @package    CleverWeb_CorreioPagSeguro
 * @copyright  Copyright (c) 2017 Clever Web
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class CleverWeb_PagSeguro_Helper_Data extends Mage_Core_Helper_Data{
	const XML_PATH_PAYMENT_PAGSEGURO_EMAIL              = 'payment/cleverweb_pay/merchant_email';
    const XML_PATH_PAYMENT_PAGSEGURO_TOKEN              = 'payment/cleverweb_pay/token';
    const XML_PATH_PAUMENT_PAGSEGURO_SANDBOX            = 'payment/cleverweb_pay/sandbox';
    const XML_PATH_PAYMENT_PAGSEGURO_SANDBOX_EMAIL      = 'payment/cleverweb_pay/sandbox_merchant_email';
    const XML_PATH_PAYMENT_PAGSEGURO_SANDBOX_TOKEN      = 'payment/cleverweb_pay/sandbox_token';
	const XML_PATH_PAYMENT_PAGSEGURO_SELERMAIL      	= 'payment/cleverweb_pay/selermail';
	const XML_PATH_PAYMENT_PAGSEGURO_PARCELANJUROS      = 'payment/cleverweb_pay/parcelasnjuros';	
	const XML_PATH_PAYMENT_PAGSEGURO_TAXA      			= 'payment/cleverweb_pay/taxapagseguro';
	const XML_PATH_PAYMENT_PAGSEGURO_TARIFA      		= 'payment/cleverweb_pay/tarifapagseguro';
	
	const XML_PATH_PAYMENT_PAGSEGURO_PRODUCAO_APPID      = 'payment/cleverweb_pay/appid';
	const XML_PATH_PAYMENT_PAGSEGURO_PRODUCAO_APPKEY     = 'payment/cleverweb_pay/appkey';	
	const XML_PATH_PAYMENT_PAGSEGURO_SANDBOX_APPID       = 'payment/cleverweb_pay/sandbox_appid';
	const XML_PATH_PAYMENT_PAGSEGURO_SANDBOX_APPKEY      = 'payment/cleverweb_pay/sandbox_appkey';
	
	
	//URLs PAGSeguro
	const URL_PATH_PAYMENT_PAGSEGURO_PRODUCAO_VZ      	= 'https://pagseguro.uol.com.br';
	const URL_PATH_PAYMENT_PAGSEGURO_SANDBOX_VZ      	= 'https://sandbox.pagseguro.uol.com.br';
	const URL_PATH_PAYMENT_PAGSEGURO_PRODUCAO_WS      	= 'https://ws.pagseguro.uol.com.br';
	const URL_PATH_PAYMENT_PAGSEGURO_SANDBOX_WS      	= 'https://ws.sandbox.pagseguro.uol.com.br';	
	const URL_PATH_PAYMENT_PAGSEGURO_PRODUCAO_STC      	= 'https://stc.pagseguro.uol.com.br';
	const URL_PATH_PAYMENT_PAGSEGURO_SANDBOX_STC      	= 'https://stc.sandbox.pagseguro.uol.com.br';
	
	
	public function getNotificacao($cod){
		$token = $this->getToken();
		$email = $this->getMerchantEmail();
		$appid = $this->getAppid();
		$appkey = $this->getAppkey();
		
		if ($this->isSandbox()){
			$url = self::URL_PATH_PAYMENT_PAGSEGURO_SANDBOX_WS;
		}else{
			$url = self::URL_PATH_PAYMENT_PAGSEGURO_PRODUCAO_WS;
		}
		//$urlEnvio = $url.'/v3/transactions/notifications/'.$cod.'?email='.$email.'&token='.$token;
		$urlEnvio = $url.'/v3/transactions/notifications/'.$cod.'?appId='.$appid.'&appKey='.$appkey;
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $urlEnvio,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: application/xml"
		  ),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);		
		curl_close($curl);		
		if ($err) {
		  return "cURL Error #:" . $err;
		} else {
		  return $response;
		}		
	}
	
	public function getTaxaPagseguro(){
		$taxa = Mage::getStoreConfig(self::XML_PATH_PAYMENT_PAGSEGURO_TAXA);
		$taxa = str_replace(',', '.', $taxa);
		if($taxa!='' && is_numeric((int)$taxa)){
			return $taxa;
		}else{
			return 0;
		}
	}
	
	public function getTarifaPagseguro(){
		$tarifa = Mage::getStoreConfig(self::XML_PATH_PAYMENT_PAGSEGURO_TARIFA);
		$tarifa = str_replace(',', '.', $tarifa);
		if($tarifa!='' && is_numeric((int)$tarifa)){
			return $tarifa;
		}else{
			return 0;
		}
	}
	
	public function getParcelasSjuros(){
		$intParcelas = Mage::getStoreConfig(self::XML_PATH_PAYMENT_PAGSEGURO_PARCELANJUROS);
		if($intParcelas!='' && is_numeric($intParcelas)){
			//
		}else{
			$intParcelas = 1;
		}
		return $intParcelas;
	}
	
	public function getUrlStc(){
		$urlStc = self::URL_PATH_PAYMENT_PAGSEGURO_PRODUCAO_STC;
		if ($this->isSandbox()){
			$urlStc = self::URL_PATH_PAYMENT_PAGSEGURO_SANDBOX_STC;
		}
		return $urlStc;
	}
	
	public function isSandbox(){
        return Mage::getStoreConfigFlag(self::XML_PATH_PAUMENT_PAGSEGURO_SANDBOX);
    }
	
	
	public function getAppid(){
		$appid = Mage::getStoreConfig(self::XML_PATH_PAYMENT_PAGSEGURO_PRODUCAO_APPID);
		if ($this->isSandbox()){
			$appid = Mage::getStoreConfig(self::XML_PATH_PAYMENT_PAGSEGURO_SANDBOX_APPID);
		}
		if (empty($appid)) {
            return false;
        }
		return $appid;
	}
	
	public function getAppkey(){
		$appkey = Mage::getStoreConfig(self::XML_PATH_PAYMENT_PAGSEGURO_PRODUCAO_APPKEY);
		if ($this->isSandbox()){
			$appkey = Mage::getStoreConfig(self::XML_PATH_PAYMENT_PAGSEGURO_SANDBOX_APPKEY);
		}
		if (empty($appkey)) {
            return false;
        }
		return $appkey;
	}
	
	public function getSelerMail(){
		return Mage::getStoreConfig(self::XML_PATH_PAYMENT_PAGSEGURO_SELERMAIL);
	}
		
	public function getToken(){
        //$this->checkTokenIntegrity();
        $token = Mage::getStoreConfig(self::XML_PATH_PAYMENT_PAGSEGURO_TOKEN);
        if ($this->isSandbox()) {
            $token = Mage::getStoreConfig(self::XML_PATH_PAYMENT_PAGSEGURO_SANDBOX_TOKEN);
        }
        if (empty($token)) {
            return false;
        }
        return Mage::helper('core')->decrypt($token);
    }
	
	 public function getMerchantEmail(){
        if ($this->isSandbox()) {
            return Mage::getStoreConfig(self::XML_PATH_PAYMENT_PAGSEGURO_SANDBOX_EMAIL);
        }
        return Mage::getStoreConfig(self::XML_PATH_PAYMENT_PAGSEGURO_EMAIL);
    }
	
	public function getURLaceitarvendedor($code){
		$url = ($this->isSandbox() ? self::URL_PATH_PAYMENT_PAGSEGURO_SANDBOX_VZ : self::URL_PATH_PAYMENT_PAGSEGURO_PRODUCAO_VZ);
		$url .= "/userapplication/v2/authorization/request.jhtml?code=$code";
		return $url;
	}
	
	public function getAutozacao($reference,$mail){
		
		$xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<authorizationRequest>
			<permissions>
				<code>CREATE_CHECKOUTS</code>
				<code>DIRECT_PAYMENT</code>
				<code>RECEIVE_TRANSACTION_NOTIFICATIONS</code>
				<code>SEARCH_TRANSACTIONS</code>
				<code>MANAGE_PAYMENT_PRE_APPROVALS</code>
			</permissions>
			<redirectURL>https://www.lojadoperfume.com.br/customer/account/edit/</redirectURL>
			<notificationURL>https://www.lojadoperfume.com.br/customer/account/edit/</notificationURL>
			<account>
		    	<email>'.$mail.'</email>
		    	<type>SELLER</type>
		  </account>
		</authorizationRequest>';
		
		
		$appid = $this->getAppid();
		$appkey = $this->getAppkey();
		$url = ($this->isSandbox() ? self::URL_PATH_PAYMENT_PAGSEGURO_SANDBOX_WS : self::URL_PATH_PAYMENT_PAGSEGURO_PRODUCAO_WS);
		$url .= "/v2/authorizations/request?appId=$appid&appKey=$appkey";
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $xml,
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: application/xml"
		  ),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);		
		curl_close($curl);		
		if ($err) {
		  return "cURL Error #:" . $err;
		} else {
		  return $response;
		}
	}


	public function getAutozacaoAdm($reference,$mail){
		
		$xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<authorizationRequest>
			<permissions>
				<code>CREATE_CHECKOUTS</code>
				<code>DIRECT_PAYMENT</code>
				<code>RECEIVE_TRANSACTION_NOTIFICATIONS</code>
				<code>SEARCH_TRANSACTIONS</code>
				<code>MANAGE_PAYMENT_PRE_APPROVALS</code>
			</permissions>
			<redirectURL>https://www.lojadoperfume.com.br/index.php/paineladm/system_config/edit/section/payment/key/'.$reference.'/</redirectURL>
			<notificationURL>https://www.lojadoperfume.com.br/index.php/paineladm/system_config/edit/section/payment/key/'.$reference.'/</notificationURL>
			<account>
		    	<email>'.$mail.'</email>
		    	<type>SELLER</type>
		  </account>
		</authorizationRequest>';
		
		
		$appid = $this->getAppid();
		$appkey = $this->getAppkey();
		$url = ($this->isSandbox() ? self::URL_PATH_PAYMENT_PAGSEGURO_SANDBOX_WS : self::URL_PATH_PAYMENT_PAGSEGURO_PRODUCAO_WS);
		$url .= "/v2/authorizations/request?appId=$appid&appKey=$appkey";
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $xml,
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: application/xml"
		  ),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);		
		curl_close($curl);		
		if ($err) {
		  return "cURL Error #:" . $err;
		} else {
		  return $response;
		}
	}
	
	public function enviaPagamento($xml){
		$appid = $this->getAppid();
		$appkey = $this->getAppkey();
		$url = ($this->isSandbox() ? self::URL_PATH_PAYMENT_PAGSEGURO_SANDBOX_WS : self::URL_PATH_PAYMENT_PAGSEGURO_PRODUCAO_WS);
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "$url/transactions/?appId=$appid&appKey=$appkey",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $xml,
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: application/xml"
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  return "cURL Error #:" . $err;
		} else {
		  return $response;
		}
	}
	
	public function getSessionId()   {
		$appid = $this->getAppid();
		$appkey = $this->getAppkey();		
        $url = ($this->isSandbox() ? self::URL_PATH_PAYMENT_PAGSEGURO_SANDBOX_WS : self::URL_PATH_PAYMENT_PAGSEGURO_PRODUCAO_WS);
		$url .= '/sessions?appId='.$appid.'&appKey='.$appkey;		
        $ch = curl_init($url);
        $params['appId'] = $appid;
        $params['token'] = $appkey;			
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_POSTFIELDS      => http_build_query($params),
                CURLOPT_POST            => count($params),
                CURLOPT_RETURNTRANSFER  => 1,
                CURLOPT_TIMEOUT         => 45,
                CURLOPT_SSL_VERIFYPEER  => false,
                CURLOPT_SSL_VERIFYHOST  => false,
            )
        );
        $response = null;
        try{
            $response = curl_exec($ch);
        }catch(Exception $e){
            Mage::logException($e);
            return false;
			//return 'erro';
        }	
		//return $response;	
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($response);
        if (false === $xml) {
            if (curl_errno($ch) > 0) {
                $this->writeLog('Falha de comunicação com API do PagSeguro: ' . curl_error($ch));
            } else {
                $this->writeLog(
                    'Falha na autenticação com API do PagSeguro. Verifique email e token cadastrados.
                    Retorno pagseguro: ' . $response
                );
            }
            return false;
        }
        return (string)$xml->id;
    }
	
	public function validaCPF($cpf = null) { 
	    // Verifica se um número foi informado
	    if(empty($cpf)) {
	        return false;
	    }	 
	    // Elimina possivel mascara
	    $cpf = ereg_replace('[^0-9]', '', $cpf);
	    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);	     
	    // Verifica se o numero de digitos informados é igual a 11 
	    if (strlen($cpf) != 11) {
	        return false;
	    }
	    // Verifica se nenhuma das sequências invalidas abaixo 
	    // foi digitada. Caso afirmativo, retorna falso
	    else if ($cpf == '00000000000' || 
	        $cpf == '11111111111' || 
	        $cpf == '22222222222' || 
	        $cpf == '33333333333' || 
	        $cpf == '44444444444' || 
	        $cpf == '55555555555' || 
	        $cpf == '66666666666' || 
	        $cpf == '77777777777' || 
	        $cpf == '88888888888' || 
	        $cpf == '99999999999') {
	        return false;
	     // Calcula os digitos verificadores para verificar se o
	     // CPF é válido
	     } else { 
	        for ($t = 9; $t < 11; $t++) {	             
	            for ($d = 0, $c = 0; $c < $t; $c++) {
	                $d += $cpf{$c} * (($t + 1) - $c);
	            }
	            $d = ((10 * $d) % 11) % 10;
	            if ($cpf{$c} != $d) {
	                return false;
	            }
	        }	 
	        return true;
	    }
	}
	 public function getPaymentHash($param=null){
        $isAdmin = Mage::app()->getStore()->isAdmin();
        $session = ($isAdmin)?'core/cookie':'checkout/session';
        $registry = Mage::getSingleton($session);

        $registry = ($isAdmin)?$registry->get('PsPayment'):$registry->getData('PsPayment');

        $registry = unserialize($registry);

        if (is_null($param)) {
            return $registry;
        }

        if (isset($registry[$param])) {
            return $registry[$param];
        }

        return false;
    }
	private function getAddressAttributeValue($address, $attributeId) {
        $isStreetline = preg_match('/^street_(\d{1})$/', $attributeId, $matches);

        if ($isStreetline !== false && isset($matches[1])) { //uses streetlines
            return $address->getStreet(intval($matches[1]));
        } else if ($attributeId == '') { //do not tell pagseguro
            return '';
        }
        return (string)$address->getData($attributeId);
    }
	
	 public function getStateCode($state)
    {
        if(strlen($state) == 2 && is_string($state))
        {
            return mb_convert_case($state,MB_CASE_UPPER);
        }
        else if(strlen($state) > 2 && is_string($state))
        {
            $state = $this->normalizeChars($state);
            $state = trim($state);
            $state = $this->stripAccents($state);
            $state = mb_convert_case($state, MB_CASE_UPPER);
            $codes = array(
                'AC'=>'ACRE',
                'AL'=>'ALAGOAS',
                'AM'=>'AMAZONAS',
                'AP'=>'AMAPA',
                'BA'=>'BAHIA',
                'CE'=>'CEARA',
                'DF'=>'DISTRITO FEDERAL',
                'ES'=>'ESPIRITO SANTO',
                'GO'=>'GOIAS',
                'MA'=>'MARANHAO',
                'MT'=>'MATO GROSSO',
                'MS'=>'MATO GROSSO DO SUL',
                'MG'=>'MINAS GERAIS',
                'PA'=>'PARA',
                'PB'=>'PARAIBA',
                'PR'=>'PARANA',
                'PE'=>'PERNAMBUCO',
                'PI'=>'PIAUI',
                'RJ'=>'RIO DE JANEIRO',
                'RN'=>'RIO GRANDE DO NORTE',
                'RO'=>'RONDONIA',
                'RS'=>'RIO GRANDE DO SUL',
                'RR'=>'RORAIMA',
                'SC'=>'SANTA CATARINA',
                'SE'=>'SERGIPE',
                'SP'=>'SAO PAULO',
                'TO'=>'TOCANTINS'
            );
            if ($code = array_search($state, $codes)) {
                return $code;
            }
        }
        return $state;
    }
 	public static function normalizeChars($s) {
        $replace = array(
            'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'È' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ñ' => 'N', 'Ò' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y',
            'ä' => 'a', 'ã' => 'a', 'á' => 'a', 'à' => 'a', 'å' => 'a', 'æ' => 'ae', 'è' => 'e', 'ë' => 'e', 'ì' => 'i',
            'í' => 'i', 'î' => 'i', 'ï' => 'i', 'Ã' => 'A', 'Õ' => 'O',
            'ñ' => 'n', 'ò' => 'o', 'ô' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'ú', 'û' => 'u', 'ü' => 'ý', 'ÿ' => 'y',
            'Œ' => 'OE', 'œ' => 'oe', 'Š' => 'š', 'Ÿ' => 'Y', 'ƒ' => 'f', 'Ğ'=>'G', 'ğ'=>'g', 'Š'=>'S',
            'š'=>'s', 'Ş'=>'S', 'ș'=>'s', 'Ș'=>'S', 'ş'=>'s', 'ț'=>'t', 'Ț'=>'T', 'ÿ'=>'y', 'Ž'=>'Z', 'ž'=>'z'
        );
        return preg_replace('/[^0-9A-Za-zÃÁÀÂÇÉÊÍÕÓÔÚÜãáàâçéêíõóôúü.\-\/ ]/u', '', strtr($s, $replace));
    }
	
	public function removeDuplicatedSpaces($string) {
        $string = $this->normalizeChars($string);

        return preg_replace('/\s+/', ' ', trim($string));
    }
	
	public function extractPhone($phone)
    {
        $digits = new Zend_Filter_Digits();
        $phone = $digits->filter($phone);
        //se começar com zero, pula o primeiro digito
        if (substr($phone, 0, 1) == '0') {
            $phone = substr($phone, 1, strlen($phone));
        }
        $originalPhone = $phone;

        $phone = preg_replace('/^(\d{2})(\d{7,9})$/', '$1-$2', $phone);

        if (is_array($phone) && count($phone) == 2) {
            list($area, $number) = explode('-', $phone);
            return array(
                'area' => $area,
                'number'=>$number
            );
        }

        return array(
            'area' => (string)substr($originalPhone, 0, 2),
            'number'=> (string)substr($originalPhone, 2, 9),
        );
    }
	/*
	public function checkTokenIntegrity(){
        $section = Mage::getSingleton('adminhtml/config')->getSection('payment');
        $frontendType = (string)$section->groups->cleverweb_pay->fields->token->frontend_type;

        if ('obscure' != $frontendType) {
            $this->writeLog(
                'O Token não está seguro. Outro módulo PagSeguro pode estar em conflito. Desabilite-os via XML.'
            );
        }
    }
	*/
}