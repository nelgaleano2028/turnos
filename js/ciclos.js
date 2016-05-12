$(document).ready(main);
function main(){	
 
	//FUNCION PARA EL TOOLTIP pase por encima y le salga un aviso
	$("#crear, #correo, #imprimir, #editar, #eliminar").hover(function(){
		$(this).tooltip("show");
	});
	
	//FUNCION PARA internet explorer 8 y ponga las imagenes bien
   $("#crear img").hover(function(){
		$(this).attr('src','../../img/Nuevo2.png');
   },function(){
		$(this).attr('src','../../img/Nuevo.png');
   });
   
     $("#correo img").hover(function(){
		
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
				$(".codigo_ciclo").removeClass("codigo_ciclo");
				$(".dias_ciclo").removeClass("dias_ciclo");
				$(".uno_ciclo").removeClass("uno_ciclo");
				$(".dos_ciclo").removeClass("dos_ciclo");
				$(".tres_ciclo").removeClass("tres_ciclo");
				$(".cuatro_ciclo").removeClass("cuatro_ciclo");
				$(".cinco_ciclo").removeClass("cinco_ciclo");
				$(".seis_ciclo").removeClass("seis_ciclo");
				$(".siete_ciclo").removeClass("siete_ciclo");
				$(".obs_ciclo").removeClass("obs_ciclo");
				$(".horas_ciclo").removeClass("horas_ciclo");						
		}else{
			$(this).toggleClass("selecionar");
			$("#editar, #eliminar").css("display","inline-block");
			$(".codigos_"+h+"").addClass("codigo_ciclo");
			$(".dias_"+h+"").addClass("dias_ciclo");
			$(".uno_"+h+"").addClass("uno_ciclo");
			$(".dos_"+h+"").addClass("dos_ciclo");
			$(".tres_"+h+"").addClass("tres_ciclo");
			$(".cuatro_"+h+"").addClass("cuatro_ciclo");
			$(".cinco_"+h+"").addClass("cinco_ciclo");
			$(".seis_"+h+"").addClass("seis_ciclo");
			$(".siete_"+h+"").addClass("siete_ciclo");
			$(".observacion_"+h+"").addClass("obs_ciclo");
			$(".horas_"+h+"").addClass("horas_ciclo");
			
		}
		
		});
	
	}
	
	
	$('.tabla #ciclos input').keyup(filtros);
	$("#crear").click(modalcrear_ciclo);
	$("#editar").click(modaleditar_ciclo);
	$("#eliminar").click(modaleliminar_ciclo);
	$("#correo").click(correo_turno);
	$("#imprimir").click(imprimir_contenido);
	
}

function modaleditar_ciclo(){

	var cuanto=$(".codigo_ciclo").length;
	
		
	if(cuanto>0){
		var codigo_ciclo=$(".codigo_ciclo").html();
		var uno_ciclo=$(".uno_ciclo").html();
		var dos_ciclo=$(".dos_ciclo").html();
		var tres_ciclo=$(".tres_ciclo").html();
		var cuatro_ciclo=$(".cuatro_ciclo").html();
		var cinco_ciclo=$(".cinco_ciclo").html();
		var seis_ciclo=$(".seis_ciclo").html();
		var siete_ciclo=$(".siete_ciclo").html();
		var obs_ciclo=$(".obs_ciclo").html();
		var horas_ciclo=$(".horas_ciclo").html();	
		
			$.ajax({
				url:'capturar_horas.php',
				type:'POST',
				dataType:"json",
				data:'td1='+uno_ciclo+'&td2='+dos_ciclo+'&td3='+tres_ciclo+'&td4='+cuatro_ciclo+'&td5='+cinco_ciclo+'&td6='+seis_ciclo+'&td7='+siete_ciclo,
				success:function(data){
					
						$("#b1").val(data.turnos[0].td1);
						$("#b2").val(data.turnos[1].td2);
						$("#b3").val(data.turnos[2].td3);
						$("#b4").val(data.turnos[3].td4);
						$("#b5").val(data.turnos[4].td5);
						$("#b6").val(data.turnos[5].td6);
						$("#b7").val(data.turnos[6].td7);
				
					return false;
				}
				
			});
	}

	var	mensaje = '<div id="usuario_n" style="color: rgb(0,0,0); text-align: left;">';
	    mensaje += "<form id='editar_turno'>";
		mensaje += "<div style='display:inline-block; width:20%' ><label >C&oacute;digo del Ciclo</label>";
		mensaje += "<input type='text' class='codigo' onkeyup='this.value=this.value.toUpperCase();' name='codigo' value='"+codigo_ciclo+"' style='width: 100%;'/></div>";
		mensaje += "<div style='display:inline-block; width:20%; margin-left: 40px;' ><label >D&iacute;as</label>";
		mensaje += "<input type='text' readonly='readonly' class='horas' name='horas' value='7' style='width: 40%;'/></div>";
		mensaje += "<div><label >Observaciones</label><input type='text' name='obser' id='obser' style='width: 90%;' value='"+obs_ciclo+"'/> </div>";
		mensaje += "<div><table class='tableone table-bordered' border='0' id='ciclos_new'>";
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
		mensaje += "<tr style='cursor:pointer; text-align: center;'>";
		mensaje += "<td height='30px' class='list_t' id='c1'>"+uno_ciclo+"</td>";
		mensaje += "<input type='hidden' id='b1' value='' />"
		mensaje += "<td height='30px' class='list_t' id='c2'>"+dos_ciclo+"</td>";
		mensaje += "<input type='hidden' id='b2' value='' />"
		mensaje += "<td height='30px' class='list_t' id='c3'>"+tres_ciclo+"</td>";
		mensaje += "<input type='hidden' id='b3' value='' />"
		mensaje += "<td height='30px' class='list_t' id='c4'>"+cuatro_ciclo+"</td>";
		mensaje += "<input type='hidden' id='b4' value='' />"
		mensaje += "<td height='30px' class='list_t' id='c5'>"+cinco_ciclo+"</td>";
		mensaje += "<input type='hidden' id='b5' value='' />"
		mensaje += "<td height='30px' class='list_t' id='c6'>"+seis_ciclo+"</td>";
		mensaje += "<input type='hidden' id='b6' value='' />"
		mensaje += "<td height='30px' class='list_t' id='c7'>"+siete_ciclo+"</td>";
		mensaje += "<input type='hidden' id='b7' value='' />"
		mensaje += "<td height='30px' id='tot_hora'>"+horas_ciclo+"</td>";
		mensaje += "</tr>";
		mensaje += "</tbody>";
		mensaje += "</table></div>";
		mensaje += "<input type='hidden' id='cod_old' value='"+codigo_ciclo+"' />"
		mensaje += "<div class='validar' style='color:#fff !important; text-align:center; margin-top: 20px;'></div>";
		mensaje += "<input type='hidden' id='centro_script' value='"+$('#centro_costo').val()+"' />"
		mensaje += "<div style='margin-top:5%; text-align:center;'><input id='editar_ciclo' type='button' class='btn btn-primary' value='Editar Ciclo'/></div>";
		mensaje += "</form>";
		mensaje += "</div>";
		
	   modals("Editar Ciclo  <i class='icon-calendar' ></i>",mensaje);

				$(".list_t").popover({
					title: "",
					content: ""
				});
				$(".list_t").click(function(event) {
					event.preventDefault();
					event.stopPropagation();
					var param=$(this).attr("id");
					
					$(this).popover(
						"ajax",
						"ajax_catalogo_turnos.php?param="+param
						
					).popover('show');
								
					var codigos=['c1','c2','c3','c4','c5','c6','c7'];
					if(param == codigos[0]){
						$("#c2, #c3, #c4, #c5, #c6, #c7").popover('hide');
					}else if(param == codigos[1]){
						$("#c1, #c3, #c4, #c5, #c6, #c7").popover('hide');
					}else if(param == codigos[2]){
						$("#c1, #c2, #c4, #c5, #c6, #c7").popover('hide');
					}else if(param == codigos[3]){
						$("#c1, #c3, #c2, #c5, #c6, #c7").popover('hide');
					}else if(param == codigos[4]){
						$("#c1, #c3, #c2, #c4, #c6, #c7").popover('hide');
					}else if(param == codigos[5]){
						$("#c1, #c3, #c2, #c4, #c5, #c7").popover('hide');
					}else if(param == codigos[6]){
						$("#c1, #c3, #c2, #c4, #c5, #c6").popover('hide');
					}
				});
			
		$("#editar_ciclo").click(editar_ciclo);                                           
}

function editar_ciclo(){

	if($('.codigo').val() == 0 || $('#c1').html()=='' || $('#c2').html()=='' || $('#c3').html()=='' ||
	   $('#c4').html()=='' || $('#c5').html()=='' || $('#c6').html()=='' || $('#c7').html()==''){
	
		$('.validar').html("<span class='mensajes_error'>Existen campos vac&iacute;os</span>");
		return false;
		
	}else{
		$('.validar').html("");
	
		$.ajax({
			url:'editar_ciclo.php',
			type:'POST',
			data:'cod_old='+$('#editar_turno #cod_old').val()+'&codigo_turno='+$('.codigo').val()+'&obser='+$('#obser').val()+'&td1='+$('#c1').html()+'&td2='+$('#c2').html()+'&td3='+$('#c3').html()+'&td4='+$('#c4').html()+'&td5='+$('#c5').html()+'&td6='+$('#c6').html()+'&td7='+$('#c7').html()+"&horas="+$("#tot_hora").html()+"&cod_cc2="+$('#centro_script').val(),
			dataType:'html',
			success:function(data){
			
				$('.codigo').val('');
				$('#obser').val('');
				$('.list_t, #tot_hora').html('');
				$('#ciclos_new input[type="hidden"]').val('');
				$('.validar').html(data);
				$("#contenido").html('');
				$('.codigo').attr('disabled','disabled');
				$('#obser').attr('disabled','disabled');
				$("#editar_ciclo").attr("disabled","disabled");
				$(".list_t").popover('destroy');
				$("#contenido").load('ciclos_catalogo.php');
				$('.list_t, #tot_hora').attr('bgcolor','#eee');
			}
		});
		
		return false;
	}

}

function modaleliminar_ciclo(){

	var cuanto=$(".codigo_ciclo").length;
			
	if(cuanto>0){
		var codigo_ciclo=$(".codigo_ciclo").html();
		var uno_ciclo=$(".uno_ciclo").html();
		var dos_ciclo=$(".dos_ciclo").html();
		var tres_ciclo=$(".tres_ciclo").html();
		var cuatro_ciclo=$(".cuatro_ciclo").html();
		var cinco_ciclo=$(".cinco_ciclo").html();
		var seis_ciclo=$(".seis_ciclo").html();
		var siete_ciclo=$(".siete_ciclo").html();
		var obs_ciclo=$(".obs_ciclo").html();
		var horas_ciclo=$(".horas_ciclo").html();	
	}

	var	mensaje = '<div id="usuario_n" style="color: rgb(0,0,0); text-align: left;">';
		mensaje += '<div class="mensaje-alert" style="text-align:center; margin-bottom: 6%;">';
		mensaje += '<p style="color:red; font-size: 170%; font-weight: bold;">¿Seguro desea eliminar el ciclo?</p>';
		mensaje += '</div>';
	    mensaje += "<form id='editar_turno'>";
		mensaje += "<div style='display:inline-block; width:20%' ><label >C&oacute;digo del Ciclo</label>";
		mensaje += "<input type='text' class='codigo' readonly='readonly' name='codigo' value='"+codigo_ciclo+"' style='width: 100%;'/></div>";
		mensaje += "<div style='display:inline-block; width:20%; margin-left: 40px;' ><label >D&iacute;as</label>";
		mensaje += "<input type='text' readonly='readonly' class='horas' name='horas' value='7' style='width: 40%;'/></div>";
		mensaje += "<div><label >Observaciones</label><input type='text' name='obser' id='obser' readonly='readonly' style='width: 90%;' value='"+obs_ciclo+"'/> </div>";
		mensaje += "<div><table class='tableone table-bordered' border='0' id='ciclos_new'>";
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
		mensaje += "<tr style='cursor:pointer; text-align: center;'>";
		mensaje += "<td height='30px' class='list_t'  bgcolor='#eee'>"+uno_ciclo+"</td>";
		mensaje += "<td height='30px' class='list_t'  bgcolor='#eee'>"+dos_ciclo+"</td>";
		mensaje += "<td height='30px' class='list_t'  bgcolor='#eee'>"+tres_ciclo+"</td>";
		mensaje += "<td height='30px' class='list_t'  bgcolor='#eee'>"+cuatro_ciclo+"</td>";
		mensaje += "<td height='30px' class='list_t'  bgcolor='#eee'>"+cinco_ciclo+"</td>";
		mensaje += "<td height='30px' class='list_t'  bgcolor='#eee'>"+seis_ciclo+"</td>";
		mensaje += "<td height='30px' class='list_t'  bgcolor='#eee'>"+siete_ciclo+"</td>";
		mensaje += "<td height='30px' id='tot_hora' bgcolor='#eee'>"+horas_ciclo+"</td>";
		mensaje += "</tr>";
		mensaje += "</tbody>";
		mensaje += "</table></div>";
		mensaje += "<input type='hidden' id='cod_old' value='"+codigo_ciclo+"' />"
		mensaje += "<div class='validar' style='color:#fff !important; text-align:center; margin-top: 20px;'></div>";
		mensaje += "<input type='hidden' id='centro_script' value='"+$('#centro_costo').val()+"' />"
		mensaje += "<div style='margin-top:5%; text-align:center;'><input id='eliminar_ciclo' type='button' class='btn btn-primary' value='Eliminar Ciclo'/></div>";
		mensaje += "</form>";
		mensaje += "</div>";
		
	   modals("Eliminar Ciclo  <i class='icon-trash' ></i>",mensaje);


		$("#eliminar_ciclo").click(eliminar_ciclo); 
}


function eliminar_ciclo(){

	$.ajax({
			url:'eliminar_ciclo.php',
			type:'POST',
			data:'cod_old='+$('#cod_old').val()+"&cod_cc2="+$('#centro_script').val(),
			dataType:'html',
			success:function(data){
				$('.validar').html(data);
				$("#contenido").html('');
				$("#editar_turno").css("disabled","disabled");
				$("#eliminar_ciclo").attr("disabled","disabled");
				$("#contenido").load('ciclos_catalogo.php');	
			}
		});
		
		return false;
}

function filtros(){

	var recibe=$(this).val();
	var detector=$(this).attr('name');
	

	
	$('#ciclos tr').show();
	
	if(recibe.length>0 && detector=='codigo'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#ciclos tr td.codigos").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='hora'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#ciclos tr td.horas").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='lunes'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#ciclos tr td.uno").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='martes'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#ciclos tr td.dos").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='miercoles'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#ciclos tr td.tres").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='jueves'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#ciclos tr td.cuatro").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='viernes'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#ciclos tr td.cinco").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='sabado'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#ciclos tr td.seis").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='domingo'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#ciclos tr td.siete").not(":Contains('"+recibe+"')").parent().hide();
	}
	
	return false;
}
/*
function filtros_new(e){
	alert(e.type);
	$('.letras').focus_lost(function() {
	  $(this).show();
	});
	$(':input:visible:enabled:first').focus();

	var ok=$("#sies").text();
	alert(ok);
	return false;
	}
*/



/*Modal principal que agarra el html de crear, editar, eliminar*/
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

/*Funcion para cargar la interfaz de crear Ciclo*/
function modalcrear_ciclo(){
	var	mensaje = '<div id="usuario_n" style="color: rgb(0,0,0); text-align: left;">';
	    mensaje += "<form id='nuevo_turno'>";
		mensaje += "<div style='display:inline-block; width:20%' ><label >C&oacute;digo del Ciclo</label>";
		mensaje += "<input type='text' class='codigo' onkeyup='this.value=this.value.toUpperCase();' name='codigo' value='' style='width: 100%;'/></div>";
		mensaje += "<div style='display:inline-block; width:20%; margin-left: 40px;' ><label >D&iacute;as</label>";
		mensaje += "<input type='text' readonly='readonly' class='horas' name='horas' value='7' style='width: 40%;'/></div>";
		mensaje += "<div><label >Observaciones</label><input type='text' name='obser' id='obser' style='width: 90%;'/> </div>";
		mensaje += "<div><table class='tableone table-bordered' border='0' id='ciclos_new'>";
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
		mensaje += "<tr style='cursor:pointer; text-align: center;'>";
		mensaje += "<td height='30px' class='list_t' id='c1'></td>";
		mensaje += "<input type='hidden' id='b1' value='0' />"
		mensaje += "<td height='30px' class='list_t' id='c2'></td>";
		mensaje += "<input type='hidden' id='b2' value='0' />"
		mensaje += "<td height='30px' class='list_t' id='c3'></td>";
		mensaje += "<input type='hidden' id='b3' value='0' />"
		mensaje += "<td height='30px' class='list_t' id='c4'></td>";
		mensaje += "<input type='hidden' id='b4' value='0' />"
		mensaje += "<td height='30px' class='list_t' id='c5'></td>";
		mensaje += "<input type='hidden' id='b5' value='0' />"
		mensaje += "<td height='30px' class='list_t' id='c6'></td>";
		mensaje += "<input type='hidden' id='b6' value='0' />"
		mensaje += "<td height='30px' class='list_t' id='c7'></td>";
		mensaje += "<input type='hidden' id='b7' value='0' />"
		mensaje += "<td height='30px' id='tot_hora'>0</td>";
		mensaje += "</tr>";
		mensaje += "</tbody>";
		mensaje += "</table></div>";
		mensaje += "<div class='validar' style='color:#fff !important; text-align:center; margin-top: 20px;'></div>";
		mensaje += "<input type='hidden' id='centro_script' value='"+$('#centro_costo').val()+"' />"
		mensaje += "<div style='margin-top:5%; text-align:center;' id='esconder_ciclo'><input id='crear_ciclo' type='button' class='btn btn-primary' value='Crear Ciclo'/></div>";
		mensaje += "</form>";
		mensaje += "</div>";
		
	   modals("Ciclo Nuevo  <i class='icon-calendar' ></i>",mensaje);

				$(".list_t").popover({
					title: "",
					content: ""
				});
				$(".list_t").click(function(event) {
					event.preventDefault();
					event.stopPropagation();
					var param=$(this).attr("id");
					
					$(this).popover(
						"ajax",
						"ajax_catalogo_turnos.php?param="+param
						
					).popover('show');
								
					var codigos=['c1','c2','c3','c4','c5','c6','c7'];
					if(param == codigos[0]){
						$("#c2, #c3, #c4, #c5, #c6, #c7").popover('hide');
					}else if(param == codigos[1]){
						$("#c1, #c3, #c4, #c5, #c6, #c7").popover('hide');
					}else if(param == codigos[2]){
						$("#c1, #c2, #c4, #c5, #c6, #c7").popover('hide');
					}else if(param == codigos[3]){
						$("#c1, #c3, #c2, #c5, #c6, #c7").popover('hide');
					}else if(param == codigos[4]){
						$("#c1, #c3, #c2, #c4, #c6, #c7").popover('hide');
					}else if(param == codigos[5]){
						$("#c1, #c3, #c2, #c4, #c5, #c7").popover('hide');
					}else if(param == codigos[6]){
						$("#c1, #c3, #c2, #c4, #c5, #c6").popover('hide');
					}
				});
			
		$("#crear_ciclo").click(crear_ciclo);
}

function copiar_turn(id,param,horas){
	
	if(param=='c1'){
		$("#b1").val(horas);

	}else if(param== 'c2'){
		
		$("#b2").val(horas);
		
		var b1=$("#c1").html();
		
		if(typeof(b1) != undefined){
		
			var b2=id;

		}	
	
	}else if(param== 'c3'){
		$("#b3").val(horas);
		
		var b1=$("#c2").html();
		
		if(typeof(b1) != undefined){
		
			var b2=id;
			var b3=$("#c1").html();

		}	
	
	}else if(param== 'c4'){
		$("#b4").val(horas);
		
		var b1=$("#c3").html();
		
		if(typeof(b1) != undefined){
		
			var b2=id;
	       var b3=$("#c2").html();
		}	

	}else if(param== 'c5'){
		$("#b5").val(horas);
		
		var b1=$("#c4").html();
		
		if(typeof(b1) != undefined){
		
			var b2=id;
			var b3=$("#c3").html();

		}	
	
	}else if(param== 'c6'){
		$("#b6").val(horas);
		
		var b1=$("#c5").html();
		
		if(typeof(b1) != undefined){
		
			var b2=id;
			var b3=$("#c4").html();
			

		}	
	
	}else if(param== 'c7'){
		$("#b7").val(horas);
		
		var b1=$("#c6").html();
		
		if(typeof(b1) != undefined){
		
			var b2=id;
			var b3=$("#c5").html();

		}	
	
	}
	

		/*traigo el parametro maximo de horas para ciclos*/
		$.ajax({
			url:'verificar_parametros.php',
			type:'POST',
			data:"info="+2,
			dataType:'json',
			success:function(data){
				
				var sumatoria=Number($("#b1").val())+Number($("#b2").val())+Number($("#b3").val())+Number($("#b4").val())+Number($("#b5").val())+Number($("#b6").val())+Number($("#b7").val());
				$("#tot_hora").html(sumatoria);
				 
			     var p=comprobar();
				 
				 //console.log(p);
				 
				if($("#c1").html() == ""){
				
					$('.validar').html('<span class="error" style="color:white; background-color:red; padding:2px;">Porfavor llenar la primera casilla</span>');
					$("#crear_ciclo").attr("disabled","disabled");
					
				
				}else if(p > 1){
					
					$('.validar').html('<span class="error" style="color:white; background-color:red; padding:2px;">El turno no debe ser superior a 8 horas, comuniquese con el administrador</span>');
					$("#crear_ciclo").attr("disabled","disabled");
					
					
				
				}else{
					
					
						if(sumatoria > data.t_hor_min_ciclos){
				
						$('.validar').html('<span class="error" style="color:white; background-color:red; padding:2px;">El ciclo no debe ser superior a '+data.t_hor_min_ciclos+' horas, comuniquese con el administrador</span>');
						$("#crear_ciclo").attr("disabled","disabled");
						
						$(".list_t").popover('fadeOut');
						
						}else{
							
							$('.validar').html('');
							$("#crear_ciclo").removeAttr("disabled");
						}
					 
					 
					
					 
					 
					
				
				}
				
			
				
			}
		});
	
	
	
	$("#"+param).html(id);
	$(".list_t").popover('fadeOut');
	return false;
}

/*function comprobar(b1,b2){

	var jqXHR =	$.ajax({
			url:'verificar_parametros.php',
			type:'POST',
			data:"info="+3+"&ciclo1="+b1+"&ciclo2="+b2,
			async: false
			
		});
	 return jqXHR.responseText;
}*/

function comprobar(){
	
	var contador=1;
	
	var c1="";
	var c2="";
	
	while(contador <=7){
		
		//var p=contador;

		if(contador ==1 ){
		
			c1=$("#c"+contador+"").html();
		    c2=$("#c"+(contador+1)+"").html();
			
			//console.log(c1+"  "+c2+" hola1");
			//console.log(contador);

		}else if(contador > 1){
		
			c1=$("#c"+(contador-1)+"").html();
		    c2=$("#c"+contador+"").html();
		
			//console.log(c1+"  "+c2+" hola2");
			//console.log(contador);
		}
		
		
		var jqXHR =	$.ajax({

			url:'verificar_parametros.php',
			type:'POST',
			data:"info="+3+"&ciclo1="+c1+"&ciclo2="+c2,
			async: false
			
		});
		
		console.log(jqXHR.responseText+" respuesta del server"); 
		
		if(jqXHR.responseText  > 1){
		
			return jqXHR.responseText;
		}else if(jqXHR.responseText ==1){
			contador++;
		}
		
		
		//var p=jqXHR.responseTex;
		
		//console.log(p);
		
		/*if(p!='1'){
		
			//console.log(p);
		
		}else{
		
			//console.log("hola2");
		
		}*/
		/*if(Number(jqXHR.responseTex) != 1){
			//console.log(c1+"  "+c2);
		     break; 
			//console.log(contador);
			//break;
		}*/
		//console.log(contador);
			
		
	}
	
	//return jqXHR.responseTex;;
}


function crear_ciclo(){

	
	if($('.codigo').val() == 0 || $('#c1').html()=='' || $('#c2').html()=='' || $('#c3').html()=='' ||
	   $('#c4').html()=='' || $('#c5').html()=='' || $('#c6').html()=='' || $('#c7').html()==''){
	
		$('.validar').html("<span class='mensajes_error'>Existen campos vac&iacute;os</span>");
		return false;
		
	}else{
		
		$('.validar').html("");
	
		$.ajax({
			url:'nuevo_ciclo.php',
			type:'POST',
			data:'codigo_turno='+$('.codigo').val()+'&obser='+$('#obser').val()+'&td1='+$('#c1').html()+'&td2='+$('#c2').html()+'&td3='+$('#c3').html()+'&td4='+$('#c4').html()+'&td5='+$('#c5').html()+'&td6='+$('#c6').html()+'&td7='+$('#c7').html()+"&horas="+$("#tot_hora").html()+"&cod_cc2="+$('#centro_script').val(),
			dataType:'html',
			success:function(data){
				//console.log(data); return false;
				$('.codigo').val('');
				$('#obser').val('');
				$('.list_t, #tot_hora').html('');
				$('#ciclos_new input[type="hidden"]').val('');
				$('.validar').html(data);
				$("#contenido").html('');
				$("#contenido").load('ciclos_catalogo.php');
			}
		});
		
		return false;
	}
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

function imprimir_contenido(){
  window.open("imprimir_ciclo.php", '_blank');
}


