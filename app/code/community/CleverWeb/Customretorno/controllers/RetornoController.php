<?php
class CleverWeb_Customretorno_RetornoController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
    	//https://www.lojadoperfume.com.br/index.php/customretorno/retorno/index/
    	$_helper = Mage::helper('cleverweb_pagseguro');
		
    	$notificationCode = $_POST['notificationCode'];		
		if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){
			echo 'retorno PagSeguro';
			$retorno = $_helper->getNotificacao($notificationCode);				
			if($retorno != 'Unauthorized' && $retorno !='Not Found'){
				$transaction = simplexml_load_string($retorno);
				$reference = $transaction->reference;
				$int_status = $transaction->status;
				if($int_status!=''){
					$int_status = trim($int_status);
					switch ($int_status) {					    
					    case '1':
					       	$state = 'new';
							$status = 'pending';
							$str_msg = 'Aguardando pagamento: o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.';
					        break;
					    case '2':
					        $state = 'processing';
							$status = 'processing';
							$str_msg = 'Em análise: o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.';
					        break;
						case '3':
					        $state = 'processing';
							$status = 'processing';
							$str_msg = 'Paga: a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.';
					        break;
						case '4':
					        $state = 'processing';
							$status = 'processing';
							$str_msg = 'Disponível: a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.';
					        break;
						case '5':
					        $state = 'payment_review';
							$status = 'payment_review';
							$str_msg = 'Em disputa: o comprador, dentro do prazo de liberação da transação, abriu uma disputa.';
					        break;
						case '6':
					        $state = 'closed';
							$status = 'closed';
							$str_msg = 'Devolvida: o valor da transação foi devolvido para o comprador.';
					        break;
					    case '7':
					        $state = 'canceled';
							$status = 'canceled';
							$str_msg = 'Cancelada: a transação foi cancelada sem ter sido finalizada.';
					        break;
						case '8':
					        $state = 'canceled';
							$status = 'canceled';
							$str_msg = 'Debitado: o valor da transação foi devolvido para o comprador.';
					        break;
						case '9':
					        $state = 'payment_review';
							$status = 'payment_review';
							$str_msg = 'Retenção temporária: o comprador contestou o pagamento junto à operadora do cartão de crédito ou abriu uma demanda judicial ou administrativa (Procon).';
					        break;
					}
					if($state!='' && $status!=''){			
						$order = Mage::getModel('sales/order')->loadByIncrementId($reference);
						$comment = $str_msg;
						$order->setState($state, $status, $comment, false);
						$order->save();
					}
					$nmArquivo = "notif-".date('d-m-Y-H-i').$notificationCode;
					$fp = fopen("app/code/community/CleverWeb/PagSeguro/Model/gera/$nmArquivo.txt", "w");
						$escreve = fwrite($fp, $retorno);
					fclose($fp);
				}
			}
		}else{
			$str_xml = '<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>
						<transaction>
						<date>2017-04-12T19:58:21.000-03:00</date>
						<code>7E6F6FBE-8963-4551-ABBE-9E131CD5B626</code>
						<reference>100000064</reference>
						<type>1</type>
						<status>7</status>
						<cancellationSource>INTERNAL</cancellationSource>
						<lastEventDate>2017-04-12T19:58:42.000-03:00</lastEventDate>
						<paymentMethod>
						<type>1</type>
						<code>101</code>
						</paymentMethod>
						<grossAmount>71.00</grossAmount>
						<discountAmount>0.00</discountAmount>
						<creditorFees>
						<installmentFeeAmount>0.00</installmentFeeAmount>
						<intermediationRateAmount>0.40</intermediationRateAmount>
						<intermediationFeeAmount>2.83</intermediationFeeAmount>
						</creditorFees>
						<netAmount>67.77</netAmount>
						<extraAmount>0.00</extraAmount>
						<installmentCount>1</installmentCount>
						<itemCount>1</itemCount>
						<items>
						<item>
						<id>229</id>
						<description>Teste de compra </description>
						<quantity>1</quantity>
						<amount>50.00</amount>
						</item>
						</items>
						<sender>
						<name>Mauro Silva</name>
						<email>contato@cleverweb.com.br</email>
						<phone>
						<areaCode>11</areaCode>
						<number>20356256</number>
						</phone>
						</sender>
						<shipping>
						<address>
						<street>Rua Aveleda</street>
						<number> 88</number>
						<complement>Bloco 05 Ap 02</complement>
						<district>S�o Paulo</district>
						<city>S�o Paulo</city>
						<state>SP</state>
						<country>BRA</country>
						<postalCode>03572330</postalCode>
						</address>
						<type>3</type>
						<cost>21.00</cost>
						</shipping>
						<applications>
						<application>
						<id>lojadoperfume</id>
						<name>lojadoperfume</name>
						<role>INTERMEDIATION</role>
						</application>
						</applications>
						</transaction>';
						/*
						$transaction = simplexml_load_string($str_xml);
						$reference = $transaction->reference;
						$status = $transaction->status;
						echo '<br />Status: '.$status.'<br />';
						echo 'Referencia: '.$reference.'<br />';
						
						
						
		
						$reference = '100000059';
						$state = 'canceled';
						$status = 'canceled';
						$str_msg = 'Cancelada: a transação foi cancelada sem ter sido finalizada.';
						$order = Mage::getModel('sales/order')->loadByIncrementId((string)$reference);						
						$order->setState($state, $status, $str_msg, false);
						$order->save();
						*/


		}
		
		/*
1	Aguardando pagamento: o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.
2	Em análise: o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.
3	Paga: a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.
4	Disponível: a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.
5	Em disputa: o comprador, dentro do prazo de liberação da transação, abriu uma disputa.
6	Devolvida: o valor da transação foi devolvido para o comprador.
7	Cancelada: a transação foi cancelada sem ter sido finalizada.
8	Debitado: o valor da transação foi devolvido para o comprador.
9	Retenção temporária: o comprador contestou o pagamento junto à operadora do cartão de crédito ou abriu uma demanda judicial ou administrativa (Procon).
		
		*/
    }
}