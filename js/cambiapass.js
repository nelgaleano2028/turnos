$(document).ready(main);


function main(){
	$("#form_pass").submit(validar);
	$(".pass").keyup(recibe_con);
	$("#passv, #nue_cont, #pass").keyup(textkey);
}

function textkey(){
	if( $(this).val() != "" ){
            $(".help-inline").fadeOut("slow");
			$("#val1, #val2, #val3").removeClass(".control-group error");
            return false;
        }
}



function validar(){
		$(".help-inline").remove();
		
		
		if($("#passv").val() == ""){
			$("#val1").addClass("control-group error");
			$("#passv").focus().after("<span class='help-inline'>Ingrese su Contrase&ntilde;a actual </span>");
			return false;
		}else if($("#nue_cont").val() == ""){
			$("#val2").addClass("control-group error");
			$("#nue_cont").focus().after("<span class='help-inline'>Ingrese una Contrase&ntilde;a</span>");
			return false;
		}else if($("#pass").val() == ""){
			$("#val3").addClass("control-group error");
			$("#pass").focus().after("<span class='help-inline'>Ingrese una Contrase&ntilde;a</span>");
			return false;
		}else if($("#nue_cont").val() != $("#pass").val()){
		$("#val2").addClass("control-group error");
			$("#nue_cont").focus().after("<span class='help-inline'>Las Contrase&ntilde;a no coinciden.</span>");
			return false;
			
		}else{
		
				$.ajax({url: "../../server/php/cambiapass.php",
						type: "POST",
						dataType: "html",
						data: $("#form_pass").serialize(),
						cache:false,
						async:true,
						success:function(data){
						
							var acceso = data.trim();
							
							if(acceso=='1'){
								error_validacion('ERROR',"Escriba su antigua Contrase\u00f1a");
								return false;
							}else if(acceso=='TURNOSJEFE'){
								modals("Notificacion","Se Ingresaron los Datos Correctamente","main_rherrera.php");							
								return false;
							}else if(acceso=='TURNOS'){
								modals("Notificacion","Se Ingresaron los Datos Correctamente","main_adminturnos.php");								
								return false;
							}else if(acceso=='TURNOSHE'){
								modals("Notificacion","Se Ingresaron los Datos Correctamente","main_turnoshe.php");								
								window.location='main_turnoshe.php';
								return false;
							}else if(acceso=='2'){
								success_validacion('EXITO',"Se modifico la contraseña correctamente");
								return false;
							}else{
								error_validacion('ERROR',acceso);
								return false;
							}
						
						}
				});	
				
				return false;
		}
}

function modals(titulo,mensaje,url){

	var modal='<!-- Modal -->';
			modal+='<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">';
			modal+='<div class="modal-header">';
			modal+='<h3 id="myModalLabel">'+titulo+'</h3>';
			modal+='</div>';
			modal+='<div class="modal-body">';
			modal+='<p>'+mensaje+'</p>';
			modal+='</div>';
			modal+='<div class="modal-footer">';
			modal+='<input type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true" value="Aceptar"/>';
			modal+='</div>';
			modal+='</div>';
	$("body").append(modal);
	
	$('#myModal').modal({
		keyboard: false,
		backdrop: "static"
	});
	
	$('#myModal').on('hidden', function () {
		window.location=url;
	});
	
}


function recibe_con(){
	var html=checkStrength($(this).val());
	$("#result").html(html);
	
	if(html == 'Muy Débil'){
		$("#nue_cont").addClass("input_short");
		return false;
	}else if(html =='Débil'){
		$("#nue_cont").addClass("input_weak");
		return false;
	}else if(html =='Bueno'){
		$("#nue_cont").addClass("input_good");
		return false;
	}else{
		$("#nue_cont").addClass("input_strong");
		return false;
	}
	return false;
}

function error_validacion(titulo,body){

	var error=' <div class="alert alert-error">';
		error+=' <a class="close" data-dismiss="alert" id="cerrar">×</a>';
		error+='<h4 class="alert-heading">'+titulo+'</h4>';
		error+=body;
		error+='</div>';
		$("#error").html(error);
		
		$("#cerrar").click(limpiar);
}

function success_validacion(titulo,body){

	var error=' <div class="alert alert-success">';
		error+=' <a class="close" data-dismiss="alert" id="cerrar">×</a>';
		error+='<h4 class="alert-heading">'+titulo+'</h4>';
		error+=body;
		error+='</div>';
		$("#error").html(error);
		
		$("#cerrar").click(limpiar);
}

function limpiar(){
	$("#passv, #nue_cont, #pass").val("");
	$('#result').html("");
	$("#nue_cont").removeClass("input_short");
		$("#nue_cont").removeClass("input_weak");
		$("#nue_cont").removeClass("input_good");
		$("#nue_cont").removeClass("input_strong");
		$('#result').removeClass('short');
		$('#result').removeClass('weak');
		$('#result').removeClass('good');
		$('#result').removeClass('strong');
		
}

function checkStrength(password){
    
	//initial strength
    var strength = 0
	
    //if the password length is less than 6, return message.
    if (password.length < 6) { 
		$('#result').removeClass();
		$("#nue_cont").removeClass("input_short");
		$("#nue_cont").removeClass("input_weak");
		$("#nue_cont").removeClass("input_good");
		$("#nue_cont").removeClass("input_strong");
		
		$('#result').addClass('short');
		return 'Muy Débil';
	}
    
    //length is ok, lets continue.
	
	//if length is 8 characters or more, increase strength value
	if (password.length > 7) strength += 1
	
	//if password contains both lower and uppercase characters, increase strength value
	if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))  strength += 1
	
	//if it has numbers and characters, increase strength value
	if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/))  strength += 1 
	
	//if it has one special character, increase strength value
    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/))  strength += 1
	
	//if it has two special characters, increase strength value
    if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
	
	//now we have calculated strength value, we can return messages
	
	//if value is less than 2
	if (strength < 2 ) {
		$('#result').removeClass();
		$("#nue_cont").removeClass("input_short");
		$("#nue_cont").removeClass("input_weak");
		$("#nue_cont").removeClass("input_good");
		$("#nue_cont").removeClass("input_strong");
		$('#result').addClass('weak');
		return 'Débil';			
	} else if (strength == 2 ) {
		$('#result').removeClass();
		$("#nue_cont").removeClass("input_short");
		$("#nue_cont").removeClass("input_weak");
		$("#nue_cont").removeClass("input_good");
		$("#nue_cont").removeClass("input_strong");
		$('#result').addClass('good');
		return 'Bueno'		
	} else {
		$('#result').removeClass();
		$("#nue_cont").removeClass("input_short");
		$("#nue_cont").removeClass("input_weak");
		$("#nue_cont").removeClass("input_good");
		$("#nue_cont").removeClass("input_strong");
		$('#result').addClass('strong');
		return 'Fuerte'
	}
}
