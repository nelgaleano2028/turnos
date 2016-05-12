 $(document).ready(function() {
                
		//var param=[0,1,2,3,4];	
		var param=$_GET("param");	
		
		console.log(param);
		
		datagrid(param);
		
		
 } );	

 function datagrid(param){
 
	//console.log(param);
 
	/*inicio tabla*/
		$('#admin').dataTable({
            "aaSorting": [[ 0, "desc" ]],
			"bAutoWidth": false,			
			"bJQueryUI": true,
			"iDisplayLength": 5,
			"sDom": '<"H"TfrlP>t<"F"ip><"clear">',
		    
			"oTableTools": {
								"sSwfPath": "../../js/DataTables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
				          		"aButtons": [
								{"sExtends": "xls","sButtonText": "Guardar a Excel","sFileName": "solicitudes_intercambiar_turno.xls","bFooter": false,"mColumns":param},
								{"sExtends": "pdf","sButtonText": "Guardar a PDF","sFileName": "solicitudes_intercambiar_turno.pdf","sPdfOrientation": "landscape","mColumns":param},
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
         
		/*fin tabla*/	
 
 
 
 
 }
function aceptar_solicitud_inter(id,fecha,cod_epl_cambio,cod_epl_actual,ta,tc,jefe){

	   $.ajax({
                type:"POST",
                url: "solicitudes.php",
                data:"id="+id+"&info="+1+"&fecha="+fecha+"&cod_epl_cambio="+cod_epl_cambio+"&cod_epl_actual="+cod_epl_actual+"&ta="+ta+"&tc="+tc+"&jefe="+jefe,
                success: function(datos){
                       
                        if(datos==1){
                            var mensaje="Se confirma el cambio de turno";
                            Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
                            
                            $("#contenido").load('sol_intercambio_turnos.php')//carga de el datatable luego de una accion del alert.OJO CON ID

                        }else if(datos == 2){

                                var mensaje="Se debe hacer el cambio del turno "+ta+" a "+tc+" en programaci&oacute;n";
                                Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
                        }else if(datos == 3){
                            
                                 var mensaje="No se puede hacer el cambio de turno rechazar solicitud";
                                Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
                        }else if(datos == 4){
                            
                             var mensaje="Error al enviar la solicitud al correo";
                                Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
                                
                        }else if(datos == 5){
                            
                             var mensaje="Error en hacer la solicitud de cambio de turno intentalo de nuevo";
                                Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
                        }

                }
	 });
	
	return false;
}

		
		
function rechazar_solicitud_inter(id,cod_epl_actual,cod_epl_cambio,jefe,turno_actual,turno_cambiar,fecha){

	$.ajax({
		type:"POST",
		url: "solicitudes.php",
		data:"id="+id+"&info="+2+"&cod_epl_actual="+cod_epl_actual+"&cod_epl_cambio="+cod_epl_cambio+"&jefe="+jefe+"&turno_actual="+turno_actual+"&turno_cambiar="+turno_cambiar+"&fecha="+fecha,
		success: function(datos){
                
			if(datos==1){
				var mensaje="Se rechaza la solicitud cambio turno";
				 Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
				$("#contenido").load('sol_intercambio_turnos.php')//carga de el datatable luego de una accion del alert.OJO CON ID
			
			}else if(datos==2){
				
				var mensaje="Error en rechazar la solicitud de cambio de turno intentalo de nuevo";
				Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
			
			}else if(datos==4){
                               var mensaje="Error al enviar la solicitud al correo";
				Alert.alert(mensaje,function(){$('#myModal6').modal('hide');}) 
                            
                        }
			
		}
	});
	
	return false;
}

function aceptar_solicitud_inter_emp(id,fecha,emp_solicita,emp_cambia,tur_actual,tur_cambiar,jefe){
    
    
$.ajax({
            type:"POST",
            url: "solicitudes.php",
            data:"id="+id+"&info="+7+"&cod_epl_actual="+emp_solicita+"&cod_epl_cambio="+emp_cambia+"&jefe="+jefe+"&turno_actual="+tur_actual+"&turno_cambiar="+tur_cambiar+"&fecha="+fecha,
            success: function(datos){
               
                    if(datos==1){
                            var mensaje="Se acepta la solicitud cambio turno";
                             Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
                            $("#contenido").load('empleado_confirm_inter.php')//carga de el datatable luego de una accion del alert.OJO CON ID

                    }else if(datos==2){

                            var mensaje="Error en rechazar la solicitud de cambio de turno intentalo de nuevo";
                            Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})

                    }else if(datos==4){
                           var mensaje="Error al enviar la solicitud al correo";
                            Alert.alert(mensaje,function(){$('#myModal6').modal('hide');}) 

                    }

            }
	});
	
	return false;
    
   
    
}

function rechazar_solicitud_inter_emp(id,fecha,emp_solicita,emp_cambia,tur_actual,tur_cambiar,jefe){

    $.ajax({
            type:"POST",
            url: "solicitudes.php",
            data:"id="+id+"&info="+8+"&cod_epl_actual="+emp_solicita+"&cod_epl_cambio="+emp_cambia+"&jefe="+jefe+"&turno_actual="+tur_actual+"&turno_cambiar="+tur_cambiar+"&fecha="+fecha,
            success: function(datos){        
                    if(datos==1){
                            var mensaje="Se rechaza la solicitud cambio turno";
                             Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
                            $("#contenido").load('empleado_confirm_inter.php')//carga de el datatable luego de una accion del alert.OJO CON ID

                    }else if(datos==2){

                            var mensaje="Error en rechazar la solicitud de cambio de turno intentalo de nuevo";
                            Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})

                    }else if(datos==4){
                           var mensaje="Error al enviar la solicitud al correo";
                            Alert.alert(mensaje,function(){$('#myModal6').modal('hide');}) 

                    }

            }
	});
	
	return false;
    
    
}

function aceptar_solicitud_aus(id,cod_epl,fecha_ini,fecha_fin,cod_cc2,cod_con,jefe){
    
	   $.ajax({
                type:"POST",
                url: "solicitudes.php",
                data:"&id="+id+"&info="+3+"&fecha_ini="+fecha_ini+"&fecha_fin="+fecha_fin+"&cod_epl="+cod_epl+"&cod_cc2="+cod_cc2+"&cod_con="+cod_con+"&jefe="+jefe,
                success: function(datos){
                    //console.log(datos); return false;
                        if(datos==1){
                            var mensaje="Se confirma la ausencia";
                            Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
                            $("#contenido").load('sol_ausencia_turnos.php');//carga de el datatable luego de una accion del alert.OJO CON ID
                        }else if (datos==2){
                                var mensaje="Debe cambiar las ausencias en la programacion";
                                Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
                        }else if (datos== 3){
                                var mensaje="No se puede hacer la solicitud intentalo de nuevo";
                                Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
                        }else if(datos==4){
                               var mensaje="Error al enviar la solicitud al correo";
				Alert.alert(mensaje,function(){$('#myModal6').modal('hide');}) 
                            
                        }
                }
	});
	
	return false;
}


function rechazar_solicitud_aus(id,cod_epl,fecha_ini,fecha_fin,cod_cc2,cod_con,jefe){


	$.ajax({
		type:"POST",
		url: "solicitudes.php",
                data:"&id="+id+"&info="+4+"&fecha_ini="+fecha_ini+"&fecha_fin="+fecha_fin+"&cod_epl="+cod_epl+"&cod_cc2="+cod_cc2+"&cod_con="+cod_con+"&jefe="+jefe,
		success: function(datos){ 
				//console.log(datos); return false;
			if(datos==1){
				var mensaje="Se rechaza la solicitud de ausencia";
				 Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
				$("#contenido").load('sol_ausencia_turnos.php')//carga de el datatable luego de una accion del alert.OJO CON ID
			
			}else if(datos==2){
				
				var mensaje="Error en hacer la solicitud de ausencia";
				Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
			
			}else if(datos==4){
                               var mensaje="Error al enviar la solicitud al correo";
				Alert.alert(mensaje,function(){$('#myModal6').modal('hide');}) 
                            
                        }
			
		}
	});
	
	return false;
}

function aceptar_solicitud_turno(id,fecha_solicitud,cod_epl,turno_solicitud,jefe){

    $.ajax({
        type:"POST",
        url: "solicitudes.php",
        data:"id="+id+"&info="+5+"&fecha_solicitud="+fecha_solicitud+"&cod_epl="+cod_epl+"&turno_solicitud="+turno_solicitud+"&jefe="+jefe,
        success: function(datos){
                //console.log(datos); return false;
                if(datos==1){
                    var mensaje="Se confirma el cambio de turno";
                    Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})

                    $("#contenido").load('sol_intercambio_turnos.php')//carga de el datatable luego de una accion del alert.OJO CON ID

                }else if(datos == 2){

                        var mensaje="Se debe hacer el cambio del turno "+turno_solicitud+" en programaci&oacute;n";
                        Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
                        
                }else if(datos == 4){

                     var mensaje="Error al enviar la solicitud al correo";
                        Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})

                }else if(datos == 5){

                     var mensaje="Error en hacer la solicitud de cambio de turno intentalo de nuevo";
                        Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
                }

        }
	 });
	
	return false;
    
    
}


function rechazar_solicitud_turno(id,fecha_solicitud,cod_epl,turno_solicitud,jefe){
    
  
    $.ajax({
            type:"POST",
            url: "solicitudes.php",
            data:"id="+id+"&info="+6+"&cod_epl="+cod_epl+"&jefe="+jefe+"&turno_solcitud="+turno_solicitud+"&fecha_solicitud="+fecha_solicitud,
            success: function(datos){
                    if(datos==1){
                            var mensaje="Se rechaza la solicitud de ausencia";
                             Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})
                            $("#contenido").load('sol_ausencia_turnos.php')//carga de el datatable luego de una accion del alert.OJO CON ID

                    }else if(datos==2){

                            var mensaje="Error en hacer la solicitud de ausencia";
                            Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})

                    }else if(datos==4){
                           var mensaje="Error al enviar la solicitud al correo";
                            Alert.alert(mensaje,function(){$('#myModal6').modal('hide');}) 

                    }

            }
	});
	
	return false;
      
}

			