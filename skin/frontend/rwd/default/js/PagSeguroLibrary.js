/*
 
 * Pagina desenvolvido por Clever Web - Mauro Lacerda
 * contato@cleverweb.com.br
 * www.cleverweb.com.br
 * */

// JavaScript Document

//Função verifica
function verificaCartao(valorTotal, int_QtdParcelasSemJuros){		
	PagSeguroDirectPayment.getBrand({
		cardBin: jQuery("input#cleverweb_pay_creditcardnumber").val(),
		success: function(response){
			var str_CardName = response.brand.name;
			var str_BinCard = response.brand.bin;
			var int_cvvSize = response.brand.cvvSize;				
			var str_International = response.brand.international;
			var str_validationAlgorithm = response.brand.validationAlgorithm;
			jQuery('#cleverweb_pay_strnmcartao').val(str_CardName);
			//alert(int_cvvSize);
			/*
			jQuery('#str_BinCartao').val(str_BinCard);
			jQuery('#str_CVVCartao').val(int_cvvSize);
			jQuery('#str_International').val(str_International);
			jQuery('#str_ValidacaoCartao').val(str_validationAlgorithm);
			*/
			jQuery('#cleverweb_pay_cartao-selecionado').show();
			jQuery('#cleverweb_pay_cartao-selecionado').html('<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/'+str_CardName+'.png" border="0" /> ' );
			mostraParcelas(valorTotal, int_QtdParcelasSemJuros, str_CardName);
		},
		error: function(response){},
		complete: function(response){}
	});
}


//Define Parcelas
//depois do brand
//maxInstallmentNoInterest: int_QtdParcelasSemJuros,
function mostraParcelas(valorTotal, int_QtdParcelasSemJuros, str_CardName){
		//alert(valorTotal+' - '+str_CardName+' - '+int_QtdParcelasSemJuros);
		//maxInstallmentNoInterest: int_QtdParcelasSemJuros,		
		PagSeguroDirectPayment.getInstallments({
			amount: valorTotal,
			brand: str_CardName,
			success: function(response){
				//console.log(response.installments);
				 var ContParcelas = '';
				 var valorParcelaReal = '';
				 var valorTotalReal = '';
				 var csjuros = '';				
				 jQuery.each(response.installments, function() {
						jQuery.each(this, function(){
							if(this.interestFree==true){
								csjuros = " sem juros";
							}else{
								csjuros = " com juros";
							}	
							valorParcelaReal = numeroParaMoeda(this.installmentAmount);
							valorTotalReal = numeroParaMoeda(this.totalAmount);													
							ContParcelas = ContParcelas+'<option value="'+this.quantity+';'+this.installmentAmount+'">'+this.quantity+' x '+valorParcelaReal+' || Total '+valorTotalReal+csjuros+'</option>';
							
						});
				   });				 
				 jQuery('#cleverweb_pay_parcelamentoPagSeguro').html('<select title="Parcelas:" class="input-text required-entry" id="cleverweb_pay_strparcelas" name="payment[strparcelas]" autocomplete="off" required="required">'+ContParcelas+'</select>');
			},
			error: function(response){},
			complete: function(response){}
		});
}
function moedaParaNumero(valor){
    return isNaN(valor) == false ? parseFloat(valor) :   parseFloat(valor.replace("R$","").replace(".","").replace(",","."));
}

function numeroParaMoeda(n, c, d, t){
    c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

function iniciarPagamentoForm(){	
	if(jQuery('#cleverweb_payb_strcpftit').val() != '' && jQuery('#cleverweb_payb_strdddtelfone').val() !=''){
		
		var meuHash = PagSeguroDirectPayment.getSenderHash();
		var tokenPagamento = '';
	    jQuery.ajax({
			method: "POST",
			url: '/app/code/community/CleverWeb/PagSeguro/Model/gera/geraHashFile.php',
			data: { hash: meuHash, token: tokenPagamento, card: 'd'+jQuery('#cleverweb_payb_strcpftit').val()  },
			success: function(html){
				//console.log("Data Saved: " + html);
			}
		});
	}
	
	if(jQuery('#cleverweb_pay_creditcardnumber').val()!='' && jQuery('#cleverweb_pay_strnmcartao').val() !='' && jQuery('#cleverweb_pay_creditcardcvv').val() !='' && jQuery('#cleverweb_pay_creditcardduedatemonth').val() != '' && jQuery('#cleverweb_pay_creditcardduedateyear').val() !=''){		
		var meuHash = PagSeguroDirectPayment.getSenderHash();
		//alert(meuHash);	                           
	    var param = {
	        cardNumber: jQuery('#cleverweb_pay_creditcardnumber').val(),
	        brand: jQuery('#cleverweb_pay_strnmcartao').val(),
	        cvv: jQuery('#cleverweb_pay_creditcardcvv').val(),
	        expirationMonth: jQuery('#cleverweb_pay_creditcardduedatemonth').val(),
	        expirationYear: jQuery('#cleverweb_pay_creditcardduedateyear').val(),
	        success: function(response){
	        	var tokenPagamento = response.card.token;
	        	jQuery.ajax({
		          method: "POST",
		          url: '/app/code/community/CleverWeb/PagSeguro/Model/gera/geraHashFile.php',
		          data: { hash: meuHash, token: tokenPagamento, card: jQuery('#cleverweb_pay_creditcardnumber').val()  },
		          success: function(html){
				  	//console.log("Data Saved: " + html);
				  }

		        }).done(function( msg ) {
		        	//console.log("Data Saved: " + msg);
		      	});
	        	
	            jQuery('#cleverweb_pay_meuhash').val(meuHash);
	            jQuery('#cleverweb_pay_tokenpagamento').val(tokenPagamento);
	        },
	        error: function(response){
	            console.log(response);
	        },
	        complete: function(response){
	            //nada
	        }
	    }				
	    PagSeguroDirectPayment.createCardToken(param);	                            		
	    if(jQuery('#cleverweb_pay_meuhash').val()!=''){
	        //return true;
	    }else{
	    	//return false;
	    }
	}else{
		//return false;
	}                        		
}



	