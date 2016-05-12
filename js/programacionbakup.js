$(document).ready(main);
function main(){

	tiempo_sistema();
	
	//change para manejar el centro de costo de la programacion turnos y supernumerarios temporal
	$(".centro_costo").change(function(){ 
	
			 $("#contenido").html("");
			 $("#contenido2").html("");
			
			var centro_costo=$(".centro_costo").val();
			
			 if(centro_costo == '-1'){
			    $("#contenido").html("");
				$("#contenido2").html("");		
			 }
			
            var idCombo1 = $(this).val();
			var codigo = $('#cod_epl_sesion').val();
			var server=  $('#server').val();
            $.ajax({
                type : "POST",
                url : "ajax_cargos_anidados.php",                
                data : "idCombo1="+idCombo1+"&codigo="+codigo+"&server="+server,
                success : function(data){
				   $("#combo2").show('slow');
                   $("#combo2").html(data);
				   $(".cargo").change(function(){
						
						 var fecha=$(".anio").val()+"-"+$(".mes").val();
						 var centro_costo=$(".centro_costo").val();
					     var cargo=$(".cargo").val();
						 
						 if(cargo == '-1'){
							 $("#contenido").html("");
							 $("#contenido2").html("");
							 return false;
						 }
						 programacion(fecha, centro_costo, cargo, codigo);
						 auditoria(fecha, centro_costo, cargo, codigo );
		
				   });
				   
				   $(".anio, .mes").change(function(){
						
						 var fecha=$(".anio").val()+"-"+$(".mes").val();
						 var centro_costo=$(".centro_costo").val();
					     var cargo=$(".cargo").val();
						 var codigo = $('#cod_epl_sesion').val();
						 programacion(fecha, centro_costo, cargo, codigo);
						 auditoria(fecha, centro_costo, cargo, codigo );
		
				   });
				   
               }
           });
     
	  $('#meses, #anios').css('display', 'inline');
	});
	
	
	$(".supernume_tmp").change(function(){
		$.ajax({
			url : "ajax_supernume_reemp.php",
			type : "POST",			
			data : "id="+$(this).val(),
			dataType:'html',
			success:function(data){
				$("#super_reempl").html(data);	
			}
		});
		return false;
	});
	
	$("#imprimir_pdf").click(imprimir_pdf);
	$("#imprimir_excel").click(imprimir_excel);
	$("#correo_programacion").click(correo_programacion);
}

/* Funcion unica de modal para el correo*/
function modals_correo(titulo,mensaje){

	var modal='<!-- Modal -->';
			modal+='<div id="myModal3" class="modal2 hide fade" style="margin-top: 5%; background-color: rgb(41, 76, 139); color: #fff; z-index: 900000; behavior: url(../../css/PIE.htc);width: 60%;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">';
			modal+='<div class="modal-header" style="border-bottom: 0px !important;">';
			modal+='<button type="button" class="close" style="color:#fff !important;" data-dismiss="modal" aria-hidden="true">×</button>';
			modal+='<h4 id="myModalLabel">'+titulo+'</h4>';
			modal+='</div>';
			modal+='<div class="modal-body" style="max-width: 92% !important; background-color:#fff; margin: 0 auto; margin-bottom: 1%; border-radius: 8px; behavior: url(../../css/PIE.htc);">';
			modal+='<p>'+mensaje+'</p>';
			modal+='</div>';
		
			modal+='</div>';
	$("#main").append(modal);
	
	$('#myModal3').modal({
		keyboard: false,
		backdrop: "static" 
	});
	
	$('#myModal3').on('hidden', function () {
		$(this).remove();
	});
	
}
/*enviar correo la programacion*/
function correo_programacion(){

	var fecha=$(".anio").val()+"-"+$(".mes").val();
	var anio=$(".anio").val();
	var mes=$(".mes").val();
	var centro_costo=$(".centro_costo").val();
    var cargo=$(".cargo").val();
	var codigo=$('#cod_epl_sesion').val();

	 var empleados='empleados';	
		
		var	contenido = '<div id="correo_n">';
					contenido+='<form class="well">';
					contenido+='<div>';		
					contenido+='<label  for="selectmultiple" style="color:#000;">Destinatarios</label></div>';
					contenido+='<div>';	
					contenido+='<select data-placeholder="Seleccione usuarios.." id="selectmultiple" class="seleccionm" name="selectmultiple" multiple>';
					contenido+='</select></div>';
					contenido+='<div>';	
					contenido+='<label  for="textarea" style="color:#000; margin-top:5px;">Mensaje</label></div>';
					contenido+='<textarea class="texemail" name="textarea"style="color:#000;"></textarea>';
					contenido+= "<br><div class='validar' style='color:#fff !important; width:100%; text-align:center'></div>";
					contenido+='<div style="text-align:center;margin-top:10px;"><input type="button" id="enviar_email" name="singlebutton" class="btn btn-primary" value="Enviar"></div>';
					contenido+='</form>';
					contenido+='</div>';
		modals_correo("Enviar Planilla Email <i class='icon-envelope' ></i>",contenido);
		$("#selectmultiple").chosen({width:"95%"});
		
		$.ajax({
				url:"correo_empleado.php",
				type:"post",
				data:"correo="+empleados,
				success:function(data){
					$("#selectmultiple").html(data);
					$("#selectmultiple").trigger("liszt:updated");
				}
		});
		$.ajax({
				url:"email_programacion.php",
				type:"post",
				dataType: "html",
				data:"fecha="+fecha+"&cc="+centro_costo+"&cargo="+cargo+"&jefe="+codigo+"&anio="+anio+"&mes="+mes,
				success:function(data){
				//console.log(data); return  false;
					
					$("#correo_n .texemail").val(data);
					
					tinyMCE.init({
						selector: "textarea",
						inline: true,
						
						theme : "simple",
						width: "640",
						height: "190",
					});
					
					$("#enviar_email").click(enviar_email); //falta
				}
		});
		
}

function enviar_email(){
	
	var ta= $(".texemail").val();
	
		$.ajax({
			url:"enviar_correo.php",
			type:"post",
			data:"correo="+$("#selectmultiple").val()+"&mens="+ta+"&info="+1,
			beforeSend:function(){
				$("#enviar_email").attr("disabled","disabled");
				$('.validar').html("<span class='mensajes_info_correo'>Enviando...</span>");
			},
			success:function(data){
				$('.validar').html("<span class='mensajes_success'>"+data+"</span>");  //.mensajes_success
				$("#enviar_email").removeAttr("disabled");
			}
		});
}

/*Imprimir programacion*/
function imprimir_pdf(){
	
	var fecha=$(".anio").val()+"-"+$(".mes").val();
	var anio=$(".anio").val();
	var mes=$(".mes").val();
	var centro_costo=$(".centro_costo").val();
    var cargo=$(".cargo").val();
	var codigo=$('#cod_epl_sesion').val();
	
	window.open("imprimir_programacion.php?fecha="+fecha+"&cc="+centro_costo+"&cargo="+cargo+"&jefe="+codigo+"&anio="+anio+"&mes="+mes, '_blank');
		
}

function imprimir_excel(){

	var fecha=$(".anio").val()+"-"+$(".mes").val();
	var anio=$(".anio").val();
	var mes=$(".mes").val();
	var centro_costo=$(".centro_costo").val();
    var cargo=$(".cargo").val();
	var codigo=$('#cod_epl_sesion').val();

	window.open("imprimir_programacion_excel.php?fecha="+fecha+"&cc="+centro_costo+"&cargo="+cargo+"&jefe="+codigo+"&anio="+anio+"&mes="+mes, '_blank');
	
}

/*para validar la programacion del modulo Programacion de turnos*/
$("#validar_programacion").click(function(){
	//console.log("hola1");
	var contar= 0;	
	var mensaje =""; 
	$.ajax({
			url : "validar_programacion.php",
			type : "POST",
			data : "mes="+$(".mes").val()+"&ano="+$(".anio").val()+"&cod_cc2="+$(".centro_costo").val()+"&cod_car="+$(".cargo").val()+"&cod_epl_jefe="+$('#cod_epl_sesion').val(),
			dataType: "json",
			success:function(data){
			
				//console.log(data); 
					if(data != 1){
			
						for(i = 0; i < data.length; i++){
							//console.log(data[i].empleado.codigo);
							//console.log(data[i].empleado.horas);
							
							if(data[i].empleado.codigo != "undefined"){
								
								var oTable = $('#example').dataTable();
								var nFiltered = oTable.fnGetFilteredNodes();
								var vard=$("."+data[i].empleado.codigo,nFiltered);
									vard.css("color","red");
									
									contar = vard.css("color","red").length;
									console.log(contar);
									if(parseInt(contar) >= 1){
										mensaje="<p style='text-align:center; color:red; font-weight:bold;'>Faltan colaboradores por porgramar</p>";
										
									}else{
										$("."+data[i].empleado.horas,nFiltered).css("color","red");
										mensaje="<p style='text-align:center; color:red; font-weight:bold;'>Horas incompletas</p>";
										vard.css("color","black");
										contar=0;
									}
							}
							
							
						}
					}else{
						mensaje="<p style='text-align:center; color:green; font-weight:bold;'>Buena programación</p>";
					}
				
				Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})	
				return false;
					 // llama el archivo de alert.js
				
			}
		});
	
	return false;
});


/*para copiar la programacion del mes pasado*/
// CONFIRM DIALOG CON ALERT
$("#copiar_programacion").click(function(){
	
	var  contenido='<div id="mensaje">';
	     contenido+='<p style="color:black; text-align:center;" class="mensaje">Esta seguro que desea realizar esta acción?</p>';
		 contenido+= "<div class='validar'></div>";
		 contenido+='<div class="botones" style="text-align:center;">';
		 contenido+='<a href="#" style="color:#fff;"  id="aceptar_programacion" class="btn btn-primary">Aceptar</a>';
		 contenido+='<a href="#" style="color:#fff; margin-left:10px;" id="cancelar" class="btn btn-primary">Cancelar</a>';
		 contenido+='</div>'
	     contenido+='</div>';
		 
	modals("Informaci&oacute;n  <i class='icon-question-sign'></i>",contenido);
	
	$("#aceptar_programacion").click(function(){
		var fecha=$(".anio").val()+"-"+$(".mes").val();
		
		$.ajax({
			url : "copiar_programacion_antes.php",
			type : "POST",			
			data : "mes="+$(".mes").val()+"&ano="+$(".anio").val()+"&cod_cc2="+$(".centro_costo").val()+"&cod_car="+$(".cargo").val()+"&cod_epl_jefe="+$('#cod_epl_sesion').val(),
			dataType:'html',
			success:function(data){
				if(data==2){
					$('#myModal2').modal('hide');
					var mensaje="<p style='text-align:center; color:red; font-weight:bold;'>No hay programación para copiar</p>";
					Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})	 // llama el archivo de alert.js
					programacion(fecha, $(".centro_costo").val(), $(".cargo").val(), $('#cod_epl_sesion').val());
				    auditoria(fecha, $(".centro_costo").val(), $(".cargo").val(),  $('#cod_epl_sesion').val());
				}else if(data==1){
					$('#myModal2').modal('hide');
					var mensaje="<p style='text-align:center; color:red; font-weight:bold;'>Programación copiada Exitosamente</p>";
					Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})	 // llama el archivo de alert.js
					programacion(fecha, $(".centro_costo").val(), $(".cargo").val(), $('#cod_epl_sesion').val());
				    auditoria(fecha, $(".centro_costo").val(), $(".cargo").val(),  $('#cod_epl_sesion').val());
					
				}else if(data==3){
					$('#myModal2').modal('hide');
					var mensaje="<p style='text-align:center; color:red; font-weight:bold;'>Ya Existen empleados con programación</p>";
					Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})	 // llama el archivo de alert.js	
				}
			}
		});
		return false;
		
	 });
	
	$("#cancelar").click(function(){
		$('#myModal2').modal('hide');
	 });	
});

/*Formulario para reemplazar el supernumerario tmp por un supuernumerario asignado desde gestion humana*/
$("#supernume_reemplazo").click(function(){
	$(".error").remove();
	
	if($("#su_reemp .supernume_tmp").val() == -1){
		$("#su_reemp .supernume_tmp").after("<span class='error' style='color:red; font-size:14px;'> Obligatorio </span>");
		return false;
	}else if($("#su_reemp .supernume_re").val() == -1){
		$("#su_reemp .supernume_re").after("<span class='error' style='color:red; font-size:14px;'> Obligatorio </span>");
		return false;
	}else{
		$.ajax({
			url : "ajax_reemplazo.php",
			type : "POST",			
			data : $("#su_reemp").serialize(),
			//dataType:'html',
			success:function(data){
				if(data==1){
					var mensaje="Se guardo satisfactoriamente";
					$("#su_reemp  select").val(-1);
					Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})	 // llama el archivo de alert.js
					$("#super_reempl").hide('slow');
				}else if(data==2){
					var mensaje="No Se guardo el registro";
					$("#su_reemp  select").val(-1);
					Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})	 // llama el archivo de alert.js
					$("#super_reempl").hide('slow');
				}else{
					var mensaje="<span class='error' style='color:red; font-size:14px;'> El Supernumerario temporal debe tener programación</span>";
					$("#su_reemp  select").val(-1);
					Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})	 // llama el archivo de alert.js
					$("#super_reempl").hide('slow');
				
				}
			}
		});
	}

	return false;
});

/*para crear los supuernumerarios temporales*/
$("#supernume_temp").click(function(){
	$(".error").remove();
	if($("#su_temp input[type=text]").val() == 0){
		$("#su_temp .nombre").after("<span class='error' style='color:red; font-size:14px;'> Obligatorio </span>");
			return false;
	}else if($("#su_temp .anio").val() == -1){
		$("#su_temp .ano").after("<span class='error' style='color:red; font-size:14px;'> Obligatorio </span>");
		return false;
	}else if($("#su_temp .mes").val() == -1){
		$("#su_temp .mes_super").after("<span class='error' style='color:red; font-size:14px;'> Obligatorio </span>");
		return false;
	}else if($("#su_temp .centro_costo").val() == -1){
		$("#su_temp .centro_costo_tmp").after("<span class='error' style='color:red; font-size:14px;'> Obligatorio </span>");
		return false;
	}else if($("#su_temp .cargo").val() == -1){
		$("#su_temp .cargo_tmp").after("<span class='error' style='color:red; font-size:14px;'> Obligatorio </span>");
		return false;
	}
	
	$.ajax({
		type : "POST",
        url : "add_super_temp.php",                
        data : $("#su_temp").serialize(),
        success : function(data){
			if(data=='1'){
				var mensaje="Se guardo satisfactoriamente";
				$("#su_temp input[type=text]").val("");
				$("#su_temp select").val(-1);
				$("#combo2").hide('slow');
				Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})	 // llama el archivo de alert.js
			}else{
				var mensaje="No se ha podido guardar la informaci&oacute;n";  
				Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})  // llama el archivo de alert.js
			}
		}
	});
	return false;
});

/*Este metodo es imvocado desde la programacion_turnos.php*/
function programacion_empleado(cod_epl,nombre){

	var mes=$(".mes").val();
	var anio=$(".anio").val();
	var fecha=anio+"-"+mes;
	var centro_costo=$(".centro_costo").val();
	var cargo=$(".cargo").val();
	var jefe_prog=$("#jefe_programacion").val();
	$.ajax({
		url:"programacion_manual.php",
		type:"POST",
		data:"mes="+mes+"&cod_epl="+cod_epl+"&anio="+anio,
		success:function(data){
			
			//console.log(data); return false;
			//progra_turnos_ciclos(nombre,mes,anio,cod_epl,jefe_prog);
			if(data==1){
				modals(nombre,"<div style='text-align:center; color:rgb(41, 76, 139);font-weight: bold;'>Ya tiene programaci&oacute;n asignada</div>");
			}else{
				progra_turnos_ciclos(nombre,mes,anio,cod_epl,jefe_prog);
			}
			
			/*if(data==2){
				progra_turnos_ciclos(nombre,mes,anio,cod_epl,jefe_prog);
			
			}else if(data==1){
		
				modals(nombre,"<div style='text-align:center; color:rgb(41, 76, 139);font-weight: bold;'>Ya tiene programaci&oacute;n asignada</div>");
		
			}else{
			
				var	mensaje = '<div id="usuario_n" style="color: rgb(0,0,0); text-align: center;">';
				mensaje += "<p style='text-align:center; color:rgb(41, 76, 139);font-weight: bold;'>Desea copiar la programaci&oacute;n del mes anterior</p>";
				mensaje += "<div style='margin-top:5%; text-align:center;'>";
				mensaje  += "<input id='copiar_programacion_anterior' type='button' class='btn btn-primary' value='Aceptar'/>";
				mensaje  += "<input id='cancelar_programacion'  style='margin-left:10px' type='button' class='btn btn-primary' value='Cancelar'/>";
				mensaje += "</div>"
				mensaje += "</div>";
				
				modals("Informaci&oacute;n de la Programaci&oacute;n",mensaje);
				
				$("#copiar_programacion_anterior").click(function(){
					
					$.ajax({url:"copiar_programacion.php",
						type:"POST",
						dataType: "html",
						cache:false,
						data: {arreglo: JSON.stringify(data)},
						success:function(res){
							$("#usuario_n").addClass("validar");
							$(".validar").html(res);
							var codigo = $('#cod_epl_sesion').val();
							programacion(fecha, centro_costo, cargo, codigo);
				            auditoria(fecha, centro_costo, cargo, codigo);
						}
					});
					return false;
				});
				
				$("#cancelar_programacion").click(function(){
					$("#myModal2").modal("hide");
					$("#myModal2").remove();
					
					progra_turnos_ciclos(nombre,mes,anio,cod_epl,jefe_prog);
					return false;
				});
				
			}*/
			
		}
	});	
	return false;
}

/*llama el modal para la programacion turnos por ciclo*/
function progra_turnos_ciclos(nombre,mes,anio,cod_epl,jefe_prog){
	
	$.post('continuacion_ciclo.php',{anio:anio, mes:mes, cod:cod_epl} , function(resp){
		$('#ciclo').html(resp);
	})
	
	var	mensaje = '<div id="usuario_n" style="color: rgb(0,0,0); text-align: left;">';
	    mensaje += "<form id='nuevo_turno'>";
		mensaje += "<p style='text-align:center; color:rgb(41, 76, 139);font-weight: bold;'>"+nombre+"</p>";
		mensaje += "<div><table class='tableone table-bordered' border='1' id='ciclos_new'>";
        mensaje += "<thead>";
		mensaje += "<p style='text-align:center; color:rgb(41, 76, 139); font-weight: bold;'>Ciclo Anterior: <span id='ciclo'></span></p>";		
		mensaje += "<tr style='background-color: rgb(41, 76, 139); color: #fff; text-align: center;'>";
		mensaje += "<th  scope='col'>Ciclo</th>";
		mensaje += "<th  scope='col'>Lu</th>";
		mensaje += "<th  scope='col'>Ma</th>";
		mensaje += "<th scope='col'>Mi</th>";
		mensaje += "<th  scope='col'>Ju</th>";
		mensaje += "<th  scope='col'>Vi</th>";
		mensaje += "<th scope='col'>Sa</th>";
		mensaje += "<th scope='col'>Do</th>";
		mensaje += "<th  scope='col'>Horas</th>";
		mensaje += "</tr>";
		mensaje += "</thead>";
		mensaje += "<tbody>";
		var j=0;
		for(i=1; i < 7; i++){
			mensaje += "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id="+i+">";
			mensaje += "<td height='20px' class='list_t bandera' id='c"+i+"'></td>";
			mensaje += "<td height='20px' class='1 bandera'></td>";
			mensaje += "<td height='20px' class='2 bandera'></td>";
			mensaje += "<td height='20px' class='3 bandera'></td>";
			mensaje += "<td height='20px' class='4 bandera'></td>";
			mensaje += "<td height='20px' class='5 bandera'></td>";
			mensaje += "<td height='20px' class='6 bandera'></td>";
			mensaje += "<td height='20px' class='7 bandera'></td>";
			mensaje += "<td height='20px' class='bandera'></td>";
			mensaje += "</tr>";	
		}
		mensaje += "</tbody>";
		mensaje += "</table></div>";
		mensaje += "<div class='validar'></div>";
		mensaje += "<div style='margin-top:5%; text-align:center;'><input id='crear_programacion' type='button' class='btn btn-primary' value='Aceptar'/></div>";
		mensaje += "</form>";
		mensaje += "</div>";
		
		var mes_click=verificar_mes(mes);
		
		
		
		$.ajax({
			url:"ver_dias.php",
			type:"POST",
			dataType:"json",
			data:"mes="+mes+"&anio="+anio,
			success:function(data){
				//console.log(data); 
				for(var j=0;j<data.numeros.length;j++){
						
					$("#"+data.numeros[j].semana+" ."+data.numeros[j].dia+"").attr("title",""+(j+1)+"");
					
				}
			}
		});
		
	    modals('PROGRAMACI&Oacute;N DE TURNOS DEL MES '+mes_click+'',mensaje);
	
	$(".list_t").popover({
					title: "",
					content: ""
				});
				$(".list_t").click(function(event) {
					$('.error').remove();
					event.preventDefault();
					event.stopPropagation();
					var param=$(this).parent().attr("id");
					var id=$(this).attr("id");
					
					$(this).popover(
						"ajax",
						"ajax_catalogo_ciclo.php?param="+param+"&mes="+mes+"&anio="+anio+"&cod_epl="+cod_epl+"&jefe_prog="+jefe_prog
						
					).popover('show');
					
						var codigos=['c1','c2','c3','c4','c5','c6'];
						if(id == codigos[0]){
							$("#c2, #c3, #c4, #c5, #c6").popover('hide');
						}else if(id == codigos[1]){
							$("#c1, #c3, #c4, #c5, #c6").popover('hide');
						}else if(id == codigos[2]){
							$("#c1, #c2, #c4, #c5, #c6").popover('hide');
						}else if(id == codigos[3]){
							$("#c1, #c3, #c2, #c5, #c6").popover('hide');
						}else if(id == codigos[4]){
							$("#c1, #c3, #c2, #c4, #c6").popover('hide');
						}else if(id == codigos[5]){
							$("#c1, #c3, #c2, #c4, #c5").popover('hide');
						}
					});

	$("#crear_programacion").click(function(){
		 
		 var array= new Array();
				
		 $(".bandera").each(function(index){
			
             array[index]=$(this).text();
			 if( array[index]==""){
				//alert("error");
				$('.validar').html("<span class='error mensajes_error'>Se debe llenar toda la tabla</span>");
				return false;
			}
         });
		 
	
		if(array[53]!=undefined){
			$('.error').remove();
			$.ajax({
				url:"ing_programacion_epl.php",
				type:"POST",
				dataType:"html",
				data:{arreglo:array,
					  cod_epl:cod_epl,
					  mes:mes,
					  anio:anio,
					  cod_cc2:$(".centro_costo").val(),
					  cod_car:$(".cargo").val(),
					  cod_epl_jefe:$("#cod_epl_sesion").val()
					  },
				success:function(data){
					//console.log(data);return false;
					$('.validar').html(data);
					$("#crear_programacion").hide();
					
					//para refrescar 
					var fecha=anio+"-"+mes;
					var centro_costo=$(".centro_costo").val();
					var cargo=$(".cargo").val();
					var codigo = $('#cod_epl_sesion').val();
					
					programacion(fecha, centro_costo, cargo, codigo);
					auditoria(fecha, centro_costo, cargo, codigo);
				}
			
			});
		}
	});

   return false;
}

/*permite crear una nueva programacion ajustandose al calendario indicado*/
function copiar_ciclo(id,param,cod_epl){

	var mes=$('.mes').val();
	var anio=$('.anio').val();
	$.ajax({
		url:"verificar_fecha.php",
		type:"post",
		dataType:"json",
		data:"mes="+mes+"&anio="+anio+"&cod_epl="+cod_epl,
		success:function(data){
		 
			if(param==1 && data.dia_inicio.inicia==0 && data.dia_fin.retiro != 1){ //semana 1
				 
				
				$("table #1 > td:eq(0)").html($("table #tur"+id+" > td:eq(0)").html());
				
				
				for(var i=1; i<data.dia_inicio.dia_numero;i++){ 
					$("table #1 ."+i+"").html("X");
				}
				datos=[]; 
				for(var j=i;j<=7;j++){
					$("table #1 ."+j+"").html($("table #tur"+id+" ."+j+"").html());
					datos.push("'"+$("table #tur"+id+" ."+j+"").html()+"'"); 
				}
				sumar_total($("table #1 > td:eq(8)"),datos);
			
			}else if(param==data.dia_fin.semana && data.dia_fin.retiro==0){ //terminar semanas
			    
				//console.log("hola2");
				
				
				$("table #"+data.dia_fin.semana+" > td:eq(0)").html($("table #tur"+id+" > td:eq(0)").html());
				datos=[];
				for(var p=1; p<=data.dia_fin.dia_numero;p++){
					$("table #"+data.dia_fin.semana+" ."+p+"").html($("table #tur"+id+" ."+p+"").html());
					datos.push("'"+$("table #tur"+id+" ."+p+"").html()+"'"); 
				}
				
				if(data.dia_fin.semana==5){
					for(var l=1;l<=7;l++){
						$("table #6 > td:eq(0)").html("X");
						$("table #6   ."+l+"").html("X");
						$("table #6 > td:eq(8)").html("X");
					}
				}
				
				for(var t=p; t<=7;t++){
				
					$("table #"+data.dia_fin.semana+" ."+t+"").html("X");
				}
				sumar_total($("table #"+data.dia_fin.semana+" > td:eq(8)"),datos);
				
			}else if((data.dia_inicio.inicia==1 && param==1) || (data.dia_inicio.inicia==2 && param==1)){ // cuando inicia contrato ojo hacer validacion tambien con param
			
				//console.log("hola3");
				//console.log("entro aca"); return false;
				if(data.dia_inicio.inicia==2){
					//console.log("entro aca 1"); 
					for(var u=1; u<data.dia_inicio.dia_mes1;u++){  // este for se va encargar de llenar de X hasta el dia que comience el mes
					$("table #1 ."+u+"").html('X');
					}
					
					for(var u=data.dia_inicio.dia_mes1; u<data.dia_inicio.dia_mes2;u++){  // este for se va encargar de llenar de X hasta el dia que comience el mes
						$("table #1 ."+u+"").html('N');
					}
				}else{
					 
					for(var u=1; u<data.dia_inicio.dia_mes;u++){  // este for se va encargar de llenar de X hasta el dia que comience el mes
						$("table #1 ."+u+"").html('X');
					}
				}
				
			
				if(data.dia_inicio.semana > 1){ // si el empleado no inicia en la semana 1
					
					
					$("table #1 > td:eq(0)").html('X');
					$("table #1 > td:eq(8)").html('X');
					
					for(var r=u; r<=7; r++){
						$("table #1 ."+r+"").html('N'); // este for se va encargar de llenar de N despues del dia que comienza el mes de la semana 1
					}
					
					for(var m=2;m<=data.dia_inicio.semana;m++){
							
						if( m <data.dia_inicio.semana){
							$("table #"+m+"").children('td').html('N');
							$("table #"+m+" > td:eq(0)").html('X');
							$("table #"+m+" > td:eq(8)").html('X');
						}else{
							$("table #"+m+" > td:eq(0)").html($("table #tur"+id+" td:eq(0)").html());
						
							for(var i=1; i<data.dia_inicio.dia_numero;i++){ 
								$("table #"+m+" ."+i+"").html('N');
							}
							datos=[]; 
								if(data.dia_inicio.inicia==1){
									$("table #"+m+" ."+data.dia_inicio.dia_numero+"").css("color","blue");
								}
							for(var s=i;s<=7;s++){
							
								$("table #"+m+" ."+s+"").html($("table #tur"+id+" ."+s+"").html());
								datos.push("'"+$("table #tur"+id+" ."+s+"").html()+"'"); 
							}
							sumar_total($("table #"+m+" > td:eq(8)"),datos);
						}
					}
					
				}else{  // si el empleado inicia en la semana 1
				
					
					
					datos=[]; 
					$("table #1 > td:eq(0)").html($("table #tur"+id+" td:eq(0)").html());
					
					
					if(data.dia_inicio.inicia==1){
						$("table #1 ."+data.dia_inicio.dia_numero+"").css("color","blue");
						
						for(var r=u; r<=7; r++){
							$("table #1 ."+r+"").html('N'); // se encarga de llenar de N hasta que inicia el contrato
							
						}
						
					}
					
					//$("#1 ."+u+"").html('N');
					//data.dia_inicio.dia_mes
					
					//var u=(u+1);
					//console.log(u); return false;
					
					if(data.dia_inicio.inicia==2){
						
						for(var r=data.dia_inicio.dia_mes2;r<=7;r++){
						
							$("table #1 ."+r+"").html($("table #tur"+id+" ."+r+"").html());
							datos.push("'"+$("table #tur"+id+" ."+r+"").html()+"'"); 
						}
					
						sumar_total($("table #1 > td:eq(8)"),datos);
					
					}else{
					
						for(var r=data.dia_inicio.dia_numero;r<=7;r++){
						
						$("table #1 ."+r+"").html($("table #tur"+id+" ."+r+"").html());
						datos.push("'"+$("table #tur"+id+" ."+r+"").html()+"'"); 
						}
						sumar_total($("table #1 > td:eq(8)"),datos);
					}
					
					
				}
				
			}else if(param==data.dia_fin.semana && (data.dia_fin.retiro==1 || data.dia_fin.retiro==3) ){ // cuando es la fecha de retiro
			
				
			//console.log("hola4");
				for(var r=data.dia_fin.semana; r<=6; r++){

				   if(r==data.dia_fin.semana){
					
						$("table #"+r+" > td:eq(0)").html($("table #tur"+id+" td:eq(0)").html());
						datos=[]; 
						for(var s=1;s<=data.dia_fin.dia_numero;s++){

							$("table #"+data.dia_fin.semana+" ."+s+"").html($("table #tur"+id+" ."+s+"").html());
							
							datos.push("'"+$("table #tur"+id+" ."+s+"").html()+"'"); 
						}
						
						if(data.dia_fin.retiro==1){
							
							$("table #"+data.dia_fin.semana+" ."+data.dia_fin.dia_numero+"").css("color","red");
						}
						
						
						sumar_total($("table #"+data.dia_fin.semana+" > td:eq(8)"),datos);
						
						for(var o=s; o<=7;o++){
						
							if(data.dia_fin.ret=='vto_cto'){
								$("table #"+data.dia_fin.semana+" ."+o+"").html('VCTO');
								
							}else if(data.dia_fin.ret=='super'){
								
								$("table #"+data.dia_fin.semana+" ."+o+"").html('N');
							
							}else{ $("table #"+data.dia_fin.semana+" ."+o+"").html('R');}
						
						}
					}else{
						
						if(data.dia_fin.ret=='vto_cto'){
							$("table #"+r+"").children('td').html('VCTO');
							
						}else if(data.dia_fin.ret=='super'){
							
							$("table #"+r+"").children('td').html('N');
							
						}else{ $("table #"+r+"").children('td').html('R'); 
							}
					
						$("table #"+r+" > td:eq(0)").html('X');
						$("table #"+r+" > td:eq(8)").html('X');
					}

				}
				
			}else if(param < data.dia_fin.semana && (data.dia_inicio.inicia==0 || data.dia_inicio.inicia==1 || data.dia_inicio.inicia==2 )){ // llena siempre lo que hace falta
			
				
				//console.log("hola5");
				$("table #"+param+" > td:eq(0)").html($("table #tur"+id+" > td:eq(0)").html());
				
				if(data.dia_inicio.inicia==0 && data.dia_fin.ret=='vto_cto'){
				
					
					
					datos=[];
					
					if(param== 1){
						
						
						for(var i=1; i<data.dia_inicio.dia_numero;i++){ 
						$("table #1 ."+i+"").html("X");
						}
						
						
						for(var x=i; x<=7;x++){
							$("table #"+param+" ."+x+"").html($("table #tur"+id+" ."+x+"").html());
							datos.push("'"+$("table #tur"+id+" ."+x+"").html()+"'"); 
						}
					
					
					
					}else{
					
						datos=[];
						for(var x=1; x<=7;x++){
							$("table #"+param+" ."+x+"").html($("table #tur"+id+" ."+x+"").html());
							datos.push("'"+$("table #tur"+id+" ."+x+"").html()+"'"); 
						}	
					
					
					
					}
					
					
					
					sumar_total($("table #"+param+" > td:eq(8)"),datos);
				}else{
				
					
				
					datos=[];
					for(var x=1; x<=7;x++){
						$("table #"+param+" ."+x+"").html($("table #tur"+id+" ."+x+"").html());
						datos.push("'"+$("table #tur"+id+" ."+x+"").html()+"'"); 
					}	
					sumar_total($("table #"+param+" > td:eq(8)"),datos);
				
				}
				

			}
			
			$("#c1, #c2, #c3, #c4, #c5, #c6").popover('hide');  //CERRAR EL EL POPUP DE TURNOS
		}	
	});
}

/*suma el total de turnos en una semana*/
function sumar_total(id,datos){
var retorno=null;
	$.ajax({
			url:"sumar_turnos.php",
			type:"POST",
			dataType:"html",
			data:{arreglo:datos},
			success:function(data){
				$(id).html(data);
			}			
	});
	return false;
	
}
/*Modal principal parametrizables para manajar la programacion*/
function modals(titulo,mensaje){

	var modal='<!-- Modal -->';
			modal+='<div id="myModal2" class="modal hide fade" style="margin-top: 3%; background-color: rgb(41, 76, 139); color: #fff; z-index: 900000; behavior: url(../../css/PIE.htc)" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">';
			modal+='<div class="modal-header" style="border-bottom: 0px !important;">';
			modal+='<button type="button" class="close" style="color:#fff !important;" data-dismiss="modal" aria-hidden="true">×</button>';
			modal+='<h4 id="myModalLabel">'+titulo+'</h4>';
			modal+='</div>';
			modal+='<div class="modal-body" style="max-width: 92% !important; background-color:#fff; margin: 0 auto; margin-bottom: 1%; border-radius: 8px; behavior: url(../../css/PIE.htc);">';
			modal+='<p>'+mensaje+'ggg</p>';
			modal+='</div>';
			modal+='</div>';
			
	$("#main").append(modal);
	
	$('#myModal2').modal({
		keyboard: false,
		backdrop: "static" 
	});
	
	$('#myModal2').on('hidden', function () {
		$(this).remove();
	});
}

function modals2(titulo,mensaje){
	var modal='<!-- Modal -->';
			modal+='<div id="myModal5" class="modal hide fade" style="margin-top: 3%; background-color: rgb(41, 76, 139); color: #fff; z-index: 900000; behavior: url(../../css/PIE.htc)" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">';
			modal+='<div class="modal-header" style="border-bottom: 0px !important;">';
			modal+='<button type="button" class="close" style="color:#fff !important;" data-dismiss="modal" aria-hidden="true">×</button>';
			modal+='<h4 id="myModalLabel">'+titulo+'</h4>';
			modal+='</div>';
			modal+='<div class="modal-body" style="max-width: 92% !important; background-color:#fff; margin: 0 auto; margin-bottom: 1%; border-radius: 8px; behavior: url(../../css/PIE.htc);">';
			modal+='<p>'+mensaje+'</p>';
			modal+='</div>';
			modal+='</div>';		
	$("#main").append(modal);
	
	$('#myModal5').modal({
		keyboard: false,
		backdrop: "static" 
	});
	
	$('#myModal5').on('hidden', function () {
		$(this).remove();
	});
}

function programacion(fecha, centro_costo, cargo, codigo){
	$.ajax({
		dataType: "json",
		type:"GET",
		url: "ind.php",
		data: "fecha="+fecha,
		success: function (datos1){
			var canti=datos1[0].calendario1.numeros.length;
			var canti2=datos1[0].calendario2.dias.length;
			/*tbody*/
			$.ajax({
			   type:"POST",
			   url: "ajax_catalogo_programacion.php",
			   data: "cantidad="+canti+"&centro_costo="+centro_costo+"&cargo="+cargo+"&fecha="+fecha+"&codigo="+codigo,	
				 beforeSend:function(){
					$("#contenido").html("<h1 id='cerrar_se'>Espere Por favor<span>.</span><span>.</span><span>.</span></h1>");
			   },
			   success: function (datos){
					
					var canti=datos1[0].calendario1.numeros.length;
					var canti2=datos1[0].calendario2.dias.length;
		 
					//INICIO DE TABLA	 
			
					//THEAD
					var table="<div style='width:99%'><table style='color: rgb(41, 76, 139) !important;' cellpadding='0' cellspacing='0' border='1' class='display' id='example'><thead style='background-color: rgb(41, 76, 139); font-size: 13px; color: #fff; font-weight:bold;'><tr><td rowspan='2' align='center'>No</td><td rowspan='2' align='center' id='dias'>Empleado</td>";
			
					for(i=0; i < canti2; i ++){
						table+="<td align='center'>"+datos1[0].calendario2.dias[i]+"</td>";
					}
					table+="<td rowspan='2' align='center'>Sem1</td><td rowspan='2' align='center'>Sem2</td><td rowspan='2' align='center'>Sem3</td><td rowspan='2' align='center'>Sem4</td><td rowspan='2' align='center'>Sem5</td><td rowspan='2' align='center'>Sem6</td><td rowspan='2' align='center'>Horas</td></tr><tr>";
				
					for(i=0; i < canti; i ++){
						table+="<td align='center'>&nbsp;"+datos1[0].calendario1.numeros[i]+"&nbsp;</td>";
					}
					table+="</tr></thead>";
					//FIN THEAD
					
					//TBODY
							table+=datos;
							//console.log(datos);
							//return false;
					//FIN TBODY
			
					table+="</table></div><br><br>";
			
					//FIN TABLA
					$("#contenido").html(table);
					
					/*click derecho de opciones de la programacion*/
					$(".context-menu-one").contextmenu(click_derecho_empleado);
					//click_derecho_turnos();
					 $(".context-menu-two").contextmenu(click_derecho_turnos);
					
					//Aca va el datable porque se crea example y ahi si con ese example hagame esta accion
					$('#example').dataTable({

						"bLengthChange": false,
						"bSort": false,
						"bPaginate": false,
						"bInfo": false,
						"bFilter": false,
						"oLanguage": {
								"sProcessing": "Procesando...",										
								"sZeroRecords": "No se encontraron resultados",										
								"sInfoEmpty": "No existen registros",									
								"oPaginate": {
								"sFirst": "Primero",
								
								"sPrevious": "Anterior",
								"sNext": "Siguiente",
								"sLast": "Último"
								}
						}
				
					});
					
					/*click derecho de opciones de la programacion*/
					$(".context-menu-one").contextmenu(click_derecho_empleado);
					//click_derecho_turnos();
					 $(".context-menu-two").contextmenu(click_derecho_turnos);
				}
			});
			/*fin table*/	
		}
	});
}

/*Metodo que despliega el menu para los empleados de la programacion*/
function click_derecho_empleado(){
	$(this).addClass("senalar");
	$.contextMenu({
				selector: '.context-menu-one', 
				callback: function(key, options) {
					var m=$(this).attr("id");
					var clase=$(this).attr('class');
					var id_prog=$(this).attr('id');
					var separar=clase.split(" ");
					var empleado=separar[1]; // ojo desde var tur hasta  var separar[1] sirve para traerme el turno y el dia  cuando doy click derecho en un turno del empleado
					var epl=empleado.split("_").join(" "); 
					var cod_epl=separar[2];
					//var m = "clicked: " + $(this).html();
					if(key=="delete"){
						var clase=$(this).attr('class');
						
						if(m != 0){
							confirm_dialog(clase,m);
						}
						
					}else if(key=="edit"){
						if(m != 0){
							editar_turnos(epl,cod_epl,id_prog);
						}
					}else if(key=="copy"){
						var m=$(this).attr("id");
						if(m == 0){
							var mensaje="Para copiar debes seleccionar a un empleado que contenga una programación";
							Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
						}else{
								$.ajax({url : "ajax_copiar_programacion.php",
											type: "POST",
											data: "id="+m,
											dataType: "html",
									   });
						}
					}else{
						var clase=$(this).attr('class');
										var separar=clase.split(" ");
										var empleado=separar[2];
										var epl=empleado.split("_").join(" "); 
						$.ajax({url : "ajax_copiar_programacion.php",
									type: "POST",
									dataType: "html",
									success:function(data){
										var mes=$(".mes").val();
	                                    var anio=$(".anio").val();
										var area = $(".centro_costo").val();
										var cargo = $(".cargo").val();
										var jefe = $('#cod_epl_sesion').val();
										var fecha=anio+"-"+mes;
										var id=m;
										
										$.post('ajax_pegar_programacion.php',{data:data,anio:anio,mes:mes,cod_epl:epl,area:area,cargo:cargo,jefe:jefe,id:id}, function(data) {
											
											if(data==1){
												
											Alert.alert("No se ha podido pegar la programación",function(){$('#myModal6').modal('hide');});
											}else{
											
													Alert.alert(data,function(){$('#myModal6').modal('hide');});
													programacion(fecha, area, cargo, jefe);
											        auditoria(fecha, area, cargo, jefe );
											}
											
											
										});
									}
								  });
					}
					
				},
				items: {
					"delete": {name: "Eliminar Programación", icon: "delete"},
					"edit": {name: "Editar Programación", icon: "edit"},
					"copy": {name: "Copiar Programación", icon: "copy"},
					"paste": {name: "Pegar Programación", icon: "paste"},
					
				}
			});			
}

function confirm_dialog(clase,m){
	
	
	var separar=clase.split(" ");
		var empleado=separar[2];
		var codigo=empleado.split("_").join(" "); 
		var nombre=$('.senalar').html();
		var mes=$(".mes").val();
		var anio=$(".anio").val();
		var fecha=anio+"-"+mes;
		var centro_costo=$(".centro_costo").val();
		var cargo=$(".cargo").val();
		var jefe=$("#cod_epl_sesion").val();
		
		$.ajax({url : "ajax_eliminar_programacion.php",
			type: "POST",
			data: "id="+m+"&ano="+anio+"&mes="+mes+"&area="+centro_costo+"&codigo="+codigo+"&modulo="+1,
			dataType: "html",
			success:function(data){
				//console.log(data); return false;
				if(data==1){
				
					var  contenido='<div id="mensaje">';
					 contenido+='<p style="color:red;text-align:center;" class="mensaje"> El empleado tiene vaciones confirmadas no puede eliminar este registro</p>';
					 contenido+= "<div class='validar'></div>";
					 contenido+='<div class="botones" style="text-align:center;">';
					 //contenido+='<a href="#" style="color:#fff;"  id="aceptar" class="btn btn-primary">Aceptar</a>';
					 contenido+='<a href="#" style="color:#fff; margin-left:10px;" id="cancelar" class="btn btn-primary">Cancelar</a>';
					 contenido+='</div>'
					 contenido+='</div>';
					 
					 modals("Informaci&oacute;n  <i class='icon-question-sign'></i>",contenido);
					 
				
				}else if(data==2){
					
					var  contenido='<div id="mensaje">';
					 contenido+='<p style="color:red;text-align:center;" class="mensaje"> Desea eliminar el registro con ausencias</p>';
					 contenido+= "<div class='validar'></div>";
					 contenido+='<div class="botones" style="text-align:center;">';
					 contenido+='<a href="#" style="color:#fff;"  id="aceptar" class="btn btn-primary">Aceptar</a>';
					 contenido+='<a href="#" style="color:#fff; margin-left:10px;" id="cancelar" class="btn btn-primary">Cancelar</a>';
					 contenido+='</div>'
					 contenido+='</div>';
					 
					 modals("Informaci&oacute;n  <i class='icon-question-sign'></i>",contenido);
				
				
				}else if (data==3){
				
					var  contenido='<div id="mensaje">';
					 contenido+='<p style="color:red;text-align:center;" class="mensaje">El empleado tiene ausencias en estado Vigente, para eliminarlas debe comunicarse con Gesti&oacute;n  Humana. Desea eliminar la programaci&oacute;n</p>';
					 contenido+= "<div class='validar'></div>";
					 contenido+='<div class="botones" style="text-align:center;">';
					 contenido+='<a href="#" style="color:#fff; margin-left:5px;"  id="aceptar_c" class="btn btn-primary">Aceptar</a>';
					 contenido+='</div>'
					 contenido+='</div>';
					 
					 modals("Informaci&oacute;n  <i class='icon-question-sign'></i>",contenido);
					 
					 $("#aceptar_c").click(function(){
						$('#myModal2').modal('hide');
					 });
					 
					/*$("#aceptar_c").click(function(){
						$.ajax({url : "ajax_eliminar_programacion.php",
								type: "POST",
								data: "id="+m+"&ano="+anio+"&mes="+mes+"&area="+centro_costo+"&cargo="+cargo+"&codigo="+codigo+"&nombre="+nombre+"&jefe="+jefe+"&modulo="+2,
								dataType: "html",
								success:function(data){
									//console.log(data); return false;
									$('#myModal2').modal('hide');
									//para refrescar 
									programacion(fecha, centro_costo, cargo, jefe);
									auditoria(fecha, centro_costo, cargo, jefe );
								}
						});
					});*/
					return false;
					 
					 
				
				}else if (data==4){
				
					var  contenido='<div id="mensaje">';
					 contenido+='<p style="color:red;text-align:center;" class="mensaje">El empleado tiene ausencias en estado Confirmado, para eliminarlas debe comunicarse con Gesti&oacute;n  Humana.</p>';
					 contenido+= "<div class='validar'></div>";
					 contenido+='<div class="botones" style="text-align:center;">';
					 contenido+='<a href="#" style="color:#fff; margin-left:5px;"  id="cancelar_c" class="btn btn-primary">Aceptar</a>';
					 contenido+='</div>'
					 contenido+='</div>';
					 
					 modals("Informaci&oacute;n  <i class='icon-question-sign'></i>",contenido);
					 
					 $("#cancelar_c").click(function(){
						$('#myModal2').modal('hide');
					 });
					 
					$("#aceptar_c").click(function(){
						$.ajax({url : "ajax_eliminar_programacion.php",
								type: "POST",
								data: "id="+m+"&ano="+anio+"&mes="+mes+"&area="+centro_costo+"&cargo="+cargo+"&codigo="+codigo+"&nombre="+nombre+"&jefe="+jefe+"&modulo="+2,
								dataType: "html",
								success:function(data){
									//console.log(data); return false;
									$('#myModal2').modal('hide');
									//para refrescar 
									programacion(fecha, centro_costo, cargo, jefe);
									auditoria(fecha, centro_costo, cargo, jefe );
								}
						});
					});
					return false;
					 
					 
				
				}else {
				
					var  contenido='<div id="mensaje">';
					 contenido+='<p style="color:black;text-align:center;" class="mensaje"> Desea eliminar el registro</p>';
					 contenido+= "<div class='validar'></div>";
					 contenido+='<div class="botones" style="text-align:center;">';
					 contenido+='<a href="#" style="color:#fff;"  id="aceptar" class="btn btn-primary">Aceptar</a>';
					 contenido+='<a href="#" style="color:#fff; margin-left:10px;" id="cancelar" class="btn btn-primary">Cancelar</a>';
					 contenido+='</div>'
					 contenido+='</div>';
					 
					 modals("Informaci&oacute;n  <i class='icon-question-sign'></i>",contenido);
				
				
				}
				
				$("#aceptar").click(function(){
					$.ajax({url : "ajax_eliminar_programacion.php",
							type: "POST",
							data: "id="+m+"&ano="+anio+"&mes="+mes+"&area="+centro_costo+"&cargo="+cargo+"&codigo="+codigo+"&nombre="+nombre+"&jefe="+jefe+"&modulo="+2,
							dataType: "html",
							success:function(data){
								
								$('#myModal2').modal('hide');
								//para refrescar 
								
								programacion(fecha, centro_costo, cargo, jefe);
								auditoria(fecha, centro_costo, cargo, jefe);
								
								
							}
					});
					return false;
					
					
				 });
				
				$("#cancelar").click(function(){
					$('#myModal2').modal('hide');
				 });
				
			}
		});
		
		return false;
}





function editar_turnos(epl,cod_epl,id_prog){
	
	var mes=$(".mes").val();
	var anio=$(".anio").val();
	var jefe=$("#cod_epl_sesion").val();
	var cod_cc2=$(".centro_costo").val();
	var cod_car=$(".cargo").val();
	
	
	
	$.ajax({ // inicio ajax principal
		
			url:"verificar_ausencia.php",
			type:"POST",
			dataType:"json",
			data:"cod_epl="+cod_epl+"&mes="+mes+"&anio="+anio+"&cod_cc2="+cod_cc2+"&info="+1,
			success:function(res){
					
				var	mensaje = '<div id="usuario_n" style="color: rgb(0,0,0); text-align: left;">';
				mensaje += "<form id='edito_programa'>";
				mensaje += "<p style='text-align:center; color:rgb(41, 76, 139);font-weight: bold;'>"+epl+"</p>";
				mensaje += "<div><table class='tableone table-bordered' border='1' id='ciclos_new'>";
				mensaje += "<thead>";	
				mensaje += "<tr style='background-color: rgb(41, 76, 139); color: #fff; text-align: center;'>";
				mensaje += "<th  scope='col'>Lu</th>";
				mensaje += "<th  scope='col'>Ma</th>";
				mensaje += "<th scope='col'>Mi</th>";
				mensaje += "<th  scope='col'>Ju</th>";
				mensaje += "<th  scope='col'>Vi</th>";
				mensaje += "<th scope='col'>Sa</th>";
				mensaje += "<th scope='col'>Do</th>";
				mensaje += "<th  scope='col'>Horas</th>";
				mensaje += "</tr>";
				mensaje += "</thead>";
				mensaje += "<tbody>";
				var t=0;
				for(i=1; i < 7; i++){
					mensaje += "<tr style='cursor:pointer; text-align: center;' class='seleccionar' id="+i+">";
					mensaje += "<td height='20px' class='1 list_t'></td>";
					mensaje += "<input type='hidden' class='b1'>";
					mensaje += "<input type='hidden' class='not a1'>";
					mensaje += "<td height='20px' class='2 list_t'></td>";
					mensaje += "<input type='hidden'  class='b2'>";
					mensaje += "<input type='hidden' class='not a2'>";
					mensaje += "<td height='20px' class='3 list_t'></td>";
					mensaje += "<input type='hidden' class='b3'>";
					mensaje += "<input type='hidden' class='not a3'>";
					mensaje += "<td height='20px' class='4 list_t'></td>";
					mensaje += "<input type='hidden' class='b4'>";
					mensaje += "<input type='hidden' class='not a4'>";
					mensaje += "<td height='20px' class='5 list_t'></td>";
					mensaje += "<input type='hidden' class='b5'>";
					mensaje += "<input type='hidden' class='not a5'>";
					mensaje += "<td height='20px' class='6 list_t'></td>";
					mensaje += "<input type='hidden' class='b6'>";
					mensaje += "<input type='hidden' class='not a6'>";
					mensaje += "<td height='20px' class='7 list_t'></td>";
					mensaje += "<input type='hidden' class='b7'>";
					mensaje += "<input type='hidden' class='not a7'>";
					mensaje += "<td height='20px'  class='horas_"+(t+=1)+"'></td>";
					mensaje += "<input type='hidden' name='sem"+t+"' class='not sem"+t+"'>";
					mensaje += "</tr>";		
				}
				mensaje += "</tbody>";
				mensaje += "</table></div>";
				mensaje += "<input type='hidden' name='id' id='id_edit_tur' value="+id_prog+">";
				mensaje += "<input type='hidden' name='mes' id='mes_edit_tur' value="+mes+">";
				mensaje += "<input type='hidden' name='anio' id='anio_edit_tur' value="+anio+">";
				mensaje += "<input type='hidden' name='cod_epl_jefe' id='jefe_edit_tur' value="+jefe+">";
				mensaje += "<input type='hidden' name='vigencia_vac' id='prueba_tur' value="+res.info[0].ausencia+">";
				mensaje += "<div class='validar'></div>";
				mensaje += "<div style='margin-top:5%; text-align:center;' id='mostrar_boton'><input id='editar_programacion' type='button' class='btn btn-primary' value='Aceptar'/></div>";
				mensaje += "<div style='margin-top:5%; text-align:center; display:none;' id='esconder_boton'><input id='vige_aceptar' type='button' class='btn btn-primary' value='Aceptar'/>";
				mensaje += "<input id='vige_cancelar' style='margin-left:5px;' type='button' class='btn btn-primary' value='Cancelar'/></div>";
				mensaje += "</form>";
				mensaje += "</div>";
				
				var mes_click=verificar_mes(mes);
				
				modals('EDITAR PROGRAMACI&Oacute;N DE TURNOS DEL MES '+mes_click+'',mensaje);
				
				$.ajax({
					url:"traer_turno.php",
					type:"POST",
					dataType:"json",
					data:"cod_epl="+cod_epl+"&mes="+mes+"&anio="+anio+"&jefe="+jefe+"&cod_car="+cod_car+"&cod_cc2="+cod_cc2,
					success:function(data){
						
						//console.log(data);
						var l=0;
						for(var j=0;j<data.turnos.length;j++){
							
							//mejorar
							if(data.turnos[j].semana == 0){
								data.turnos[j].semana =1;
							}
							
							if(data.turnos[j].turno != 'X'){
								 $("table #"+data.turnos[j].semana +" ."+data.turnos[j].dia+"").html(data.turnos[j].turno);
								 $("table #"+data.turnos[j].semana +" ."+data.turnos[j].dia+"").attr("title",""+(j+1)+"");
							}else{
								 $("table #"+data.turnos[j].semana+" ."+data.turnos[j].dia+"").html(data.turnos[j].turno);
							}
						   
					$("table #"+data.turnos[j].semana+" .a"+data.turnos[j].dia+"").val(data.turnos[j].turno).attr('name', 'Td'+(l+=1)+'');
					
							$("table #"+data.turnos[j].semana+" .b"+data.turnos[j].dia+"").val(data.turnos[j].hora);
							//$("#"+data.turnos[j].semana+" .b"+data.turnos[j].dia+"");
							if(j<=5){
								$(".horas_"+(j+1)+"").html(data.horas[j].horas);
								$(".horas_"+(j+1)+"").attr("title",""+data.ciclos[j].ciclos+""); 
								$(".sem"+(j+1)+"").val(data.horas[j].horas);							
							}
						}
					}
				});
				
				$(".list_t").popover({
					title: "",
					content: ""
				});
				
				$("#vige_aceptar").click(function(){
					
					$("#prueba_tur").val(2);
					$('#mostrar_boton').css("display","block");
					$('#esconder_boton').css("display","none");
				
				});
				
				
				$("#vige_cancelar").click(function(){
					$("#prueba_tur").val(1);
					$('#mostrar_boton').css("display","block");
					$('#esconder_boton').css("display","none");
				});
				
				
				
				$(".list_t").click(function(event) {
					var param=$(this).attr('class');
					var id=$(this).parent().attr('id');// traigo el id del padre en este caso es el <tr>
					var input=$(this).next().attr('class'); // traigo la clase del input  que esta debajo de class .list_t
					var input2=$(this).next().next().attr('class');
					var input2=input2.split(" ");
					
					if($("#prueba_tur").val()==1 && $(this).html() == '<span style="color:#A0522D; font-weight:bold;">V</span>'){
					
						$('.validar').html('<span style="color:white; background-color:red; padding:2px;">Desea cambiar Las vaciones vigentes por turnos<span>');
						
						$('#mostrar_boton').css('display','none');
						$('#esconder_boton').css('display','block');
						
					
					}

					switch($(this).html()){
					
						case '<span style="color:#A0522D; font-weight:bold;">V</span>' :
					
						case '<span style="color:#3399FF; font-weight:bold;">IG</span>' :
							
						case '<span style="color:#6B8E23; font-weight:bold;">LN</span>' :
							
						case '<span style="color:#87CEFA; font-weight:bold;">SP</span>' :
						
						case '<span style="color:#F4A460; font-weight:bold;">LM</span>' :
						
						case '<span style="color:#CD5C5C; font-weight:bold;">AT</span>' :
							
						case  '<span style="color:#EE82EE; font-weight:bold;">LP</span>' :
							 
						case  '<span style="color:#FFA07A; font-weight:bold;">EP</span>' :
						
						case  '<span style="color:#00cbff; font-weight:bold;">LR</span>' :
						
							$.ajax({
								url:"verificar_ausencia.php",
								type:"POST",
								data:"cod_epl="+cod_epl+"&mes="+mes+"&anio="+anio+"&cod_cc2="+cod_cc2+"&info="+2,
								success:function(data){

									if(data==2 && $("#prueba_tur").val()==2){
										
										$("#"+id+" .list_t").popover(
										"ajax",
										"ajax_catalogo_turnos.php?param="+param[0]+"&id="+id+"&input="+input+"&input2="+input2[1]		
										).popover('show');
										
										if(param[0] == 1){
											$(".2, .3, .4, .5, .6, .7").popover('hide');
										}else if(param[0] == 2){
											$(".1, .3, .4, .5, .6, .7").popover('hide');
										}else if(param[0] == 3){
											$(".1, .2, .4, .5, .6, .7").popover('hide');
										}else if(param[0] == 4){
											$(".1, .3, .2, .5, .6, .7").popover('hide');
										}else if(param[0] == 5){
											$(".1, .3, .2, .4, .6, .7").popover('hide');
										}else if(param[0] == 6){
											$(".1, .3, .2, .4, .5, .7").popover('hide');
										}else if(param[0] == 7){
											$(".1, .3, .2, .4, .5, .6").popover('hide');
										}		

									}else if(data==3){
									
										$('.validar').html('<span style="color:white; background-color:red; padding:2px;">El empleado tiene ausencias en estado Confirmado<span>');
									}
								
								}
							});
							break;
						case '<span style="color:#00FA9A; font-weight:bold;">VD</span>' :
							$('.validar').html('<span style="color:white; background-color:red; padding:2px;">El empleado tiene vaciones confirmadas <span>');
							return false;
						break;
						case 'X':
						case '':
							return false;
						default:
							if($("#prueba_tur").val()==3){
								
								$(this).popover(
								"ajax",
								"ajax_catalogo_turnos.php?param="+param[0]+"&id="+id+"&input="+input+"&input2="+input2[1]		
								).popover('show');
							
								var codigos=['1','2','3','4','5','6','7'];
							
								if(param[0] == codigos[0]){
									$(".2, .3, .4, .5, .6, .7").popover('hide');
								}else if(param[0] == codigos[1]){
									$(".1, .3, .4, .5, .6, .7").popover('hide');
								}else if(param[0] == codigos[2]){
									$(".1, .2, .4, .5, .6, .7").popover('hide');
								}else if(param[0] == codigos[3]){
									$(".1, .3, .2, .5, .6, .7").popover('hide');
								}else if(param[0] == codigos[4]){
									$(".1, .3, .2, .4, .6, .7").popover('hide');
								}else if(param[0] == codigos[5]){
									$(".1, .3, .2, .4, .5, .7").popover('hide');
								}else if(param[0] == codigos[6]){
									$(".1, .3, .2, .4, .5, .6").popover('hide');
								}	
							
								return false;
							
							}else{
							
								$(this).popover(
								"ajax",
								"ajax_catalogo_turnos.php?param="+param[0]+"&id="+id+"&input="+input+"&input2="+input2[1]+"&info="+1		
								).popover('show');
							
								var codigos=['1','2','3','4','5','6','7'];
							
								if(param[0] == codigos[0]){
									$(".2, .3, .4, .5, .6, .7").popover('hide');
								}else if(param[0] == codigos[1]){
									$(".1, .3, .4, .5, .6, .7").popover('hide');
								}else if(param[0] == codigos[2]){
									$(".1, .2, .4, .5, .6, .7").popover('hide');
								}else if(param[0] == codigos[3]){
									$(".1, .3, .2, .5, .6, .7").popover('hide');
								}else if(param[0] == codigos[4]){
									$(".1, .3, .2, .4, .6, .7").popover('hide');
								}else if(param[0] == codigos[5]){
									$(".1, .3, .2, .4, .5, .7").popover('hide');
								}else if(param[0] == codigos[6]){
									$(".1, .3, .2, .4, .5, .6").popover('hide');
								}	
							
								return false;
							}
							
						break;
					}
					
				});
				
				$("#editar_programacion").click(editar_programacion);
				
				

			}
	}); // fin ajax principal

		
			
	return false;
}


function copiar_turn(codigo,param,id,input,input2,horas){

	var anterior=Number(param) - 1;
	var posterior=Number(param);
	
	var resta = posterior - anterior;
	if(resta==1){
		
		var anterior=$("#"+id+" ."+anterior+"").html();
		
		 $.ajax({

			url:'verificar_parametros.php',
			type:'POST',
			data:"info="+3+"&ciclo1="+anterior+"&ciclo2="+codigo,
			success:function(res){
				if(res != 1){
		
					$('.validar').html('<span style="color:white; background-color:red; padding:2px;">El minimo de descanso entre turnos es '+res+'</span>');
					$("#editar_programacion").attr("disabled","disabled");
										
					$(".list_t").popover('fadeOut');
					return false;
					
				}else{ //inicio else
				
					$("table #"+id+" ."+param+"").html(codigo);
					$("table #"+id+" ."+input+"").val(horas);
					$("table #"+id+" ."+input2+"").val(codigo);
					
					$(".1, .2, .3, .4, .5, .6, .7").popover('hide');
					
					var sumatoria=0;
					var contador=1;
					// no incluir el ultimo elemento input:not(:last-child)
					$("table #"+id+" input:not(.not)" ).each(function(index){
					  //console.log( index + ": " + $(this).attr("class") );
					  sumatoria+=Number($(this).val());
					  $("table .horas_"+id+"").html(sumatoria);                          
					  $("table .sem"+id+"").val(sumatoria);  
					});
					
					
					/*traigo el parametro maximo de horas para ciclos*/
						$.ajax({

							url:'verificar_parametros.php',
							type:'POST',
							data:"info="+2,
							dataType:'json',
							success:function(data){
								
								if(sumatoria > data.t_hor_min_ciclos){//48 es parametrizable
						  
									$('.validar').html('<span style="color:white; background-color:red; padding:2px;">El ciclo no debe ser superior a '+data.t_hor_min_ciclos+' horas, comuniquese con el administrador<span>');
									$("#editar_programacion").attr("disabled","disabled");
										
									$(".list_t").popover('fadeOut');
									return false;
									
								}else{
									$('.validar').html('');
									$("#editar_programacion").removeAttr("disabled");
								}
									
								
							}
						});
					
					
					$(".list_t").popover('fadeOut');
					return false;	
								
				
				}//fin else

			}
				
		});	

	}else{
	
	
		$("#"+id+" ."+param+"").html(codigo);
		$("#"+id+" ."+input+"").val(horas);
		$("#"+id+" ."+input2+"").val(codigo);
		
		$(".1, .2, .3, .4, .5, .6, .7").popover('hide');
		
		var sumatoria=0;
		var contador=1;
		// no incluir el ultimo elemento input:not(:last-child)
		$("#"+id+" input:not(.not)" ).each(function(index){
		  //console.log( index + ": " + $(this).attr("class") );
		  sumatoria+=Number($(this).val());
		  $(".horas_"+id+"").html(sumatoria);                          
		  $(".sem"+id+"").val(sumatoria);  
		});
		
		
		/*traigo el parametro maximo de horas para ciclos*/
			$.ajax({

				url:'verificar_parametros.php',
				type:'POST',
				data:"info="+2,
				dataType:'json',
				success:function(data){
					
					if(sumatoria > data.t_hor_min_ciclos){//48 es parametrizable
			  
						$('.validar').html('<span style="color:white; background-color:red; padding:2px;">El ciclo no debe ser superior a '+data.t_hor_min_ciclos+' horas, comuniquese con el administrador<span>');
						$("#editar_programacion").attr("disabled","disabled");
							
						$(".list_t").popover('fadeOut');
						return false;
						
					}else{
						$('.validar').html('');
						$("#editar_programacion").removeAttr("disabled");
					}
						
					
				}
			});
		
		
		$(".list_t").popover('fadeOut');
		return false;
	
	
	}
	
	
}

/*despues de editar los turnos esta funcion sirve para editar la progamacion por empleado*/
function editar_programacion(){
	$('.validar').html("");
	$.ajax({
		url:'editar_programacion.php',
		type:'POST',
		data:$("#edito_programa").serialize(),
		//dataType:'html',
		success:function(data){
			//console.log(data);
			if(data==1){
				var fecha=$(".anio").val()+"-"+$(".mes").val();
				$(".validar").css("display","block");
				$(".validar").html("<span style='margin-top:28px;' class='mensajes_success'>Se actualizó correctamente.</span>");
				$("#editar_programacion").attr("disabled","disabled");
				programacion(fecha, $(".centro_costo").val(), $(".cargo").val(), $('#cod_epl_sesion').val());
				auditoria(fecha, $(".centro_costo").val(), $(".cargo").val(),  $('#cod_epl_sesion').val());
			}else{
				$(".validar").css("display","block");
				$(".validar").html("<span style='margin-top:28px;' class='mensajes_error'>No se actualizó los cambios.</span>");				
			}
		}
	});	
	return false;
}

/*metodo para hacer cambios en los turnos de los empleados*/
function click_derecho_turnos(){
		$(this).addClass("senalar");
		
		switch($(".senalar").html()){
			case '<span style="color:#A0522D; font-weight:bold;">V</span>' :
				
			case '<span style="color:#3399FF; font-weight:bold;">IG</span>' :
				
			case '<span style="color:#6B8E23; font-weight:bold;">LN</span>' :
				
			case '<span style="color:#87CEFA; font-weight:bold;">SP</span>' :
			
			case '<span style="color:#00cbff; font-weight:bold;">LR</span>' :
			
			case '<span style="color:#F4A460; font-weight:bold;">LM</span>' :
			
			case '<span style="color:#CD5C5C; font-weight:bold;">AT</span>' :
				
			case  '<span style="color:#EE82EE; font-weight:bold;">LP</span>' :
				 
			case  '<span style="color:#FFA07A; font-weight:bold;">EP</span>' :
				
			case  '<span style="color:#00FA9A; font-weight:bold;">VD</span>' :
				var valor=1;
				$(this).removeClass("senalar");
				break;
			default:
				var valor=0;
			break;
		}
		
		if(valor==1){
		
			var mensaje="Ya se registraron ausencias";
			Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})	 // llama el archivo de alert.js
			return false;
		}
		
				$.contextMenu({
				selector: '.context-menu-two', 
				callback: function(key, options) {
					var turno=$(this).html();
					if(turno=="" && key =="delete"){
						var mensaje="No hay turnos";
						Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})	 // llama el archivo de alert.js
						return false;
					}
					var clase=$(this).attr('class');
					var separar=clase.split(" ");
					var dia=separar[1]; // ojo desde var tur hasta  var separar[1] sirve para traerme el turno y el dia  cuando doy click derecho en un turno del empleado
					var empleado=separar[2];
					var epl=empleado.split("_").join(" "); 
					var cod_epl=separar[3];
					//var m = "clicked: " + $(this).html();
					if(key=="delete"){ 
						intercambiar_turno(turno,dia,epl,cod_epl);
					}else{
						
						var mes=$(".mes").val();
						var anio=$(".anio").val();
						var fecha=dia+"-"+mes+"-"+anio;
						var calculo=1;
						$.ajax({
							url:"calculo_ausencias.php",
							type:"POST",
							data:"cod_epl="+cod_epl+"&fecha="+fecha+"&calculo="+calculo,
							success:function(data){	
								//console.log(data);return false;
								if(data==1){
									var mensaje="Es un día no hábil";
									Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})	 // llama el archivo de alert.js
									return false;
								}else{
									ausencias(turno,dia,epl,cod_epl); // llamar al modulo de ausencias
								}
							}		
						});
						
						
					}
					//window.console && console.log(m); 
				},
				items: {
					"delete": {name: "Intercambiar programación", icon: "copy"},
					"edit": {name: "Registrar Ausencia", icon: "add"},	
				}
			});			
		
		
}

/*==============================
	Modulo o modal de ausencias
================================*/
function ausencias(turno,dia,epl,cod_epl){
	

	var mes=$(".mes").val();
	var anio=$(".anio").val();
	var jefe=$("#cod_epl_sesion").val();
	var fecha=dia+"-"+mes+"-"+anio;
	
	var cod_cc2=$(".centro_costo").val();
	var cod_car=$(".cargo").val();
	
	$.ajax({ 
		url:"ausencias.php",
		type:"POST",
		dataType:"json",
		data:"info="+3+"&cod_epl="+cod_epl+"&fecha="+fecha+"&jefe="+jefe+"&cod_cc2="+cod_cc2+"&mes="+mes+"&anio="+anio,
		success:function(data){	
			//console.log(data); return false;
			if(data[0].datos==1 || data[0].datos==2){
			
				
				var mensaje="<div style='color:black'><div style='text-align:center;margin-bottom: 2% !important;'>";
				mensaje+="<h5>El usuario no se le puede generar ausencias</h5>";
				mensaje+="</div></div>";
			
		
			
			}else {
				
				if(dia == '1'){var anexoDia = "0";}else if(dia == '2'){var anexoDia = "0";}else if(dia == '3'){var anexoDia = "0";}else if(dia == '4'){var anexoDia = "0";}else if(dia == '5'){var anexoDia = "0";}else if(dia == '6'){var anexoDia = "0";}else if(dia == '7'){var anexoDia = "0";}else if(dia == '8'){var anexoDia = "0";}else if(dia == '9'){var anexoDia = "0";}else{var anexoDia = "";}
				
				
				if(mes == '1'){var anexoMes = '0';}else if(mes == '2'){var anexoMes = '0';}else if(mes == '3'){var anexoMes = '0';}else if(mes == '4'){var anexoMes = '0';}else if(mes == '5'){var anexoMes = '0';}else if(mes == '6'){var anexoMes = '0';}else if(mes == '7'){var anexoMes = '0';}else if(mes == '8'){var anexoMes = '0';}else if(mes == '9'){var anexoMes = '0';}else{var anexoMes = "";}
				
				
				var fechaIniCOmpleta = anexoDia + dia + "-" + anexoMes + mes + "-" + anio;
				
				
				
				var mensaje="<div style='color:black'><div style='text-align:center;margin-bottom: 2% !important;'>";
				mensaje+="<h5>"+epl+"</h5>";
				mensaje+="<p >Fecha: "+anexoDia+dia+"-"+anexoMes+mes+"-"+anio+"</p>";
				mensaje+="</div>";
				mensaje+='<form class="form-horizontal">';
				mensaje+='<div class="form-inline" style="margin-left:10%; margin-bottom: 5%;">';
				mensaje+='<label>Ausencia:</label>';
				mensaje+='<div style="margin-left:2%; display:inline;">';
				mensaje+='<select id="ausencias" name="ausencias" class="input-xlarge" ></select>';
				mensaje+='</div>';
				mensaje+='</div>';
				mensaje+='<div class="form-inline" style="margin-left:9%; margin-bottom: 5%;">';
				mensaje+='<label>D&iacute;as:</label>';
				mensaje+='<div style="margin-left:2%; display:inline;">';
				mensaje+='<div class="input-append">';
				mensaje+='<input type="text" class="input-small" name="dias" id="dias_calculo" maxlength="2"/>';
				mensaje+='<button class="btn" type="button" style="color:white; background:rgb(41, 76, 139) !important;" id="calculo" >Calcular</button>';
				mensaje+='</div>';
				mensaje+='</div>';
				mensaje+='<label style="margin-left: 3%;">Fecha Final:</label>';
				mensaje+='<div style="margin-left:2%; display:inline;">';
				mensaje+='<input type="text" class="input-small" name="fechas" id="fecha_final_aus" readonly="readonly"/>'; 
				mensaje+='</div>';
				mensaje+='</div>';
				mensaje+='<div id="esconder_ausencia" style="display:none;">'; // econder el combobox ausencias
				mensaje+='<div class="form-inline" style="margin-left:5%; margin-bottom: 4%;">';
				mensaje+='<label>Posibles Reemplazos : </label> ';
				mensaje+='<div style="margin-left:9%; display:inline;">';
				mensaje+='<select class="input-xlarge elegir" id="reem_aus_super"></select>';
				mensaje+='</div>';
				mensaje+='</div>';
				mensaje+='<div class="form-inline" style="margin-left:5%; margin-bottom: 4%;">';
				mensaje+='<label>Reemplazante por cargo: </label> ';
				mensaje+='<div style="margin-left:6%; display:inline;">';
				mensaje+='<select class="input-xlarge elegir" id="reem_aus_car"></select>';
				mensaje+='</div>';
				mensaje+='</div>';
				mensaje+='<div class="form-inline" style="margin-left:5%; margin-bottom: 4%;">';
				mensaje+='<label>Reemplazante por Area : </label> ';
				mensaje+='<div style="margin-left:6%; display:inline;">';
				mensaje+='<select class="input-xlarge elegir" id="reem_aus_area"></select>';
				mensaje+='</div>';
				mensaje+='</div>';
				mensaje+='</div>';
				mensaje+='<div id="vacaciones_tiempo" style="height:120px;float:left;display:none;overflow:scroll;width:100%">';
				mensaje+='<table border="1" class="tableone table-bordered" id="creacion">';
				mensaje += "<tr style='background-color: rgb(41, 76, 139); color: #fff; text-align: center;'><th>Fecha inicial</th><th>Fecha final</th><th>Días</th></tr>";
				for(var t=0; t<data.length; t++){
					mensaje +=	"<tr class='si contar_aus selec_"+t+"' id="+t+"><td align='center' class='fec_cau_ini_"+t+"'>"+data[t].fec_cau_ini+"</td>";
					mensaje +=	"<td align='center'  align='center' class='fec_cau_fin_"+t+"'>"+data[t].fec_cau_fin+"</td>";
					mensaje +=	"<td align='center' class='dias_aus_"+t+"' >"+data[t].dias+"</td>";
					mensaje +=	"</tr>";
				}
				mensaje+='</table>';
				mensaje+='</div>';
				mensaje += "<div class='validar'></div>";
				mensaje+='<div class="control-group" style="margin-left:5%; margin-top:3%;">';
				mensaje+='<div class="controls">';
				mensaje+= "<div id='g_aus'>";
				mensaje+='<button type="submit" class="btn btn-primary" id="guardar_ausencia">Guardar</button>';
				mensaje+='</div>';
				mensaje+='</div>';
				mensaje+='</div>';
				mensaje+='</form>';
				mensaje+="</div>";
				
		
			
			
			
			}
			
			
			modals("AUSENCIAS",mensaje);	
			
			var contar=Number($('.contar_aus').length);
			
			/*tabla para seleccionar el periodo en vacaciones en disfrute*/
			for(u=0;u<contar;u++){
					
				$(".selec_"+u+"").bind('click',function(){
					var a= Number($(".selecionar_aus").length);
					var p = $(this).attr("id");
					if(a > 0){
						$(".selecionar_aus").css("background","white");
						$(".selecionar_aus").removeClass("selecionar_aus");
						$(".dias_aus").removeClass("dias_aus");
						$(".fec_cau_ini").removeClass("fec_cau_ini");
						$(".fec_cau_fin").removeClass("fec_cau_fin");
					
					}else{
						$(this).addClass("selecionar_aus");
						$(".selecionar_aus").css("background","rgb(175, 203, 238)");
						$(".dias_aus_"+p+"").addClass("dias_aus");
						$(".fec_cau_ini_"+p+"").addClass("fec_cau_ini");
						$(".fec_cau_fin_"+p+"").addClass("fec_cau_fin");
						
						
					}
				});
			} /* Fin tabla para seleccionar el periodo en vacaciones en disfrute*/
			
			$.ajax({ /*Este ajax trae todas las ausencias de la tabla conceptos_ayu y se refleja en el combo box*/
				url:"ausencias.php",
				type:"POST",
				data:"info="+1,
				success:function(data){	
					$("#ausencias").html(data);
				}		
			});
	
					
					
			$("#ausencias").change(function(){ //para calcular los dias de vacaciones solo cuando elijo en el combobox ausencias
				$("#fecha_final_aus").val("");
				$("#reem_aus_car").val(0);
				$("#reem_aus_super").val(0);
				$("#fecha_final_area").val(0);
				$("#vacaciones_tiempo").css("display","none");
				
				$("#esconder_ausencia").css("display","none");
				
				if($("#ausencias").val()==11){ // 11 es el codigo del concepto de vacaciones
					//$("#vacaciones_tiempo").css("display","none");
					$.ajax({ 
						url:"ausencias.php",
						type:"POST",
						data:"info="+2+"&cod_epl="+cod_epl,
						success:function(data){	
							$('#dias_calculo').val(data); // para llenar automaticamente los 15 dias
						}		
					});
				}else{
					$('#dias_calculo').val("");
				}
			});
			
			/*combobox de empleados reemplazantes*/	
			$.ajax({ //segundo combo empleados x cargo ó reemplazante del empleado session
				url:"reemplazo_ausencias.php",
				type:"POST",
				data:"info="+1+"&cod_car="+cod_car,
				success:function(data){	
					$("#reem_aus_car").html(data);
					$.ajax({  //tercer combo empleados x area  del empleado session
						url:"reemplazo_ausencias.php",
						type:"POST",
						data:"info="+2+"&cod_cc2="+cod_cc2+"&cod_epl_jefe="+jefe,
						success:function(data){	
							
							$("#reem_aus_area").html(data);
						}		
					});
					/*$.ajax({  //cuarto combo empleados x externo listos deben de ser de las mismo cargo del empleado de session
						url:"reemplazo_ausencias.php",
						type:"POST",
						data:"info="+3+"&cod_car="+cod_car,
						success:function(data){	
							//console.log(data);return false;
							$("#reem_aus_exter").html(data);
						}		
					});*/
				}		
			});
				
					
			$("#calculo").click(function(){ /*Para hacer el calculo de dias y tambien validar si tiene vacaciones*/
				
				if($("#ausencias").val()==11){
					
					$.ajax({
						url:"calculo_vacaciones.php",
						type:"POST",
						data:"cod_epl="+cod_epl+"&fecha="+fecha+"&canti="+$("#dias_calculo").val()+"&ausencias="+$("#ausencias").val(),
						success:function(data){
					//console.log(data); return false;
							
							if(data==2){	
								$(".validar").html("<span style='margin-top:28px;' class='mensajes_error'> El empleado no ha cumplido el minimo de vacaciones</span>");
								$('#g_aus').css("display","none");
								return false;
							}if (data==3){
								$(".validar").html("<span style='margin-top:28px;' class='mensajes_error'> El empleado solo puede disfrutar 15 días</span>");
								return false;
							}else{ // inicio else
								$("#fecha_final_aus").val(data);
								$("#esconder_ausencia").css("display","block");	
								$.ajax({  //primer combobox de reemplazo 
									url:"reemplazo_ausencias.php",
									type:"POST",
									data:"info="+4+"&mes="+mes+"&anio="+anio+"&cod_cc2="+cod_cc2+"&cod_epl_jefe="+jefe+"&cod_epl="+cod_epl+"&fec_ini="+fecha+"&fec_fin="+$("#fecha_final_aus").val()+"&cod_car="+cod_car,
									success:function(data){	
										//console.log(data); return false;
										$("#reem_aus_super").html(data);
									}
									
								});
								return false;
							}	// fin else	
						}		
					});
				}else if($("#ausencias").val()==9000){
					$.ajax({
						url:'verificar_parametros.php',
						type:'POST',
						data:"info="+4+"&ausencia="+$("#dias_calculo").val(),
						success:function(res){
							if(res != 1){
								
								$('.validar').html('<span style="color:white; background-color:red; padding:2px;">El minimo de vacaciones de disfrute es: '+res+'</span>');
								return false;
							
							}else{
							
								$.ajax({
									url:"calculo_vacadisfrute.php",
									type:"POST",
									data:"cod_epl="+cod_epl+"&fecha="+fecha+"&canti="+$("#dias_calculo").val(),
									success:function(data){	
										//console.log(data); return false; 
										$("#fecha_final_aus").val(data);
										var fec_fin=$("#fecha_final_aus").val(data);
										$("#esconder_ausencia").css("display","none");
										$("#vacaciones_tiempo").css("display","block");
										
									}
								});
							}
						}
					});
				
				}else{ // resultado  de las otras  ausencias que no son vacaciones y vacaciones en disfrute
					
					var calculo=2;
					$.ajax({
						url:"calculo_ausencias.php",
						type:"POST",
						data:"cod_epl="+cod_epl+"&fecha="+fecha+"&canti="+$("#dias_calculo").val()+"&calculo="+calculo,
						success:function(data){
						
							$("#fecha_final_aus").val(data);
							$("#esconder_ausencia").css("display","block");
							$.ajax({  //primer combobox de reemplazo 
								url:"reemplazo_ausencias.php",
								type:"POST",
								data:"info="+4+"&mes="+mes+"&anio="+anio+"&cod_cc2="+cod_cc2+"&cod_epl_jefe="+jefe+"&cod_epl="+cod_epl+"&fec_ini="+fecha+"&fec_fin="+$("#fecha_final_aus").val()+"&cod_car="+cod_car,
								success:function(data){	
									//console.log(data); return false;
									$("#reem_aus_super").html(data);
								}
								
							});
						}
					});
				
				
				}
			});
			
			$(".elegir").change(function(){ // Para habilitar y desabilitar los combobox de los reemplazantes
				
				if($(this).val() > 0) {  
					$(this).removeClass("elegir");
					$(this).addClass("elegir_2");
					$(".elegir " ).each(function(index){
						$( this ).attr("disabled","disabled");
					});
				} 
				
				$(".elegir_2").bind('change',function(){
				
					if($(this).val() == 0) { 
						$(this).removeClass("elegir2");
						$(this).addClass("elegir");
						$(".elegir " ).each(function(index){
							$( this ).removeAttr("disabled","disabled");
						});
					} 
				});	
			}); // fin del combobox de reemplazantes
			
			$("#guardar_ausencia").click(function(){ /*guardar las ausencias*/
			
				alert(fecha);
				
				var anio1 = fechaIniCOmpleta.substring(10, 6);
				
				var mes1 = fechaIniCOmpleta.substring(3, 5);
				
				var dia1 = fechaIniCOmpleta.substring(0, 2);
				
				
				// alert(anio1);
				
				
				var anioCompleto1 = anio1 + "-" + mes1 + "-" + dia1 + " " + "00:00:00.000";
				
				
			
				var ausenciaReal = $("#fecha_final_aus").val();
				
				var anio = ausenciaReal.substring(10, 6);
				
				var mes = ausenciaReal.substring(3, 5);
				
				var dia = ausenciaReal.substring(0, 2);
				
				var anioCompleto = anio + "-" + mes + "-" + dia + " " + "00:00:00.000";
				
				 var modulo="VALIDARDATOSFEC_INI_R"; // para indicar que es el modulo de vacaciones en disfrute
				 var ausencia='<span style="color:#00FA9A; font-weight:bold;">VD</span>'; 
				
			//	alert(anioCompleto1 + "  " + anioCompleto); 
				
				

				        $.ajax({ 
							url:"guardar_ausenciasvalidar.php",
							type:"POST",
							data:"fecha_ini_r="+anioCompleto1+'&fecha_fin_r='+anioCompleto+'&modulo='+modulo+'&cod_epl='+cod_epl+'&mes='+mes+'&diaini='+dia1+'&diafin='+dia,
							success:function(res){
								
							//	alert(res);
								
								// var res2 = res.replace(",,,,,,,,,,,,,", "             ");
								
								
						
								var myArray = res.split(','); //explode
								
                                  console.log(myArray);

								var pos0 = myArray[0];
								var pos1 = myArray[1];
								var pos2 = myArray[2];
								var pos3 = myArray[3];
								var pos4 = myArray[4];
								var pos5 = myArray[5];
								var pos6 = myArray[6];
								var pos7 = myArray[7];
								var pos8 = myArray[8];
								var pos9 = myArray[9];
								var pos10 = myArray[10];
								var pos11 = myArray[11];
								var pos12 = myArray[12];
								var pos13 = myArray[13];
								var pos14 = myArray[14];
								var pos15 = myArray[15];
								var pos16 = myArray[16];
								var pos17 = myArray[17];
								var pos18 = myArray[18];
								var pos19 = myArray[19];
								var pos20 = myArray[20];
								var pos21 = myArray[21];
								var pos22 = myArray[22];
								var pos23 = myArray[23];
								var pos24 = myArray[24];
								var pos25 = myArray[25];
								var pos26 = myArray[26];
								var pos27 = myArray[27];
								var pos28 = myArray[28];
								var pos29 = myArray[29];
								var pos30 = myArray[30];
								var pos31 = myArray[31];								
								
								// console.log(pos13+pos20);
								
								
								if(pos0 == 'VD' || pos13 == "VD" || pos20 == "VD" || pos1 == "VD" || pos2 == "VD" || pos3 == "VD" || pos4 == "VD" || pos5 == "VD" || pos6 == "VD" || pos7 == "VD" || pos8 == "VD" || pos9 == "VD" || pos10 == "VD" || pos11 == "VD" || pos12 == "VD" || pos14 == "VD" || pos15 == "VD" || pos16 == "VD" || pos17 == "VD" || pos18 == "VD" || pos19 == "VD" || pos21 == "VD" || pos22 == "VD" || pos23 == "VD" || pos24 == "VD" || pos25 == "VD" || pos26 == "VD" || pos27 == "VD" || pos28 == "VD" || pos29 == "VD" || pos30 == "VD" || pos31 == "VD"){
									
									 $(".validar").html("<span style='margin-top:28px;' class='mensajes_error'> No se puede ingresar la ausencia</span>");
									 
									// location.reload();
									
								}else{
									
									
									
								}
								
							
								$('#g_aus').css("display","none");
								
								
						
							}		
						});
				
				
				
				// return false;
				
				
			
				//console.log($(".elegir_2").val()); return false;
				
				if($(".elegir_2").val()== undefined){ var reem=1;}else{ var reem=$(".elegir_2").val();}
				
				//console.log($(".elegir_2").val()); return false;
				if($("#ausencias").val()==9000){ //9000 es vacaciones en disfrute
					//$('#g_aus').css("display","none");
					var dias=parseInt($(".dias_aus").html());
					var dias_tomados=parseInt($('#dias_calculo').val());
					var pendientes_ante= 15 - dias;
					var pen_now= pendientes_ante - dias_tomados;
					var fec_cau_ini=$(".fec_cau_ini").html();
					var fec_cau_fin=$(".fec_cau_fin").html();
					if(dias_tomados <= pendientes_ante){ // dias = 5
						 var ausencia='<span style="color:#00FA9A; font-weight:bold;">VD</span>'; 
						 var modulo=1; // para indicar que es el modulo de vacaciones en disfrute
						$.ajax({ 
							url:"guardar_ausencias.php",
							type:"POST",
							data:"cod_con="+$("#ausencias").val()+"&cod_epl="+cod_epl+"&fec_cau_ini="+fec_cau_ini+"&fec_cau_fin="+fec_cau_fin+"&fec_ini="+fecha+"&fec_fin="+$("#fecha_final_aus").val()+"&dias="+$("#dias_calculo").val()+"&cod_cc2="+$(".centro_costo").val()+"&dias_pen="+pen_now+"&cod_car="+cod_car+"&mes="+mes+"&anio="+anio+"&cod_epl_jefe="+jefe+"&reem_car="+reem+"&ausencia="+ausencia+"&modulo="+modulo,
							success:function(res){
							
							
								$('#g_aus').css("display","none");
								if(res==1){
									$(".validar").html("<span style='margin-top:28px;' class='mensajes_success'> Se ingreso correctamente</span>");
								}else{
									$(".validar").html("<span style='margin-top:28px;' class='mensajes_error'> No Se ingreso correctamente</span>");
								}
								var fecha2 = anio+"-"+mes;
								var codigo = $('#cod_epl_sesion').val();
								programacion(fecha2, cod_cc2, cod_car, codigo);
								auditoria(fecha2, cod_cc2, cod_car, codigo);
							}		
						});
						
						return false;
						
					}else{
					    $('#g_aus').css("display","block");
						$('#dias_calculo').val("");
						$("#fecha_final_aus").val("");
						$(".validar").html("<span style='margin-top:28px;' class='mensajes_error'>Excede el n&uacute;mero de d&iacute;as para vacaciones</span>");
						return false;
					}
					
				
				}else{
						
					switch($("#ausencias").val()){
						case "11" :
							ausencia= '<span style="color:#A0522D; font-weight:bold;">V</span>';
						break;
						case "48" :
							ausencia= '<span style="color:#3399FF; font-weight:bold;">IG</span>';
						break;
						case "540" :
							ausencia= '<span style="color:#6B8E23; font-weight:bold;">LN</span>';
						break;
						case "545" :
							ausencia= '<span style="color:#87CEFA; font-weight:bold;">SP</span>';
						break;
						case "71" :
							ausencia= '<span style="color:#F4A460; font-weight:bold;">LM</span>';
						break;
						case "72" :
							ausencia= '<span style="color:#CD5C5C; font-weight:bold;">AT</span>';
						break;
						case  "73" :
							ausencia= '<span style="color:#EE82EE; font-weight:bold;">LP</span>'; 
						case  "74" :
							ausencia= '<span style="color:#FFA07A; font-weight:bold;">EP</span>';
						break;
						case  "35" :
							ausencia= '<span style="color:#00cbff; font-weight:bold;">LR</span>';
						break;
					}
					
					var modulo=2;
					
					if($("#reem_aus_car option:selected").val() != 0){
					
						var nom_epl=$("#reem_aus_car option:selected").html();
						
					}else if($("#reem_aus_area option:selected").val() != 0){
					
						var nom_epl=$("#reem_aus_area option:selected").html();
						
					}else if($("#reem_aus_super option:selected").val() != 0){
					
						var nom_epl=$("#reem_aus_super option:selected").html();
					}
					
					$.ajax({ 
						url:"guardar_ausencias.php",
						type:"POST",
						data:"cod_con="+$("#ausencias").val()+"&cod_epl="+cod_epl+"&fec_ini="+fecha+"&fec_fin="+$("#fecha_final_aus").val()+"&dias="+$("#dias_calculo").val()+"&cod_cc2="+$(".centro_costo").val()+"&cod_car="+cod_car+"&mes="+mes+"&anio="+anio+"&cod_epl_jefe="+jefe+"&reem_car="+reem+"&ausencia="+ausencia+"&modulo="+modulo+
						"&nom_reem="+nom_epl+"&nom_epl="+epl,
						
						success:function(res){
							//console.log(res);  return false;
							$('#g_aus').css("display","none");
							if(res==1){
								$(".validar").html("<span style='margin-top:28px;' class='mensajes_success'> Se ingreso correctamente</span>");
							}else{
								$(".validar").html("<span style='margin-top:28px;' class='mensajes_error'> No Se ingreso correctamente</span>");
							}
							var fecha2 = anio+"-"+mes;
							var codigo = $('#cod_epl_sesion').val();
							programacion(fecha2, cod_cc2, cod_car, codigo);
                            auditoria(fecha2, cod_cc2, cod_car, codigo);
						}		
					});

					return false;
				}
				
			});
		}		
	});
		
	return false;
}


//modal de intercambiar turno
function intercambiar_turno(turno,dia,epl,cod_epl){

	var mes=$(".mes").val();
	var anio=$(".anio").val();
	var jefe=$("#cod_epl_sesion").val();
	var cod_cc2=$(".centro_costo").val();
	var cod_car=$(".cargo").val();
		$.ajax({
			url:"intercambiar_turno.php",
			type:"POST",
			dataType:"json",
			data:"turno="+turno+"&dia="+dia+"&mes="+mes+"&anio="+anio+"&jefe="+jefe+"&cod_cc2="+cod_cc2+"&cod_car="+cod_car+"&cod_epl="+cod_epl,
			success:function(data){
				var	mensaje = '<div id="usuario_n" style="color: rgb(0,0,0); text-align: left;">';
					mensaje += "<form id='intercambiar_turno'>";
					mensaje += "<p style='text-align:center; color:rgb(41, 76, 139);font-weight: bold;'>"+epl+"</p>";
					mensaje += "<p style='text-align:center; color:rgb(41, 76, 139);font-weight: bold;'>Fecha: "+dia+"-"+mes+"-"+anio+"</p>";
					mensaje += "<div style=' display:inline-block; color:rgb(41, 76, 139); width:20%; margin-left:20%' ><label >Turno Actual</label>";
					mensaje += "<input type='text' class='turno_actual'  name='turno_actual' value='"+turno+"' readonly='readonly' style='width: 100%;'/></div>";
					mensaje += "<div style=' display:inline-block; color:rgb(41, 76, 139); width:20%; margin-left:20%' ><label >Turno Nuevo</label>";
					mensaje += "<input type='text' class='turno_nuevo'  name='turno_nuevo' value='' readonly='readonly' style='width: 100%;'/></div><br>";
					mensaje += "<p></p>";
					mensaje += "<p style='text-align:center; color:rgb(41, 76, 139);font-weight: bold;'>EMPLEADOS DISPONIBLES</p>";
					mensaje += "<div style='height:120px;float:left;display:block;overflow:scroll;width:100%'><table id='creacion' class='tableone table-bordered' border='1'>";
					mensaje += "<tr style='background-color: rgb(41, 76, 139); color: #fff; text-align: center;'><th>Empleado</th><th>Turno</th></tr>"; 
					for(var i=0; i<data.length; i++){
						mensaje +=	"<tr class='si contar seleccionar_"+i+"' id="+i+"><td align='center' class='nom_"+i+"'>"+data[i].nombres+"</td>";
						mensaje +=	"<td align='center' class='turno_"+i+"'>"+data[i].turno+"</td>";
						mensaje +=	"<td align='center' style='display:none;'class='cod_epl_"+i+"'>"+data[i].cod_epl+"</td>";
						mensaje +=	"</tr>";
					}
					mensaje += "</table></div>";
					mensaje += "<div class='validar'></div>";
					mensaje += "<div style='margin-top:5%; text-align:center;' id='esconder'><input id='intercambiar' type='button' class='btn btn-primary' value='Guardar'/></div>";
					mensaje += "</form>";
		            mensaje += "</div>";
					
					modals2('INTERCAMBIAR TURNO',mensaje);
					
					var contar=Number($('.contar').length);
					for(u=0;u<contar;u++){
					
						$(".seleccionar_"+u+"").bind('click',function(){
							var a= Number($(".selecionar").length);
			                var h = $(this).attr("id");
							if(a > 0){
								$(".selecionar").removeClass("selecionar");
								$(".tur_inter").removeClass("tur_inter");
								$(".inter_epl").removeClass("inter_epl");
								$(".nom_epl").removeClass("nom_epl");
							
							}else{
								$(this).addClass("selecionar");
								$(".turno_"+h+"").addClass("tur_inter");
								$(".cod_epl_"+h+"").addClass("inter_epl");
								$(".nom_"+h+"").addClass("nom_epl");
							}
							
							$(".turno_nuevo").val($(".tur_inter").html());
						});
					}

					$("#intercambiar").click(function(){
					
						$(".validar").css("display","none");
						
						if($(".turno_nuevo").val()== 0){
							$(".validar").css("display","block");
							$(".validar").html("<span style='margin-top:28px;' class='mensajes_error'>El campo Turno Nuevo esta vacío.</span>");
							return false;
						}
						$.ajax({
							url:"add_intercambio.php",
							type:"POST",
							dataType:"html",
							data:"cod_epl1="+cod_epl+"&cod_epl2="+$(".inter_epl").html()+"&turno1="+turno+"&turno2="+$(".tur_inter").html()+"&dia="+dia+"&mes="+mes+"&anio="+anio+"&jefe="+jefe+"&cod_car="+cod_car+"&cod_cc2="+cod_cc2+"&nom1="+epl+"&nom2="+$(".nom_epl").html(),
							success:function(data){
								$(".validar").css("display","block");
								$(".validar").html("<p style='margin-top:28px;'>"+data+"</p>");
								$("#esconder").css("display","none");
								var fecha = anio+"-"+mes;
								var codigo = $('#cod_epl_sesion').val();
								programacion(fecha, cod_cc2, cod_car, codigo);
                                auditoria(fecha, cod_cc2, cod_car, codigo);
							
							}
						});
						return false;
					});
			}
		});
	return false;
}


//Auditoria
function auditoria(fecha, centro_costo, cargo, codigo){ 
	$.ajax({
				dataType: "json",
				type:"GET",
				url: "ind.php",
				data: "fecha="+fecha,
				success: function (datos1){
				
					var canti=datos1[0].calendario1.numeros.length;
					var canti2=datos1[0].calendario2.dias.length;
				
					/*tbody*/
					$.ajax({
					  
					   type:"POST",
					   url: "auditoria2.php",
					   data: "cantidad="+canti+"&centro_costo="+centro_costo+"&cargo="+cargo+"&fecha="+fecha+"&codigo="+codigo,
							 beforeSend:function(){
							$("#contenido2").html("");                                                                                                 	
					   },
					   success: function (datos){
					   
							//console.log(datos);return false;
							
							var canti=datos1[0].calendario1.numeros.length;
							var canti2=datos1[0].calendario2.dias.length;
				 
							//INICIO DE TABLA	 
					
							//THEAD
							var table="<div style='width:99%'><table style='color: rgb(41, 76, 139) !important;' cellpadding='0' cellspacing='0' border='1' class='display' id='example2'><thead style='background-color: rgb(41, 76, 139); font-size: 13px; color: #fff; font-weight:bold;'><tr><td rowspan='2' align='center'>Turno</td><td rowspan='2' id='dias' align='center'>Horas</td>";
					
							for(i=0; i < canti2; i ++){
								table+="<td align='center'>"+datos1[0].calendario2.dias[i]+"</td>";
							}
							table+="<td rowspan='2' align='center'>Sem1</td><td rowspan='2' align='center'>Sem2</td><td rowspan='2' align='center'>Sem3</td><td rowspan='2' align='center'>Sem4</td><td rowspan='2' align='center'>Sem5</td><td rowspan='2' align='center'>Sem6</td><td rowspan='2' align='center'>Tmes</td></tr><tr>";
						
							for(i=0; i < canti; i ++){
								table+="<td align='center'>&nbsp;&nbsp;"+datos1[0].calendario1.numeros[i]+"&nbsp;&nbsp;</td>";
							}
							table+="</tr></thead>";
							//FIN THEAD

							table+=datos;

							table+="</table></div><br><br>";
					
							//FIN TABLA
					
							$("#contenido2").html(table);
							
							//Aca va el datable porque se crea example y ahi si con ese example hagame esta accion
							$('#example2').dataTable({

								"bLengthChange": false,
								"bSort": false,
								"bPaginate": true,
								"bInfo": false,
								"bFilter": false,
								"oLanguage": {
										"sProcessing": "Procesando...",										
										"sZeroRecords": "No se encontraron resultados",										
										"sInfoEmpty": "No existen registros",									
										"oPaginate": {
										"sFirst": "Primero",
										"sPrevious": "Anterior",
										"sNext": "Siguiente",
										"sLast": "Último"
										}
								}
						
							});
							
						}
					});
					/*fin table*/
				}
			});
}


//Funcion para poner por defecto el mes y año en el combo box

function tiempo_sistema(){
	
	var fecha=new Date();
	var ano=fecha.getFullYear();
	//var ano=2011;
	var mes=fecha.getMonth() +1 ;
	
	for(var i=2005; i<2030; i++){	
	
		if(i == ano){
		  $('#'+i).attr("selected","selected");
		  break;
		}	
	}
	
	switch(mes)
	{
	case 1:
	  $('#enero').attr("selected","selected");
	  break;
	case 2:
	  $('#febrero').attr("selected","selected");
	  break;
	case 3:
	 $('#marzo').attr("selected","selected");
	  break;
	case 4:
	 $('#abril').attr("selected","selected");
	  break;
	case 5:
	  $('#mayo').attr("selected","selected");
	  break;
	 case 6:
	  $('#junio').attr("selected","selected");
	  break;
	case 7:
	  $('#julio').attr("selected","selected");
	  break;
	case 8:
	  $('#agosto').attr("selected","selected");
	  break;
	case 9:
	  $('#septiembre').attr("selected","selected");
	  break;
	case 10:
	  $('#octubre').attr("selected","selected");
	  break;
	case 11:
	  $('#noviembre').attr("selected","selected");
	  break;
	case 12:
	  $('#diciembre').attr("selected","selected");
	  break; 
	}
}

//funcion para verificar el mes de la programacion
function verificar_mes(mes){
	switch(mes){
		case '1':
			r="ENERO";
		break;
		case '2':
			r="FEBRERO";
		break;
		case '3':
			r="MARZO";
		break;
		case '4':
			r="ABRIL";
		break;
		case '5':
			r="MAYO";
		break;
		case '6':
			r="JUNIO";
		break;
		case '7':
			r="JULIO";
		break;
		case '8':
			r="AGOSTO";
		break;
		case '9':
			r="SEPTIEMBRE";
		break;
		case '10':
			r="OCTUBRE";
		break;
		case '11':
			r="NOVIEMBRE";
		break;
		case '12':
			r="DICIEMBRE";
		break;
	}
	return r;
}