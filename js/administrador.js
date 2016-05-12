$(document).ready(main);
function main(){

	tiempo_sistema();
	
	//change para manejar el centro de costo de la programacion turnos y supernumerarios temporal
	$(".empleado_jefe").change(function(){ 
	
			
			var empleado_jefe=$(".empleado_jefe").val();
			
			 if(empleado_jefe != '-1'){
			 
				$.ajax({
					type : "POST",
					url : "ajax_administra_combo.php",                
					data : "empleado_jefe="+empleado_jefe+"&info="+1,
					success : function(data){
					   $("#combo2").show('slow');
					   $("#combo2").html(data);

					   $(".centroCosto").change(function(){
							
							$.ajax({
							type : "POST",
							url : "ajax_administra_combo.php",                
							data : "centrocosto="+ $(".centroCosto").val()+"&info="+2+"&jefe="+empleado_jefe,
								success : function(data){
								   $("#combo3").show('slow');
								   $("#combo3").html(data);
								   
								    $(".cargo").change(function(){
										
										$.ajax({
											type : "POST",
											url : "ajax_administra_combo.php",
											dataType:'json',
											data : "cargo="+ $(".cargo").val()+"&info="+3+"&jefe="+empleado_jefe,
											success : function(data){
												
							
												var mensaje = "<p style='text-align:center; color:rgb(41, 76, 139);font-weight: bold; font-size: 15px;'>EMPLEADOS DISPONIBLES</p>";
												mensaje += "<div>";
												mensaje += '<table cellpadding="0" cellspacing="0" border="0" class="display " id="creacion" width="100%" style="color:rgb(41,76,139) !important;">';
												mensaje += "<thead>";
												mensaje += "<tr>";												
												mensaje += "<th style='color:#2b4c88; font-weight: bold' width='9%' scope='col'>Codigo</th><th style='color:#2b4c88; font-weight: bold' width='9%' scope='col'>Nombre</th><th style='color:#2b4c88; font-weight: bold' width='9%' scope='col'>Apellido</th></tr>"; 
												mensaje += "</thead>";
												mensaje += "<tbody>";
												for(var i=0; i<data.length; i++){
													
													mensaje +=	"<tr><td align='center'>"+data[i].codigo+"</td>";
													mensaje +=	"<td align='center'>"+data[i].nombre+"</td>";
													mensaje +=	"<td align='center'>"+data[i].apellido+"</td>";
													mensaje +=	"</tr>";
												}
												mensaje += "</tbody>";
												mensaje += "</table></div>";
												
												$("#contenido").html(mensaje);
												
												$('#creacion').dataTable({
													 "aaSorting": [[ 0, "desc" ]],
													"bAutoWidth": false,			
													"bJQueryUI": true,
													"iDisplayLength": 5,
													"sDom": '<"H"TfrlP>t<"F"ip><"clear">',
													
													"oTableTools": {
															"sSwfPath": "../../js/DataTables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
															"aButtons": [
															{"sExtends": "xls","sButtonText": "Guardar a Excel","sFileName": "solicitudes_intercambiar_turno.xls","bFooter": false,"mColumns":[0,1,2]},
															{"sExtends": "pdf","sButtonText": "Guardar a PDF","sTitle": "Solicitudes de Novedades de Empleados","sFileName": "solicitudes_intercambiar_turno.pdf","sPdfOrientation": "landscape","mColumns":[0,1,2]},
															]
														},
										   "oLanguage": {
															"oPaginate": {
																	"sPrevious": "Anterior", 
																	"sNext": "Siguiente", 
																	"sLast": "Ultima", 
																	"sFirst": "Primera" 
																	},"sLengthMenu": 'Mostrar <select>'+ 
																	'<option value="5">5</option>'+ 
																	'<option value="10">10</option>'+ 
																	'<option value="25">25</option>'+ 
																	'<option value="50">50</option>'+ 
																	'<option value="100">100</option>'+ 
																	'<option value="-1">Todos</option>'+ 
																	'</select> registros', 

															"sInfo": "Mostrando del _START_ a _END_ (Total: _TOTAL_ resultados)", 
															"sInfoFiltered": " - filtrados de _MAX_ registros", 
															"sInfoEmpty": "No hay resultados de busqueda", 
															"sZeroRecords": "No hay registros a mostrar", 
															"sProcessing": "Espere, por favor...", 
															"sSearch": "Buscar:"
															}
												});
											}
										});
									});
								}
							});
					   
					   });

				   }
				});
			    
					
			 }
			
            
     
	  $('#meses, #anios').css('display', 'inline');
	});
	
	$(".privilegios").change(function(){
			
		
		$.ajax({
			type : "POST",
			url : "ajax_administra_combo.php",
			dataType:'json',
			data : "privilegios="+$(".privilegios").val()+"&info="+4,
			success : function(data){
			
				var mensaje = "<p style='text-align:center; color:rgb(41, 76, 139);font-weight: bold; font-size: 15px;'>USUARIOS DISPONIBLES</p>";
				mensaje += "<div>";
				mensaje += '<table cellpadding="0" cellspacing="0" border="0" class="display " id="creacion" width="100%" style="color:rgb(41,76,139) !important;">';
				mensaje += "<thead>";
				mensaje += "<tr>";												
				mensaje += "<th style='color:#2b4c88; font-weight: bold' width='9%' scope='col'>Usuario</th><th style='color:#2b4c88; font-weight: bold' width='9%' scope='col'>Nombre</th><th style='color:#2b4c88; font-weight: bold' width='9%' scope='col'>Apellido</th></tr>"; 
				mensaje += "</thead>";
				mensaje += "<tbody>";
				for(var i=0; i<data.length; i++){
					
					mensaje +=	"<tr><td align='center'>"+data[i].usuario+"</td>";
					mensaje +=	"<td align='center'>"+data[i].nombre+"</td>";
					mensaje +=	"<td align='center'>"+data[i].apellido+"</td>";
					mensaje +=	"</tr>";
				}
				mensaje += "</tbody>";
				mensaje += "</table></div>";
				
				$("#contenido").html(mensaje);
				
				$('#creacion').dataTable({
					 "aaSorting": [[ 0, "desc" ]],
					"bAutoWidth": false,			
					"bJQueryUI": true,
					"iDisplayLength": 5,
					"sDom": '<"H"TfrlP>t<"F"ip><"clear">',
					
					"oTableTools": {
							"sSwfPath": "../../js/DataTables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
							"aButtons": [
							{"sExtends": "xls","sButtonText": "Guardar a Excel","sFileName": "solicitudes_intercambiar_turno.xls","bFooter": false,"mColumns":[0,1,2]},
							{"sExtends": "pdf","sButtonText": "Guardar a PDF","sTitle": "Solicitudes de Novedades de Empleados","sFileName": "solicitudes_intercambiar_turno.pdf","sPdfOrientation": "landscape","mColumns":[0,1,2]},
							]
						},
		   "oLanguage": {
							"oPaginate": {
									"sPrevious": "Anterior", 
									"sNext": "Siguiente", 
									"sLast": "Ultima", 
									"sFirst": "Primera" 
									},"sLengthMenu": 'Mostrar <select>'+ 
									'<option value="5">5</option>'+ 
									'<option value="10">10</option>'+ 
									'<option value="25">25</option>'+ 
									'<option value="50">50</option>'+ 
									'<option value="100">100</option>'+ 
									'<option value="-1">Todos</option>'+ 
									'</select> registros', 

							"sInfo": "Mostrando del _START_ a _END_ (Total: _TOTAL_ resultados)", 
							"sInfoFiltered": " - filtrados de _MAX_ registros", 
							"sInfoEmpty": "No hay resultados de busqueda", 
							"sZeroRecords": "No hay registros a mostrar", 
							"sProcessing": "Espere, por favor...", 
							"sSearch": "Buscar:"
							}
				});
			}
		});
	
	
	});
	
	
	/*GUARDAR PARAMETRIZACION DEL APLICATIVO*/
	$("#guardar_administra").click(function(){
		
		$(".error").remove();
		if($("#t_hor_max_turnos").val() == 0){
			
			$("table td .t_hor_max_turnos").after("<span class='error' style='color:red; font-size:14px;'>&nbsp;&nbsp;*</span>");
				return false;
				
		}else if($("#t_hor_min_ciclos").val() == 0){
		
			$("table td . t_hor_min_ciclos").after("<span class='error' style='color:red; font-size:14px;'>&nbsp;&nbsp;*</span>");
				return false;
		
		}else if($("#t_hor_min_prog").val() == 0){
		
			$("table td .t_hor_min_prog").after("<span class='error' style='color:red; font-size:14px;'>&nbsp;&nbsp;*</span>");
				return false;
		
		}else if($("#t_administradorTur").val() == 0){
		
			$("table td .t_administradorTur").after("<span class='error' style='color:red; font-size:14px;'>&nbsp;&nbsp;*</span>");
				return false;
		
		}else if($("#correo_jefe_gh").val() == 0){
		
			$("table td .correo_jefe_gh").after("<span class='error' style='color:red; font-size:14px;'>&nbsp;&nbsp;*</span>");
				return false;
		
		}else if($("#correo_tiempo_extra").val() == 0){
		
			$("table td .correo_tiempo_extra").after("<span class='error' style='color:red; font-size:14px;'>&nbsp;&nbsp;*</span>");
				return false;
		
		}else if($("#tiempo_desc_turnos").val() == 0){
		
			$("table td .tiempo_desc_turnos").after("<span class='error' style='color:red; font-size:14px;'>&nbsp;&nbsp;*</span>");
				return false;
		
		}else if($("#tiempo_hol_marca").val() == 0){
		
			$("table td .tiempo_hol_marca").after("<span class='error' style='color:red; font-size:14px;'>&nbsp;&nbsp;*</span>");
				return false;
		
		}else if($("#min_hora_extra").val() == 0){
		
			$("table td .min_hora_extra").after("<span class='error' style='color:red; font-size:14px;'>&nbsp;&nbsp;*</span>");
				return false;
		
		}else if($("#dias_vac").val() == 0){
		
			$("table td .dias_vac").after("<span class='error' style='color:red; font-size:14px;'>&nbsp;&nbsp;*</span>");
				return false;
		
		}
		
		$.ajax({
			type : "POST",
			url : "guardar_parametros.php",                
			data : $("#parametros_admin").serialize(),
			success : function(data){
				if(data=='1'){
					
					var mensaje="Se guardo satisfactoriamente";
					
					Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})	 // llama el archivo de alert.js
					
						$("#contenido").load('parametrizacion_admin.php');
				}else{
					var mensaje="No se ha podido guardar la informaci&oacute;n";  
					Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})  // llama el archivo de alert.js
				}
			}
		});
		return false;
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