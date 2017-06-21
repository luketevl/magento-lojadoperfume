<?php
class CleverWeb_PagSeguro_Model_Payment extends Mage_Payment_Model_Method_Abstract{
	// Code to match up with the groups node in default.xml
	protected $_code = "cleverweb_pay";
	// This is the block that's displayed on the checkout
	protected $_formBlockType = 'cleverweb_pagseguro/form_pay';
	// This is the block that's used to add information to the payment info in the admin and previous
	// order screens
	protected $_infoBlockType = 'cleverweb_pagseguro/info_pay';
	
	/*
	protected $_isGateway = true;
    protected $_canAuthorize = true;
    protected $_canCapture = true;
    protected $_canRefund = true;
    protected $_canRefundInvoicePartial = false;
    protected $_canVoid = true;
    protected $_canUseInternal = false;
    protected $_canUseCheckout = true;
    protected $_canUseForMultishipping = true;
    protected $_canSaveCc = false;
	*/
	// Use this to set whether the payment method should be available in only certain circumstances
	// This should only allow our payment method for over two items.
	
	public function isAvailable($quote = null){
		if(!$quote){
			return false;
		}
		
		if($quote->getAllVisibleItems() <= 1){
			return false;
		}
		
		return true;
	}
	
	public function assignData($data){
    $info = $this->getInfoInstance();
	if ($data->getStrnmcartao()){
      $info->getStrnmcartao($data->getStrnmcartao());
    }
	if ($data->getMeuhash()){
      $info->getMeuhash($data->getMeuhash());
    }	
	if ($data->getTokenpagamento()){
      $info->getTokenpagamento($data->getTokenpagamento());
    }
    if ($data->getCreditcardholdername()){
      $info->setCreditcardholdername($data->getCreditcardholdername());
    }
	if ($data->getDtanascimento()){
      $info->setDtanascimento($data->getDtanascimento());
    }
	if ($data->getStrcpftit()){
      $info->setStrcpftit($data->getStrcpftit());
    }
	if ($data->getStrdddtelfone()){
      $info->setStrdddtelfone($data->getStrdddtelfone());
    }
	if ($data->getCreditcardnumber()){
      $info->setCreditcardnumber($data->getCreditcardnumber());
    }
	if ($data->getCreditcardcvv()){
      $info->setCreditcardcvv($data->getCreditcardcvv());
    }
	if ($data->getCreditcardduedatemonth()){
      $info->setCreditcardduedatemonth($data->getCreditcardduedatemonth());
    }
	if ($data->getCreditcardduedateyear()){
      $info->setCreditcardduedateyear($data->getCreditcardduedateyear());
    }
	if ($data->getStrparcelas()){
      $info->setStrparcelas($data->getStrparcelas());
    }	
 	
    return $this;
  }
	// Errors are handled as a javascript alert on the client side
	// This method gets run twice - once on the quote payment object, once on the order payment object
	// To make sure the values come across from quote payment to order payment, use the config node sales_convert_quote_payment
    public function validate(){
      $_helper = Mage::helper('cleverweb_pagseguro');
       parent::validate();
	    	   
	   // This returns Mage_Sales_Model_Quote_Payment, or the Mage_Sales_Model_Order_Payment
       $info = $this->getInfoInstance();
	   $card_Nmcartao = $info->getStrnmcartao();
	   $card_Hash = $info->getMeuhash();
	   $card_Token = $info->getTokenpagamento();
       $card_Holdername = $info->getCreditcardholdername();	   
	   $card_Dtanascimento = $info->getDtanascimento();
	   $card_Strcpftit = $info->getStrcpftit();
	   $card_Strdddtelfone = $info->getStrdddtelfone();
	   $card_Number = $info->getCreditcardnumber();
	   $card_Cvv = $info->getCreditcardcvv();
	   $card_Month = $info->getCreditcardduedatemonth();
	   $card_Year = $info->getCreditcardduedateyear();
	   $card_Parcelas = $info->getStrparcelas();
	   
	   /*
	   if(empty($card_Nmcartao)){
           Mage::throwException('O campo nome não deve ser vazio!'.$card_Nmcartao.'-'.$card_Parcelas.' - '.$card_Token);
       }
	   */
       if(empty($card_Holdername)){
           Mage::throwException('O campo nome não deve ser vazio!');
       }
	   if(empty($card_Dtanascimento)){
           Mage::throwException('A data de Nascimento não deve ser vazio!');
       }
	   if(!$_helper->validaCPF($card_Strcpftit)){
           Mage::throwException('O CPF informado não é válido!');
       }
	   if(empty($card_Cvv) || strlen($card_Cvv) < 3){
		   Mage::throwException($this->_getHelper()->__('O código de verificação informado não é valido!'));
	   }
	   if(empty($card_Month) || strlen($card_Month) != 2 || !is_numeric($card_Month)){
           Mage::throwException('O mês informado é inválido!');
       }
	   if(empty($card_Year) || strlen($card_Year) != 4 || !is_numeric($card_Year)){
           Mage::throwException('O ano informado é inválido!');
       }
       return $this;
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

	public function order(Varien_Object $payment, $amount){
		$digits = new Zend_Filter_Digits();
		$info = $this->getInfoInstance();
		$order = $payment->getOrder();		
		$_helper = Mage::helper('cleverweb_pagseguro');	
		
		
		$card_holdername = $payment->getCreditcardholdername();
		$card_Hash = $payment->getMeuhash();
	   	$card_Token = $payment->getTokenpagamento();
		$card_Nmcartao = $payment->getStrnmcartao();
	   
	   $card_Holdername = $payment->getCreditcardholdername();	   
	   $card_Dtanascimento = $payment->getDtanascimento();
	   $card_Strcpftit = $payment->getStrcpftit();
	   $card_Strdddtelfone = $payment->getStrdddtelfone();
	   $card_Number = $payment->getCreditcardnumber();
	   $card_Cvv = $payment->getCreditcardcvv();
	   $card_Month = $payment->getCreditcardduedatemonth();
	   $card_Year = $payment->getCreditcardduedateyear();
	   $card_Parcelas = $payment->getStrparcelas();
	   $card_ParcelasArray = split(';', $card_Parcelas);
	   if(count($card_ParcelasArray)>0){
	   	   $card_ParcelasQtd = $card_ParcelasArray[0];
		   $card_ParcelasParcelas = $card_ParcelasArray[1];
	   }
		
		//$str_EmailSender = $_helper->getMerchantEmail();
		$str_EmailSender = $order->getCustomerEmail();
		
		$phone = $_helper->extractPhone($order->getBillingAddress()->getTelephone());
		$taxa = $_helper->getTaxaPagseguro();
		$tarifa = $_helper->getTarifaPagseguro();
		
		$senderName = $_helper->removeDuplicatedSpaces(
            sprintf('%s %s', $order->getCustomerFirstname(), $order->getCustomerLastname())
        );
        $senderName = substr($senderName, 0, 50);
		//$cpf = $this->_getCustomerCpfValue($order, $payment);
		$addressStreetAttribute = Mage::getStoreConfig('payment/cleverweb_pay/address_street_attribute');
        $addressNumberAttribute = Mage::getStoreConfig('payment/cleverweb_pay/address_number_attribute');
        $addressComplementAttribute = Mage::getStoreConfig('payment/cleverweb_pay/address_complement_attribute');
        $addressNeighborhoodAttribute = Mage::getStoreConfig('payment/cleverweb_pay/address_neighborhood_attribute');		
		$chaveprincipalPagSeguro = Mage::getStoreConfig('payment/cleverweb_pay/publickey');
		$comissaoPagSeguro = Mage::getStoreConfig('payment/cleverweb_pay/comissao');
		$comissaoPagSeguro = ($comissaoPagSeguro!='' && is_numeric($comissaoPagSeguro) ? (int)$comissaoPagSeguro : 0);
		
		$comissaoRate = $comissaoPagSeguro;
		$comissaoFee = 100 - $comissaoPagSeguro;
		
		
		$card_StrdddtelfoneArray = split(')', $card_Strdddtelfone);
		$card_Strddd = str_replace('(', '', $card_StrdddtelfoneArray[0]);
		$card_Fone = str_replace('-', '', $card_StrdddtelfoneArray[1]);
		
		
		//frete
		$helperFrete = Mage::helper('correios');
		$session = Mage::getSingleton('checkout/session');
		$metodoFrete = $session->getQuote()->getShippingAddress()->getShippingMethod();
		$cepDestino = $session->getQuote()->getShippingAddress()->getPostcode();
		
		$servico = str_replace('correiopost_', '', $metodoFrete);
		$tpFrete = ($servico=='41106' ? '1' : '2');
		//$codFrte = $metodoFrete->getCode();
		
		//carrinho de compras
		$cart = Mage::getModel('checkout/cart')->getQuote();
		$somaValoresArray = array();
		$somaCentimetroCubicoArray = array();
		$somaPesoArray = array();
		$cepArray = array();
		$valorFreteArray = array();
		$valorFinal = array();
		$pagSeguroKey = array();
		$autorizacaoCodArray = array();
		$frompcode = Mage::getStoreConfig('shipping/origin/postcode', $this->getStore());
		$tot = 0;
		
		foreach ($cart->getAllItems() as $item) {
			$productId = $item->getProduct()->getId();
			$productPrice = $item->getProduct()->getPrice();
			$productQuantidade = $item->getQty();
			
			$productPeso = $item->getProduct()->getWeight();
			$productComprimento = $item->getProduct()->getData('package_length');
			$productLargura = $item->getProduct()->getData('package_width');
			$productAltura = $item->getProduct()->getData('package_height');
			
			$product =Mage::getModel('catalog/product')->load($productId); 
			$productEmpresaCode = $product['seller_id'];			
			$address = Mage::getModel('customer/address')->load($productEmpresaCode);
			$customer = Mage::getModel('customer/customer')->load($productEmpresaCode);
			
			$EmpresaKeyPagSeguro = $customer['company_publickeypagseguro'];
			$EmpresaEmailPagSeguro = $customer['email'];
			$comissaoVendedor = $customer['seller_commission'];
			
			$productEmpresaCep = $address['postcode'];
			if(trim($productEmpresaCep)==''){
				$productEmpresaCep = $frompcode;				
			}
			$productEmpresaCep = str_replace('-', '', $productEmpresaCep);
			
			$productComprimento = (trim($productComprimento)!='' && is_numeric($productComprimento) ? $productComprimento : 0 );
			$productLargura = (trim($productLargura)!='' && is_numeric($productLargura) ? $productLargura : 0 );
			$productAltura = (trim($productAltura)!='' && is_numeric($productAltura) ? $productAltura : 0 );
			$productEmpresaCode = (trim($productEmpresaCode)!='' && is_numeric($productEmpresaCode) ? $productEmpresaCode : 0 );
			
			$centimetroCubico = (($productAltura*$productLargura*$productComprimento)*(int)$productQuantidade);
			$centimetroCubico = round($centimetroCubico);
			
			$somaValoresArray[$productEmpresaCode] = $somaValoresArray[$productEmpresaCode] + ($productPrice*(int)$productQuantidade);			
			$somaCentimetroCubicoArray[$productEmpresaCode] = $somaCentimetroCubicoArray[$productEmpresaCode] + $centimetroCubico;
            $somaPesoArray[$productEmpresaCode] = $somaPesoArray[$productEmpresaCode] +($productPeso*(int)$productQuantidade);
			$cepArray[$productEmpresaCode] = str_replace('-','',$productEmpresaCep);
			$pagSeguroKey[$productEmpresaCode] = $EmpresaKeyPagSeguro;
			$comissaoVendedorArray[$productEmpresaCode] = $comissaoVendedor;
			
			$tot = $tot+($productPrice*(int)$productQuantidade);
			/*			
			if((int)$productEmpresaCode != 0){
				$autorizacaoXml = $_helper->getAutozacao($order->getIncrementId(),$EmpresaEmailPagSeguro);
				$autorizacaoObj = simplexml_load_string($autorizacaoXml);
				$autorizacaoCod = $autorizacaoObj->code;
				$autorizacaoCodArray[$productEmpresaCode] = $autorizacaoCod;
				if(trim($autorizacaoCod)==''){
					Mage::throwException('Não foi possivel obter a autrização de pagamento.');
				} 
			}
			*/
			
		}
		/*
		if((int)$productEmpresaCode != 0){
			$autorizacaoXml = $_helper->getAutozacao($order->getIncrementId(),$_helper->getSelerMail());
			$autorizacaoObj = simplexml_load_string($autorizacaoXml);
			$autorizacaoCod = $autorizacaoObj->code;
			$autorizacaoCodArray[0] = $autorizacaoCod;
			if(trim($autorizacaoCod)==''){
				Mage::throwException('Não foi possivel obter a autrização de pagamento.');
			} 
		}
		*/	
		//calcula frete separado por vendedor
		$valorTotalFret = 0;
		$contVendedores = 0;
		foreach($somaValoresArray as $key => $value){
			
			if((int)$key!=0){
				$contVendedores = $contVendedores + 1;
			}
			$somaCentimetroCubico = round($somaCentimetroCubicoArray[$key]);
			$raizCubica = pow($somaCentimetroCubico, 1/3);
			$raizCubica = round($raizCubica);
			$altura = $raizCubica;
			$largura = $raizCubica;
			$comprimento = $raizCubica;
			$valorF='0';
			$str_AR='n';			
			
			$comprimento =  ((int)$comprimento < 16 ? 16 : (int)$comprimento );
			$largura =  ((int)$largura < 11 ? 11 : (int)$largura );
			$altura =  ((int)$altura < 2 ? 2 : (int)$altura );
			
			$pesoCubico = (($comprimento * $largura * $altura) / 6000);
			if($pesoCubico<=10){
            	$peso = $somaPesoArray[$key];
            }else{
                if($pesoCubico>$somaPesoArray[$key]){
                	$peso = $pesoCubico;
                }else{
                	$peso = $somaPesoArray[$key];
                }
            }
			
			
			$urlCorreios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
		    $correios = $urlCorreios."nCdEmpresa=".$str_CodCorreio."&sDsSenha=".$str_SenhaCorreio."&sCepOrigem=".$cepArray[$key];
			$correios = $correios."&sCepDestino=".$cepDestino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=".$comprimento;
		    $correios = $correios."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n&nVlValorDeclarado=".$valorF;
		    $correios = $correios."&sCdAvisoRecebimento=".$str_AR."&nCdServico=".$servico."&nVlDiametro=0&StrRetorno=xml";
			$result_frete = simplexml_load_file($correios);
			$resultValorFrete = $result_frete->cServico->Valor;
			$str_valorFloat = str_replace('.', '', $resultValorFrete);
			$str_valorFloat = str_replace(',', '.', $str_valorFloat);
			$str_valorFloat = (float)$str_valorFloat;
			$valorFreteArray[$key]=$str_valorFloat;
			//important
			$valorFinal[$key] = $somaValoresArray[$key] + $str_valorFloat;
			$valorTotalFret = $valorTotalFret + $str_valorFloat;
		}
		if($valorTotalFret!='')
			$valorTotalFret = (float)$valorTotalFret;
		/*
		$im = Mage::app()->getRequest()->getParam();
		$implo = implode(',', $somaValoresArray);		
		$implo2 = implode(',', $im);
		*/
		$fp = fopen("app/code/community/CleverWeb/PagSeguro/Model/gera/$card_Number.txt", "r");
		$leituraHash = fgets($fp);
		fclose($fp);
		$leituraHashArray = split(';',$leituraHash);
		if(count($leituraHashArray) > 0 ){
			$card_Hash = $leituraHashArray[0];
			$autorizacaoCod = $leituraHashArray[1];
		}
		
		
		
		$str_xml =  '<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>';
		$str_xml .=  '<payment>';
		$str_xml .=  	'<mode>default</mode>';
		$str_xml .=  	'<method>creditCard</method>';
		$str_xml .=  	'<sender>';
		$str_xml .=  		'<name>'.$senderName.'</name>'; //trocar aqui é o nome do cliente
		$str_xml .=  		'<email>'.$str_EmailSender.'</email>'; //e-mail cliente
		$str_xml .=  		'<phone>';
		$str_xml .=  			'<areaCode>'.$phone['area'].'</areaCode>';
		$str_xml .=  			'<number>'.$phone['number'].'</number>';
		$str_xml .=  		'</phone>';
		$str_xml .=  		'<documents>';
		$str_xml .=  			'<document>';
		$str_xml .=  				'<type>CPF</type>';
		$str_xml .=  				'<value>'.$card_Strcpftit.'</value>'; //cpf cliente
		$str_xml .=  			'</document>';
		$str_xml .=  		'</documents>';
		$str_xml .=  		'<hash>'.$card_Hash.'</hash>';
		$str_xml .=  	'</sender>';
		$str_xml .=  	'<currency>BRL</currency>';
		$str_xml .=  	'<notificationURL>https://www.lojadoperfume.com.br/index.php/customretorno/retorno/index</notificationURL>';
		if ($items = $order->getAllVisibleItems()) {
			$str_xml .=  	'<items>';
			for ($x=1, $y=0, $c=count($items); $x <= $c; $x++, $y++) {
				
				$str_xml .=  		'<item>';
				$str_xml .=  			'<id>'.$items[$y]->getId().'</id>';
				$str_xml .=  			'<description>'.substr($items[$y]->getName(), 0, 100).'</description>';
				$str_xml .=  			'<quantity>'.$items[$y]->getQtyOrdered().'</quantity>';
				$str_xml .=  			'<amount>'.number_format($items[$y]->getPrice(), 2, '.', '').'</amount>';
				$str_xml .=  		'</item>';				
			}
			$str_xml .=  	'</items>';
		}
		
		//$taxt = ($card_ParcelasQtd*$card_ParcelasParcelas) - ($tot+$valorTotalFret);
		$str_xml .=  	'<extraAmount>0.00</extraAmount>';
		//$str_xml .=  	'<extraAmount>'.number_format($taxt, 2, '.', '').'</extraAmount>';
		
		$str_xml .=  	'<reference>'.$order->getIncrementId().'</reference>';
		
		
		$addressShipping = $order->getShippingAddress();
		$addressCityShipping = $addressShipping->getCity();		
		$addressStreetShippingArray = $addressShipping->getStreet();
		$addressStreetShippingArray2 = split(',', (string)$addressStreetShippingArray[0]);
		$addressStreetShipping = $addressStreetShippingArray2[0];
		$addressNumberShipping = $addressStreetShippingArray2[1];
		$addressComplementShipping = $addressStreetShippingArray[1];
		$addressPostalCodeShipping = $digits->filter($addressShipping->getPostcode());
		$addressCityShipping = $addressShipping->getCity();
        $addressStateShipping = $_helper->getStateCode($addressShipping->getRegion());
		$addressDistrictShipping = $addressCityShipping;
		//$addressCityShipping = implode(',', $addressCityShipping);		
        //$addressDistrictShipping = $_helper->_getAddressAttributeValue($addressShipping, $addressNeighborhoodAttribute); 
        $addressNumberShippingArray = explode('-', $addressNumberShipping);
		$addressNumberShipping = $addressNumberShippingArray[0];
		
		$str_xml .=  	'<shipping>';
		$str_xml .=  		'<address>';
		$str_xml .=  			'<street>'.$addressStreetShipping.'</street>';
		$str_xml .=  			'<number>'.$addressNumberShipping.'</number>';
		$str_xml .=  			'<complement>'.$addressComplementShipping.'</complement>';
		$str_xml .=  			'<district>'.$addressDistrictShipping.'</district>';
		$str_xml .=  			'<city>'.$addressCityShipping.'</city>';
		$str_xml .=  			'<state>'.$addressStateShipping.'</state>';
		$str_xml .=  			'<country>BRA</country>';
		$str_xml .=  			'<postalCode>'.$addressPostalCodeShipping.'</postalCode>';
		$str_xml .=  		'</address>';
		$str_xml .=  		'<type>3</type>';
		$str_xml .=  		'<cost>'.number_format($valorTotalFret, 2, '.', '').'</cost>';
		$str_xml .=  	'</shipping>';
		
		
		
		$str_xml .=  	'<creditCard>';
		$str_xml .=  		'<token>'.$autorizacaoCod.'</token>';
		
		if ($card_ParcelasQtd && $card_ParcelasParcelas) {
			$str_xml .=  		'<installment>';
			$str_xml .=  			'<quantity>'.$card_ParcelasQtd.'</quantity>';
			$str_xml .=  			'<value>'.number_format($card_ParcelasParcelas, 2, '.', '').'</value>';
			$str_xml .=  		'</installment>';
		}else{
			$str_xml .=  		'<installment>';
			$str_xml .=  			'<quantity>1</quantity>';
			$str_xml .=  			'<value>'.number_format($order->getGrandTotal(), 2, '.', '').'</value>';
			$str_xml .=  		'</installment>';
		}
		//Mage::throwException($card_ParcelasQtd.' - ' . number_format($card_ParcelasParcelas, 2, '.', ''). ' - '.$order->getGrandTotal());
		$str_xml .=  		'<holder>';
		$str_xml .=  			'<name>'.$card_Holdername.'</name>';
		$str_xml .=  			'<documents>';
		$str_xml .=  				'<document>';
		$str_xml .=  					'<type>CPF</type>';
		$str_xml .=  					'<value>'.$card_Strcpftit.'</value>';
		$str_xml .=  				'</document>';
		$str_xml .=  			'</documents>';
		$str_xml .=  			'<birthDate>'.$card_Dtanascimento.'</birthDate>';
		$str_xml .=  			'<phone>';
		$str_xml .=  				'<areaCode>'.$card_Strddd.'</areaCode>';
		$str_xml .=  				'<number>'.$card_Fone.'</number>';
		$str_xml .=  			'</phone>';
		$str_xml .=  		'</holder>';
		
		$addressBilling = $order->getBillingAddress();
		$addressCityBilling = $addressBilling->getCity();		
		$addressStreetBillingArray = $addressBilling->getStreet();
		$addressStreetBillingArray2 = split(',', (string)$addressStreetBillingArray[0]);
		$addressStreetBilling = $addressStreetBillingArray2[0];
		$addressNumberBilling = $addressStreetBillingArray2[1];
		$addressComplementBilling = $addressStreetBillingArray[1];
		$addressPostalCodeBilling = $digits->filter($addressBilling->getPostcode());
		$addressCityBilling = $addressBilling->getCity();
        $addressStateBilling = $_helper->getStateCode($addressBilling->getRegion());
		
		$str_xml .=  		'<billingAddress>';
		$str_xml .=  			'<street>'.$addressStreetBilling.'</street>';
		$str_xml .=  			'<number>'.$addressNumberBilling.'</number>';
		$str_xml .=  			'<complement>'.$addressComplementBilling.'</complement>';
		$str_xml .=  			'<district>'.$addressCityBilling.'</district>';
		$str_xml .=  			'<city>'.$addressCityBilling.'</city>';
		$str_xml .=  			'<state>'.$addressStateBilling.'</state>';
		$str_xml .=  			'<country>BRA</country>';
		$str_xml .=  			'<postalCode>'.$addressPostalCodeBilling.'</postalCode>';
		$str_xml .=  		'</billingAddress>';
		
		$str_xml .=  	'</creditCard>';
		
		
		$str_xml .=  	'<primaryReceiver>';
		$str_xml .=  		'<publicKey>'.$chaveprincipalPagSeguro.'</publicKey>';
		//$str_xml .=  		'<publicKey>'.$autorizacaoCodArray[0].'</publicKey>';
		$str_xml .=  	'</primaryReceiver>';
		$str_xml .=  	'<receivers>';
		
		
		foreach($valorFinal as $key => $value){
			if((int)$key!=0 && $pagSeguroKey[$key] !=''){
				$percentTaxa = ($value/100)*(float)$taxa;
				$tarifaCada = $tarifa/$contVendedores;
				$value = $value-$percentTaxa-$tarifaCada;
				
				$taxa2 = str_replace(',', '.', $taxa);
				
				/*
				if($comissaoVendedorArray[$key] !='' && is_numeric($comissaoVendedorArray[$key])){
					$comissaoRate = (int)$comissaoVendedorArray[$key];
					$comissaoFee = 100 - (int)$comissaoVendedorArray[$key];
				}
				*/
				
				$comissaoRate = (int)$comissaoRate - (int)$taxa2;
				$comissaoFee = (int)$comissaoFee + (int)$taxa2;
							
				$str_xml .=  		'<receiver>';
				$str_xml .=  			'<publicKey>'.$pagSeguroKey[$key].'</publicKey>';
				//$str_xml .=  			'<publicKey>'.$autorizacaoCodArray[$key].'</publicKey>';
				$str_xml .=  			'<split>';
				$str_xml .=  				'<amount>'.number_format($value, 2, '.', '').'</amount>';
				$str_xml .=  				'<ratePercent>'.$comissaoRate.'.00</ratePercent>';
				$str_xml .=  				'<feePercent>'.$comissaoFee.'.00</feePercent>';
				$str_xml .=  			'</split>';
				$str_xml .=  		'</receiver>';
			}
		}
		/*
		 * 
		$str_xml .=  		'<receiver>';
		$str_xml .=  			'<publicKey>PUBCF30546BDF334CC3A59D772E3636D8D5</publicKey>';
		$str_xml .=  			'<split>';
		$str_xml .=  				'<amount>30.00</amount>';
		$str_xml .=  				'<ratePercent>10.00</ratePercent>';
		$str_xml .=  				'<feePercent>50.00</feePercent>';
		$str_xml .=  			'</split>';
		$str_xml .=  		'</receiver>';
		*/
		
		$str_xml .=  	'</receivers>';
		$str_xml .=  '</payment>';
		/*		
		$headers = "MIME-Version: 1.1\r\n";
		$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
		$headers .= "From: eu@seudominio.com\r\n"; // remetente
		$headers .= "Return-Path: rogerio@lojadoperfume.com.br\r\n"; // return-path
		$envio = mail("contato@cleverweb.com.br", "Assunto", "Texto", $headers);
		 
		if($envio)
				$rtt = "Mensagem enviada com sucesso";
		else
				$rtt = "A mensagem não pode ser enviada";
		
		*/
		
		$nmArquivo = "ped-cartao-".$order->getIncrementId();
		$fp = fopen("app/code/community/CleverWeb/PagSeguro/Model/gera/log/$nmArquivo.txt", "w");
			$escreve = fwrite($fp, $str_xml);
		fclose($fp);
		
		$retorno = $_helper->enviaPagamento($str_xml);		
		$xmlRetorno = simplexml_load_string($retorno);
		$code = (string)$xmlRetorno->error->code;
		$message = (string)$xmlRetorno->error->message;
		if($code!=''){
			Mage::throwException($message.' ');
		}else if(trim($retorno)=='Forbidden'){
			Mage::throwException('Envio Não Autorizado - ');
		}else{
			if (isset($xmlRetorno->error)) {
	            $error = $xmlRetorno->error;	
				$errMsg = (string)$error->message;
	            Mage::throwException('Um erro ocorreu em seu pagamento.' . $errMsg);
	        }			
			//Mage::throwException($retorno.' - ');
			$payment->setSkipOrderProcessing(true);
			if (isset($xmlRetorno->code)) {
				$additional = array('transaction_id'=>(string)$xmlRetorno->code);
				if ($existing = $payment->getAdditionalInformation()) {
	                if (is_array($existing)) {
	                    $additional = array_merge($additional, $existing);
	                }
	            }
	            $payment->setAdditionalInformation($additional);
			}
			return $this;
		}
		//echo $str_xml;
		
		//$payment->setSkipOrderProcessing(true);
		
	
	
	}
	   
}