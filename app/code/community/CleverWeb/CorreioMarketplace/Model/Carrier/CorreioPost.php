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
 * @package    CleverWeb_CorreioMarketplace
 * @copyright  Copyright (c) 2017 Clever Web
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class CleverWeb_CorreioMarketplace_Model_Carrier_CorreioPost  
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{

    protected $_code = 'correiopost';
	 protected $_clientRequest;

    protected $_result = null;

    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
    			
        if (!$this->getConfigFlag('active'))
        {
            //Desabilitado
            return false;
        }

        $result = Mage::getModel('shipping/rate_result');

        $error = Mage::getModel('shipping/rate_result_error');
        $error->setCarrier($this->_code);
        $error->setCarrierTitle($this->getConfigData('title'));

        $packagevalue = $request->getBaseCurrency()->convert($request->getPackageValue(), $request->getPackageCurrency()); //Recupera o valor dos produtos que estão no carrinho

        $frompcode = Mage::getStoreConfig('shipping/origin/postcode', $this->getStore()); //Pega o CEP da sua loja, da configuração do site.
        $topcode = $request->getDestPostcode(); //Pega o CEP digitado pelo usuário.
		$topcode = str_replace('-', '', $topcode);
        if(!ereg("^[0-9]{8}$", $topcode))
        {
            //CEP está errado
            $error->setErrorMessage('O CEP está errado');
            $result->append($error);
            Mage::helper('customer')->__('Invalid ZIP CODE');
            return $result;
        }
		
		
		$cart = Mage::getModel('checkout/cart')->getQuote();
		$somaCentimetroCubicoArray = array();
		$somaPesoArray = array();
		$cepArray = array();
		
		foreach ($cart->getAllItems() as $item) {
			$productId = $item->getProduct()->getId();
		    $productName = $item->getProduct()->getName();
		    $productPrice = $item->getProduct()->getPrice();
			$productSku = $item->getSku();
			$productQuantidade = $item->getQty();
			$productPeso = $item->getProduct()->getWeight();			
			
			$productComprimento = $item->getProduct()->getData('package_length');
			$productLargura = $item->getProduct()->getData('package_width');
			$productAltura = $item->getProduct()->getData('package_height');
			//$productEmpresa = $item->getProduct()->getSeller();
			
			$product =Mage::getModel('catalog/product')->load($productId); 
			$productEmpresaCode = $product['seller_id'];
			
			$address = Mage::getModel('customer/address')->load($productEmpresaCode);
			//print_r($address);
			$productEmpresaName = $address['company'];
			$productEmpresaCep = $address['postcode'];
			if(trim($productEmpresaCep)==''){
				$productEmpresaCep = $frompcode;
				$productEmpresaCep = str_replace('-', '', $productEmpresaCep);
			}
			
			$productComprimento = (trim($productComprimento)!='' && is_numeric($productComprimento) ? $productComprimento : 0 );
			$productLargura = (trim($productLargura)!='' && is_numeric($productLargura) ? $productLargura : 0 );
			$productAltura = (trim($productAltura)!='' && is_numeric($productAltura) ? $productAltura : 0 );
			$productEmpresaCode = (trim($productEmpresaCode)!='' && is_numeric($productEmpresaCode) ? $productEmpresaCode : 0 );
			
			
			$centimetroCubico = (($productAltura*$productLargura*$productComprimento)*(int)$productQuantidade);
			$centimetroCubico = round($centimetroCubico);
			
			$somaCentimetroCubicoArray[$productEmpresaCode] = $somaCentimetroCubicoArray[$productEmpresaCode] + $centimetroCubico;			
            $somaPesoArray[$productEmpresaCode] = $somaPesoArray[$productEmpresaCode] +($productPeso*(int)$productQuantidade); 
			$cepArray[$productEmpresaCode] = str_replace('-','',$productEmpresaCep);
			
			
			/*
			echo 'ID: '.$productId.'<br />';
			echo 'Nome: '.$productName.'<br />';
			echo 'Preço: '.$productPrice.'<br />';
			echo 'SKU: '.$productSku.'<br />';
			echo 'Quantidade: '.$productQuantidade.'<br />';
			echo 'Peso: '.$productPeso.'<br />';
			echo 'Comprimento: '.$productComprimento.'<br />';
			echo 'Largura: '.$productLargura.'<br />';
			echo 'Altura: '.$productAltura.'<br />';
			echo 'Empresa Code: '.$productEmpresaCode.'<br />';
			echo 'Empresa Nome: '.$productEmpresaName.'<br />';
			echo 'Empresa CEP: '.$productEmpresaCep.'<br />';
			echo 'SubTotal: '.$packagevalue.'<br />';
			
			echo '<br /><br />';
			*/
		}
		
		//print_r($somaCentimetroCubicoArray);
		//	echo '<br />';
		
		if (!$rates = $this->_doRequest($request)) {
                return false;
        }
		$str_ExibeMsgErro = "s";
		foreach ($rates as $rate) {
			$str_valorSomaFloatFinal = 0;
			$servico = $rate->getCode();
			
			$servico = str_replace('40010', '04014', $servico);
			$servico = str_replace('41106', '04510', $servico);
			
			
			$str_AR='n';
			$str_valorSomaFloatFinal = $this->_calculaFrete($somaCentimetroCubicoArray,$somaPesoArray,$cepArray,$servico,$cepArray[$indice],$topcode,$valorF='0',$str_CodCorreio='',$str_SenhaCorreio='',$str_AR='n');
			
			if($str_valorSomaFloatFinal!='0,00' && $str_valorSomaFloatFinal!='0.00'){
				$str_ExibeMsgErro = "n";
				$sweight = $request->getPackageWeight();
		        $method = Mage::getModel('shipping/rate_result_method'); //Recupera o peso dos produtos no carrinho.
		        $method->setCarrier($this->_code);
		        $method->setCarrierTitle($this->getConfigData('name'));
		        $method->setMethod($rate->getCode());
		        $method->setMethodTitle($this->_getMethodTitle($rate, $this->_canShowDeliverytime()));
		        $method->setPrice($str_valorSomaFloatFinal + $this->getConfigData('handling_fee')); //Diz ao Magento qual será o valor do frete
		        $method->setCost($str_valorSomaFloatFinal); //Grava o custo do frete. Note a diferença entre preço e custo, o preço é o que irá para o usuário e custo é uma informação sua, que não será exibida.
		            $result->append($method);
		        $this->_result = $result;
		        $this->_updateFreeMethodQuote($request); //Caso você tenha definido uma promoção ou um cartão de desconto que o frete seja gratuito essa função fará o trabalho para você.
		     }
			//echo $rate->getPrice().'<br />';
		}
		if($str_ExibeMsgErro=='s'){	
            echo '<script>alert("Não foi possivel calcular o frete para seu CEP");</script>';
		}
		        
        return $this->_result;
    }

    public function getAllowedMethods()
    {
        return array($this->_code => $this->getConfigData('title'));
    }
	
	protected function _canShowDeliverytime()
    {
        return (bool)$this->_getHelper()->getConfigData('show_deliverytime');
    }
	//protected function _calculaFrete($somaCentimetroCubicoArray=array(), $somaPesoArray=array(), $str_CodCorreio, $str_SenhaCorreio )
	protected function _calculaFrete($somaCentimetroCubicoArray=array(), $somaPesoArray=array(),$cepArray=array(),$servico,$CEPorigem,$CEPdestino,$valorF='0',$str_CodCorreio='',$str_SenhaCorreio='',$str_AR='n')
	{
		$somaCentimetroCubico = 0;
		$raizCubica = 0;
		$pesoCubico = 0;
		$str_valorSomaFloat = 0;
		foreach ($somaCentimetroCubicoArray as $indice => $valor) {
		    $somaCentimetroCubico = round($valor);
			$raizCubica = pow($somaCentimetroCubico, 1/3);
			$raizCubica = round($raizCubica);
			$altura = $raizCubica;
			$largura = $raizCubica;
			$comprimento = $raizCubica;
			
			$comprimento =  ((int)$comprimento < 16 ? 16 : (int)$comprimento );
			$largura =  ((int)$largura < 11 ? 11 : (int)$largura );
			$altura =  ((int)$altura < 2 ? 2 : (int)$altura );
				
			$pesoCubico = (($comprimento * $largura * $altura) / 6000);
			if($pesoCubico<=10){
            	$peso = $somaPesoArray[$indice];
            }else{
                if($pesoCubico>$somaPesoArray[$indice]){
                	$peso = $pesoCubico;
                }else{
                	$peso = $somaPesoArray[$indice];
                }
            }
			
			$servico = str_replace('40010', '04014', $servico);
			$servico = str_replace('41106', '04510', $servico);
			
			$urlCorreios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";	   
		    $correios = $urlCorreios."nCdEmpresa=".$str_CodCorreio."&sDsSenha=".$str_SenhaCorreio."&sCepOrigem=".$cepArray[$indice];
			$correios = $correios."&sCepDestino=".$CEPdestino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=".$comprimento;
		    $correios = $correios."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n&nVlValorDeclarado=".$valorF;
		    $correios = $correios."&sCdAvisoRecebimento=".$str_AR."&nCdServico=".$servico."&nVlDiametro=0&StrRetorno=xml";
			$result_frete = simplexml_load_file($correios);
			
			//print_r($result_frete);
			//echo $correios;
					
			$int_PrazoEntrega = $result_frete->cServico->PrazoEntrega;
			$resultValorFrete = $result_frete->cServico->Valor;
			$int_coddErro = $result_frete->cServico->Erro;
            $str_msgErro = $result_frete->cServico->MsgErro;
		    //echo "\$indice[$indice] => $valor.\n";
		    $str_valorFloat = str_replace('.', '', $resultValorFrete);
			$str_valorFloat = str_replace(',', '.', $str_valorFloat);
			$str_valorFloat = (float)$str_valorFloat;
			
		    /*
		    echo 'Prazo: '.$int_PrazoEntrega.'<br />';
			echo 'Valor: '.$resultValorFrete.'<br />';
			echo 'Valor float: '.$str_valorFloat.'<br />';
			echo 'CodErro: '.$int_coddErro.'<br />';
			echo 'msgErro: '.$str_msgErro.'<br />';
			echo 'cep origem: '.$cepArray[$indice].'<br />';
			echo 'cep destino: '.$topcode.'<br />';
			echo '<br /><br />';
			*/
			$str_valorSomaFloat = $str_valorSomaFloat + $str_valorFloat; 
			
		}
		$str_valorSomaFloat = number_format($str_valorSomaFloat,2,".","");
		return $str_valorSomaFloat;
	}

	protected function _doRequest(Mage_Shipping_Model_Rate_Request $request)
    {
        /* @var $client Storm_Correios_Model_Carrier_Webservice */
        $client = Mage::getModel('correios/carrier_webservice');
        $client->setShippingRequest($request);

        if (!$requestData = $client->request()) {
            return false;
        }

        $this->_setClientRequest($requestData);
        return $requestData;
    }
	protected function _setClientRequest(array $request)
    {
        $this->_clientRequest = $request;
        return $this;
    }
	protected function _getMethodTitle(Varien_Object $method, $includeDeliveryTime = false)
    {
        $title = $this->_getHelper()->getMethodTitle($method->getCode());

        if($method->getShowMessage() && $method->hasErrorMessage()) {
            $title .= sprintf(' - %s', $method->getErrorMessage());
        }
        
        if ($includeDeliveryTime) {
            if ($method->getDeliveryTime() > 1) {
                return $this->_getHelper()->__('%s (%d working days)', $title, $method->getDeliveryTime());
            } else {
                return $this->_getHelper()->__('%s (%d working day)', $title, $method->getDeliveryTime());
            }
        }

        return $title;
    }
	protected function _getHelper()
    {
        return Mage::helper('correios');
    }
	
	public function isTrackingAvailable()    {
        return true;
    }
	
	 public function getTrackingInfo($tracking){
        $result = $this->getTracking($tracking);
        if ($result instanceof Mage_Shipping_Model_Tracking_Result) {
            if ($trackings = $result->getAllTrackings()) {
                return $trackings[0];
            }
        } elseif (is_string($result) && !empty($result)) {
            return $result;
        }
        return false;
    }
	 public function getTracking($trackings) {
        $this->_result = Mage::getModel('shipping/tracking_result');
        foreach ((array) $trackings as $code) {
            $this->_getTracking($code);
        }
        return $this->_result;
    }
}
