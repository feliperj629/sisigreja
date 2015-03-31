// JavaScript Document

//adiciona mascara de cnpj

function MascaraCNPJ(cnpj){

	if(mascaraInteiro(cnpj)==false){

		event.returnValue = false;

	}	

	return formataCampo(cnpj, '00.000.000/0000-00', event);

}



//adiciona mascara de cep

function MascaraCep(cep){

		if(mascaraInteiro(cep)==false){

		event.returnValue = false;

	}	

	return formataCampo(cep, '00.000-000', event);

}



//adiciona mascara de data

function MascaraData(data_nas){

	if(mascaraInteiro(data_nas)==false){

		event.returnValue = false;

	}	

	return formataCampo(data_nas, '00/00/0000', event);

}

function MascaraData(data_bat){

	if(mascaraInteiro(data_bat)==false){

		event.returnValue = false;

	}	

	return formataCampo(data_bat, '00/00/0000', event);

}

function MascaraData(data_res){

	if(mascaraInteiro(data_res)==false){

		event.returnValue = false;

	}	

	return formataCampo(data_res, '00/00/0000', event);

}

function MascaraData(data_bat_esp){

	if(mascaraInteiro(data_bat_esp)==false){

		event.returnValue = false;

	}	

	return formataCampo(data_bat_esp, '00/00/0000', event);

}



//adiciona mascara ao telefone

function MascaraTelefone( campo ) {

			

				function trata( valor,  isOnBlur ) {

					

					valor = valor.replace(/\D/g,"");             			

					valor = valor.replace(/^(\d{2})(\d)/g,"($1)$2"); 		

					

					if( isOnBlur ) {

						

						valor = valor.replace(/(\d)(\d{4})$/,"$1-$2");   

					} else {



						valor = valor.replace(/(\d)(\d{3})$/,"$1-$2"); 

					}

					return valor;

				}

				

				campo.onkeypress = function (evt) {

					 

					var code = (window.event)? window.event.keyCode : evt.which;	

					var valor = this.value

					

					if(code > 57 || (code < 48 && code != 8 ))  {

						return false;

					} else {

						this.value = trata(valor, false);

					}

				}

				

				campo.onblur = function() {

					

					var valor = this.value;

					if( valor.length < 13 ) {

						this.value = ""

					}else {		

						this.value = trata( this.value, true );

					}

				}

				

				campo.maxLength = 14;

			}



			//adiciona mascara ao Celular

function MascaraCelular( campo ) {

			

				function trata( valor,  isOnBlur ) {

					

					valor = valor.replace(/\D/g,"");             			

					valor = valor.replace(/^(\d{2})(\d)/g,"($1)$2"); 		

					

					if( isOnBlur ) {

						

						valor = valor.replace(/(\d)(\d{4})$/,"$1-$2");   

					} else {



						valor = valor.replace(/(\d)(\d{3})$/,"$1-$2"); 

					}

					return valor;

				}

				

				campo.onkeypress = function (evt) {

					 

					var code = (window.event)? window.event.keyCode : evt.which;	

					var valor = this.value

					

					if(code > 57 || (code < 48 && code != 8 ))  {

						return false;

					} else {

						this.value = trata(valor, false);

					}

				}

				

				campo.onblur = function() {

					

					var valor = this.value;

					if( valor.length < 13 ) {

						this.value = ""

					}else {		

						this.value = trata( this.value, true );

					}

				}

				

				campo.maxLength = 14;

			}



//adiciona mascara ao CPF

function MascaraCPF(cpf){

	if(mascaraInteiro(cpf)==false){

		event.returnValue = false;

	}	

	return formataCampo(cpf, '000.000.000-00', event);

}





//adiciona mascara ao RG

function MascaraRG(rg){

        if((rg)==false){

                event.returnValue = false;

        }       

        return formataCampo(rg, '99.999.999-*', event);

}





//valida CEP

function ValidaCep(cep){

	exp = /\d{2}\.\d{3}\-\d{3}/

	if(!exp.test(cep.value))

		alert('Numero de Cep Invalido!');		

}



//valida data

/*function ValidaData(data_nas){

	exp = /\d{2}\/\d{2}\/\d{4}/

	if(!exp.test(data_nas.value))

		alert('Data Invalida!');			

}*/



//valida o CPF digitado

function ValidarCPF(Objcpf){

	var cpf = Objcpf.value;

	exp = /\.|\-/g

	cpf = cpf.toString().replace( exp, "" ); 

	var digitoDigitado = eval(cpf.charAt(9)+cpf.charAt(10));

	var soma1=0, soma2=0;

	var vlr =11;

	

	for(i=0;i<9;i++){

		soma1+=eval(cpf.charAt(i)*(vlr-1));

		soma2+=eval(cpf.charAt(i)*vlr);

		vlr--;

	}	

	soma1 = (((soma1*10)%11)==10 ? 0:((soma1*10)%11));

	soma2=(((soma2+(2*soma1))*10)%11);

	

	var digitoGerado=(soma1*10)+soma2;

	if(digitoGerado!=digitoDigitado)	

		alert('CPF Invalido!');		

}



//valida numero inteiro com mascara

function mascaraInteiro(){

	if (event.keyCode < 48 || event.keyCode > 57){

		event.returnValue = false;

		return false;

	}

	return true;

}



//valida o CNPJ digitado

function ValidarCNPJ(ObjCnpj){

	var cnpj = ObjCnpj.value;

	var valida = new Array(6,5,4,3,2,9,8,7,6,5,4,3,2);

	var dig1= new Number;

	var dig2= new Number;

	

	exp = /\.|\-|\//g

	cnpj = cnpj.toString().replace( exp, "" ); 

	var digito = new Number(eval(cnpj.charAt(12)+cnpj.charAt(13)));

		

	for(i = 0; i<valida.length; i++){

		dig1 += (i>0? (cnpj.charAt(i-1)*valida[i]):0);	

		dig2 += cnpj.charAt(i)*valida[i];	

	}

	dig1 = (((dig1%11)<2)? 0:(11-(dig1%11)));

	dig2 = (((dig2%11)<2)? 0:(11-(dig2%11)));

	

	if(((dig1*10)+dig2) != digito)	

		alert('CNPJ Invalido!');

		

}



//formata de forma generica os campos

function formataCampo(campo, Mascara, evento) { 

	var boleanoMascara; 

	

	var Digitato = evento.keyCode;

	exp = /\-|\.|\/|\(|\)| /g

	campoSoNumeros = campo.value.toString().replace( exp, "" ); 

   

	var posicaoCampo = 0;	 

	var NovoValorCampo="";

	var TamanhoMascara = campoSoNumeros.length;; 

	

	if (Digitato != 8) { // backspace 

		for(i=0; i<= TamanhoMascara; i++) { 

			boleanoMascara  = ((Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".")

								|| (Mascara.charAt(i) == "/")) 

			boleanoMascara  = boleanoMascara || ((Mascara.charAt(i) == "(") 

								|| (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " ")) 

			if (boleanoMascara) { 

				NovoValorCampo += Mascara.charAt(i); 

				  TamanhoMascara++;

			}else { 

				NovoValorCampo += campoSoNumeros.charAt(posicaoCampo); 

				posicaoCampo++; 

			  }	   	 

		  }	 

		campo.value = NovoValorCampo;

		  return true; 

	}else { 

		return true; 

	}

}