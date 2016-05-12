$(document).ready(main);

function main(){
        
       
	tiempo_sistema();

	cargar_tabla();

	var codigo = $('#cod_epl_sesion').val();
	var fecha=$(".anio").val()+"-"+$(".mes").val();
	var centro_costo=$(".centro_costo").val();
	var cargo=$(".cargo").val();
	
	
	
	 auditorias(fecha, codigo);
	
	$(".anio, .mes").change(function(){ cargar_tabla();});
        
        /*Intercambiar turno*/
        $("#intercambiar_turno").click(intercambiar);
        $("#registrar_ausencia").click(ausencia);
        $("#enviar_turno").click(enviar_turno);
        $("#imprimir_turno").click(imprimir_contenido);
        $("#solicitar_turno").click(solicitar_turno);
}

/*Imprimir programacion*/
function imprimir_contenido(){
    
	var fecha=$(".anio").val()+"-"+$(".mes").val();
	var anio=$(".anio").val();
	var mes=$(".mes").val();
        var cod_epl=$('#cod_epl_sesion').val();

        
        var contenido= 1;
        
          $.ajax({
            url:"find_cen_ca.php",
            type:"POST",
            dataType:"json",
            data:"cod_epl="+cod_epl+"&mes="+mes+"&anio="+anio+"&contenido="+contenido,
            success:function(data){
                
                  imprimir_pagina(fecha,data.cod_cc2,data.cod_car,data.cod_jefe,anio,mes);

            }
          });
        
         return false;
          
}

function imprimir_pagina(fecha,cod_cc2,cod_car,cod_jefe,anio,mes){
   
   window.open("imprimir_programacion_emp.php?fecha="+fecha+"&cc="+cod_cc2+"&cargo="+cod_car+"&jefe="+cod_jefe+"&anio="+anio+"&mes="+mes, '_blank');  
}


function enviar_turno(){
    
    var fecha=$(".anio").val()+"-"+$(".mes").val();
    var anio=$(".anio").val();
    var mes=$(".mes").val();
    var centro_costo=$(".centro_costo").val();
    var cargo=$(".cargo").val();
    var cod_epl=$('#cod_epl_sesion').val();
    
    var contenido=1;
    var empleados='empleados';	
    
     $.ajax({
        url:"find_cen_ca.php",
        type:"POST",
        dataType:"json",
        data:"cod_epl="+cod_epl+"&mes="+mes+"&anio="+anio+"&contenido="+contenido,
        success:function(data){
            //console.log(data); return false;
             var contenido = '<div id="correo_n">';
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
                    data:"fecha="+fecha+"&cc="+data.cod_cc2+"&cargo="+data.cod_car+"&jefe="+cod_epl+"&anio="+anio+"&mes="+mes,
                    success:function(res){
                         //console.log(res); return false;
                        $("#correo_n .texemail").val(res);

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
     });
   
}

function enviar_email(){
	
	var ta= $(".texemail").val();
	
        $.ajax({
                url:"enviar_correo.php",
                type:"post",
                data:"correo="+$("#selectmultiple").val()+"&mens="+ta,
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

function intercambiar(){
       
    var	mensaje = '<div id="block_intercambiar" style="color: rgb(0,0,0); text-align: left;">';
        mensaje += "<div style='color:rgb(41, 76, 139); width:20%; margin-left:20%; width:350px;' >";
        mensaje += "<span  style='font-weight:bold; font-size:16px !important;'>Seleccione el d&iacute;a que desea intercambiar</span></div>";
        mensaje += "<div style='margin-left:20%; margin-top:20px;'>";
        mensaje += '<div class="input-append">';
        mensaje += '<select class="input-xlarge elegir" id="inter"><option value="0" >Seleccione....</option>';
        for(var i=1; i<=31; i++){
        mensaje += '<option value="'+i+'">'+i+'</option>'; 
        }
        mensaje += '</select>';
        mensaje += '</div>';
        mensaje += "</div>";
        mensaje += "<p></p>";
        mensaje += "</div>";
        
    
       modals2('INTERCAMBIAR TURNO',mensaje);
       
       $("#inter").change(function(){
          
            //$('#myModal5').modal('hide');
            var dia=$("#inter").val();
            
            intercambiar_turno(dia);
            $('#myModal5').modal('hide');

       });
       
       return false;
}

function intercambiar_turno(dia){
      
      $("#inter").val("0");
      var mes=$(".mes").val();
      var anio=$(".anio").val();
      var cod_epl=$("#cod_epl_sesion").val();
      var fecha=dia+"-"+mes+"-"+anio;
      
      
    $.ajax({
        url:"find_cen_ca.php",
        type:"POST",
        dataType:"json",
        data:"cod_epl="+cod_epl+"&mes="+mes+"&anio="+anio+"&dia="+dia,
        success:function(data){
                    
            if(data.datos==1){
 
                var mensaje="No hay turnos para intercambiar";

                Alert.alert(mensaje,function(){$('#myModal6').modal('hide');})	
            }
            $.ajax({
                url:"intercambiar_turno.php",
                type:"POST",
               dataType:"json",
                data:"&dia="+dia+"&mes="+mes+"&anio="+anio+"&jefe="+data.cod_jefe+"&cod_cc2="+data.cod_cc2+"&cod_car="+data.cod_car+"&cod_epl="+cod_epl,
                success:function(res){
                   
                var mensaje = '<div id="usuario_n" style="color: rgb(0,0,0); text-align: left;">';
                    mensaje += "<form id='intercambiar_turno'>";
                    mensaje += "<p style='text-align:center; color:rgb(41, 76, 139);font-weight: bold;'>Fecha: "+dia+"-"+mes+"-"+anio+"</p>";
                    mensaje += "<div style=' display:inline-block; color:rgb(41, 76, 139); width:20%; margin-left:20%' ><label >Turno Actual</label>";
                    mensaje += "<input type='text' class='turno_actual'  name='turno_actual' value='"+data.turno+"' readonly='readonly' style='width: 100%;'/></div>";
                    mensaje += "<div style=' display:inline-block; color:rgb(41, 76, 139); width:20%; margin-left:20%' ><label >Turno Nuevo</label>";
                    mensaje += "<input type='text' class='turno_nuevo'  name='turno_nuevo' value='' readonly='readonly' style='width: 100%;'/></div><br>";
                    mensaje += "<div style='display:none;'><input type='text' name='cod_epl_cambio' id='cod_epl_cambio'/></div>";
                    mensaje += "<p></p>";
                    mensaje += "<p style='text-align:center; color:rgb(41, 76, 139);font-weight: bold;'>EMPLEADOS DISPONIBLES</p>";
                    mensaje += "<div style='height:120px;float:left;display:block;overflow:scroll;width:100%'><table id='creacion' class='tableone table-bordered' border='1'>";
                    mensaje += "<tr style='background-color: rgb(41, 76, 139); color: #fff; text-align: center;'><th>Empleado</th><th>Turno</th></tr>"; 
                    for(var i=0; i<res.length; i++){
                            mensaje +=	"<tr class='si contar seleccionar_"+i+"' id="+i+"><td align='center' class='nom_"+i+"'>"+res[i].nombres+"</td>";
                            mensaje +=	"<td align='center' class='turno_"+i+"'>"+res[i].turno+"</td>";
                            mensaje +=	"<td align='center' style='display:none;'class='cod_epl_"+i+"'>"+res[i].cod_epl+"</td>";
                            mensaje +=	"</tr>";
					}
                    mensaje += "</table></div>";
                    mensaje += "<div class='validar'></div>";
                    mensaje += "<div style='margin-top:5%; text-align:center;' id='esconder'><input id='intercambiar' type='button' class='btn btn-primary' value='Solicitar'/></div>";
                    mensaje += "</form>";
                    mensaje += "</div>";
					
                    modals3('INTERCAMBIAR TURNO',mensaje);
                    
                    var contar=Number($('.contar').length);
                    for(var u=0;u<contar;u++){

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
                                     $("#cod_epl_cambio").val($(".inter_epl").html());
                            });
                    }

                    $("#intercambiar").click(function(){

                       var cod_jefe=data.cod_jefe;
                       var cod_cc2=data.cod_cc2;
                       var cod_car=data.cod_car;
                       var info=1;
                       
                       $.ajax({
                            url:"ajax_solicita_turno_tmp.php",
                            type:"POST",
                            data:"cod_epl_actual="+cod_epl+"&cod_epl_cambio="+$("#cod_epl_cambio").val()+"&turno_actual="+$(".turno_actual").val()+"&turno_cambio="+$(".turno_nuevo").val()+"&fecha_ini="+fecha+"&cod_cc2="+data.cod_cc2+"&cod_car="+data.cod_car+"&cod_jefe="+data.cod_jefe+"&info="+info,
                            success:function(res){
                               
                               if(res==1){
                                     $("#esconder").css("display","none");
                                     $(".validar").html("<span style='margin-top:28px;' class='mensajes_success'>La solicitud se envi&oacute; correctamente</span>");
                                      cargar_tabla()
                                }else if(res==2){
                                     $("#esconder").css("display","none");
                                    $(".validar").html("<span style='margin-top:28px;' class='mensajes_error'>La solicitud No se ingreso Intentalo de nuevo</span>");
                                     cargar_tabla();
                                }else if(res==3){
                                     $("#esconder").css("display","none");
                                    $(".validar").html("<span style='margin-top:28px;' class='mensajes_error'>No se ha enviado la solicitud al correo</span>");
                                    
                                }
                                  
                            }
                        
                        });
                 
                    });

                }
            });
        }
    
     });
  
    
     return false; 
}

function solicitar_turno(){
     
    var mes=$(".mes").val();
    var anio=$(".anio").val();
    var cod_epl=$("#cod_epl_sesion").val();
      
    
      var mensaje = '<div id="block_solicitar" style="color: rgb(0,0,0); text-align: left;">';
        mensaje += "<div style='color:rgb(41, 76, 139); width:20%; margin-left:20%; width:350px;' >";
        mensaje += "<span  style='font-weight:bold; font-size:16px !important;'>Seleccione el d&iacute;a que desea Solicitar</span></div>";
        mensaje += "<div style='margin-left:20%; margin-top:10px;'>";
        mensaje += '<div class="input-append">';
        mensaje += '<select class="input-xlarge elegir" id="dia_solici"><option value="0" >Seleccione....</option>';
        for(var i=1; i<=31; i++){
        mensaje += '<option value="'+i+'">'+i+'</option>'; 
        }
        mensaje += '</select>';
        mensaje += '</div>';
        mensaje += "</div>";
         mensaje += "<div style='color:rgb(41, 76, 139); width:20%; margin-left:20%; width:350px; margin-top:5px;' >";
        mensaje += "<span  style='font-weight:bold; font-size:16px !important;'>Seleccione Turno que desea</span></div>";
        mensaje += "<div style='margin-left:20%; margin-top:10px;'>";
        mensaje += '<div class="input-append">';
        mensaje += '<select class="input-xlarge elegir" id="turnos_emple"><option value="0" >Seleccione....</option>';
        
        mensaje += '</select>';
        mensaje += '</div>';
        mensaje += "</div>";
        mensaje += "<div class='validar'></div>";
        mensaje += "<div style='margin-top:3%; text-align:center;' id='esconder'><input id='solicita_turno' type='button' class='btn btn-primary' value='Solicitar'/></div>";
        mensaje += "<p></p>";
        mensaje += "</div>";
        
    
       modals2('SOLICITAR TURNO',mensaje);
       
      
        $.ajax({ 
             url:"turnos_empleados.php",
             type:"POST",
             success:function(data){	
                     $("#turnos_emple").html(data); // para llenar automaticamente los 15 dias
             }		
         }); 
         
         
          $("#solicita_turno").click(function(){

            if($("#dia_solici").val()==0){

                 $(".validar").html("<span style='margin-top:28px;' class='mensajes_error'>Debe elegir el d&iacute;a</span>");

            }else if($("#turnos_emple").val()==0){

                 $(".validar").html("<span style='margin-top:28px;' class='mensajes_error'>Debe elegir el turno</span>");

            }else{ //inicio else

                $.ajax({ //inicio ajax
                   url:"find_cen_ca.php",
                   type:"POST",
                   dataType:"json",
                   data:"cod_epl="+cod_epl+"&mes="+mes+"&anio="+anio+"&dia="+$("#dia_solici").val()+"&contenido=1",
                   success:function(data){
                     
                       var cod_jefe=data.cod_jefe;
                       var cod_cc2=data.cod_cc2;
                       var cod_car=data.cod_car;
                       var fecha=$("#dia_solici").val()+"-"+mes+"-"+anio;
                       var info=2;
                      
                        $.ajax({
                               url:"ajax_solicita_turno_tmp.php",
                               type:"POST",
                               data:"cod_epl_actual="+cod_epl+"&turno_solicitud="+$("#turnos_emple").val()+"&fecha_solicitud="+ fecha+"&cod_cc2="+cod_cc2+"&cod_car="+cod_car+"&cod_jefe="+cod_jefe+"&info="+info,
                               success:function(res){ //INICIO res
                                   //console.log(res); return false;
                                   if(res==1){
                                     $("#esconder").css("display","none");
                                     $(".validar").html("<span style='margin-top:28px;' class='mensajes_success'>La solicitud se envi&oacute; correctamente</span>");
                                      cargar_tabla();
                                    }else if(res==2){
                                         $("#esconder").css("display","none");
                                        $(".validar").html("<span style='margin-top:28px;' class='mensajes_error'>La solicitud No se ingreso Intentalo de nuevo</span>");
                                         cargar_tabla();
                                    }else if(res==3){
                                         $("#esconder").css("display","none");
                                        $(".validar").html("<span style='margin-top:28px;' class='mensajes_error'>No se ha enviado la solicitud al correo</span>");

                                    }





                              }//FIN res
                       });

                    }
                });//Fin ajax




            } // fin else
        });
         
    
    return false;
}



function modals2(titulo,mensaje){
    
    var modal='<!-- Modal -->';
        modal+='<div id="myModal5" class="modal hide fade" style="margin-top: 3%; background-color: rgb(41, 76, 139); color: #fff; z-index: 900000; behavior: url(../../css/PIE.htc)" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">';
        modal+='<div class="modal-header" style="border-bottom: 0px !important;">';
        modal+='<button type="button" class="close" style="color:#fff !important;" data-dismiss="modal" aria-hidden="true">x</button>';
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


function modals3(titulo,mensaje){
    
    var modal='<!-- Modal -->';
        modal+='<div id="myModal6" class="modal hide fade" style="margin-top: 3%; background-color: rgb(41, 76, 139); color: #fff; z-index: 900000; behavior: url(../../css/PIE.htc)" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">';
        modal+='<div class="modal-header" style="border-bottom: 0px !important;">';
        modal+='<button type="button" class="close" style="color:#fff !important;" data-dismiss="modal" aria-hidden="true">x</button>';
        modal+='<h4 id="myModalLabel">'+titulo+'</h4>';
        modal+='</div>';
        modal+='<div class="modal-body" style="max-width: 92% !important; background-color:#fff; margin: 0 auto; margin-bottom: 1%; border-radius: 8px; behavior: url(../../css/PIE.htc);">';
        modal+='<p>'+mensaje+'</p>';    
        modal+='</div>';
        modal+='</div>';		
	$("#main").append(modal);
	
	$('#myModal6').modal({
		keyboard: false,
		backdrop: "static" 
	});
        
         $('#myModal6').on('hidden', function () {
		$(this).remove();
	});
    
}

function ausencia(){
    
    var	mensaje = '<div id="block_ausencia" style="color: rgb(0,0,0); text-align: left;">';
        mensaje += "<div style='color:rgb(41, 76, 139); width:20%; margin-left:14%; width:400px;' >";
        mensaje += "<span  style='font-weight:bold; font-size:16px !important;'>Seleccione el d&iacute;a que desea solicitar ausencia</span></div>";
        mensaje += "<div style='margin-left:23%; margin-top:20px;'>";
        mensaje += '<div class="input-append">';
        mensaje += '<select class="input-xlarge elegir" id="aus"><option value="0" >Seleccione....</option>';
        for(var i=1; i<=31; i++){
        mensaje += '<option value="'+i+'">'+i+'</option>'; 
        }
        mensaje += '</select>';
        mensaje += '</div>';
        mensaje += "</div>";
        mensaje += "<p></p>";
        mensaje += "</div>";
        
    
       modals2('SOLICITAR AUSENCIA',mensaje);
       
       $("#aus").change(function(){
          
            //$('#myModal5').modal('hide');
            var dia=$("#aus").val();
            
            registrar_ausencia(dia);
            
            $('#myModal5').modal('hide');

       });
       
       return false;
    
    
}

function registrar_ausencia(dia){
    
     
    $("#aus").val("0");
     var mes=$(".mes").val();
     var anio=$(".anio").val();
     var fecha= dia+"-"+mes+"-"+anio;
     
     var cod_epl=$("#cod_epl_sesion").val();
     
     var mensaje="<div style='color:black'><div style='margin-bottom:2% !important; margin-left:38%'>";		
        mensaje+="<p style='color:rgb(41, 76, 139);font-weight:bold; font-size:14px !important;'>Fecha: "+dia+"-"+mes+"-"+anio+"</p>";
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

        modals3("AUSENCIAS",mensaje);	
			
        $.ajax({ /*Este ajax trae todas las ausencias de la tabla conceptos_ayu y se refleja en el combo box*/
            url:"ausencias.php",
            type:"POST",
            data:"info="+4,
            success:function(data){	
                    $("#ausencias").html(data);
            }		
        }); 
        
        $("#ausencias").change(function(){ //para calcular los dias de vacaciones solo cuando elijo en el combobox ausencias
            $("#fecha_final_aus").val("");
            $("#esconder_ausencia").css("display","none");

            if($("#ausencias").val()==11){ // 11 es el codigo del concepto de vacaciones
                    $("#vacaciones_tiempo").css("display","none");
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
        
        $("#calculo").click(function(){ /*Para hacer el calculo de dias y tambien validar si tiene vacaciones*/

            if($("#ausencias").val()==11){

                $.ajax({
                    url:"calculo_vacaciones.php",
                    type:"POST",
                    data:"cod_epl="+cod_epl+"&fecha="+fecha+"&canti="+$("#dias_calculo").val()+"&ausencias="+$("#ausencias").val(),
                    success:function(data){
                            //console.log(data); return false;
                        if(data==1){
                            $("#g_aus").css("display","none");
                             $(".validar").html("<span style='margin-top:28px;' class='mensajes_error'> Es un d&iacute;a no h&aacute;bil</span>");
                                return false;
                        }else if(data==2){
                                  $("#g_aus").css("display","none");
                                $(".validar").html("<span style='margin-top:28px;' class='mensajes_error'> No Tiene derecho a vacaciones</span>");
                                return false;
                        }else if (data==3){
                                $(".validar").html("<span style='margin-top:28px;' class='mensajes_error'> El empleado solo puede disfrutar 15 días</span>");
                                return false;
                        }else{ // inicio else
                                $("#fecha_final_aus").val(data);
                                $("#esconder_ausencia").css("display","block");	
                                
                                return false;
                        }	// fin else	
                    }		
                });
            }else{
                var calculo=2;
                $.ajax({
                    url:"calculo_ausencias.php",
                    type:"POST",
                    data:"cod_epl="+cod_epl+"&fecha="+fecha+"&canti="+$("#dias_calculo").val()+"&calculo="+calculo,
                    success:function(data){
                        if($("#ausencias").val()==9000){
                            if($('#dias_calculo').val() > 15){

                                $(".validar").html("<span style='margin-top:28px;' class='mensajes_error'> No puede ser mayor a 15</span>");
                                return false;

                            }else{
                                $("#fecha_final_aus").val(data);
                                var fec_fin=$("#fecha_final_aus").val(data);
                                $("#esconder_ausencia").css("display","none");
                                $("#vacaciones_tiempo").css("display","block");
                            }
                        }else{

                            $("#fecha_final_aus").val(data);
                            $("#esconder_ausencia").css("display","block");
                            
                        }
                    }		
                });
            }

            return false;

        });
        
        /*Guardar ausencias*/
        
        $("#guardar_ausencia").click(function(){
                $.ajax({
                    url:"find_cen_ca.php",
                    type:"POST",
                    dataType:"json",
                    data:"cod_epl="+cod_epl+"&mes="+mes+"&anio="+anio+"&dia="+dia,
                    success:function(data){
                       var cod_jefe=data.cod_jefe;
                       var cod_cc2=data.cod_cc2;
                       var cod_car=data.cod_car;
                        
                        $.ajax({
                            url:"ajax_add_aus_tmp.php",
                            type:"POST",
                            data:"cod_con="+$("#ausencias").val()+"&cod_epl="+cod_epl+"&fec_ini="+fecha+"&fec_fin="+$("#fecha_final_aus").val()+"&cod_cc2="+cod_cc2+"&cod_car="+cod_car+"&cod_jefe="+cod_jefe,
                            success:function(res){
                                //console.log(res); return false;
                                if(res==1){
                                      $("#g_aus").css("display","none");
                                     $(".validar").html("<span style='margin-top:28px;' class='mensajes_success'>La solicitud se ingreso correctamente</span>");
                                      cargar_tabla()
                                }else{
                                    
                                    $(".validar").html("<span style='margin-top:28px;' class='mensajes_error'>La solicitud No se ingreso Intentalo de nuevo</span>");
                                     cargar_tabla();
                                }    
                            }
                        
                        });
                 
                    }
                });
            return false;   
            
        }); 

    
}


function cargar_tabla(){
	$("#contenido").html("");
	
         var codigo = $("#cod_epl_sesion").val();
	
	$.ajax({url:"ajax_main_empleado.php", 
            type:"post", 
            data:{codigo: codigo},
            dataType:"json",
            success:function(datas){
                    //console.log(datas); return false;
                    var fecha=$(".anio").val()+"-"+$(".mes").val();
                    var centro_costo=datas[0].area;
                    var cargo=datas[0].cargo;
                    var jefe =datas[0].jefe;

                    programacion(fecha, centro_costo, cargo, jefe);



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
			   url: "ajax_catalogo_programacion_emp.php",
			   data: "cantidad="+canti+"&centro_costo="+centro_costo+"&cargo="+cargo+"&fecha="+fecha+"&codigo="+codigo,	
				 beforeSend:function(){
					$("#contenido").html("<h1 id='cerrar_se'>Espere Por favor<span>.</span><span>.</span><span>.</span></h1>");
			   },
			   success: function (datos){
						//console.log(datos); return false;
					
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
				
					//click_derecho_turnos();
					// $(".context-menu-two").contextmenu(click_derecho_turnos);
					
					//Aca va el datable porque se crea example y ahi si con ese example hagame esta accion
					$('#example').dataTable({

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
								"sLast": "Ãšltimo"
								}
						}
				
					});
					
					/*click derecho de opciones de la programacion*/
					
					//click_derecho_turnos();
					 //$(".context-menu-two").contextmenu(click_derecho_turnos);
				}
			});
			/*fin table*/	
		}
	});
}


//Auditoria simplificada(ABAJO DE LA PROGRAMACION EN TIEMPO EXTRA)
function auditorias(fecha, codigo){
		$.ajax({					  
					   type:"POST",
					   url: "auditoria5_epl.php",
					   data: "fecha="+fecha+"&codigo="+codigo,
							 beforeSend:function(){
							$("#contenido2").html("");
							
					   },
					   success: function (datos){
					   
							//console.log(datos);return false;
							
										 
							//INICIO DE TABLA	 
					
							//THEAD
							var table="<div style='width:30%'><table style='color: rgb(41, 76, 139) !important; width: 100%' cellpadding='0' cellspacing='0' border='1' class='display' id='example2'>";
							
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
