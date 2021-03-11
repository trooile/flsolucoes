
var _maskMoneyIntNegative ={thousands:'', decimal:'.', allowZero:true,allowNegative:false,precision:0 };
var _maskMoneyFloat ={thousands:'', decimal:'.', allowZero:true };
var _maskMoneyFloatZero ={thousands:'', decimal:'.', allowZero:false };
var _maskMoneyFloatZeroNegative ={thousands:'', decimal:'.', allowZero:false,allowNegative:false };
var _maskMoneyFloatPrecision3 ={thousands:'', decimal:'.', allowZero:false,precision:3 };
var _id_organization = getCookie('_id_organization');
var _tables_inic = [];

var cpfCnpjMask = function (val) { return val.replace(/\D/g, '').length >= 12 ? '00.000.000/0000-00' : '000.000.000-009';}
var cpfCnpjOptions = { onKeyPress: function(val, e, field, options) { field.mask(cpfCnpjMask.apply({}, arguments), options);}};

var phoneMask = function (val) {return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';};
var phoneOptions = {onKeyPress: function(val, e, field, options) {field.mask(telefoneMask.apply({}, arguments), options);}};
					
$.extend( true, $.fn.dataTable.defaults, {
	columnDefs: [
        { targets: '_all', orderDataType:'orderAll' }
    ],
	language: {
		decimal: ",",
		thousands: ".",
        lengthMenu: "_MENU_ registros por página",
        emptyTable: "Nenhum registro encontrado",
		zeroRecords: "Nenhum registro encontrado",
		info: "Página _PAGE_ de _PAGES_ (_TOTAL_ registros)",
		infoEmpty: "Nenhum registro encontrado.",
		infoFiltered: "(filtrado de _MAX_ registros)",
		sSearch: "Search",
		paginate: {
			previous: "<",
			next: ">"
		},
		buttons: {
			pageLength: {
				'_': "Paginação (%d)",
				'-1': "Paginação (Todos)"
			}
		}
	},
	lengthMenu: [
		[ 10, 25, 50, 100, -1 ],
		[ '10', '25', '50', '100', 'Todos' ]
    ],
    preDrawCallback: function(settings, json) {

        var datatable_tabela = $('#'+settings.sTableId).DataTable();
        var datatable_cookie = 'datatable'+window.location.pathname+settings.sTableId;

        if (  _tabelas_inicializadas.includes(datatable_cookie)) {

            if(window.location.pathname != '/financeiro/consignacao_por_cliente_detalhada.php' ){ // Bug no cookie, em muitas tabelas da bad request , estou pulando uma
                setCookie(datatable_cookie,datatable_tabela.search(),0.04);
            }
            
        }else{
            $('#'+settings.sTableId).DataTable().search(getCookie(datatable_cookie))
        }

    },
    initComplete: function( settings, json ) {
        _tabelas_inicializadas.push('datatable'+window.location.pathname+settings.sTableId);
    }
} );

$.fn.dataTable.ext.buttons.excelNumber = {
	text: 'Excel',
	extend: 'excel',
	exportOptions: {
		format: {
			body: function ( data, row, column, node ) {
				
				if(typeof data == 'string'){
					var tmpData = data.replace( /[,.]/g, '' );
					
					if(!isNaN(tmpData)){

						data = data.replace( /[,]/g, '.' );	
						data = data.replace(/[.](?=.*[.])/g, "");

					}
				}
				
				return data;
	
			}
		}
	}
};

$.fn.dataTable.ext.order['orderAll'] = function  ( settings, col )
{
	return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
        
		var data = $(td).html();

		if($(td).find('button').length){

			var data = $('button',td).html();

			var dataSplit = data.split(',');

			if(dataSplit.length > 1){
				data = dataSplit[0];
			}

		}
		
		if($(td).find('input').length){
			var data = $('input', td).val();
		}

        if(/<[a-z][\s\S]*>/i.test(data)){ 
            data = $(data).text();
        }

		if(typeof data == 'string'){

			var tmpData =  data.replace( /[,.:%]|(R\$)/g, '' );


			if(!isNaN(tmpData)){
				
				data = data.replace( /[,%]|(R\$)/g, '.' );
				data = data.replace(/[.](?=.*[.])/g, "");
				data = data * 1;

			}else{
					
				if(data.match(/^\d{2}[./\/]\d{2}[./\/]\d{4}$/)){
                    data = data.split("/").reverse().join(""); 
				}else{

					if(data.match(/^\d{2}[./\/]\d{2}[./\/]\d{4} \d{2}:\d{2}:\d{2}$/)){
						var data  = data.split(" ");
						data[0] = data[0].split("/").reverse().join(""); 
                        data = data.join("");
					}
				}
			}
		}

		return data;

	} );
}

$( document ).ready(function() {

    $(window).focus(function() {

        if(_id_empresa != getCookie('_id_empresa')){

            $(window).unbind('focus');

            alert('Foi detectado uma mudança de empresa em outra aba e por isso a tela atual será atualizada.');
            
            location.reload();
        }
      
    });

	$( document ).ajaxStart(function() {
		$('body').LoadingOverlay("show");
	});

	$( document ).ajaxComplete(function() {
		$('body').LoadingOverlay("hide");
    });
    
    $( document ).ajaxError(function() {
        alerta("Erro de requisição para o servidor. Faça a operação novamente.");
        $('body').LoadingOverlay("hide");
	});

	$.ajaxSetup({
		beforeSend: function (request){
            request.withCredentials = true;
            request.setRequestHeader("Authorization", "Basic " + btoa('admin' + ":" + 'password'));
		},
	});

	$(".numberOnly").keydown(function (e) {

        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||

            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||

            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||

            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||

            (e.keyCode >= 35 && e.keyCode <= 39)) {

            return;
        }

        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
	});

});

function invertView(id){
	var obj = document.getElementById(id);
	if (obj.style.display=="none") obj.style.display="block";
	else obj.style.display="none";
}

function formatDate(evento, objeto){
    var keypress=(window.event)?event.keyCode:evento.which;
    fieldName = eval (objeto);
    if (fieldName.value == '00/00/0000')
    {
            fieldName.value=""
    }

    caracteres = '0123456789';
    separacao1 = '/';
    conjunto1 = 2;
    conjunto2 = 5;
    if ((caracteres.search(String.fromCharCode (keypress))!=-1) && fieldName.value.length < (10))
    {
            if (fieldName.value.length == conjunto1 )
            fieldName.value = fieldName.value + separacao1;
            else if (fieldName.value.length == conjunto2)
            fieldName.value = fieldName.value + separacao1;
    }
    else
            event.returnValue = false;
}

function GetXmlHttpObject() 
{
		var xmlHttp=null;
		try 
		{

			xmlHttp=new XMLHttpRequest();
		} 
		catch (e) 
		{

			try {
					xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
				} 
			catch (e) 
			{
					xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		}
	return xmlHttp;
}


function checkPassword(){
	
	
	var pass = document.getElementById('password').value;
	var conf = document.getElementById('password2').value;
	var ret = true;
	
	if (pass.length<3){
		alert('Senha deve ter 3 caracteres ou mais.');
		ret = false;
	}
	
	
	if (ret && pass!=conf){
		alert('As senhas devem ser iguais.');
		ret = false;
	}
	
	return ret;
}

function clear_form_elements(ele) {

    $(ele).find(':input').each(function() {
        switch(this.type) {
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
			case 'hidden':
            case 'textarea':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
              //  this.checked = false;
			$(this).removeAttr('checked');
			break;
			case 'file':
			$(this).val(null);
			break;
        }
    });

}

function disable_elements(ele) {

    $(ele).find(':input').each(function() {		
        switch(this.type) {
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
			case 'hidden':
            case 'textarea':
            case 'checkbox':
            case 'radio':
                $(this).attr('disabled',"disabled");
                break;
        }
    });

}

function enable_elements(ele) {

   $(ele).find(':input').each(function() {		
       switch(this.type) {
           case 'password':
           case 'select-multiple':
           case 'select-one':
           case 'text':
			case 'hidden':
           case 'textarea':
           case 'checkbox':
           case 'radio':
               $(this).removeAttr('disabled');
               break;
       }
   });

}

function clear_status_required_elements(ele) {

    $(ele).find(':input').each(function() {
        switch(this.type) {
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
			case 'hidden':
            case 'textarea':
            case 'checkbox':
            case 'radio':
                $(this).removeClass("obrigatorio");
                break;
        }
    });
}


function popula_dados(form,json,newIndexCode){
	
	$.each(json, function(index, value) {

		if(typeof newIndexCode != 'undefined'){
			index = newIndexCode.replace('index',index);
		}

		if(!$(" input[name='"+index+"']",form).is(':file')){

			

			if($(" input[name='"+index+"']",form).is(':checkbox') || $(" input[name='"+index+"']",form).is(':radio')){
				
				$(" input[name='"+index+"'][value='"+value+"']",form).prop( "checked", true );
				
			}else{

				$(" input[name='"+index+"']",form).val(value);
				$(" select[name='"+index+"']",form).val(value);
				$(" textarea[name='"+index+"']",form).val(value);

			}

		}
	});

}

function remove_required(ele) {

	$(ele).find(':input').each(function() {
	    switch(this.type) {
			case 'password':
			case 'select-multiple':
			case 'select-one':
			case 'text':
			case 'hidden':
			case 'textarea':
			case 'checkbox':
			case 'radio':
				$(this).removeClass("obrigatorio");

				if($(this).hasClass('select2-hidden-accessible')){
						
						$(this).next().children().children().removeClass('obrigatorio');
				}
	            break;
	    }
	});

	$( ".tmp_alert_valida" ).remove();

	}

	/*
	Adiciona status obrigatorio
	*/

	function required_elements(elements) {

		$( ".tmp_alert" ).remove();

		result = [];

		result['valid'] = true;

		result['elements'] = [];

		$.each(elements, function(index, value) {

			if(!$(this).prop("disabled")){

				if ($(this).val() == '' || $(this).val() == null ){

					$(this).addClass("obrigatorio");
	
					result['valid'] = false;
					result['elements'].push($(this));
					
					if($(this).hasClass('select2-hidden-accessible')){
						
						$(this).next().children().children().addClass('obrigatorio');
					
						
					}

					if($(this).next().hasClass('cke')){
						
						$(this).next().addClass('obrigatorio');
						
					}
				}else{

					if($(this).hasClass('select2-hidden-accessible')){
						
						$(this).next().children().children().removeClass('obrigatorio');
					
						
					}else{
						$(this).removeClass("obrigatorio");
					}
			
					if($(this).next().hasClass('cke')){
					
						$(this).next().removeClass('obrigatorio');
						
					}
				}
			}
		});

		return result;
	}

	function validate_elements(form_element, ignora_se_not_required = false) {

		result = [];

		result['valid'] = true;
		result['elements'] = [];
		result['mensagem'] = '';

		$.each($('.validaCpfCnpj' , form_element), function(index, value) {
			if(!$(this).prop("disabled")){
				if(ignora_se_not_required == true 
					&& form_element.hasClass('required') == false 
					&& form_element.val() == '' ){

				}
				else{
					if(!validaCpfCnpj($(this))){
						result['valid'] = false;
						result['elements'].push($(this));
						result['mensagem'] += 'O campo CPF/CNPJ não é válido.';
						$(this).addClass("obrigatorio");
					}
				}
				
			}
		});

		$.each($('.validCpf' , form_element), function(index, value) {
			if(!$(this).prop("disabled")){
				if(ignora_se_not_required == true 
					&& form_element.hasClass('required') == false 
					&& form_element.val() == '' ){

				}
				else{
					if(!validaCpf($(this))){
						result['valid'] = false;
						result['elements'].push($(this));
						result['mensagem'] += 'O campo CPF não é válido.';
						$(this).addClass("obrigatorio");
					}
				}
			}
		});

		$.each($('.validaCnpj' , form_element), function(index, value) {

			if(!$(this).prop("disabled")){
				if(ignora_se_not_required == true 
					&& form_element.hasClass('required') == false
					&& form_element.val() == '' ){
					//ignora
				}
				else{
					if(!validaCnpj($(this))){
						result['valid'] = false;
						result['elements'].push($(this));
						result['mensagem'] += 'O campo CNPJ não é válido.';
						$(this).addClass("obrigatorio");
					}
				}
			}
		});

		$.each($('.validaEmail' , form_element), function(index, value) {

			if(!$(this).prop("disabled")){
				if(ignora_se_not_required == true 
					&& form_element.hasClass('required') == false
					&& form_element.val() == '' ){
					//ignora
				}
				else{
					if(!validaEmail($(this))){
						result['valid'] = false;
						result['elements'].push($(this));
						result['mensagem'] += 'O campo Email não é válido.';
						$(this).addClass("obrigatorio");
					}
				}
			}
		});

		$.each($('.validaLength' , form_element), function(index, value) {

			if(!$(this).prop("disabled")){
				if(ignora_se_not_required == true 
					&& form_element.hasClass('required') == false
					&& form_element.val() == '' ){
					//ignora
				}
				else{
					if($(this).attr('minlength') > $(this).val().length){
						result['valid'] = false;
						result['elements'].push($(this));
						result['mensagem'] += 'O campo '+$(this).attr('name')+' precisar ter no mínimo '+$(this).attr('minlength')+" caracteres.";
						$(this).addClass("obrigatorio");
					}
				}
			}
			
		});

		return result;
    }
    
    function validaSenha(senha,confirma_senha) {

		result = [];

		result['valid'] = true;
		result['elements'] = [];
        result['mensagem'] = '';
        
        if(senha != confirma_senha){
            result['valid'] = false;
            result['mensagem'] = 'Confirmação de senha não é igual a senha , digite novamente.';
        }else{

            var letraMinuscula = new RegExp("[a-z]");
            var letraMaiuscula = new RegExp("[A-Z]");
            var numero = new RegExp("[0-9]");

            var valido = false;

            if(senha.length >= 12){
                if(letraMinuscula.test(senha)){
                    if(letraMaiuscula.test(senha)){
                        if(numero.test(senha)){
                            valido = true;
                        }
                    }
                }
            }

            if(!valido){
                result['valid'] = false;
                result['mensagem'] = 'A senha deve conter no mínimo 12 caracteres , sendo eles: 1 letra minúscula, 1 letra maiúscula  e 1 número .';
            }

        }
       
		return result;
	}

	function validaDataInicioFim(data_inicio,data_fim){
		var valid = false;
		data_inicio = stringToDate(data_inicio);
		data_fim = stringToDate(data_fim);

		if (data_fim.getTime() >= data_inicio.getTime()){
			valid = true;
		}

		return valid

	}

	function validCpfCnpj(element){
		var textoLimpo = element.val().replace(/[.\-\/]/g,'')
		
		var retorno = false

		if(textoLimpo.length == 11){
			returnn = validCpf(element);
		}else{
			returnn = validCnpj(element);
		}

		return returnn;
	}

	function validCpf(element){

		CPF = element.val();
		if(!CPF){ return false;}
		erro  = new String;
		cpfv  = CPF;
		if(cpfv.length == 14 || cpfv.length == 11){
			cpfv = cpfv.replace('.', '');
			cpfv = cpfv.replace('.', '');
			cpfv = cpfv.replace('-', '');

			var nonNumbers = /\D/;

			if(nonNumbers.test(cpfv)){
				erro = "A verificacao de CPF suporta apenas números!";
			}else{
				if (cpfv == "00000000000" ||
					cpfv == "11111111111" ||
					cpfv == "22222222222" ||
					cpfv == "33333333333" ||
					cpfv == "44444444444" ||
					cpfv == "55555555555" ||
					cpfv == "66666666666" ||
					cpfv == "77777777777" ||
					cpfv == "88888888888" ||
					cpfv == "99999999999") {
							
					erro = "Número de CPF inválido!"
				}
				var a = [];
				var b = new Number;
				var c = 11;

				for(i=0; i<11; i++){
					a[i] = cpfv.charAt(i);
					if (i < 9) b += (a[i] * --c);
				}
				if((x = b % 11) < 2){
					a[9] = 0
				}else{
					a[9] = 11-x
				}
				b = 0;
				c = 11;
				for (y=0; y<10; y++) b += (a[y] * c--);

				if((x = b % 11) < 2){
					a[10] = 0;
				}else{
					a[10] = 11-x;
				}
				if((cpfv.charAt(9) != a[9]) || (cpfv.charAt(10) != a[10])){
					erro = "Número de CPF inválido.";
				}
			}
		}else{
			if(cpfv.length == 0){
				return false;
			}else{
				erro = "Número de CPF inválido.";
			}
		}
		if (erro.length > 0){

			return false;
		}else{
			return true;
		}
	}

	function validCnpj(element){
		CNPJ = element.val();
		if(!CNPJ){ return false;}
		erro = new String;
		if(CNPJ == "00.000.000/0000-00"){ erro += "CNPJ inválido\n\n";}
		CNPJ = CNPJ.replace(".","");
		CNPJ = CNPJ.replace(".","");
		CNPJ = CNPJ.replace("-","");
		CNPJ = CNPJ.replace("/","");

		var a = [];
		var b = new Number;
		var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];
		for(i=0; i<12; i++){
		a[i] = CNPJ.charAt(i);
		b += a[i] * c[i+1];
		}
		if((x = b % 11) < 2){
		a[12] = 0
		}else{
		a[12] = 11-x
		}
		b = 0;
		for(y=0; y<13; y++){
		b += (a[y] * c[y]);
		}
		if((x = b % 11) < 2){
		a[13] = 0;
		}else{
		a[13] = 11-x;
		}
		if((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){ erro +="Dígito verificador com problema!";}
		if (erro.length > 0){
			return false;    
		}else{
			return true
		}
	}

	function validEmail(element) {

		var email = element.val();

		if(email != "") {
			var filtro = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
			if(filtro.test(email)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}

	}
	function parserDataTable(json){

		if(json.error){
			alert(json.message);
			return [];
		}else{
			return json['data'];
		}
	}

	$.fn.serializeObject = function()
	{
	    var o = {};
	    var a = this.serializeArray();
	    $.each(a, function() {
	        if (o[this.name] !== undefined) {
	            if (!o[this.name].push) {
	                o[this.name] = [o[this.name]];
	            }
	            o[this.name].push(this.value || '');
	        } else {
	            o[this.name] = this.value || '';
	        }
	    });
	    return o;
	};

	function stringToDate(data){
		var data = data.split('/');
		
		return new Date(data[2],(data[1]-1),data[0])
	}

	function dateToScreen(data){
		var data = data.split('-');
		return data[2]+'/'+data[1]+'/'+data[0];
	}

	function dateToScreenComHora(data){
		if(data==null || data=='') return '';
		var tmp = data.split(' ');
		var data = tmp[0].split('-');
		return data[2]+'/'+data[1]+'/'+data[0] + ' ' + tmp[1];
	}

	function moneyToFloat(money){
		money = money.replace(/\./g,'');
		money = money.replace(',','.');
		money = parseFloat(money);
		return money
	}

	function floatToMoney(money, milhmoney){

		if(typeof(milhmoney) == 'undefined'){
			milhmoney = true
		}

		var negative  = '';
		if (money < 0){
			money = money * - 1
			negativo = '-'
		}
		var money = money.toFixed(2).split('.');
		if(milhmoney) money[0] = money[0].split(/(?=(?:...)*$)/).join('.');
		return negative+money.join(',');
	}

	function dataMesAnterior(){
		var date = new Date();
		date.setDate(1);
		date.setMonth(date.getMonth()-1);

		return date
	}

	function resizeIframe(obj) {
		obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
	}

	function randomInt(min,max){
		min = parseInt(min);
		max = parseInt(max);

		return Math.floor(Math.random() * (max - min + 1)) + min;
	}

	function dump(obj) {
   		 var out = '';
	    for (var i in obj) {
	        out += i + ": " + obj[i] + "\n";
	    }

	    alert(out);

	    var pre = document.createElement('pre');
	    pre.innerHTML = out;
	    document.body.appendChild(pre)
	}

	function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000) );
        var expires = "expires="+ d.toUTCString();

		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

	function getCookie(cname) {
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for(var i = 0; i <ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}
    
    function formatImageSelect2(state) {

        var textSelect2 = '';

        textSelect2 += '<div style="display:flex;">'
        
        textSelect2 += '<div class="col-xs-1"><img src="'+state.address_image+'" style="height:70px;width:50px;"/></div>';
        textSelect2 += '<div class="col-xs-11" style="padding-left:40px;font-size:14px;">'+state.text+'</div>';

        textSelect2 += '</div>';

        return $(textSelect2);
    }

	Date.prototype.addDays = function(days) {
	    var date = new Date(this.valueOf());
	    date.setDate(date.getDate() + days);
	    return date;
	}

	function slugify(str) {

		str = str.toLowerCase();

		str = str.replace(/^\s+|\s+$/g, '');

		const from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
		
		const to   = "aaaaaeeeeeiiiiooooouuuunc------";

		for (let i = 0, l = from.length; i < l; i++) {
		    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
		}

		str = str.replace(/[^a-z0-9 -]/g, '');

		str = str.replace(/\s+/g, '-');

		return str;
    };