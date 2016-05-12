$(document).ready(main);
/*metodo de inicio*/
function main(){
	$("#form_login").submit(validar);
	$("#usuario, #clave").keyup(textkey);
	$("#modal_contrasena").click(cambiar_contrasena);	
}

function trim(string){
    return string.replace(/^\s*|\s*$/g, '');
}

/*Metodo de Validacion de Logueo*/
function validar(){
	//alert("hola");return false;
	$(".help-inline").remove();
	if($("#usuario").val() == ""){
		$("#val1").addClass("control-group error");
		$("#usuario").focus().after("<span class='help-inline'>Ingrese un Usuario</span>");
		return false;
	}else if($("#clave").val()== ""){
		$("#val2").addClass("control-group error");
		$("#clave").focus().after("<span class='help-inline'>Ingrese una Contraseña</span>");
		return false;
	}else{
	
		$.ajax({url: "./server/php/ajax_login.php",
				type: "POST",
				dataType: "html",
				data: $("#form_login").serialize(),
				
				success:function(data){	
					
					//console.log(data); return false;
					

						var acceso=trim(data);
									
						if(acceso == "1"){

							
							$.ajax({
								
								url: "./server/php/buscar_usuario_jefe.php",
								type: "POST",
								dataType: "html",
								
								success:function(res){	
										
										//console.log(res); return false;
									if(res==1){
										
										error_validacion2();
										return false;
									
									}else{
									
										window.location.href="server/php/main_empleado.php";
											return false;
									}
								
								}
							});
							
							return false;
							
						}else{
						
							if(acceso == "2"){
								
								window.location.href="server/php/nuevopass.php";
								return false;
							
							}else{
								
								if(acceso == "3"){
									
									window.location.href="server/php/main_rherrera.php";
									return false;
								
								}else{
								
									if(acceso == "4"){
									
										window.location.href="server/php/main_turnoshe.php";
										return false;
									
									
									}else{
										
										if(acceso == "5"){
										
											window.location.href="server/php/main_adminturnos.php";
											return false;
										
										}else{
										
										if(acceso == "6"){
										
											window.location.href="server/php/main_ghumana.php";
											return false;
										
										}else{
											
											if(acceso== 7){
												
												error_validacion3();
												return false;
											
											}else{
											
												error_validacion();
												return false;
											
											}
											
										
										}
									
									}
								
								}
							
							}
							
						}
					}
			}
			});
		return false;
	}	
}


/*Metodo que elimina las clases cuando se escribe inputs*/
function textkey(){
	if( $(this).val() != "" ){
            $(".help-inline").fadeOut("slow");
			$("#val1, #val2, #val3").removeClass(".control-group error");
            return false;
        }
}
/*Metodo que crea un popup para recordar cuenta*/
function cambiar_contrasena(){
		var modal='<!-- Modal -->';
			modal+='<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
			modal+='<div class="modal-header">';
			modal+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
			modal+='<h3 id="myModalLabel">Recordar Cuenta</h3>';
			modal+='</div>';
			modal+='<div class="modal-body">';
			modal+='<p>Por favor digite su correo electr&oacute;nico ';
			modal+='y enviaremos autom&aacute;ticamente el usuario y la ';
			modal+='contrase&ntilde;a a su buz&oacute;n de entrada. ';
			modal+='Si no lo encuentras ah&iacute;, revisa en correo no deseado o spam.</p>';
			modal+='<form id="form_correo" class="well">';
			modal+='<div id="val3"><label class="control-label" for="correo">Escribe tu direcci&oacute;n de correo electr&oacute;nico.</label>';
			modal+='<div class="controls"><input id="email" name="email" type="text" class="span4" placeholder="ejemplo@dominio.com"></div></div>';
			modal+='<div><input id="enviar_click" type="submit" class="btn btn-primary" value="Enviar"/></div>';
			modal+='</form>';
			modal+='</div>';
			modal+='<div class="modal-footer">';
			modal+='<input type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true" value="Close"/>';
			modal+='</div>';
			modal+='</div>';
			
			$("body").append(modal);
			$("#email").keyup(textkey);
			$("#form_correo").submit(click_recordar_cuenta);
			
}
/*Metodo click que envia los datos para recordar la cuenta*/
function click_recordar_cuenta(){

	$(".help-inline").remove();
	if($("#email").val() == ""){
		$("#val3").addClass("control-group error");
		return false;
	}else if($("#email").val().indexOf('@', 0) == -1 || $("#email").val().indexOf('.', 0) == -1){
		$("#val3").addClass("control-group error");
		$("#email").focus().after("<span class='help-inline'>El correo electr&oacute;nico introducido no es correcto.</span>");
		return false;
	}else{
	$.ajax({url:"./server/php/envia_olvido_contrasena.php",
			data:$("#form_correo").serialize(),
			dataType:"html",
			type:"POST",
			cache:false,
			async:true,
			success:function(data){
				
				if(data == "true"){
					
					$("#email").after("<span class='help-inline' style='color:#468847;'>Se enviaron los datos de su cuenta  verifique su correo electr&oacute;nico.</span>");
					return false;
				}else{
					
					$("#email").after("<span class='help-inline' style='color:#b94a48;'>"+data+"</span>");
					
					return false;
				}
				
				
			}
		});
		return false;
	}	
}
/*Metodo que imprime un error en la parte superior al ingreso de los datos*/
function error_validacion(){

	var error=' <div class="alert alert-error">';
		error+=' <a class="close" data-dismiss="alert" id="cerrar">×</a>';
		error+='<h4 class="alert-heading">ERROR!</h4>';
		error+='Usuario Incorrecto.';
		error+='</div>';
		$("#error").html(error);
		
		$("#cerrar").click(limpiar);
	
	}
	
function error_validacion2(){


	var error=' <div class="alert alert-error">';
		error+=' <a class="close" data-dismiss="alert" id="cerrar">×</a>';
		error+='<h4 class="alert-heading">ERROR!</h4>';
		error+='No tiene acceso a este Modulo';
		error+='</div>';
		$("#error").html(error);
		
		$("#cerrar").click(limpiar);


}


function error_validacion3(){


	var error=' <div class="alert alert-error">';
		error+=' <a class="close" data-dismiss="alert" id="cerrar">×</a>';
		error+='<h4 class="alert-heading">ERROR!</h4>';
		error+='Debes cambiar tu contraseña en Monitores Web';
		error+='</div>';
		$("#error").html(error);
		
		$("#cerrar").click(limpiar);


}
/*Metodo que limpia los inputs del login*/
function limpiar(){
	$("#usuario, #clave").val("");
}