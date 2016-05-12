$(document).ready(main);	

function  main(){

	$('#turnoshe').dataTable({
		"aaSorting": [[ 0, "desc" ]],
		"bAutoWidth": false,			
		"bJQueryUI": true,
		"iDisplayLength": 5,
		"sDom": '<"H"TfrlP>t<"F"ip><"clear">',
		
		"oTableTools": {
							"sSwfPath": "../../js/DataTables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
							"aButtons": [
							{"sExtends": "xls","sButtonText": "Guardar a Excel","sFileName": "Turnos.xls","bFooter": false,"mColumns":[0,1,2,3,4,5]},
							{"sExtends": "pdf","sButtonText": "Guardar a PDF","sFileName": "solicitudes_intercambiar_turno.pdf","sPdfOrientation": "landscape","mColumns":[0,1,2,3,4,5]},
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
	
	
	$('#turnoshe_tabla').dataTable({
		"aaSorting": [[ 0, "desc" ]],
		"bAutoWidth": false,			
		"bJQueryUI": true,
		"iDisplayLength": 5,
		"sDom": '<"H"TfrlP>t<"F"ip><"clear">',
		"sScrollX": "300%",
		
		
		
		"oTableTools": {
							"sSwfPath": "../../js/DataTables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
							"aButtons": [
							{"sExtends": "xls","sButtonText": "Guardar a Excel","sFileName": "Turnos.xls","bFooter": false,"mColumns":[0,1,2,3,4,5]},
							{"sExtends": "pdf","sButtonText": "Guardar a PDF","sFileName": "turnos.pdf","sPdfOrientation": "landscape","mColumns":[0,1,2,3,4,5]},
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

	$('#cicloshe').dataTable({
		"aaSorting": [[ 0, "desc" ]],
		"bAutoWidth": false,			
		"bJQueryUI": true,
		"iDisplayLength": 5,
		"sDom": '<"H"TfrlP>t<"F"ip><"clear">',
		
		"oTableTools": {
							"sSwfPath": "../../js/DataTables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
							"aButtons": [
							{"sExtends": "xls","sButtonText": "Guardar a Excel","sFileName": "Ciclos.xls","bFooter": false,"mColumns":[0,1,2,3,4,5,6,7,8,9,10]},
							{"sExtends": "pdf","sButtonText": "Guardar a PDF","sFileName": "solicitudes_intercambiar_turno.pdf","sPdfOrientation": "landscape","mColumns":[0,1,2,3,4,5,6,7,8,9,10]},
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


	$(".mes").change(function(){
		
		
		$(".anio").val('00');
		
		cargar_marcacion2();
	
		var seleccion="<select class='select anio'>";
		var anio=new Date();
		
		seleccion +="<option value='0' >Seleccione el A&ntilde;o...</option>";
		for(var i=2009; i<=anio.getFullYear()-1; i++){
		
		seleccion+="<option value="+i+" >"+i+"</option>";
		}
		
		seleccion+="<option value="+anio.getFullYear()+" >"+anio.getFullYear()+"</option>";
		seleccion+="</select>";

		$("#esconder1").html(seleccion);
		
		$(".anio").change(function(){
		
			var mes= $(".mes").val();
			var anio=$(this).val();
			
			if($(".mes").val() !=13){
			
				cargar_marcacion(anio,mes);
				
			}else{
			
				cargar_marcacion_anio(anio);
			
			}
			
			
		
		});
				
	});
	
	
	
	$(".usario_jefe").change(function(){
		
		
		$.ajax({
		
			url:"select_programados.php",
			type:"post",
			data:"usuario_jefe="+$(this).val()+"&info="+1,
			success:function(data){
				
				$("#combo2").html(data);
				
				$(".centro_costo").change(function(){
					var server=0;
					
					$.ajax({
						type : "POST",
						url : "ajax_cargos_anidados.php",                
						data : "idCombo1="+$(this).val()+"&codigo="+$(".usario_jefe").val()+"&server="+server,
						success : function(res){
							
						   $("#combo3").html(res);
						   
						   
						   $('.cargo').change(function(){
								var f=new Date();
								
								var anio=f.getFullYear();
								var mes=f.getMonth() +1;
								
								var fecha= anio+"-"+mes;
								var centro_costo=$(".centro_costo").val();
								var codigo=$(".usario_jefe").val();
								var cargo= $(this).val();
								
								
								programacion(fecha, centro_costo, cargo, codigo);
								auditoria(fecha, centro_costo, cargo, codigo);
								
								var seleccion="<select class='select mes_programa'>";
								
								seleccion +="<option value='0' >Seleccione el Mes...</option>";
								seleccion +='<option value="1"  id="enero">Enero</option>';
								seleccion +='<option value="2"  id="febrero">Febrero</option>';
								seleccion +='<option value="3"  id="marzo">Marzo</option>';
								seleccion +='<option value="4"  id="abril">Abril</option>';
								seleccion +='<option value="5"  id="mayo">Mayo</option>';
								seleccion +='<option value="6"  id="junio">Junio</option>';
								seleccion +='<option value="7"  id="julio">Julio</option>';
								seleccion +='<option value="8"  id="agosto">Agosto</option>';
								seleccion +='<option value="9"  id="septiembre">Septiembre</option>';
								seleccion +='<option value="10" id="octubre">Octubre</option>';
								seleccion +='<option value="11" id="noviembre">Noviembre</option>';
								seleccion +='<option value="12" id="diciembre">Diciembre</option>';
								seleccion+="</select>";
								
								$('#meses').html(seleccion);																
								
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
								
								
								$.ajax({
									type : "POST",
									url : "select_programados.php",                
									data:"info="+2,
									success : function(datos){
									
										$('#anios').html(datos);
										
										$("#"+anio+"").attr("selected","selected");
										
										
										
										$('.anio_progra').change(function(){
										
											var anio=$('.anio_progra').val();
											var mes=$('.mes_programa').val();
										
											var fecha= anio+"-"+mes;
											
											programacion(fecha, centro_costo, cargo, codigo);
											auditoria(fecha, centro_costo, cargo, codigo );
											
											$('.mes_programa').change(function(){
													
											
												var anio=$('.anio_progra').val();
												var mes=$('.mes_programa').val();
											
												var fecha= anio+"-"+mes;
												
												programacion(fecha, centro_costo, cargo, codigo);
												auditoria(fecha, centro_costo, cargo, codigo );
											});
										
										});
										
										$('.mes_programa').change(function(){
													
											
												var anio=$('.anio_progra').val();
												var mes=$('.mes_programa').val();
											
												var fecha= anio+"-"+mes;
												
												programacion(fecha, centro_costo, cargo, codigo);
												auditoria(fecha, centro_costo, cargo, codigo );
										});	
										
										
									
									}
									
								});

						   })
						}
					});
				
				});
				
				
			}
		});
		
	});
	
	
	
	
	$('#correo_electronico').click(correo_electronico);
	$('#correo_programados').click(correo_programadores);
	$("#imprimir_pdf").click(imprimir_pdf);
	$("#imprimir_excel").click(imprimir_excel);
	

}




function correo_programadores(){
		
	if($('.cargo').val() != undefined){
	
	
		var centro_costo=$(".centro_costo").val();
		var cargo=$('.cargo').val();
		var codigo=$(".usario_jefe").val();
		
		
		//console.log($('.anio_progra').val());
		
		if($('.anio_progra').val()==0){
			
			var f=new Date();
			var anio=f.getFullYear();
			var mes=f.getMonth() +1;
			var fecha= anio+"-"+mes;
		
		}else{
		
			var fecha=$('.anio_progra').val()+"-"+$('.mes_programa').val();
			var anio=$(".anio_progra").val();
			var mes=$(".mes_programa").val();
		}
		
		
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
					
					$("#correo_n .texemail").val(data);
					
					tinyMCE.init({
						mode : "textareas",
						theme : "simple",
						width: "640",
						height: "190",
					});
					
					$("#enviar_email").click(enviar_email); //falta
				}
		});
	
	
	}
	

}


/*Imprimir programacion*/
function imprimir_pdf(){

	if($('.cargo').val() != undefined){
	
		var centro_costo=$(".centro_costo").val();
		var cargo=$(".cargo").val();
		var codigo=$('.usario_jefe').val();
		var perfil=$("#"+$('.usario_jefe').val()+"").html(); //perfil de usuario

	
	if($('.anio_progra').val()==0){
			
			var f=new Date();
			var anio=f.getFullYear();
			var mes=f.getMonth() +1;
			var fecha= anio+"-"+mes;
		
		}else{
		
			var fecha=$('.anio_progra').val()+"-"+$('.mes_programa').val();
			var anio=$(".anio_progra").val();
			var mes=$(".mes_programa").val();
		}
	
		window.open("imprimir_programacion.php?fecha="+fecha+"&cc="+centro_costo+"&cargo="+cargo+"&jefe="+codigo+"&anio="+anio+"&mes="+mes+"&perfil="+perfil, '_blank');

	}
	
		
}



function imprimir_excel(){

	
	if($('.cargo').val() != undefined){
	
		var centro_costo=$(".centro_costo").val();
		var cargo=$(".cargo").val();
		var codigo=$('.usario_jefe').val();
		var perfil=$("#"+$('.usario_jefe').val()+"").html(); //perfil de usuario

	
	if($('.anio_progra').val()==0){
			
			var f=new Date();
			var anio=f.getFullYear();
			var mes=f.getMonth() +1;
			var fecha= anio+"-"+mes;
		
		}else{
		
			var fecha=$('.anio_progra').val()+"-"+$('.mes_programa').val();
			var anio=$(".anio_progra").val();
			var mes=$(".mes_programa").val();
		}
	
		window.open("imprimir_programacion_excel.php?fecha="+fecha+"&cc="+centro_costo+"&cargo="+cargo+"&jefe="+codigo+"&anio="+anio+"&mes="+mes+"&perfil="+perfil, '_blank');

	}
}




function correo_electronico(){

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
		modals_correo("Enviar Maracaciones Email <i class='icon-envelope' ></i>",contenido);
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
		
		var contenido= $("#contenido2").html();
		
		$("#correo_n .texemail").val(contenido);
		
		tinyMCE.init({
			mode : "textareas",
			theme : "simple",
			width: "640",
			height: "190"
		});
		
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
				$('.validar').html("<span class='mensajes_success'>"+data+"</span>");  //.mensajes_success
				$("#enviar_email").removeAttr("disabled");
			}
		});
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

function cargar_marcacion_anio(anio){

	$.ajax({
		dataType: "json",
		type:"POST",
		url: "tabla_marcaciones.php",
		data: "anio="+anio+"&info="+2,
		beforeSend: function(){
			
			var mensaje="<img src='../../img/486.GIF' />";
			Alert.preload(mensaje); // llama el archivo de alert.js
		
		},
		success: function (data){
			
			
			Alert.preloadCerrar(function(){$('#myModal9').modal('hide');});
			
			var table ='<table cellpadding="0" cellspacing="0" border="0" class="display " id="admin" width="100%" style="color:rgb(41,76,139) !important;">';
				table+='<thead style="background-color:rgb(41,76,139) !important;">';
				table+='<tr><th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Codigo</th>';
				table+='<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Empleado</th>';
				table+='<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Hora Entrada</th>';
				table+='<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Hora Salida</th></tr>';
				table+='</thead>';
				table+='<tbody>';
					for(var i=0; i< data.length; i++ ){
					
						table +="<tr>";
						table +='<td align="center">'+data[i].cod_epl+'</td>';
						table +='<td align="center">'+data[i].empleado+'</td>';
						table +='<td align="center">'+data[i].hor_entr+'</td>';	
						table +='<td align="center">'+data[i].hor_sal+'</td>';	
						table +="</tr>";
					}
				table+='</tbody';
				table+='</table>';
				
			var table2 ='<table cellpadding="0" cellspacing="0" border="1"  width="100%">';
				table2+='<thead>';
				table2+='<tr><th>Codigo</th>';
				table2+='<th>Empleado</th>';
				table2+='<th>Hora Entrada</th>';
				table2+='<th>Hora Salida</th></tr>';
				table2+='</thead>';
				table2+='<tbody>';
					for(var i=0; i< data.length; i++ ){
					
						table2 +="<tr>";
						table2 +='<td align="center">'+data[i].cod_epl+'</td>';
						table2 +='<td align="center">'+data[i].empleado+'</td>';
						table2 +='<td align="center">'+data[i].hor_entr+'</td>';	
						table2 +='<td align="center">'+data[i].hor_sal+'</td>';	
						table2 +="</tr>";
					}
				table2+='</tbody';
				table2+='</table>';
				
				
				$("#contenido").html(table);
				$("#contenido2").html(table2);
				
				$('#admin').dataTable({
					"aaSorting": [[ 0, "desc" ]],
					"bAutoWidth": false,			
					"bJQueryUI": true,
					"iDisplayLength": 5,
					"sDom": '<"H"TfrlP>t<"F"ip><"clear">',
					
					"oTableTools": {
										"sSwfPath": "../../js/DataTables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
										"aButtons": [
										{"sExtends": "xls","sButtonText": "Guardar a Excel","sFileName": "solicitudes_intercambiar_turno.xls","bFooter": false,"mColumns":[0,1,2,3,4,5,6]},
										{"sExtends": "pdf","sButtonText": "Guardar a PDF","sTitle": "Solicitudes de Novedades de Empleados","sFileName": "solicitudes_intercambiar_turno.pdf","sPdfOrientation": "landscape","mColumns":[0,1,2,3,4,5,6]},
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


}

function cargar_marcacion2(){

	var table ='<table cellpadding="0" cellspacing="0" border="0" class="display " id="admin" width="100%" style="color:rgb(41,76,139) !important;">';
				table+='<thead style="background-color:rgb(41,76,139) !important;">';
				table+='<tr><th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Codigo</th>';
				table+='<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Empleado</th>';
				table+='<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Hora Entrada</th>';
				table+='<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Hora Salida</th></tr>';
				table+='</thead>';
				table+='<tbody>';

						table +="<tr>";
						table +='<td align="center"></td>';
						table +='<td align="center"></td>';
						table +='<td align="center"></td>';	
						table +='<td align="center"></td>';	
						table +="</tr>";
					
				table+='</tbody';
				table+='</table>';
				
				$("#contenido").html(table);
				
				$('#admin').dataTable({
					"aaSorting": [[ 0, "desc" ]],
					"bAutoWidth": false,			
					"bJQueryUI": true,
					"iDisplayLength": 5,
					"sDom": '<"H"TfrlP>t<"F"ip><"clear">',
					
					"oTableTools": {
										"sSwfPath": "../../js/DataTables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
										"aButtons": [
										{"sExtends": "xls","sButtonText": "Guardar a Excel","sFileName": "solicitudes_intercambiar_turno.xls","bFooter": false,"mColumns":[0,1,2,3,4,5,6]},
										{"sExtends": "pdf","sButtonText": "Guardar a PDF","sTitle": "Solicitudes de Novedades de Empleados","sFileName": "solicitudes_intercambiar_turno.pdf","sPdfOrientation": "landscape","mColumns":[0,1,2,3,4,5,6]},
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

function cargar_marcacion(anio,mes){

				
	$.ajax({
		dataType: "json",
		type:"POST",
		url: "tabla_marcaciones.php",
		data: "anio="+anio+"&mes="+mes+"&info="+1,
		beforeSend: function(){
			
			var mensaje="<img src='../../img/486.GIF' />";
			Alert.preload(mensaje); // llama el archivo de alert.js
		
		},
		success: function (data){
			
			Alert.preloadCerrar(function(){$('#myModal9').modal('hide');});
			
			var table ='<table cellpadding="0" cellspacing="0" border="0" class="display " id="admin" width="100%" style="color:rgb(41,76,139) !important;">';
				table+='<thead style="background-color:rgb(41,76,139) !important;">';
				table+='<tr><th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Codigo</th>';
				table+='<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Empleado</th>';
				table+='<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Hora Entrada</th>';
				table+='<th style="color:#2b4c88; font-weight: bold" width="9%" scope="col">Hora Salida</th></tr>';
				table+='</thead>';
				table+='<tbody>';
					for(var i=0; i< data.length; i++ ){
					
						table +="<tr>";
						table +='<td align="center">'+data[i].cod_epl+'</td>';
						table +='<td align="center">'+data[i].empleado+'</td>';
						table +='<td align="center">'+data[i].hor_entr+'</td>';	
						table +='<td align="center">'+data[i].hor_sal+'</td>';	
						table +="</tr>";
					}
				table+='</tbody';
				table+='</table>';
		    
			var table2 ='<table cellpadding="0" cellspacing="0" border="1"  width="100%">';
				table2+='<thead>';
				table2+='<tr><th>Codigo</th>';
				table2+='<th>Empleado</th>';
				table2+='<th>Hora Entrada</th>';
				table2+='<th>Hora Salida</th></tr>';
				table2+='</thead>';
				table2+='<tbody>';
					for(var i=0; i< data.length; i++ ){
					
						table2 +="<tr>";
						table2 +='<td align="center">'+data[i].cod_epl+'</td>';
						table2 +='<td align="center">'+data[i].empleado+'</td>';
						table2 +='<td align="center">'+data[i].hor_entr+'</td>';	
						table2 +='<td align="center">'+data[i].hor_sal+'</td>';	
						table2 +="</tr>";
					}
				table2+='</tbody';
				table2+='</table>';
				
				
				$("#contenido").html(table);
				$("#contenido2").html(table2);
				
				
				$('#admin').dataTable({
					"aaSorting": [[ 0, "desc" ]],
					"bAutoWidth": false,			
					"bJQueryUI": true,
					"iDisplayLength": 5,
					"sDom": '<"H"TfrlP>t<"F"ip><"clear">',
					
					"oTableTools": {
										"sSwfPath": "../../js/DataTables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
										"aButtons": [
										{"sExtends": "xls","sButtonText": "Guardar a Excel","sFileName": "turnos.xls","bFooter": false,"mColumns":[0,1,2,3]},
										{"sExtends": "pdf","sButtonText": "Guardar a PDF","sFileName": "turnos.pdf","sPdfOrientation": "landscape","mColumns":[0,1,2,3]},
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
			   url: "ajax_catalogo_programacion_turhe.php",
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
					
				
				}
			});
			/*fin table*/	
		}
	});
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
 

 