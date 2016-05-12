$(document).ready(main);

function main(){

	
	//PESTAÑA 1
		$(".centro_costo").change(function(){ 
		
			tiempo_sistema();		
	
			 $("#contenido").html("");//PORGRAMACION EMPLEADOS
			 $("#contenido2").html("");//AUDITORIA SIMPLIFICADA
			 $("#contenido3").css("display","none");//TABLA COLORES
			
			
			var centro_costo=$(".centro_costo").val();
			
			 if(centro_costo == '-1'){
			    $("#contenido").html("");
				$("#contenido2").html("");
				$("#contenido3").css("display","none");			    		
			 }
			
            var idCombo1 = $(this).val();
			var codigo = $('#cod_epl_sesion').val();
			var server=  $('#server').val();
			
            $.ajax({
                type : "POST",
                url : "ajax_cargos_anidados.php",                
                data : "idCombo1="+idCombo1+"&codigo="+codigo+"&server="+server,
                success : function(data){
				   
                   $("#combo2").html(data);
				   $(".cargo").change(function(){
						
						 var fecha=$(".anio").val()+"-"+$(".mes").val();
						 var centro_costo=$(".centro_costo").val();
					     var cargo=$(".cargo").val();
						 
						 if(cargo == '-1'){
							 $("#contenido").html("");
							 $("#contenido2").html("");
							 $("#contenido3").css("display","none");							
							 return false;
						 }
						 
						 programacions(fecha, centro_costo, cargo, codigo);
						 auditorias(fecha, centro_costo, cargo, codigo );
						 $("#contenido3").css("display","block");						
		
				   });
				   
				   $(".anio, .mes").change(function(){
						
						 var fecha=$(".anio").val()+"-"+$(".mes").val();
						 var centro_costo=$(".centro_costo").val();
					     var cargo=$(".cargo").val();
						 var codigo = $('#cod_epl_sesion').val();
						 
						programacions(fecha, centro_costo, cargo, codigo);
						auditorias(fecha, centro_costo, cargo, codigo );
						$("#contenido3").css("display","block");				 
		
				   });
				   
               }//FIN SUCCESS
           });//FIN AJAX
     
	  $('#meses, #anios').css('display', 'inline');
	});
	
	
	
	//NUEVO
	$('#validar_programacion').click(function(){
						 
				/*$("#contenido").html("<h1 id='cerrar_se'>Espere Por favor<span>.</span><span>.</span><span>.</span></h1>");	
				
						
			setInterval(
			function() {*/
					var fecha=$(".anio").val()+"-"+$(".mes").val();
						 var centro_costo=$(".centro_costo").val();
					     var cargo=$(".cargo").val();
						 var codigo = $('#cod_epl_sesion').val();
						 
						 
						
				
						$('#validar_programacion').attr("disabled", "disabled");
						
						$('#validar_programacion').attr("value", "CARGANDO");
						 
						 //Funcion para eliminar todo y cargue como debe ser y no estar dandole delete a toda hora.
						 delete_tablas_validar(fecha, centro_costo, cargo, codigo);
//},5000);
	})
	//FIN NUEVO
	
	//FIN PESTAÑA UNO
	
	
	//PESTAÑA 2	
			
		
		$(".centro_costo_pro").change(function(){ 
		
			tiempo_sistema();
						
			 $("#contenido_general").html("");//TABLA AUTORIZACION EMPLEADOS		
			
			var centro_costo_pro=$(".centro_costo_pro").val();
			
			 if(centro_costo_pro == '-1'){
			    $("#contenido_general").html("");			    		
			 }			
			
            var idCombo1 = $(this).val(); //70010104
			var codigo = $('#cod_epl_sesion').val(); //45453931
			var server=  $('#server').val(); //2			
			
           $.ajax({
                type : "POST",
                url : "ajax_cargos_anidados_autorizacion.php",                
                data : "idCombo1="+idCombo1+"&codigo="+codigo+"&server="+server,
                success : function(data){					
				   
                   $("#combo9").html(data);
				   $(".cargo_autorizacion").change(function(){						
						
						 var fecha=$(".anio_pes").val()+"-"+$(".mes_pes").val();
						 var centro_costo_pro=$(".centro_costo_pro").val();
					     var cargo_autorizacion=$(".cargo_autorizacion").val();
						 				 
						 
						 if(cargo_autorizacion == '-1'){
						     
							 $("#contenido_general").html("");						
							 return false;
						 }
						 
						 
						 autorizacion(fecha, centro_costo_pro, cargo_autorizacion, codigo);	
						  					 
		
				   });
				   
				   $(".anio_pes, .mes_pes").change(function(){
						
						
						 var fecha=$(".anio_pes").val()+"-"+$(".mes_pes").val();
						 var centro_costo_pro=$(".centro_costo_pro").val();
					     var cargo_autorizacion=$(".cargo_autorizacion").val();
						 var codigo = $('#cod_epl_sesion').val();
						 
						
						 autorizacion(fecha, centro_costo_pro, cargo_autorizacion, codigo);	

												 
		
				   });
				   
               }//FIN SUCCESS
           });//FIN AJAX
     
	  $('#meses_pes, #anios_pes').css('display', 'inline');
	});	
	
	//el boton de la Segunda pestaña
	$('#autorizar').click(function(){
						 
						 var fecha=$(".anio_pes").val()+"-"+$(".mes_pes").val();
						 var centro_costo_pro=$(".centro_costo_pro").val();
					     var cargo_autorizacion=$(".cargo_autorizacion").val();
						 var codigo = $('#cod_epl_sesion').val();
						 var anio_autorizacion=$(".anio_pes").val();
						 var mes_autorizacion=$(".mes_pes option:selected").text();
						 
			             validar_autorizacion(fecha, centro_costo_pro, cargo_autorizacion, codigo, anio_autorizacion, mes_autorizacion);
	
	})
	//FIN NUEVO
	
	//FIN PESTAÑA DOS
	
	
}
//--------------------------------------------------------------------------------------------


 function delete_tablas_validar(fecha, centro_costo, cargo, codigo){
 
					$.ajax({					  
						   type:"POST",
						   url: "delete_tablas_validar.php",
						   data: "centro_costo="+centro_costo+"&cargo="+cargo+"&fecha="+fecha+"&codigo="+codigo,
										   
						   success: function (datos){
											 //console.log(datos);return false;											
											
											if(datos==1){
												
												validar_programacion(fecha, centro_costo, cargo, codigo);
												console.log('1');return false;
											
											}else if(datos==2){
												//console.log("entrte aca bn");return false;
												console.log('entre al 2 voy');		
												
												validar_programacion(fecha, centro_costo, cargo, codigo);
												//programacion_colores(fecha, centro_costo, cargo, codigo);
												console.log('2');return false;
											}
																			
											
							}
					});
 
 
 
 
 }



function validar_programacion(fecha, centro_costo, cargo, codigo){
				
				
					
				// IMPORTANTE PARA TODOS LOS ELEMENTOS DEL DATATABLE DE LA PAGINACION
				var oTable = $('#example').dataTable();
				var nFiltered = oTable.fnGetFilteredNodes();
				var longitud_empleados = $(".empleado",nFiltered).length;
		
				 
				 //var prueba= $("table #2 .context-menu-one").attr("class");
				  //console.log(longitud_empleados);return false;
				  
				//prueba= $("table #5 .context-menu-one").attr("class");
				  
				h=1;
				w=0;
				z=1;
				

//(longitud_empleados+1)
				
				
				
				for(var i=1; i<=longitud_empleados; i++){					
					
					
					/*if(h==(longitud_empleados)){
									console.log("ENTRO A LA CONDICION");
									programacion_colores(fecha, centro_costo, cargo, codigo);
									$w=1;
									return;
					}*/
					//Este pedazo que comento se descomenta cuando se pasa a productivo y el otro de abajo se comentarea OJO
					
					
					
					
				/*for(var i=1; i<=(longitud_empleados+1); i++){					
					
					
					if(h==(longitud_empleados+1)){
									console.log("ENTRO A LA CONDICION");
									programacion_colores(fecha, centro_costo, cargo, codigo);
									$w=1;
									return;
					}*/
					
					
					
					
					
					
					if(h==longitud_empleados && z!=2){
									$("#validar_programacion").removeAttr("disabled");
					
									$('#validar_programacion').attr("value", "Validacion");
									return;
					}
					
					
					
					if(w!=1){
					
						var clase=$("table #"+i+" .context-menu-one").attr("class");//me va traer las clases del elemento padre
												
						var separar=clase.split(" ");	
														
						var codigo_epl=separar[3];						
					}
					
					
					var existe=$("table #"+i+" .context-menu-two").html();//PARA SABER SI EL CUADRITO TIENE ALGO Y PUEDA ENTRAR AL AJAX
					
					
									
					
					if(existe != ""){
						
						z=2;
						
						$.ajax({					  
						   type:"POST",
						   url: "tiempo_extra_validacion.php",
						   data: "centro_costo="+centro_costo+"&cargo="+cargo+"&fecha="+fecha+"&codigo="+codigo+"&codigo_epl="+codigo_epl,
												   
						   success: function (datos){
									console.log(datos);//return false;
									//console.log("BN EL SUCCEES");
									
									
										programacion_colores(fecha, centro_costo, cargo, codigo); //--Para productivo poner esta
									
							}
						});
						
						
						
						
						
						
						
						h++;
											
					}else{
						h++;
						continue;
					}
					
					
					
					

				
								
					
				}
				
				//programacion_colores(fecha, centro_costo, cargo, codigo);
						
				return false;

}

function modal_marcacion(color,cod_epl,mes,anio,j,codigo_jefe,turno, fecha, centro_costo, cargo, codigo){

	if(color=='#F5A65D'){//orange
		horas_extras_marcadas(cod_epl,mes,anio,j, codigo_jefe, turno, fecha, centro_costo, cargo, codigo);
	}
	
	if(color=='#BBF6C0'){//green
		marcacion_existe(cod_epl,mes,anio,j,codigo_jefe, turno, fecha, centro_costo, cargo, codigo);
	}
	
	if(color=='#F997C5'){//pink
		menor_tiempo(cod_epl,mes,anio,j,codigo_jefe, turno, fecha, centro_costo, cargo, codigo);
	}
	
	if(color=='#E78587'){//red
		//console.log("si");return false;
		horario_no_coincide(cod_epl,mes,anio,j,codigo_jefe, turno, fecha, centro_costo, cargo, codigo);
	}
	
	if(color=='#F5F4B1'){//Yellow
		horas_extras_marcadas_libre(cod_epl,mes,anio,j, codigo_jefe, turno, fecha, centro_costo, cargo, codigo);
	}
	
	if(color=='#93E5DF'){//azul verde
		marcacion_existe_una_vez(cod_epl,mes,anio,j,codigo_jefe, turno, fecha, centro_costo, cargo, codigo);
	}


	return false;
}

function horas_extras_marcadas(cod_epl,mes,anio,j,codigo_jefe, turno, fecha, centro_costo, cargo, codigo){
		
		var posicion=j;
		var anio=anio;
		var mes=mes;	
			
		
		$.ajax({
		   type:"POST",
		   url: "tiempo_extra_horas.php",
		   data: "cod_epl="+cod_epl+"&mes="+mes+"&anio="+anio+"&dia="+j+"&codigo_jefe="+codigo_jefe+"&turno="+turno,	
		   success: function (datos){		
				
			var	mensaje = '<div style="color: rgb(0,0,0); text-align: left;">';
			mensaje += "<form>";	
		
			mensaje+=datos;
			//console.log(datos);//return false;
		
		
				mensaje += "</table>";
				mensaje += "</div>";
				mensaje += "<div class='validar'></div>";
				mensaje += "<div style='margin-top:5%; text-align:center;'>";
				
				mensaje += "<input id='aprobar_extras' type='button' class='btn btn-primary' value='Aprobar'/>";
				mensaje += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				mensaje += "<input id='cancelar_extras'  style='margin-left:10px' type='button' class='btn btn-primary' value='Cancelar'/>";
				
				mensaje += "</div>"
				mensaje += "</form>";
				mensaje += "</div>";
				
				
				
				modals("N&Uacute;MERO DE HORAS EXTRAS MARCADAS",mensaje);
				
				
				
				
				$("#aprobar_extras").click(function(){	
						
						extras_jefe_autoriza_hed_rel=$('#extras_jefe_hed_rel').val();
						extras_jefe_autoriza_hen_rel=$('#extras_jefe_hen_rel').val();
						extras_jefe_autoriza_hedf_rel=$('#extras_jefe_hedf_rel').val();
						extras_jefe_autoriza_henf_rel=$('#extras_jefe_henf_rel').val();
						extras_jefe_autoriza_hfd_rel=$('#extras_jefe_hfd_rel').html();
						extras_jefe_autoriza_rno_rel=$('#extras_jefe_rno_rel').html();
						extras_jefe_autoriza_rnf_rel=$('#extras_jefe_rnf_rel').html();					
											
								
						$.ajax({
						   type:"POST",
						   url: "insertar_update_tabla_autorizacion.php",
						   data: "cod_epl="+cod_epl+"&mes="+mes+"&anio="+anio+"&dia="+j+"&codigo_jefe="+codigo_jefe+"&extras_jefe_autoriza_hed_rel="+extras_jefe_autoriza_hed_rel
						   +"&extras_jefe_autoriza_hen_rel="+extras_jefe_autoriza_hen_rel+"&extras_jefe_autoriza_hedf_rel="+extras_jefe_autoriza_hedf_rel
						   +"&extras_jefe_autoriza_henf_rel="+extras_jefe_autoriza_henf_rel+"&extras_jefe_autoriza_hfd_rel="+extras_jefe_autoriza_hfd_rel
						   +"&extras_jefe_autoriza_rno_rel="+extras_jefe_autoriza_rno_rel+"&extras_jefe_autoriza_rnf_rel="+extras_jefe_autoriza_rnf_rel,
						   
						   success: function (datos){	
								//console.log(datos);return false;

								codigo_epl=$('#codigo_epl').val();
								
								$('#myModal2').modal('hide');
								
								  Alert.aprobacion();
								  
								  $.ajax({
									   type:"POST",
									   url: "update_colores_revisada.php",
									   data: "posicion="+posicion+"&mes="+mes+"&anio="+anio+"&cod_epl="+codigo_epl,											
									   success: function (datos){
									   
									   
													//console.log(datos);return false;	
													
													//$("#body").load("tiempo_extra.php");
													
													//'2013-9', '70010104', '300003','45453931'						
													
													programacion_colores(fecha, centro_costo, cargo, codigo);												  
														  
												   }
								});	
								
							}
						});										
				});
				
				
				$("#cancelar_extras").click(function(){
				
						$('#myModal2').modal('hide');
				});
		
		
		
			}
	});
		

return false;
}



function marcacion_existe(cod_epl,mes,anio,j,codigo_jefe, turno, fecha, centro_costo, cargo, codigo){
		
		var posicion=j;
		var anio=anio;
		var mes=mes;	
			
		
		$.ajax({
		   type:"POST",
		   url: "tiempo_marcacion_existe.php",
		   data: "cod_epl="+cod_epl+"&mes="+mes+"&anio="+anio+"&dia="+j+"&codigo_jefe="+codigo_jefe+"&turno="+turno,	
		   success: function (datos){		
				
				var	mensaje = '<div style="color: rgb(0,0,0); text-align: left;">';
				mensaje += "<form>";	
		
				mensaje+=datos;
				//console.log(datos);//return false;
		
		
				mensaje += "</table>";
				mensaje += "</div>";
				
				mensaje += "<div style='margin-top:5%; text-align:center;'>";
				
				mensaje += "<input id='email' type='button' class='btn btn-primary' value='Envio Email Colaborador'/>";
				mensaje += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				mensaje += "<input id='no_enviar' type='button' class='btn btn-primary' value='No Enviar'/>";
				mensaje += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				mensaje += "<input id='cancelar' type='button' class='btn btn-primary' value='Cancelar'/>";
				
				
				mensaje += "</div>"
				mensaje += "</form>";
				mensaje += "</div>";
				
				
				
				modals("NO HAY REGISTROS DE MARCACION PARA ESTE TURNO",mensaje);
				
								
				$("#email").click(function(){	
						
						codigo_epl=$('#codigo_epl').val();
												
						$('#myModal2').modal('hide');
											
						correo_programacion_extra(codigo_epl);
									
											
						$.ajax({
							   type:"POST",
							   url: "update_colores_revisada.php",
							   data: "posicion="+posicion+"&mes="+mes+"&anio="+anio+"&cod_epl="+codigo_epl,											
							   success: function (datos){
						 
											//console.log(datos);return false;	
											
											//$("#body").load("tiempo_extra.php");
												
											//'2013-9', '70010104', '300003','45453931'						
												
											programacion_colores(fecha, centro_costo, cargo, codigo);												  
														  
							   }
						});	
								
				});
				
				$("#cancelar").click(function(){ 
	
						
						$('#myModal2').modal('hide');
					
								
				});
				
				$("#no_enviar").click(function(){ 


						
						codigo_epl=$('#codigo_epl').val();
						
									
						
						$('#myModal2').modal('hide');
													
														
											
						$.ajax({
							   type:"POST",
							   url: "update_colores_revisada.php",
							     data: "posicion="+posicion+"&mes="+mes+"&anio="+anio+"&cod_epl="+codigo_epl,											
							   success: function (datos){
						 
											//console.log(datos);return false;	
											
											//$("#body").load("tiempo_extra.php");
												
											//'2013-9', '70010104', '300003','45453931'						
												
											programacion_colores(fecha, centro_costo, cargo, codigo);												  
														  
							   }
						});	
								
				});
			}										
		});
	
	return false;
				
}



function menor_tiempo(cod_epl,mes,anio,j,codigo_jefe, turno, fecha, centro_costo, cargo, codigo){
		
		var posicion=j;
		var anio=anio;
		var mes=mes;	
			
		
		$.ajax({
		   type:"POST",
		   url: "menor_tiempo.php",
		   data: "cod_epl="+cod_epl+"&mes="+mes+"&anio="+anio+"&dia="+j+"&codigo_jefe="+codigo_jefe+"&turno="+turno,	
		   success: function (datos){		
				
				var	mensaje = '<div style="color: rgb(0,0,0); text-align: left;">';
				mensaje += "<form>";	
		
				mensaje+=datos;
				//console.log(datos);return false;
		
		
				mensaje += "</table>";
				mensaje += "</div>";
				
				mensaje += "<div style='margin-top:5%; text-align:center;'>";
				
				mensaje += "<input id='email' type='button' class='btn btn-primary' value='Envio Email Colaborador'/>";
				mensaje += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				mensaje += "<input id='no_enviar' type='button' class='btn btn-primary' value='No Enviar'/>";
				mensaje += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				mensaje += "<input id='cancelar' type='button' class='btn btn-primary' value='Cancelar'/>";
				
				
				mensaje += "</div>"
				mensaje += "</form>";
				mensaje += "</div>";
				
				
				
				modals("MENOR TIEMPO LABORADO AL PROGRAMADO",mensaje);
				
				
				
				
				$("#email").click(function(){	
						
						codigo_epl=$('#codigo_epl').val();
						
						
						$('#myModal2').modal('hide');
												
						correo_programacion_extra(codigo_epl);
									
											
						$.ajax({
							   type:"POST",
							   url: "update_colores_revisada.php",
							   data: "posicion="+posicion+"&mes="+mes+"&anio="+anio+"&cod_epl="+codigo_epl,											
							   success: function (datos){
						 
											//console.log(datos);return false;	
											
											//$("#body").load("tiempo_extra.php");
												
											//'2013-9', '70010104', '300003','45453931'						
												
											programacion_colores(fecha, centro_costo, cargo, codigo);												  
														  
							   }
						});	
								
				});
				
				$("#no_enviar").click(function(){
					
						codigo_epl=$('#codigo_epl').val();
												
						$('#myModal2').modal('hide');
																
											
						$.ajax({
							   type:"POST",
							   url: "update_colores_revisada.php",
							   data: "posicion="+posicion+"&mes="+mes+"&anio="+anio+"&cod_epl="+codigo_epl,											
							   success: function (datos){
						 
											//console.log(datos);return false;	
											
											//$("#body").load("tiempo_extra.php");
												
											//'2013-9', '70010104', '300003','45453931'						
												
											programacion_colores(fecha, centro_costo, cargo, codigo);												  
														  
							   }
						});	
								
				});
				
				$("#cancelar").click(function(){ 
	
						
						$('#myModal2').modal('hide');
					
								
				});
			}										
		});
	
	return false;
				
}


function horario_no_coincide(cod_epl,mes,anio,j,codigo_jefe, turno, fecha, centro_costo, cargo, codigo){
	
		var posicion=j;
		var anio=anio;
		var mes=mes;	
			
		
		$.ajax({
		   type:"POST",
		   url: "horario_no_coincide.php",
		   data: "cod_epl="+cod_epl+"&mes="+mes+"&anio="+anio+"&dia="+j+"&codigo_jefe="+codigo_jefe+"&turno="+turno,	
		   success: function (datos){		
				
								
				var	mensaje = '<div style="color: rgb(0,0,0); text-align: left;">';
				mensaje += "<form>";	
		
				mensaje+=datos;
				//console.log(datos);return false;
		
		
				mensaje += "</table>";
				mensaje += "</div>";
				
				mensaje += "<div style='margin-top:5%; text-align:center;'>";
				
				mensaje += "<input id='email' type='button' class='btn btn-primary' value='Envio Email Colaborador'/>";
				mensaje += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";				
				mensaje += "<input id='no_enviar' type='button' class='btn btn-primary' value='No Enviar'/>";
				mensaje += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				mensaje += "<input id='cancelar' type='button' class='btn btn-primary' value='Cancelar'/>";
				
				mensaje += "</div>"
				mensaje += "</form>";
				mensaje += "</div>";
				
				
				
				modals("HORARIO NO COINCIDE CON TURNO PROGRAMADO",mensaje);
				
				
				
				
				$("#email").click(function(){


						color_mas=$('#color_mas').val();
						codigo_epl=$('#codigo_epl').val();
						
									
						
						$('#myModal2').modal('hide');
								
						
						correo_programacion_extra(codigo_epl);
														
											
						$.ajax({
							   type:"POST",
							   url: "update_colores_revisada.php",
							   data: "posicion="+posicion+"&mes="+mes+"&anio="+anio+"&color_mas="+color_mas+"&cod_epl="+codigo_epl,											
							   success: function (datos){
						 
											//console.log(datos);return false;	
											
											//$("#body").load("tiempo_extra.php");
												
											//'2013-9', '70010104', '300003','45453931'						
												
											programacion_colores(fecha, centro_costo, cargo, codigo);												  
														  
							   }
						});	
								
				});
				
				$("#no_enviar").click(function(){


						color_mas=$('#color_mas').val();
						codigo_epl=$('#codigo_epl').val();
						
									
						
						$('#myModal2').modal('hide');
													
														
											
						$.ajax({
							   type:"POST",
							   url: "update_colores_revisada.php",
							   data: "posicion="+posicion+"&mes="+mes+"&anio="+anio+"&color_mas="+color_mas+"&cod_epl="+codigo_epl,											
							   success: function (datos){
						 
											//console.log(datos);return false;	
											
											//$("#body").load("tiempo_extra.php");
												
											//'2013-9', '70010104', '300003','45453931'						
												
											programacion_colores(fecha, centro_costo, cargo, codigo);												  
														  
							   }
						});	
								
				});	
				
				$("#cancelar").click(function(){ 
	
						
						$('#myModal2').modal('hide');
					
								
				});
				
			}										
		});
	
	return false;


}



function horas_extras_marcadas_libre(cod_epl,mes,anio,j,codigo_jefe, turno, fecha, centro_costo, cargo, codigo){
		
		var posicion=j;
		var anio=anio;
		var mes=mes;	
			
		
		$.ajax({
		   type:"POST",
		   url: "tiempo_extra_horas.php",
		   data: "cod_epl="+cod_epl+"&mes="+mes+"&anio="+anio+"&dia="+j+"&codigo_jefe="+codigo_jefe+"&turno="+turno,	
		   success: function (datos){		
				
			var	mensaje = '<div style="color: rgb(0,0,0); text-align: left;">';
			mensaje += "<form>";	
		
			mensaje+=datos;
			//console.log(datos);//return false;
		
		
				mensaje += "</table>";
				mensaje += "</div>";
				mensaje += "<div class='validar'></div>";
				mensaje += "<div style='margin-top:5%; text-align:center;'>";
				
				mensaje += "<input id='aprobar_extras' type='button' class='btn btn-primary' value='Aprobar'/>";
				mensaje += "<input id='cancelar_extras'  style='margin-left:10px' type='button' class='btn btn-primary' value='Cancelar'/>";
				
				mensaje += "</div>"
				mensaje += "</form>";
				mensaje += "</div>";
				
				
				
				modals("NO HAY TURNOS PARA ESTA MARCACION",mensaje);
				
				
				
				
				$("#aprobar_extras").click(function(){	
						
						extras_jefe_autoriza_hed_rel=$('#extras_jefe_hed_rel').val();
						extras_jefe_autoriza_hen_rel=$('#extras_jefe_hen_rel').val();
						extras_jefe_autoriza_hedf_rel=$('#extras_jefe_hedf_rel').val();
						extras_jefe_autoriza_henf_rel=$('#extras_jefe_henf_rel').val();
						extras_jefe_autoriza_hfd_rel=$('#extras_jefe_hfd_rel').html();
						extras_jefe_autoriza_rno_rel=$('#extras_jefe_rno_rel').html();
						extras_jefe_autoriza_rnf_rel=$('#extras_jefe_rnf_rel').html();					
											
								
						$.ajax({
						   type:"POST",
						   url: "insertar_update_tabla_autorizacion.php",
						   data: "cod_epl="+cod_epl+"&mes="+mes+"&anio="+anio+"&dia="+j+"&codigo_jefe="+codigo_jefe+"&extras_jefe_autoriza_hed_rel="+extras_jefe_autoriza_hed_rel
						   +"&extras_jefe_autoriza_hen_rel="+extras_jefe_autoriza_hen_rel+"&extras_jefe_autoriza_hedf_rel="+extras_jefe_autoriza_hedf_rel
						   +"&extras_jefe_autoriza_henf_rel="+extras_jefe_autoriza_henf_rel+"&extras_jefe_autoriza_hfd_rel="+extras_jefe_autoriza_hfd_rel
						   +"&extras_jefe_autoriza_rno_rel="+extras_jefe_autoriza_rno_rel+"&extras_jefe_autoriza_rnf_rel="+extras_jefe_autoriza_rnf_rel,
						   
						   success: function (datos){	
								//console.log(datos);return false;

								codigo_epl=$('#codigo_epl').val();
								
								$('#myModal2').modal('hide');
								
								  Alert.aprobacion();
								  
								  $.ajax({
									   type:"POST",
									   url: "update_colores_revisada.php",
									   data: "posicion="+posicion+"&mes="+mes+"&anio="+anio+"&cod_epl="+codigo_epl,											
									   success: function (datos){
									   
									   
													//console.log(datos);return false;	
													
													//$("#body").load("tiempo_extra.php");
													
													//'2013-9', '70010104', '300003','45453931'						
													
													programacion_colores(fecha, centro_costo, cargo, codigo);												  
														  
												   }
								});	
								
							}
						});										
				});
				
				
				$("#cancelar_extras").click(function(){
				
						$('#myModal2').modal('hide');
				});
		
		
		
			}
	});
		

return false;
}



function marcacion_existe_una_vez(cod_epl,mes,anio,j,codigo_jefe, turno, fecha, centro_costo, cargo, codigo){
		
		var posicion=j;
		var anio=anio;
		var mes=mes;	
			
		
		$.ajax({
		   type:"POST",
		   url: "tiempo_marcacion_existe_una_vez.php",
		   data: "cod_epl="+cod_epl+"&mes="+mes+"&anio="+anio+"&dia="+j+"&codigo_jefe="+codigo_jefe+"&turno="+turno,	
		   success: function (datos){		
				
				var	mensaje = '<div style="color: rgb(0,0,0); text-align: left;">';
				mensaje += "<form>";	
		
				mensaje+=datos;
				//console.log(datos);//return false;
		
		
				mensaje += "</table>";
				mensaje += "</div>";
				
				mensaje += "<div style='margin-top:5%; text-align:center;'>";
				
				mensaje += "<input id='email' type='button' class='btn btn-primary' value='Envio Email Colaborador'/>";
				mensaje += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				mensaje += "<input id='no_enviar' type='button' class='btn btn-primary' value='No Enviar'/>";
				mensaje += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				mensaje += "<input id='cancelar' type='button' class='btn btn-primary' value='Cancelar'/>";
				
				
				mensaje += "</div>"
				mensaje += "</form>";
				mensaje += "</div>";
				
				
				
				modals("EXISTE SOLO UN REGISTRO DE MARCACION PARA ESTE TURNO",mensaje);
				
								
				$("#email").click(function(){	
						
						codigo_epl=$('#codigo_epl').val();
												
						$('#myModal2').modal('hide');
											
						correo_programacion_extra(codigo_epl);
									
											
						$.ajax({
							   type:"POST",
							   url: "update_colores_revisada.php",
							   data: "posicion="+posicion+"&mes="+mes+"&anio="+anio+"&cod_epl="+codigo_epl,											
							   success: function (datos){
						 
											//console.log(datos);return false;	
											
											//$("#body").load("tiempo_extra.php");
												
											//'2013-9', '70010104', '300003','45453931'						
												
											programacion_colores(fecha, centro_costo, cargo, codigo);												  
														  
							   }
						});	
								
				});
				
				$("#no_enviar").click(function(){


						
						codigo_epl=$('#codigo_epl').val();
						
									
						
						$('#myModal2').modal('hide');
													
														
											
						$.ajax({
							   type:"POST",
							   url: "update_colores_revisada.php",
							     data: "posicion="+posicion+"&mes="+mes+"&anio="+anio+"&cod_epl="+codigo_epl,											
							   success: function (datos){
						 
											//console.log(datos);return false;	
											
											//$("#body").load("tiempo_extra.php");
												
											//'2013-9', '70010104', '300003','45453931'						
												
											programacion_colores(fecha, centro_costo, cargo, codigo);												  
														  
							   }
						});	
								
				});
				
				$("#cancelar").click(function(){ 
	
						
						$('#myModal2').modal('hide');
					
								
				});
			}										
		});
	
	return false;
				
}


function validar_autorizacion(fecha, centro_costo_pro, cargo_autorizacion, codigo, anio_autorizacion, mes_autorizacion){		

	$.ajax({					  
		type:"POST",
		url: "tiempo_extra_autorizacion.php",
		data: "centro_costo="+centro_costo_pro+"&cargo="+cargo_autorizacion+"&fecha="+fecha+"&codigo="+codigo,				
		success: function (datos){	
				//console.log(datos); return false;

				var	mensaje = '<div id="usuario_n" style="color: rgb(0,0,0); text-align: left;margin-top: -15px;">';
					mensaje += "<form id='extra_autoriza'>";		
					mensaje += "<div style='height:162px;float:left;display:block;overflow:scroll;width:100%'><table class='tableone table-bordered' border='1' id='autoriza_new'>";
					mensaje += "<thead>";	
					mensaje += "<tr style='background-color: rgb(41, 76, 139); color: #fff; text-align: center;'>";
					mensaje += "<th  scope='col' style='width:52px;'>Codigo</th>";
					mensaje += "<th  scope='col' style='width:112px;'>Empleado</th>";
					mensaje += "<th  scope='col' style='width:112px;'>Concepto</th>";
					mensaje += "<th scope='col' style='width:30px;'>Horas</th>";
					mensaje += "<th  scope='col'  style='width:30px;'>estado</th>";
					mensaje += "</tr>";
					mensaje += "</thead>";
		
					mensaje+=datos;
						//console.log(datos);//return false;
			
					mensaje += "</table></div>";			
					
					mensaje += "<div style='margin-top:5%;'>";
					mensaje += "<input id='password' type='password' style='width: 120px'>&nbsp;&nbsp;<span style='color:#294c8b'>Pin</span>";
					mensaje += "<input  type='hidden' name='usuario_dig' value='"+codigo+"'>";
					mensaje += "<input  type='hidden' name='cod_cc2' value='"+centro_costo_pro+"'>";
					//mensaje += "<input  type='hidden' name='clave' value='"+$('#password').html()+"'>";
					mensaje += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					mensaje += "<input id='autorizar_final' type='button' class='btn btn-primary' value='Aceptar'/></div>";
					mensaje += "</form>";
					
					mensaje += "<div class='validar'></div>";
					
					mensaje += "</div>";
		
		
					modals("Horas Extras y Recargos de "+mes_autorizacion+" "+anio_autorizacion+"",mensaje);

					
					$("#autorizar_final").click(function(){							
					
						clave_autorizacion=$('#password').val();
								
							$.ajax({
							   type:"POST",
							   url: "autorizar_final.php",
							   data: "centro_costo="+centro_costo_pro+"&cargo="+cargo_autorizacion+"&fecha="+fecha+"&codigo="+codigo+"&clave_autorizacion="+clave_autorizacion,	
							   data:$("#extra_autoriza").serialize()+"&clave_autorizacion="+clave_autorizacion,
							   success: function (datos){	
										
										//console.log(datos);return false;					   
						
										if(datos=="1"){
																						
											$('#myModal2').modal('hide');
								
											Alert.aprobacion();
															
										}else{ 
											
												if(datos=="2"){
							
													$(".validar").css("display","block");
													$(".validar").html("<span class='mensajes_error'>Por Favor Ingrese el Pin de Autorizacion Correctamente</span>");
													return false;					
						
												}else{
													
														if(datos=="3"){
										
															$(".validar").css("display","block");
															$(".validar").html("<span class='mensajes_error'>No hay Datos para Autorizar</span>");
															return false;	
														}else{
														
																if(datos=="4"){
										
																	$(".validar").css("display","block");
																	$(".validar").html("<span class='mensajes_error'>No tienes Clave de Seguridad</span>");
																	return false;	
																}
														
														}
												}
										}
								}							
					   											   
							});	
					
					});					
		}
	 });
}



function autorizacion(fecha, centro_costo_pro, cargo_autorizacion, codigo){
						
			$.ajax({
			   type:"POST",
			   url: "ajax_catalogo_autorizacion.php",
			   data: "centro_costo="+centro_costo_pro+"&cargo="+cargo_autorizacion+"&fecha="+fecha+"&codigo="+codigo,	
				 beforeSend:function(){
					$("#contenido_general").html("<h1 id='cerrar_se'>Espere Por favor<span>.</span><span>.</span><span>.</span></h1>");
			   },
			   success: function (datos){
					//console.log(datos);return false;									
					//INICIO DE TABLA	 
			
					//THEAD
					var table="<div style='width:99%'><table style='color: rgb(41, 76, 139) !important;' cellpadding='0' cellspacing='0' border='1' class='display' id='examples'><thead style='background-color: rgb(41, 76, 139); font-size: 13px; color: #fff; font-weight:bold;'><tr><td align='center'>No</td><td  align='center' id='dias'>Empleado</td>";
					table+="<td align='center'>HED</td><td align='center'>HED APRO</td><td align='center'>HEN</td><td align='center'>HEN APR</td><td align='center'>HEDF</td><td align='center'>EDF APR</td><td align='center'>HENF</td><td align='center'>ENF APR</td><td align='center'>FD</td><td align='center'>FD APR</td><td align='center'>RNO</td><td align='center'>RNO APR</td><td align='center'>RNF</td><td align='center'>RNF APR</td>";			
					table+="</tr></thead>";
					//FIN THEAD
					
					//TBODY
							table+=datos;
							//console.log(datos);
							//return false;
					//FIN TBODY
			
					table+="</table></div><br><br>";
			
					//FIN TABLA
					$("#contenido_general").html(table);
					
					
					
					//Aca va el datable porque se crea example y ahi si con ese example hagame esta accion
					$('#examples').dataTable({

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
			
		}




//Auditoria simplificada(ABAJO DE LA PROGRAMACION EN TIEMPO EXTRA)
function auditorias(fecha, centro_costo, cargo, codigo){
		$.ajax({					  
					   type:"POST",
					   url: "auditoria4.php",
					   data: "centro_costo="+centro_costo+"&cargo="+cargo+"&fecha="+fecha+"&codigo="+codigo,
							 beforeSend:function(){
							$("#contenido2").html("");
							
					   },
					   success: function (datos){
					   
							//console.log(datos);return false;
							
										 
							//INICIO DE TABLA	 
					
							//THEAD
							var table="<div style='width:90%'><table style='color: rgb(41, 76, 139) !important; width: 100%' cellpadding='0' cellspacing='0' border='1' class='display' id='example2'>";
							
							table+="<thead style='background-color: rgb(41, 76, 139); font-size: 13px; color: #fff; font-weight:bold;'>";	

							table+="<tr>";
							
							table+="<td align='center'>Turno</td><td  align='center'>Hora Inicio</td><td align='center'>Hora Fin&nbsp;&nbsp;&nbsp;</td><td align='center'>Horas</td>";
							
							table+="</tr>";
							
							table+="</thead>";
							
							
							//FIN THEAD
							
														
							//TBODY
									table+=datos;
									//console.log(datos);
									//return false;
							//FIN TBODY
										
					
					
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
}


//PROGRAMACION

function programacions(fecha, centro_costo, cargo, codigo){
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
			   url: "ajax_catalogo_tiempo_extra.php",
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
					table+="</tr><tr>";
				
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
					
					
					 
					
					//Aca va el datable porque se crea example y ahi si con ese example hagame esta accion
					$('#example').dataTable({

						"bLengthChange": false,
						"bSort": false,
						"bPaginate": false,
						"bInfo": false,
						"bFilter": false,
						"sScrollY": "210px",
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


function programacion_colores(fecha, centro_costo, cargo, codigo){
		
	$.ajax({
		dataType: "json",
		type:"GET",
		url: "ind.php",
		data: "fecha="+fecha,
		beforeSend:function(){
					$("#contenido").html("<h1 id='cerrar_se'>Espere Por favor<span>.</span><span>.</span><span>.</span></h1>");
		},
		success: function (datos1){
			var canti=datos1[0].calendario1.numeros.length;
			var canti2=datos1[0].calendario2.dias.length;
			var h=0;
			/*tbody*/
			$.ajax({
			   type:"POST",
			   async:true,
			   url: "ajax_catalogo_tiempo_extra_colores.php",
			   data: "cantidad="+canti+"&centro_costo="+centro_costo+"&cargo="+cargo+"&fecha="+fecha+"&codigo="+codigo,
			   
			   success: function (datos){
					
					
					
					//console.log(datos);
					$("#validar_programacion").removeAttr("disabled");
					
					$('#validar_programacion').attr("value", "Validacion");
					
					var canti=datos1[0].calendario1.numeros.length;
					var canti2=datos1[0].calendario2.dias.length;
		 
					//INICIO DE TABLA	 
			
					//THEAD
					var table="<div style='width:99%'><table style='color: rgb(41, 76, 139) !important;' cellpadding='0' cellspacing='0' border='1' class='display' id='example'><thead style='background-color: rgb(41, 76, 139); font-size: 13px; color: #fff; font-weight:bold;'><tr><td rowspan='2' align='center'>No</td><td rowspan='2' align='center' id='dias'>Empleado</td>";
			
					for(i=0; i < canti2; i ++){
						table+="<td align='center'>"+datos1[0].calendario2.dias[i]+"</td>";
					}
					table+="</tr><tr>";
				
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
					
					
					
					
					//Aca va el datable porque se crea example y ahi si con ese example hagame esta accion
					$('#example').dataTable({

						"bLengthChange": false,
						"bSort": false,
						"bPaginate": false,
						"bInfo": false,
						"bFilter": false,
						"sScrollY": "210px",
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
					
					/*
					$.ajax({					  
						   type:"POST",
						   url: "prueba_before_send.php",						  
						   beforeSend:function(){
									$("#contenido").html("<h1 id='cerrar_se'>One moment rega<span>.</span><span>.</span><span>.</span></h1>");
							},					   
						   success: function (datos){	
											
											console.log(datos);	
										
							}
						});*/
					
					//if(){
						console.log("Procesando");
						//$("#contenido").css("display","none");
						
						//$("#contenido").css("display","block");
						//$("#contenido").removeAttr("display");
						
					//}
					
				}
			});
			
			
			/*fin table*/	
		}
	});
	
	console.log("Termine_afueraa");
	
}



//Funcion para poner por defecto el mes y año en el combo box
function tiempo_sistema(){
	
	var fecha=new Date();
	var ano=fecha.getFullYear();//2014
	
	//var ano=2011;
	
	var mes=fecha.getMonth() +1 ;
	
	for(var i=2005; i<2030; i++){	
	
		if(i == ano){
		  //console.log('#'+i);return false;
		  $('#'+i).attr("selected","selected");
		  break;
		}	
	}
	
	switch(mes)
	{
		case 1:
		  $('.enero').attr("selected","selected");
		  break;
		case 2:
		  $('.febrero').attr("selected","selected");
		  break;
		case 3:
		 $('.marzo').attr("selected","selected");
		  break;
		case 4:
		 $('.abril').attr("selected","selected");
		  break;
		case 5:
		  $('.mayo').attr("selected","selected");
		  break;
		 case 6:
		  $('.junio').attr("selected","selected");
		  break;
		case 7:
		  $('.julio').attr("selected","selected");
		  break;
		case 8:
		  $('.agosto').attr("selected","selected");
		  break;
		case 9:
		  $('.septiembre').attr("selected","selected");
		  break;
		case 10:
		  $('.octubre').attr("selected","selected");
		  break;
		case 11:
		  $('.noviembre').attr("selected","selected");
		  break;
		case 12:
		  $('.diciembre').attr("selected","selected");
		  break; 
	}
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
			modal+='<p>'+mensaje+'</p>';
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

/* Funcion unica de modal para el correo*/

/*enviar correo la programacion*/
function correo_programacion_extra(codigo_epl){


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
					contenido+='<textarea class="texemail" name="textarea" <textarea class="texemail" name="textarea" style="color:#000;width: 655px;height: 110px;"></textarea>></textarea>';
					contenido+= "<br><div class='validar' style='color:#fff !important; width:100%; text-align:center'></div>";
					contenido+='<div style="text-align:center;margin-top:10px;"><input type="button" id="enviar_email" name="singlebutton" class="btn btn-primary" value="Enviar"></div>';
					contenido+='</form>';
					contenido+='</div>';
		modals_correo("Enviar Planilla Email <i class='icon-envelope' ></i>",contenido);
		$("#selectmultiple").chosen({width:"95%"});
		
		$.ajax({
				url:"correo_empleado_extra.php",
				type:"post",
				data:"correo="+empleados+"&codigo_epl="+codigo_epl,
				success:function(data){
					//console.log(data);return false;
					
					$("#selectmultiple").html(data);
					$("#selectmultiple").trigger("liszt:updated");
				}
		});
		
		$("#correo_n .texemail").val();
		
					
		$("#enviar_email").click(enviar_email); 		
		
		
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
			
			//console.log(data); return false;
				$('.validar').html("<span class='mensajes_success'>"+data+"</span>");  //.mensajes_success
				$("#enviar_email").removeAttr("disabled");
			}
		});
}

function modals_correo(titulo,mensaje){
	//OJO CAMBIAR LA CLASE MODAL2 A MODAL
	var modal='<!-- Modal -->';
			modal+='<div id="myModal3" class="modal hide fade" style="margin-top: 5%; background-color: rgb(41, 76, 139); color: #fff; z-index: 900000; behavior: url(../../css/PIE.htc);width: 60%;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">';
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



