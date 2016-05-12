$(document).ready(main);
function main(){
	
	//FUNCION PARA EL TOOLTIP pase por encima y le salga un aviso
	$("#crear, #correo, #imprimir, #editar, #eliminar").hover(function(){
		$(this).tooltip("show");
	});
	
	//FUNCION PARA internet explorer 8 y ponga las imagenes bien
   $("#crear img").hover(function(){
		$(this).attr('src','../../img/TurnoNuevo2.png');
   },function(){
		$(this).attr('src','../../img/TurnoNuevo.png');
   });
   
     $("#correo img").hover(function(){
		$(this).css("width","46px");
		$(this).css("height","46px");
		$(this).attr('src','../../img/Correo2.png');
   },function(){
		$(this).attr('src','../../img/Correo.png');
   });
     $("#imprimir img").hover(function(){
		$(this).attr('src','../../img/Imprimir2.png');
   },function(){
		$(this).attr('src','../../img/Imprimir.png');
   });
     $("#editar img").hover(function(){
		$(this).attr('src','../../img/Editar2.png');
   },function(){
		$(this).attr('src','../../img/Editar.png');
   });
     $("#eliminar img").hover(function(){
		$(this).attr('src','../../img/Eliminar2.png');
   },function(){
		$(this).attr('src','../../img/Eliminar.png');
   });
	
	//Funcion para seleccionar la fila de la tabla Turnos Creados
	var contar=Number($('.contar').length);
	
	
	//Selecciona la fila a azul agregandole la clase selecionar
	//Remueve y pone la fila en azul
	for(u=0;u<contar;u++){

		$(".seleccionar_"+u+"").click(function(){ 

		var a= Number($(".selecionar").length);
			var h = $(this).attr("id");
		if(a > 0){

				$(".selecionar").removeClass("selecionar");
				$("#editar, #eliminar").css("display","none");
				$(".codigo_turno").removeClass("codigo_turno");
				$(".horas_turno").removeClass("horas_turno");
				$(".horas_ini_turno").removeClass("horas_ini_turno");
				$(".horas_fin_turno").removeClass("horas_fin_turno");
				$(".almuerzo_turno").removeClass("almuerzo_turno");
									
		}else{
			$(this).toggleClass("selecionar");
			$("#editar, #eliminar").css("display","inline-block");
			$(".codigos_"+h+"").addClass("codigo_turno");
			$(".horas_"+h+"").addClass("horas_turno");
			$(".hora_ini_"+h+"").addClass("horas_ini_turno");
			$(".hora_fin_"+h+"").addClass("horas_fin_turno");
			$(".almuerzo_"+h+"").addClass("almuerzo_turno");
		}
		
		});
	
	}
	
	
	
	$('.tabla #predeter input').keyup(filtros1);
	$('.tabla #personal input').keyup(filtros2);
	$("#crear").click(modalcrear_turno);
	$("#editar").click(modaleditar_turno);
	$("#eliminar").click(modaleliminar_turno);
	$("#imprimir").click(imprimir_contenido);
	$("#correo").click(correo_turno);
}

//Funcion que realiza los filtros en la tabla Turnos Catalogo
function filtros1(){
	var recibe=$(this).val();
	var detector=$(this).attr('name');	
	
	$('#predeter tr').show();
	
	if(recibe.length>0 && detector=='codigo'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#predeter tr td.codigos").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='hora'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#predeter tr td.horas").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='hora_ini'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#predeter tr td.hora_ini").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='hora_fin'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#predeter tr td.hora_fin").not(":Contains('"+recibe+"')").parent().hide();
	}
	return false;
}

//Funcion que realiza los filtros en la tabla Mis Turnos
function filtros2(){
	var recibe=$(this).val();
	var detector=$(this).attr('name');	
	
	$('#personal tr').show();
	
	if(recibe.length>0 && detector=='codigo'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#personal tr td.codigos").not(":Contains('"+recibe+"')").parent().hide();
		
	}
	if(recibe.length>0 && detector=='hora'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#personal tr td.horas").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='hora_ini'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#personal tr td.hora_ini").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='hora_fin'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#personal tr td.hora_fin").not(":Contains('"+recibe+"')").parent().hide();
	}
	return false;
}


/*Funcion para cargar la interfaz de crear Turno*/
function modalcrear_turno(){

	var	mensaje = '<div id="usuario_n" style="color: rgb(0,0,0); text-align: center;">';
	    mensaje += "<form id='nuevo_turno'>";
		mensaje += "<div style='float:left; width:16%' ><label >C&oacute;digo</label>";
		mensaje += "<input type='text' maxlength='3' class='codigo' onkeyup='this.value=this.value.toUpperCase();' name='codigo' value='' style='width: 40%;'/></div>";
		mensaje += "<div  style='float:left;  width:22%'><label >Horario Inicial</label>";
		mensaje += "<select style='width:90%;' class='fecha_ini' name='fecha_ini'>";
		mensaje += "<option value='-1'>Seleccione...</option>";
		for(var i=0;i<24;i++){
		mensaje+="<option value='"+i+"'>"+i+":00</option>";
		}
		mensaje+="</select></div>";
		mensaje += "<div  style='float:left;  width:22%'><label >Horario Final</label>";
		mensaje += "<select style='width:90%;' class='fecha_fin' name='fecha_fin'>";
		mensaje += "<option value='-1'>Seleccione...</option>";
		for(var i=0;i<24;i++){
		mensaje+="<option value='"+i+"'>"+i+":00</option>";
		}
		mensaje+="</select></div>";
		mensaje += "<div style='float:left; width:16%' ><label >Almuerzo</label>";
		mensaje += "<input type='text' id='almuerzo' name='almuerzo' value='' style='width: 40%;'/></div>";
		mensaje += "<div style='float:left;  width:16%' ><label >Horas</label>";
		mensaje += "<input type='text' readonly='readonly' class='horas' name='horas' value='' style='width: 40%;'/></div>";
		mensaje += "<div style='clear:both;'></div><div class='validar' style='color:#fff !important;'></div>";
		mensaje += "<div style='margin-top:5%;'><input id='crear_turno' type='button' class='btn btn-primary' value='Crear Turno'/></div>";
		mensaje += "</form>";
		mensaje += "</div>";
		
	   modals("Turno Nuevo  <i class='icon-time' ></i>",mensaje);
		
		$('.codigo').keyup(function(){
		
			$('.validar').html('');
			
		})

		$('.fecha_fin').change(function(){
			
		
			var fec_ini=Number($('.fecha_ini').val());
			var fec_fin=Number($('.fecha_fin').val());
			
			if(fec_ini < fec_fin){
			
				var horas= fec_fin - fec_ini;
				$('.horas').val(horas);
			
			}else if(fec_ini > fec_fin){
			
				var hora_cero=Math.abs(24 - fec_ini);
				
				horas= Number(hora_cero) + Number(fec_fin);
				
				$('.horas').val(horas);
			}else if(fec_ini == fec_fin){
				
				$('.horas').val(0);
			}
			
			
			$('#almuerzo').keyup(function(){
			
			
				var almuerzo = horas - Number($('#almuerzo').val()); 
				
				$('.horas').val(almuerzo);
				
				
			
			});
			
			/*traigo el parametro de el maximo de horas por turnos*/
			$.ajax({
	
				url:'verificar_parametros.php',
				type:'POST',
				data:"info="+1,
				dataType:'json',
				success:function(data){
					
					if($('.horas').val() > Number(data.t_hor_max_turnos)){
						$("#crear_turno").attr("disabled","disabled");
						$('.validar').html('<span class="mensajes_info">No existen turnos superiores a '+data.t_hor_max_turnos+' horas</span>');
						return false;
					}else{
						$('.validar').html("");
						$("#crear_turno").removeAttr("disabled");
						return false;
					}
				
					
				}
			});
		
		});
		
		$('.fecha_ini').change(function(){
		
			$('.fecha_fin').val(-1);
			$('.horas').val(0);
					
		});
		
		$("#crear_turno").click(crear_turno);
		
		
}

//Funcion para insertar el truno en la base de datos
function crear_turno(){

	if($('.codigo').val()== 0 || $('.fecha_ini').val()== -1 || $('.fecha_fin').val()==-1){
	
		$('.validar').html("<span class='mensajes_error'>Existen campos vac&iacute;os</span>");
		return false;
		
	}else{
	
		$('.validar').html("");
	
		$.ajax({
	
			url:'nuevo_turno.php',
			type:'POST',
			data:$('#nuevo_turno').serialize(),
			dataType:'html',
			success:function(data){
				$('.codigo').val('');
				$('.fecha_ini').val(-1);
				$('.fecha_fin').val(-1);
				$('.horas').val('');
				$('#almuerzo').val('');
				$('.validar').html(data);
				$("#content").html('');
				$("#content").load('turnos_catalogo.php');
				
			}
		});
		
		return false;
	
	}
}

/*Funcion para cargar la interfaz de editar Turno*/
/*Nuevo*/
function modaleditar_turno(){
	
	
	var cuanto=$(".codigo_turno").length;
	
	if(cuanto>0){
		var codigo_turno=$(".codigo_turno").html();
		var horas_turno=$(".horas_turno").html();
		var horas_ini_turno=$(".horas_ini_turno").html();
		horas_ini_turno.split(":");
		var horas_fin_turno=$(".horas_fin_turno").html();	
		horas_fin_turno.split(":");
		var almuerzo_turno=$(".almuerzo_turno").html();
	
	}else{
		var codigo_turno=$(".codigo_turno").html("");
		var horas_turno=$(".horas_turno").html("");
		var horas_ini_turno=$(".horas_ini_turno").html("");
		var horas_fin_turno=$(".horas_fin_turno").html("");
		var almuerzo_turno=$(".almuerzo_turno").html();
	}
	
	
	
	
	var	mensaje = '<div id="usuario_n" style="color: rgb(0,0,0) !important; text-align: center;">';
	    mensaje += "<form id='edit_turno'>";
		mensaje += "<div style='float:left;  width:16%' ><label >C&oacute;digo</label>";
		mensaje += "<input type='text' maxlength='3'class='codigo' name='codigo' onkeyup='this.value=this.value.toUpperCase();' value='"+codigo_turno+"' style='width: 40%;'/></div>";
		mensaje += "<div  style='float:left;  width:22%'><label >Horario Inicial</label>";
		mensaje += "<select style='width:80%;' class='fecha_ini' name='fecha_ini'>";
		for(var i=0;i<24;i++){
		mensaje+="<option value='"+i+"'>"+i+":00</option>";
		}
		mensaje += "</select></div>";
		mensaje += "<div  style='float:left;  width:22%%'><label >Horario Final</label>";
		mensaje += "<select style='width:80%;' class='fecha_fin' name='fecha_fin'>";
		for(var i=0;i<24;i++){
		mensaje+="<option value='"+i+"'>"+i+":00</option>";
		}
		mensaje += "</select></div>";
		mensaje += "<div style='float:left; width:16%' ><label >Almuerzo</label>";
		mensaje += "<input type='text' id='almuerzo' name='almuerzo' value='"+almuerzo_turno+"' style='width: 40%;'/></div>";
		mensaje += "<div style='float:left; width:20%' ><label >Horas</label>";
		mensaje += "<input type='text' class='horas' readonly='readonly' name='horas' value='"+horas_turno+"' style='width: 40%;'/></div>";
		mensaje += "<input type='hidden' name='codigo_old' value='"+codigo_turno+"' style='width:40%;'/>";
		mensaje += "<div style='clear:both;'></div><div class='validar'style='color:#fff !important; text-align:center;'></div>";
		mensaje += "<div style='margin-top:5%;'><input type='button' id='editar_turno' class='btn btn-primary' value='Guardar Turno'/></div>";
		mensaje += "</form>";
		mensaje += "</div>";
		
		
	modals("Editar Turno <i class='icon-edit'></i>",mensaje);
	
		$(".fecha_ini option:selected").html(horas_ini_turno);
		$(".fecha_fin option:selected").html(horas_fin_turno);
		var hor_ini=horas_ini_turno.split(":");
		var hor_fin=horas_fin_turno.split(":");
		
		$('.fecha_ini option:selected').val(hor_ini[0]);
		$('.fecha_fin option:selected').val(hor_fin[0]);
		
	   $('.codigo').keyup(function(){
		
			$('.validar').html('');
			
		});
		
		var horas = horas_turno
		
		$('.fecha_fin').change(function(){
		
		//console.log("hola");
			//horas=0;
		
			var fec_ini=$('#edit_turno  .fecha_ini').val();
			var fec_fin=$('#edit_turno  .fecha_fin').val();
			
			//console.log(fec_ini);
			//console.log(fec_fin);
			
			if(Number(fec_ini) < Number(fec_fin)){
			
				var horas= Number(fec_fin) - Number(fec_ini);
				console.log(horas);
				$('.horas').val(horas);
			
			}else if(Number(fec_ini) > Number(fec_fin)){
			
				var hora_cero=Math.abs(24 - fec_ini);
				
				horas= Number(hora_cero) + Number(fec_fin);
				
				$('.horas').val(horas);
			}else if(Number(fec_ini) == Number(fec_fin)){
				
				$('.horas').val(0);
			}
			
			
			
			
			
			/*traigo el parametro de el maximo de horas por turnos*/
			$.ajax({
	
				url:'verificar_parametros.php',
				type:'POST',
				data:"info="+1,
				dataType:'json',
				success:function(data){
					
					if($('.horas').val() > Number(data.t_hor_max_turnos)){
						$("#crear_turno").attr("disabled","disabled");
						$('.validar').html('<span class="mensajes_info">No existen turnos superiores a '+data.t_hor_max_turnos+' horas</span>');
						return false;
					}else{
						$('.validar').html("");
						$("#crear_turno").removeAttr("disabled");
						return false;
					}
				
					
				}
			});
		
		});
		
		
		$('#almuerzo').keyup(function(){
			
				var almuerzo = horas - Number($('#almuerzo').val()); 
				
				$('.horas').val(almuerzo);	
				
		});
		
		$('.fecha_ini').change(function(){
		
			$('.fecha_fin').val(-1);
			$('.horas').val(0);
					
		});
	
	$("#editar_turno").click(editar_turno);
}
/*Fin nuevo*/
/*Funcion para editar el truno en la base de datos*/
/*Nuevo*/
function editar_turno(){

	/*envio de datos para editar ajax*/
	if($('#edit_turno .codigo').val()== 0 || $('#edit_turno .fecha_ini').val()== -1 || $('#edit_turno .fecha_fin').val()==-1){
	
		$('.validar').html("<span class='mensajes_error'>Existen campos vac&iacute;os</span>");
		return false;
	
	}else{
	
		$('.validar').html("");
	
		$.ajax({
	
			url:'editar_turno.php',
			type:'POST',
			data:$('#edit_turno').serialize(),
			dataType:'html',
			success:function(data){
				
				console.log(data); 
				$('edit_turno .codigo').val('');
				$('.fecha_ini').val(-1);
				$('.fecha_fin').val(-1);
				$('.horas').val('');
				$('#almuerzo').val('');
				$('.validar').html(data);
				$('edit_turno .codigo').attr('readonly','readonly');
				$('.fecha_ini').attr('disabled','disabled');
				$('.fecha_fin').attr('disabled','disabled');
				$('#editar_turno').attr('disabled','disabled');
				$("#content").html('');
				$("#content").load('turnos_catalogo.php');
				
			}
		});
		
		return false;
	
	}
}
/*Fin nuevo*/

/*Funcion para cargar la interfaz de eliminar Turno*/
function modaleliminar_turno(){
	
	var cuanto=$(".codigo_turno").length;
	
	if(cuanto>0){
		var codigo_turno=$(".codigo_turno").html();
		var horas_turno=$(".horas_turno").html();
		var horas_ini_turno=$(".horas_ini_turno").html();
		horas_ini_turno.split(":");
		var horas_fin_turno=$(".horas_fin_turno").html();	
		horas_fin_turno.split(":");
	}else{
		var codigo_turno=$(".codigo_turno").html("");
		var horas_turno=$(".horas_turno").html("");
		var horas_ini_turno=$(".horas_ini_turno").html("");
		var horas_fin_turno=$(".horas_fin_turno").html("");
	}
		
	var	mensaje = '<div id="usuario_n" style="color: rgb(0,0,0) !important; text-align: center;">';
		mensaje += '<div class="mensaje-alert" style="text-align:center; margin-bottom: 6%;">';
		mensaje += '<p style="color:red; font-size: 170%; font-weight: bold;">¿Seguro desea eliminar el turno?</p>';
		mensaje += '</div>';
	    mensaje += "<form id='delete_turno'>";
		mensaje += "<div style='display:inline-block; width:20%' ><label >C&oacute;digo</label>";
		mensaje += "<input type='text' class='codigo' name='codigo' readonly='readonly' value='"+codigo_turno+"' style='width: 40%;'/></div>";
		mensaje += "<div  style='display:inline-block; width:30%'><label >Horario Inicial</label>";
		mensaje += "<select style='width:80%;' class='fecha_ini' name='fecha_ini' readonly='readonly'><option value='"+horas_ini_turno[1]+"'>"+horas_ini_turno+"</option>";
		mensaje += "</select></div>";
		mensaje += "<div  style='display:inline-block; width:30%'><label >Horario Final</label>";
		mensaje += "<select style='width:80%;' class='fecha_fin' name='fecha_fin' readonly='readonly'><option value='"+horas_fin_turno[1]+"'>"+horas_fin_turno+"</option>";
		mensaje += "</select></div>";
		mensaje += "<div style='display:inline-block; width:20%' ><label >Horas</label>";
		mensaje += "<input type='text' class='horas' readonly='readonly' name='horas' value='"+horas_turno+"' style='width: 40%;'/></div>";
		mensaje += "<input type='hidden' name='codigo_old' value='"+codigo_turno+"' style='width: 40%;'/>";
		mensaje += "<div class='validar'style='color:#fff !important; text-align:center;'></div>";
		mensaje += "<div style='margin-top:5%;'><input type='button'  id='eliminar_turno' class='btn btn-primary'  value='Eliminar'/></div>";
		mensaje += "</form>";
		mensaje += "</div>";
		
		
	    modals("Eliminar Turno  <i class='icon-trash'></i>",mensaje);
	
	$("#eliminar_turno").click(eliminar_turno);
}

//Funcion para eliminar el truno en la base de datos
function eliminar_turno(){
	
		$.ajax({	
			url:'eliminar_turno.php',
			type:'POST',
			data:$('#delete_turno').serialize(),
			dataType:'html',
			success:function(data){
				//console.log(data);return false;
				$("#eliminar_turno").attr("disabled","disabled");
				$('.validar').html(data);
				$("#content").html('');
				$("#content").load('turnos_catalogo.php');	
			}
		});
		
		return false;
}


/*Funcion para cargar la interfaz de correo Turno con el plug in Tiny*/
function correo_turno(){
	
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
	
	var tabla = $("#oculto").html();
	$("#correo_n .texemail").val(tabla);
	
	tinyMCE.init({
		mode : "textareas",
		theme : "simple",
		width: "640",
        height: "190",
	});
	
	
	$("#enviar_email").click(enviar_email);
	
}

/* Funcion unica de modal para el correo*/
function modals_correo(titulo,mensaje){

	var modal='<!-- Modal -->';
			modal+='<div id="myModal3" class="modal2 hide fade" style="margin-top: 5%; background-color: rgb(41, 76, 139); color: #fff; z-index: 900000; behavior: url(../../css/PIE.htc);width: 60%; left: 50%;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">';
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

//Funcion que envia los datos al correo del usuario
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
				$('.validar').html(data);
				$("#enviar_email").removeAttr("disabled");
			}
		});
}


/*Modal principal que agarra el html de crear, editar, eliminar*/
function modals(titulo,mensaje){

	

	var modal='<!-- Modal -->';
			modal+='<div id="myModal2" class="modal hide fade" style="margin-top: 10%; background-color: rgb(41, 76, 139); color: #fff; z-index: 900000; behavior: url(../../css/PIE.htc)" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">';
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



function imprimir_contenido(){

	
  window.open("imprimir_turno.php", '_blank');

	

}
