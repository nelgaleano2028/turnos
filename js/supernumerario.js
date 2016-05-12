$(document).ready(main);
function main(){

	$('.tabla #supernumerario input').keyup(filtros);
	$('.tabla #empleados input').keyup(filtros1);
	$('.tabla #externos input').keyup(filtros2);
	$('.tabla #admin input').keyup(filtros3);
	
	
	$("#enviar").click(function(){
		
		if($(".seleccionar").is(':checked')) {
		
			$.ajax({
	
				url:'agregar_supernumerario.php',
				type:'POST',
				cache:false,
				async:true,
				data:$('#super').serialize(),
				beforeSend:function(){
			
					$("#content").html("<h1 id='cerrar_se'>Espere Por favor<span>.</span><span>.</span><span>.</span></h1>");
				},
				success:function(data){
					var mensaje="Se han guardado correctamente";
					modal_alert(mensaje,function(){$('#myModal2').modal('hide');});
					
					$.ajax({
						url:'nuevo_supernumerario.php',
						type:"post",
						beforeSend:function(){
						
							$("#content").html("<h1 id='cerrar_se'>Espere Por favor<span>.</span><span>.</span><span>.</span></h1>");
						
						},
						success:function(data){
							
							$('#content').html(data);
						}
					
					});
				}
			});
		
		}else{
			
			var mensaje="No ha seleccionado ningun empleado";
			modal_alert(mensaje,function(){$('#myModal2').modal('hide');});
		}
		
		return false;
	});
	
	/*====================================================
		Algoritmo para activar/inactivar supernumerarios
	=======================================================*/
	var contar=Number($('.contar').length);
	for(u=0;u<contar;u++){

		$(".seleccionar_"+u+"").click(function(){ 

			var a= Number($(".selecionar").length);
				var h = $(this).attr("id");
			if(a > 0){

					$(".selecionar").removeClass("selecionar");
					$("#activar").attr("disabled","disabled");
					$(".cedula_super").removeClass("cedula_super");
					$(".nombre_super").removeClass("nombre_super");
					$(".costo_super").removeClass("costo_super");
					$(".cargo_super").removeClass("cargo_super");
					$(".estado_super").removeClass("estado_super");
										
			}else{
				$(this).toggleClass("selecionar");
				$("#activar").removeAttr("disabled");
				$(".cedula_"+h+"").addClass("cedula_super");
				$(".nombre_"+h+"").addClass("nombre_super");
				$(".costo_"+h+"").addClass("costo_super");
				$(".cargo_"+h+"").addClass("cargo_super");
				$(".estado_"+h+"").addClass("estado_super");
			}
		
		});
	}
	
	/*====================================================
		Algoritmo para Editar/eliminar movimiento del supernumerario
	=======================================================*/
	var contar_admin=Number($('.contar_admin').length);
	for(u=0;u<contar_admin;u++){

		$(".seleccionarad_"+u+"").click(function(){ 

			var a= Number($(".selesuper").length);
				var h = $(this).attr("id");
			if(a > 0){

					$(".selesuper").removeClass("selesuper");
					$("#editar_adm").attr("disabled","disabled");
					$("#eliminar_adm").attr("disabled","disabled");
					$(".id_super").removeClass("id_super");
					$(".cedula_super").removeClass("cedula_super");
					$(".reempla").removeClass("reempla");
					$(".area").removeClass("area");
					$(".ingreso").removeClass("ingreso");
					$(".super").removeClass("super");
					$("fecini").removeClass("fecini");
					$("fecfin").removeClass("fecfin");
					$("jefe").removeClass("jefe");
					$("obser").removeClass("obser");
					$("baja").removeClass("baja");
					
										
			}else{
				$(this).toggleClass("selesuper");
				$("#editar_adm").removeAttr("disabled");
				$("#eliminar_adm").removeAttr("disabled");
				$(".idsuper_"+h+"").addClass("id_super");
				$(".reemplazo_"+h+"").addClass("reempla");
				$(".baja_"+h+"").addClass("baja");
				$(".area_"+h+"").addClass("area");
				$(".ingreso_"+h+"").addClass("ingreso");
				$(".super_"+h+"").addClass("super");
				$(".fecini_"+h+"").addClass("fecini");
				$(".fecfin_"+h+"").addClass("fecfin");
				$(".jefe_"+h+"").addClass("jefe");
				$(".obser_"+h+"").addClass("obser");
				
			}
		
		});
	}
	
	
	$("#activar").click(function(){
		    var estado=$(".estado_super").html();
			if(estado=='Activo'){ var mensaje_estado='Inactivar'}else{ var mensaje_estado='Activar'}
		    confirm_dialog(mensaje_estado);		
	});
	
	
	$("#correo").click(correo_turno);
	$("#imprimir").click(function(){ imprimir_contenido("imprimir_supernumerario.php");});
	
	/*Administrar supernumerarios*/
	$("#nuevo_adm").click(addCargos_supernumerarios);
	$("#correo_adm").click(correo_supernumerario);
	$("#editar_adm").click(editar_movimiento);
	$("#imprimir_adm").click(function(){ imprimir_contenido("imprimir_det_supernumerario.php");});
	
	/*Eliminar programacion de supernumerario*/
	$("#eliminar_adm").click(function(){
			var fecha=$(".fecini").html();
			var mensaje= "¿Desea eliminar este registro?";
			
			modal_alert(mensaje,function(){ 
				var ida = $(".id_super").attr("id");
				$.ajax({
					url:"eliminar_movimiento_supernumario.php",
					data:"id="+ida+"&fecha="+fecha,
					type:"post",
					success:function(data){
						
						$("#aceptar").css("visibility","hidden");
						$("#mensaje p").html(data);
						//$(".selesuper").remove();
						//$("#content").load('admin_supernumerario.php');
						$("#editar_adm").attr("disabled","disabled");
						$("#eliminar_adm").attr("disabled","disabled");
						
						$("#content").load('admin_supernumerario.php');
															
								
						setTimeout(function() {
									$('#myModal2').modal('hide');	
								}, 1700);
						
					}
				});
				
			});
			return false;
	});
	
}

/*Funcion para editar los movimientos de reemplazo/cubrimiento supernumerario*/
function editar_movimiento(){
	
	//console.log("hola");
	var id = $(".id_super").attr("id");
	
	if(id !=0 ){
		
		$.ajax({
			url:"movimiento_super.php",
			type:"post",
			data:"id="+id,
			success:function(data){
				//document.write(data);
				if(data=='REEMPLAZO'){
					reemplazo(id);	// callback para el modal reemplazo
				}else if(data=='CUBRIMIENTO'){
					cubrimiento(id);
				}
			}
		});
	
		return false;
	}
	
}

/*funcion para el modal si al elegir un registro de la tabla administracion supernumerarios muestre el form de cubrimiento*/
function cubrimiento(id){
	var cuanto=$(".reempla").length;	
	if(cuanto>0){
		var reemplazo=$(".reempla").html();
		var baja=$(".baja").html();
		var area=$(".area").html();
		var ingreso=$(".ingreso").html();
		var supernumera=$(".super").html();
		var fec_ini=$(".fecini").html();
		var fec_fin=$(".fecfin").html();
		var jefe=$(".jefe").html();
		var obser=$(".obser").html();
		var supernumerario='supernumerarios';
		var fecha= new Date();
		var dia=fecha.getDate();
		var mes=fecha.getMonth();
		var anio=fecha.getFullYear();
		
		$.ajax({
			url:"movimiento_traer_cubri.php",
			type:"post",
			dataType:'json',
			data:"id="+id,
			success:function(data){
				console.log(data);
				var area2=data[0].cod_cc2;
				var jefe2=data[0].cod_epl_jefe;
				var supernumerario2=data[0].cod_epl_super;
				var tipobaja2=data[0].tipo_baja; 
				var cod_car=data[0].cod_car;
				var nom_car=data[0].nom_car;
				
				var supernumerario='supernumerarios';
				var fecha= new Date();
				var dia=fecha.getDate();
				var mes=fecha.getMonth() + 1;
				var anio=fecha.getFullYear();
				
				var contenido="";
				contenido+='<div id="cubrimiento">';
				contenido+='<div id="obligatorio2" style="color:red; text-align:center; display:none;" id="obligatorio">Los campos con (*) son requeridos</div>';
				contenido+='<form class="form-horizontal" style="color:black" id="cubri_form">';
				contenido+='<div class="control-group">';
				contenido+='<label class="control-label" >Supernumerario</label>';
				contenido+='<div class="controls">';
				contenido+='<label class="cubri_super">'+supernumera+'</label><input type="hidden" name="cubri_super" id="cubri_super" value='+supernumerario2+' />';
				contenido+='</div>';
				contenido+='</div>';
				contenido+='<div class="control-group">';
				contenido+='<label class="control-label" >Jefe de Proceso</label>';
				contenido+='<div class="controls">';
				contenido+='<select id="cubri_jefe" name="cubri_jefe"><option>Seleccione..</option></select>';
				contenido+='</div>';
				contenido+='</div>';
				contenido+='<div class="control-group">';
				contenido+='<label class="control-label">&Aacute;rea</label>';
				contenido+='<div class="controls">';
				contenido+='<select id="cubri_area" name="cubri_area"><option value="'+area2+'">'+area+'</option></select>';
				contenido+='</div>';
				contenido+='</div>';
								
				contenido+='<div class="controls-row" style="margin-left: 118px;">';
				contenido+='<span class="help-inline cubri_fecini" style=" color: black;">Inicial </span>';
				contenido+='<div class="input-append date" id="fec_inir2" data-date="'+dia+'-'+mes+'-'+anio+'" data-date-format="dd-mm-yyyy" style="margin-left: 20px; max-width: 100px;"> ';
				contenido+='<input class="span2" size="16" type="text" value="'+fec_ini+'" name="cubri_fecini" id="cubri_fecini"/>';
				contenido+='<span class="add-on"><i class="icon-th"></i></span>';
				contenido+='</div>';
				contenido+='<span class="help-inline cubri_fecfin" style="margin-left: 91px; color: black;">Final </span>';
				
				contenido+='<div class="input-append date" id="fec_finr2" data-date="'+dia+'-'+mes+'-'+anio+'" data-date-format="dd-mm-yyyy" style="margin-left: 20px; max-width: 100px;"> ';
				contenido+=' <input class="span2" size="16" type="text" value="'+fec_fin+'" name="cubri_fecfin" id="cubri_fecfin"/>';
				contenido+='<span class="add-on"><i class="icon-th"></i></span>';
				contenido+='</div>';
				contenido+='</div><br>';
				
				contenido+='<div class="control-group">';
				contenido+='<label class="control-label">Observaciones</label>';
				contenido+='<div class="controls">';
				contenido+='<textarea style="margin: 0px; max-width: 526px; height: 78px; width: 529px;" name="cubri_observa" id="cubri_observa">'+obser+'</textarea>';
				contenido+='</div>';
				contenido+='</div>';
				contenido+='<input type="hidden" value="'+id+'" name="id_super_nov">';
				contenido+='<div style="text-align: center;">';
				contenido+='<input type="submit" class="btn btn-primary" id="cubri" value="Aceptar"/>';
				contenido+='</div>';
				
				contenido+='</form>';	
				contenido+='</div>';
				
				modals_supernumerario_admin("Editar Cubrimiento<i class='icon-retweet' ></i>",contenido);
				$("#cubri_tipo").chosen({width:"95%"});
				$("#cubri_jefe").chosen({width:"95%"});
				$("#cubri_area").chosen({width:"95%"});
				validar_fechas('cubri_fecini','cubri_fecfin');
				$('#cubri_fecini').datepicker({ format: 'dd-mm-yyyy'});
				$('#cubri_fecfin').datepicker({format: 'dd-mm-yyyy'});
				
				
				$.ajax({
						url:"get_all_jefe.php",
						type:"post",
						data:"supernume="+supernumerario+"&data1="+jefe2+"&data2="+jefe,
						success:function(data){
							$("#cubri_jefe").html(data);
							$("#cubri_jefe").trigger("liszt:updated");
						}
				});
				
				$("#cubri_jefe").change(function(){
	
					var id=$(this).val();
					$.ajax({
						url:"select_jefe_areas.php",
						type:"post",
						data:"id="+id,
						success:function(data){
							
							$("#cubri_area").html(data);
							$("#cubri_area").trigger("liszt:updated");
						}
					});
				});
				
				/*update para el cubrimiento*/
				$("#cubri").click(function(){
					
					$("#obligatorio2").css("display","block");
					
					$(".error").remove();
					if($("#cubri_form select").val() == 0 ){
						
						$("#cubri_form select").after("<span class='error' style='color:red; font-size:16px;'> * </span>");
						return false;
						
					}else if($("#cubri_form #cubri_fecini").val() == ""){
						
					
						$("#cubri_form .cubri_fecini").after("<span class='error' style='color:red; font-size:16px;'> *</span>");
						
						return false;
					}else if($("#cubri_form #cubri_fecfin ").val() == ""){
						
					
						$("#cubri_form .cubri_fecfin").after("<span class='error' style='color:red; font-size:16px;'> *</span>");
						
						return false;
					}else{
						
						$("#obligatorio2").css("display","none");
						$("#cubri_form").hide("slow");
						var contenido="";
								contenido+='<div class="alert alert-info" style="text-align:center;">';
										contenido+='<h4>Informaci&oacute;n!</h4>';
										contenido+='<p>Est&aacute; seguro de este movimiento?</p>';
										contenido+='<p><input class="btn btn-primary" type="button" id="aceptar_cubri" value="Aceptar"/>';
										contenido+='<input class="btn btn-primary" type="button" id="cancelar_cubri" value="Cancelar" style="margin-left:10px;"/></p>';
										contenido+='</div>';
						$("#cubrimiento").append(contenido);
						
						$("#aceptar_cubri").click(function(){
						
							$.ajax({
								url:"update_movsuper.php",
								type:"post",
								data:$("#cubri_form").serialize(),
								success:function(data){
									$(".alert").remove();
									if(data==1){
										var contenido="";
											contenido+='<div class="alert alert-success" style="text-align:center;">';
											contenido+='<h4>Informaci&oacute;n!</h4>';
											contenido+='<p>Se Actualiza correctamente</p>';
											contenido+='<a href="#" style="color:#fff;"  id="aceptar_cofirm" class="btn btn-primary">Aceptar</a>';
											contenido+='</div>';
											$("#cubrimiento").append(contenido);
											$("#content").load('admin_supernumerario.php');
											$("#aceptar_cofirm").click(function(){
											
												$('#myModal4').modal('hide');
												
											 });
									}else if(data==3){
					
										var contenido="";
											contenido+='<div class="alert alert-error" style="text-align:center;">';
											contenido+='<h4>Informaci&oacute;n!</h4>';
											contenido+='<p>El supernumerario esta haciendo un Reemplazo</p>';
											contenido+='<a href="#" style="color:#fff;"  id="aceptar_cofirm" class="btn btn-primary">Aceptar</a>';
											contenido+='</div>';
											$("#cubrimiento").append(contenido);
											$("#aceptar_cofirm").click(function(){
											
												$('#myModal4').modal('hide');
												
											 });
										
									}else if(data==4){
									
										var contenido="";
											contenido+='<div class="alert alert-error" style="text-align:center;">';
											contenido+='<h4>Informaci&oacute;n!</h4>';
											contenido+='<p>El supernumerario esta haciendo un cubrimiento</p>';
											contenido+='<a href="#" style="color:#fff;"  id="aceptar_cofirm" class="btn btn-primary">Aceptar</a>';
											contenido+='</div>';
											$("#cubrimiento").append(contenido);
											$("#aceptar_cofirm").click(function(){
											
												$('#myModal4').modal('hide');
												
											 });
										
									}else{
										var contenido="";
											contenido+='<div class="alert alert-error" style="text-align:center;">';
											contenido+='<h4>Alerta!</h4>';
											contenido+='<p>No Se Actualiza correctamente Contacta al administrador</p>';
											contenido+='<a href="#" style="color:#fff;"  id="aceptar_cofirm" class="btn btn-primary">Aceptar</a>';
											contenido+='</div>';
											$("#cubrimiento").append(contenido);
								
											$("#aceptar_cofirm").click(function(){
											
												$('#myModal4').modal('hide');
												
											 });
									}
									return false;
								}
							});
						
						});
					
						
						$("#cancelar_cubri").click(function(){		
							$(".alert").remove();
							$("#cubri_form").show("slow");
						});
								
						return false;
					}
				});
			}
		});
		
	}

}

/*funcion para el modal si al elegir un registro de la tabla administracion supernumerarios muestre el form de reemplazo*/
function reemplazo(id){

	//console.log(id); 
	var cuanto=$(".selesuper").length;
	
	if(cuanto>0){
		var reemplazo=$(".reempla").html();
		
		var baja=$(".baja").html();
		//var area=$(".area").html();
		var ingreso=$(".ingreso").html();
		//var supernumera=$(".super").html();
		var fec_ini=$(".fecini").html();
		var fec_fin=$(".fecfin").html();
		//var jefe=$(".jefe").html();
		var obser=$(".obser").html();
		
		$.ajax({
			url:"movimiento_traer.php",
			type:"post",
			dataType:'json',
			data:"id="+id,
			success:function(data){
				//console.log(data); 
				//console.log(data[0].nom_car);
			   var area=data[0].nom_cc2;
			   var area2=data[0].centro_costo2;
			   var jefe2=data[0].cod_epl_jefe;
			   var jefe=data[0].jefe;
			   var reemplazo2=data[0].cod_epl_reemp;
			   var supernumerario2=data[0].cod_epl_super;
			   var tipobaja2=data[0].nombre_baja;
               var tipo_baja=data[0].tipo_baja			   
			   var cod_car=data[0].cod_car;
			   var nom_car=data[0].nom_car;
			   var supernumerario='supernumerarios';
			   var supernumera=data[0].supernumerario
				var fecha= new Date();
				var dia=fecha.getDate();
				var mes=fecha.getMonth() + 1;
				var anio=fecha.getFullYear();

							var contenido="";
							contenido+='<div id="reemplazo">';
							contenido+='<div id="obligatorio" style="color:red; text-align:center; display:none;">Los campos con (*) son requeridos</div>';
							contenido+='<form class="form-horizontal" style="color:black" id="reemplazo_form">';
							contenido+='<div class="control-group">';
							contenido+='<label class="control-label" for="inputsupernumerario" >Supernumerario</label>';
							contenido+='<div class="controls">';
							contenido+='<label class="inputsupernumerario">'+supernumera+'</label><input type="hidden" name="cod_epl_super" id="inputsupernumerario" value='+supernumerario2+' />';
							contenido+='</div>';
							contenido+='</div>';
							contenido+='<div class="control-group">';
							contenido+='<label class="control-label" for="inputbaja">Tipo de baja</label>';
							contenido+='<div class="controls">';
							contenido+='<select id="inputbaja" name="tipo_baja" ></select>';
							contenido+='</div>';
							contenido+='</div>';
							contenido+='<div class="control-group">';
							contenido+='<label class="control-label" for="inputreemplazar">Empleado a Reemplazar</label>';
							contenido+='<div class="controls">';
							contenido+='<select id="inputreemplazar" name="cod_epl_reemp" >';
							contenido+='</select>';
							contenido+='</div>';
							contenido+='</div>';
							contenido+='<div class="control-group">';
							contenido+='<label class="control-label">&Aacute;rea</label>';
							contenido+='<div class="controls">';
							contenido+='<label class="area">'+area+'</label><input type="hidden" id="area" name="cod_cc2" value="'+area2+'">';
							contenido+='</div>';
							contenido+='</div>';
							contenido+='<div class="control-group">';
							contenido+='<label class="control-label" >Cargo</label>';
							contenido+='<div class="controls">';
							contenido+='<label class="cargo">'+nom_car+'</label><input type="hidden" id="cargo" value="'+cod_car+'" />';
							contenido+='</div>';
							contenido+='</div>';
							contenido+='<div class="control-group">';
							contenido+='<label class="control-label">Jefe de Proceso</label>';
							contenido+='<div class="controls">';
							contenido+='<label class="jefe">'+jefe+'</label><input type="hidden" id="jefe" name="cod_epl_jefe" value="'+jefe2+'" />';
							contenido+='</div>';
							contenido+='</div>';
							
							contenido+='<div class="controls-row" style="margin-left: 118px;">';
							contenido+='<span class="help-inline fec_ini" style=" color: black;">Inicial</span>';
							contenido+='<div class="input-append date" id="fec_ini" data-date="'+dia+'-'+mes+'-'+anio+'" data-date-format="dd-mm-yyyy" style="margin-left: 20px; max-width: 100px;"> ';
							contenido+=' <input class="span2" size="16" type="text" name="fec_ini" id="fec_inir" value="'+fec_ini+'"/>';
							contenido+='<span class="add-on"><i class="icon-th"></i></span>';
							contenido+='</div>';
							contenido+='<span class="help-inline fec_fin" style="margin-left: 91px; color: black;">Final </span>';
							
							contenido+='<div class="input-append date" id="fec_fin" data-date="'+dia+'-'+mes+'-'+anio+'" data-date-format="dd-mm-yyyy" style="margin-left: 20px; max-width: 100px;"> ';
							contenido+=' <input class="span2" size="16" type="text" name="fec_fin" id="fec_finr" value="'+fec_fin+'"/>';
							contenido+='<span class="add-on"><i class="icon-th"></i></span>';
							contenido+='</div>';
							contenido+='</div><br>';
							
							contenido+='<div class="control-group">';
							contenido+='<label class="control-label observaciones">Observaciones</label>';
							contenido+='<div class="controls">';
							contenido+='<textarea id="observaciones" style="width: 528px;height:40px; max-width: 499px;" name="observaciones">'+obser+'</textarea>';
							contenido+='</div>';
							contenido+='</div>';
							contenido+='<input type="hidden" name="id_super_nov" value="'+id+'">';
							contenido+='<input type="hidden" name="id_reemp_old" value="'+reemplazo2+'">';
							contenido+='<div style="text-align: center;">';
							contenido+='<div class="boton">';
							contenido+='<input type="submit" class="btn btn-primary" id="reemp" value="Aceptar"  />';
							contenido+='</div>';
							contenido+='</div>';
							
							
							contenido+='</form>';	
							
							contenido+='</div>';
							
				modals_supernumerario_admin("Editar Reemplazo<i class='icon-retweet' ></i>",contenido);
				/*script de reemplazo*/
				//$("#inputsupernumerario").chosen({width:"95%"});
				$("#inputbaja").chosen({width:"95%"});
				$("#inputreemplazar").chosen({width:"95%"});
				validar_fechas('fec_inir','fec_finr');
				/*fin reemplazo*/
				
				
				$.ajax({
						url:"select_tipobaja.php",
						type:"post",
						data:"supernume="+supernumerario+"&data1="+tipo_baja+"&data2="+tipobaja2,
						success:function(data){
							//console.log(data); return false;
							$("#inputbaja").html(data);
							$("#inputbaja").trigger("liszt:updated");
						}
				});
				
				/*ajax para traer todos los empleados basic*/
				
				$.ajax({
						url:"select_eplreemplazo.php",
						type:"post",
						data:"supernume="+supernumerario+"&data1="+reemplazo2+"&data2="+reemplazo+"&supernu="+supernumerario2,
						success:function(data){
							//console.log(data); return false;
							$("#inputreemplazar").html(data);
							$("#inputreemplazar").trigger("liszt:updated");
						}
				});
				
				$("#inputreemplazar").change(function(){
					var id_reempla=$(this).val();
					
					$.ajax({
						url:"get_jefe.php",
						dataType:"json",
						type:"post",
						data:"id="+id_reempla,
						success:function(data){
							$("#cargo").val(data[0].cargo);
							$(".cargo").html(data[0].nom_car);
							$("#area").val(data[0].cod_cc2);
							$(".area").html(data[0].area);
							$("#jefe").val(data[0].cod_epl_jefe);
							$(".jefe").html(data[0].nom_jefe);	
						}
					});
				});
				
				/*insert para el reemplazo*/
				$("#reemp").click(function(){

					$("#obligatorio").css("display","block");
					
					$(".error").remove();
					if($("#reemplazo_form select").val() == 0 ){
						
						$("#reemplazo_form select").after("<span class='error' style='color:red; font-size:16px;'> * </span>");
						return false;
						
					}else if($("#reemplazo_form #fec_inir").val() == ""){
						
					
						$("#reemplazo_form .fec_inir").after("<span class='error' style='color:red; font-size:16px;'> *</span>");
						
						return false;
					}else if($("#reemplazo_form #fec_finr ").val() == ""){
						
					
						$("#reemplazo_form .fec_finr").after("<span class='error' style='color:red; font-size:16px;'> *</span>");
						
						return false;
					}else{
						
						$("#obligatorio").css("display","none");
						
						$("#reemplazo_form").hide("slow");
							var contenido="";
							contenido+='<div class="alert alert-info" style="text-align:center;">';
									contenido+='<h4>Informaci&oacute;n!</h4>';
									contenido+='<p>Est&aacute; seguro de este movimiento?</p>';
									contenido+='<p><input class="btn btn-primary" type="button" id="aceptar_reem" value="Aceptar"/>';
									contenido+='<input class="btn btn-primary" type="button" id="cancelar_reem" value="Cancelar" style="margin-left:10px;"/></p>';
									contenido+='</div>';
							$("#reemplazo").append(contenido);
							
							$("#aceptar_reem").click(function(){
								
								$.ajax({
									url:"update_movsuper.php",
									type:"post",
									data:$("#reemplazo_form").serialize(),
									success:function(data){
										//console.log(data); return false;
										$(".alert").remove();
										if(data==1){
											var contenido="";
											contenido+='<div class="alert alert-success" style="text-align:center;">';
											contenido+='<h4>Informaci&oacute;n!</h4>';
											contenido+='<p>Se Atualizo correctamente</p>';
											contenido+='<a href="#" style="color:#fff;"  id="aceptar_cofirm" class="btn btn-primary">Aceptar</a>';
											contenido+='</div>';
											
											$("#reemplazo").append(contenido);
											
											$("#content").load('admin_supernumerario.php');
											$("#aceptar_cofirm").click(function(){
											
												$('#myModal4').modal('hide');
												
											 });
										}else if(data==3){
							
											var contenido="";
											contenido+='<div class="alert alert-error" style="text-align:center;">';
											contenido+='<h4>Alerta!</h4>';
											contenido+='<p>El supernumerario ya esta haciendo reemplazo</p>';
											contenido+='<a href="#" style="color:#fff;"  id="aceptar_cofirm" class="btn btn-primary">Aceptar</a>';
											contenido+='</div>';
											$("#reemplazo").append(contenido);
											
											$("#aceptar_cofirm").click(function(){
											
												$('#myModal4').modal('hide');
												
											 });
				
										}else if(data==4){
										   
											var contenido="";
											contenido+='<div class="alert alert-error" style="text-align:center;">';
											contenido+='<h4>Alerta!</h4>';
											contenido+='<p>El supernumerario ya esta haciendo cubrimiento</p>';
											contenido+='<a href="#" style="color:#fff;"  id="aceptar_cofirm" class="btn btn-primary">Aceptar</a>';
											contenido+='</div>';
											$("#reemplazo").append(contenido);
											
											$("#aceptar_cofirm").click(function(){
											
												$('#myModal4').modal('hide');
												
											 });	
												
										}else{
											var contenido="";
											contenido+='<div class="alert alert-error" style="text-align:center;">';
											contenido+='<h4>Alerta!</h4>';
											contenido+='<p>No Se ingreso correctamente Contacta al administrador</p>';
											contenido+='</div>';
											
											$("#reemplazo").append(contenido);
											
											$("#content").load('admin_supernumerario.php');
											$("#aceptar_cofirm").click(function(){
											
												$('#myModal4').modal('hide');
												
											 });
										}
										return false;
									}
								});
							
							
							});
							
							$("#cancelar_reem").click(function(){
								
								$(".alert").remove();
								$("#reemplazo_form").show("slow");
								
								
							});
							
							return false;
					}
				});

			}
		});
		
	}
		

	return false;
}

/*Funcion para cargar la interfaz de correo Turno con el plug in Tiny para la administracion de supernumerarios*/
function correo_supernumerario(){
       
       var empleados='empleados';        
               
       var        contenido = '<div id="correo_n">';
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
       modals_correo_admin("Enviar Planilla Email <i class='icon-envelope' ></i>",contenido);
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
               width: "900",
			   height: "190",
       });
       $("#enviar_email").click(enviar_email);
}

/*modal para administracion de supernumerarios*/
function modals_correo_admin(titulo,mensaje){

	var modal='<!-- Modal -->';
                       modal+='<div id="myModal3" class="modal2 hide fade" style="margin-top: 5%; background-color: rgb(41, 76, 139); color: #fff; z-index: 900000; behavior: url(../../css/PIE.htc);width: 80%; left: 40%;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">';
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
/*funcion para el modal del alert*/
function modal_alert(mensaje,callback){
	
	 var contenido='<div id="mensaje">';
	     contenido+='<p style="color:black; text-align:center;">'+mensaje+'</p>';
		 contenido+='<div class="botones" style="text-align:center;">';
		 contenido+='<a href="#" style="color:#fff;"  id="aceptar" class="btn btn-primary">Aceptar</a>';
		 contenido+='</div>'
	     contenido+='</div>';
	 
	 modals("Informaci&oacute;n  <i class='icon-exclamation-sign'></i>",contenido);
	 
	 $("#aceptar").click(function(){
		 callback();
	 
	 })
}
/*Funcion para asignar cargos a un supernumerario*/
function addCargos_supernumerarios(){
	
	var supernume='supernumerarios';
	var fecha= new Date();
	var dia=fecha.getDate();
	var mes=fecha.getMonth() + 1;
	var anio=fecha.getFullYear();
	
	var	contenido = '<div id="correo_n">';
				contenido+='<ul class="nav nav-tabs" id="myTab">';
				contenido+='<li class="active"><a href="#reemplazo">Reemplazo</a></li>';		
				contenido+='<li><a href="#cubrimiento">Cubrimiento</a></li>';
				contenido+='</ul>';	
				contenido+='<div class="tab-content">';
				
				/*fin tab de reemplazo*/
				contenido+='<div class="tab-pane active" id="reemplazo">';
				contenido+='<div id="obligatorio" style="color:red; text-align:center; display:none;">Los campos con (*) son requeridos</div>';
				contenido+='<div id="obligatorio3" style="color:red; text-align:center;"></div>';
				contenido+='<form class="form-horizontal" style="color:black" id="reemplazo_form">';
				contenido+='<div class="control-group">';
				contenido+='<label class="control-label" for="inputsupernumerario" >Supernumerario</label>';
				contenido+='<div class="controls">';
				contenido+='<select  id="inputsupernumerario" name="cod_epl_super"></select>';
				contenido+='</div>';
				contenido+='</div>';
				contenido+='<div class="control-group">';
				contenido+='<label class="control-label" for="inputbaja">Tipo de baja</label>';
				contenido+='<div class="controls">';
				contenido+='<select id="inputbaja" name="tipo_baja"><option>Seleccione..</option></select>';
				contenido+='</div>';
				contenido+='</div>';
				contenido+='<div class="control-group">';
				contenido+='<label class="control-label" for="inputreemplazar">Empleado a Reemplazar</label>';
				contenido+='<div class="controls">';
				contenido+='<select id="inputreemplazar" name="cod_epl_reemp"><option>Seleccione..</option></select>';
				contenido+='</div>';
				contenido+='</div>';
				contenido+='<div class="control-group">';
				contenido+='<label class="control-label">&Aacute;rea</label>';
				contenido+='<div class="controls">';
				contenido+='<label class="area">(Area del empleado) </label><input type="hidden" id="area" name="cod_cc2" >';
				contenido+='</div>';
				contenido+='</div>';
				contenido+='<div class="control-group">';
				contenido+='<label class="control-label" >Cargo</label>';
				contenido+='<div class="controls">';
				contenido+='<label class="cargo">(Cargo del empleado)</label><input type="hidden" id="cargo" />';
				contenido+='</div>';
				contenido+='</div>';
				contenido+='<div class="control-group">';
				contenido+='<label class="control-label">Jefe de Proceso</label>';
				contenido+='<div class="controls">';
				contenido+='<label class="jefe">(Jefe del Empleado)</label><input type="hidden" id="jefe" name="cod_epl_jefe"/>';
				contenido+='</div>';
				contenido+='</div>';
				
				
				contenido+='<div class="controls-row" style="margin-left: 118px;">';
				contenido+='<span class="help-inline fec_ini" style=" color: black;">Inicial</span>';
				contenido+='<div class="input-append date" id="fec_inir" data-date="'+dia+'-'+mes+'-'+anio+'" data-date-format="dd-mm-yyyy" style="margin-left: 20px; max-width: 100px;"> ';
				contenido+=' <input class="span2" size="16" type="text" name="fec_ini" id="fec_ini"/>';
				contenido+='<span class="add-on"><i class="icon-th"></i></span>';
				contenido+='</div>';
				contenido+='<span class="help-inline fec_fin" style="margin-left: 91px; color: black;">Final </span>';
				
				contenido+='<div class="input-append date" id="fec_finr" data-date="'+dia+'-'+mes+'-'+anio+'" data-date-format="dd-mm-yyyy" style="margin-left: 20px; max-width: 100px;"> ';
				contenido+=' <input class="span2" size="16" type="text" value="" name="fec_fin" id="fec_fin"/>';
				contenido+='<span class="add-on"><i class="icon-th"></i></span>';
				contenido+='</div>';
				contenido+='</div><br>';
				
				contenido+='<div class="control-group">';
				contenido+='<label class="control-label observaciones">Observaciones</label>';
				contenido+='<div class="controls">';
				contenido+='<textarea id="observaciones" style="width: 528px;height:40px; max-width: 499px;" name="observaciones"></textarea>';
				contenido+='</div>';
				contenido+='</div>';
				
				contenido+='<div style="text-align: center;">';
				contenido+='<div class="boton">';
				contenido+='<input type="submit" class="btn btn-primary" id="reemp" value="Aceptar"  />';
				contenido+='</div>';
				contenido+='</div>';
				
				contenido+='</form>';	
				
				contenido+='</div>';	
				/*fin tab de reemplazo*/
				
				/*tab de cubrimiento*/
				contenido+='<div class="tab-pane" id="cubrimiento">';
				contenido+='<div id="obligatorio2" style="color:red; text-align:center; display:none;" id="obligatorio">Los campos con (*) son requeridos</div>';
				contenido+='<form class="form-horizontal" style="color:black" id="cubri_form">';
				contenido+='<div class="control-group">';
				contenido+='<label class="control-label" for="inputsupernumerario">Supernumerario</label>';
				contenido+='<div class="controls">';
				contenido+='<select id="cubri_super" name="cubri_super"><option>Seleccione..</option></select>';
				contenido+='</div>';
				contenido+='</div>';
				contenido+='<div class="control-group">';
				contenido+='<label class="control-label" >Jefe de Proceso</label>';
				contenido+='<div class="controls">';
				contenido+='<select id="cubri_jefe" name="cubri_jefe"><option>Seleccione..</option></select>';
				contenido+='</div>';
				contenido+='</div>';
				contenido+='<div class="control-group">';
				contenido+='<label class="control-label">&Aacute;rea</label>';
				contenido+='<div class="controls">';
				contenido+='<select id="cubri_area" name="cubri_area"><option>Seleccione..</option></select>';
				contenido+='</div>';
				contenido+='</div>';
								
				contenido+='<div class="controls-row" style="margin-left: 118px;">';
				contenido+='<span class="help-inline cubri_fecini" style=" color: black;">Inicial </span>';
				contenido+='<div class="input-append date" id="fec_inir2" data-date="'+dia+'-'+mes+'-'+anio+'" data-date-format="dd-mm-yyyy" style="margin-left: 20px; max-width: 100px;"> ';
				contenido+='<input class="span2" size="16" type="text" value="" name="cubri_fecini" id="cubri_fecini"/>';
				contenido+='<span class="add-on"><i class="icon-th"></i></span>';
				contenido+='</div>';
				contenido+='<span class="help-inline cubri_fecfin" style="margin-left: 91px; color: black;">Final </span>';
				
				contenido+='<div class="input-append date" id="fec_finr2" data-date="'+dia+'-'+mes+'-'+anio+'" data-date-format="dd-mm-yyyy" style="margin-left: 20px; max-width: 100px;"> ';
				contenido+=' <input class="span2" size="16" type="text" value="" name="cubri_fecfin" id="cubri_fecfin"/>';
				contenido+='<span class="add-on"><i class="icon-th"></i></span>';
				contenido+='</div>';
				contenido+='</div><br>';
				
				contenido+='<div class="control-group">';
				contenido+='<label class="control-label">Observaciones</label>';
				contenido+='<div class="controls">';
				contenido+='<textarea style="margin: 0px; max-width: 526px; height: 78px; width: 529px;" name="cubri_observa" id="cubri_observa"></textarea>';
				contenido+='</div>';
				contenido+='</div>';
				
				contenido+='<div style="text-align: center;">';
				contenido+='<input type="submit" class="btn btn-primary" id="cubri" value="Aceptar"/>';
				contenido+='</div>';
				
				contenido+='</form>';	
				contenido+='</div>';
				contenido+='</div>';
				contenido+='</div>';
				
	modals_supernumerario_admin("Nuevo Movimiento de Supernumerario <i class='icon-retweet' ></i>",contenido);
	

	/*script de reemplazo*/
	$("#inputsupernumerario").chosen({width:"95%"});
	$("#inputbaja").chosen({width:"95%"});
	$("#inputreemplazar").chosen({width:"95%"});
	validar_fechas('fec_inir','fec_finr');
	//$('#fec_finr').datepicker({ format: 'dd-mm-yyyy'});
	//$('#fec_inir').datepicker({format: 'dd-mm-yyyy'});
	/*fin reemplazo*/
	
	/*script de cubirmiento*/
	$("#cubri_super").chosen({width:"95%"});
	$("#cubri_tipo").chosen({width:"95%"});
	$("#cubri_jefe").chosen({width:"95%"});
	$("#cubri_area").chosen({width:"95%"});
	validar_fechas('fec_inir2','fec_finr2');
	 //$('#fec_inir2').datepicker({format: 'dd-mm-yyyy'});
	 //$("#fec_finr2").datepicker({format: 'dd-mm-yyyy'});
	/*fin cubirmiento*/ 
  
	/*funciones y eventos de combos reemplazo  y cubrimiento*/
	$.ajax({
			url:"select_supernu.php",
			type:"post",
			data:"supernume="+supernume,
			success:function(data){
				$("#inputsupernumerario").html(data);
				$("#cubri_super").html(data);
				$("#cubri_super").trigger("liszt:updated");
				$("#inputsupernumerario").trigger("liszt:updated");
				
					
			}
	});
	
	$.ajax({
			url:"select_tipobaja.php",
			type:"post",
			data:"supernume="+supernume,
			success:function(data){
				$("#inputbaja").html(data);
				$("#inputbaja").trigger("liszt:updated");
			}
	});
	
	$.ajax({
			url:"get_all_jefe.php",
			type:"post",
			data:"supernume="+supernume,
			success:function(data){
				$("#cubri_jefe").html(data);
				$("#cubri_jefe").trigger("liszt:updated");
			}
	});
	

	$('#inputsupernumerario').change(function(){
		$(".error").remove();
		
		if($("#inputsupernumerario").val() > 0){
			$.ajax({
				url:"select_eplreemplazo.php",
				type:"post",
				data:"supernu="+$("#inputsupernumerario").val(),
				success:function(data){
					//console.log(data); return false;
					$("#inputreemplazar").html(data);
					$("#inputreemplazar").trigger("liszt:updated");
				}
			});
		}else{
			
			$("#reemplazo_form  #inputsupernumerario").after("<span class='error' style='color:red; font-size:16px;'> Debe elegir un supernumerario </span>");
		
		}

	});
	

	$("#inputreemplazar").change(function(){
		
		var id=$(this).val();
		
			$.ajax({
				url:"get_jefe.php",
				dataType:"json",
				type:"post",
				data:"id="+id,
				success:function(data){
					$("#cargo").val(data[0].cargo);
					$(".cargo").html(data[0].nom_car);
					$("#area").val(data[0].cod_cc2);
					$(".area").html(data[0].area);
					$("#jefe").val(data[0].cod_epl_jefe);
					$(".jefe").html(data[0].nom_jefe);	
				}
			});
		
		
	
	});
	
	$("#cubri_jefe").change(function(){
		
		var id=$(this).val();
		$.ajax({
			url:"select_jefe_areas.php",
			type:"post",
			data:"id="+id,
			success:function(data){
				$("#cubri_area").html(data);
				$("#cubri_area").trigger("liszt:updated");
			}
		});
	});
	/*fin funciones y eventos de combos reemplazo y cubrimiento*/
	
	/*Validacion change formulario de reemplazo*/
	
	
	/*insert para el reemplazo*/
	$("#reemp").click(function(){
		
		var  fecha_finf = new Date();
		var fecha_inif = new Date();
		var hoy=new Date();
		hoy=dia+"-"+mes+"-"+anio;
		fecha_finf = $("#reemplazo_form #fec_fin ").val();
		fecha_inif = $("#reemplazo_form #fec_ini ").val();
		
		
		$("#obligatorio").css("display","block");
		
		$(".error").remove();
		if($("#reemplazo_form #inputsupernumerario").val() == 0 ){
			
			$("#reemplazo_form select").after("<span class='error' style='color:red; font-size:16px;'> * </span>");
			return false;
			
		}else if($("#reemplazo_form  #inputbaja").val()== 0){
		
			$("#reemplazo_form select").after("<span class='error' style='color:red; font-size:16px;'> * </span>");
			return false;
		
		}else if($("#reemplazo_form  #inputreemplazar").val()== 0){
		
			$("#reemplazo_form select").after("<span class='error' style='color:red; font-size:16px;'> * </span>");
			return false;
		
		}else if($("#reemplazo_form #fec_ini").val() == ""){
			
		
			$("#reemplazo_form .fec_ini").after("<span class='error' style='color:red; font-size:16px;'> *</span>");
			
			return false;
		}else if($("#reemplazo_form #fec_fin ").val() == ""){
			
		
			$("#reemplazo_form .fec_fin").after("<span class='error' style='color:red; font-size:16px;'> *</span>");
			
			return false;
		}else{
			
			$("#obligatorio").css("display","none");
			
			$("#reemplazo_form").hide("slow");
				var contenido="";
				contenido+='<div class="alert alert-info" style="text-align:center;">';
						contenido+='<h4>Informaci&oacute;n!</h4>';
						contenido+='<p>Est&aacute; seguro de este movimiento?</p>';
						contenido+='<p><input class="btn btn-primary" type="button" id="aceptar_reem" value="Aceptar"/>';
						contenido+='<input class="btn btn-primary" type="button" id="cancelar_reem" value="Cancelar" style="margin-left:10px;"/></p>';
						contenido+='</div>';
				$("#reemplazo").append(contenido);
				
				$("#aceptar_reem").click(function(){
					
					$.ajax({
						url:"add_movsuper.php",
						type:"post",
						data:$("#reemplazo_form").serialize(),
						success:function(data){
							//console.log(data); return false;
							$(".alert").remove();
							if(data==1){
								
								var contenido="";
								contenido+='<div class="alert alert-success" style="text-align:center;">';
								contenido+='<h4>Informaci&oacute;n!</h4>';
								contenido+='<p>Se ingreso correctamente</p>';
								contenido+='<a href="#" style="color:#fff;"  id="aceptar_cofirm" class="btn btn-primary">Aceptar</a>';
								contenido+='</div>';
								$("#reemplazo").append(contenido);
								
								$("#content").load('admin_supernumerario.php');
								$("#aceptar_cofirm").click(function(){
								
									$('#myModal4').modal('hide');
									
								 });
								
							}else if(data==3){
								
								var contenido="";
								contenido+='<div class="alert alert-error" style="text-align:center;">';
								contenido+='<h4>Alerta!</h4>';
								contenido+='<p>El supernumerario ya tiene movimiento</p>';
								contenido+='<a href="#" style="color:#fff;"  id="aceptar_cofirm" class="btn btn-primary">Aceptar</a>';
								contenido+='</div>';
								$("#reemplazo").append(contenido);
								
								$("#aceptar_cofirm").click(function(){
								
									$('#myModal4').modal('hide');
									
								 });
	
							}else if(data==2){
								var contenido="";
								contenido+='<div class="alert alert-error" style="text-align:center;">';
								contenido+='<h4>Alerta!</h4>';
								contenido+='<p>No Se ingreso correctamente Contacta al administrador</p>';
								contenido+='<a href="#" style="color:#fff;"  id="aceptar_cofirm" class="btn btn-primary">Aceptar</a>';
								contenido+='</div>';
								
								$("#aceptar_cofirm").click(function(){
								
									$('#myModal4').modal('hide');
									
								 });	
	
							}
							return false;
						}
					});
				
				
				});
				
				$("#cancelar_reem").click(function(){
					
					$(".alert").remove();
					$("#reemplazo_form").show("slow");
					
					
				});
				
				return false;
		}
	});
	
	
	
	/*insert para el cubrimiento*/
	$("#cubri").click(function(){
		
		$("#obligatorio2").css("display","block");
		
		$(".error").remove();
		if($("#cubri_form cubri_super").val() == 0 ){
			
			$("#cubri_form select").after("<span class='error' style='color:red; font-size:16px;'> * </span>");
			return false;
			
		}else if($("#cubri_form #cubri_tipo").val() == 0){
			
		
			$("#cubri_form select").after("<span class='error' style='color:red; font-size:16px;'> *</span>");
			
			return false;
			
		}else if($("#cubri_form #cubri_jefe").val() == 0){
			
		
			$("#cubri_form select").after("<span class='error' style='color:red; font-size:16px;'> *</span>");
			
			return false;
		}else if($("#cubri_form #cubri_area ").val() == 0){
			
		
			$("#cubri_form #cubri_area").after("<span class='error' style='color:red; font-size:16px;'> *</span>");
			
			return false;
		}else if($("#cubri_form #cubri_fecini").val() == ""){
			
		
			$("#cubri_form .cubri_fecini").after("<span class='error' style='color:red; font-size:16px;'> *</span>");
			
			return false;
		}else if($("#cubri_form #cubri_fecfin ").val() == ""){
			
		
			$("#cubri_form .cubri_fecfin").after("<span class='error' style='color:red; font-size:16px;'> *</span>");
			
			return false;
			
		}else{
			
			$("#obligatorio2").css("display","none");
			$("#cubri_form").hide("slow");
			var contenido="";
					contenido+='<div class="alert alert-info" style="text-align:center;">';
							contenido+='<h4>Informaci&oacute;n!</h4>';
							contenido+='<p>Est&aacute; seguro de este movimiento?</p>';
							contenido+='<p><input class="btn btn-primary" type="button" id="aceptar_cubri" value="Aceptar"/>';
							contenido+='<input class="btn btn-primary" type="button" id="cancelar_cubri" value="Cancelar" style="margin-left:10px;"/></p>';
							contenido+='</div>';
			$("#cubrimiento").append(contenido);
			
			$("#aceptar_cubri").click(function(){
			
				$.ajax({
					url:"add_movsuper.php",
					type:"post",
					data:$("#cubri_form").serialize(),
					success:function(data){
						$(".alert").remove();
						if(data==1){
							var contenido="";
								contenido+='<div class="alert alert-success" style="text-align:center;">';
								contenido+='<h4>Informaci&oacute;n!</h4>';
								contenido+='<p>Se ingreso correctamente</p>';
								contenido+='<a href="#" style="color:#fff;"  id="aceptar_cofirm" class="btn btn-primary">Aceptar</a>';
								contenido+='</div>';
								$("#cubrimiento").append(contenido);
								$("#content").load('admin_supernumerario.php');
								$("#aceptar_cofirm").click(function(){
									$('#myModal4').modal('hide');
								 });
								
						}else if(data==4){
						
							var contenido="";
								contenido+='<div class="alert alert-error" style="text-align:center;">';
								contenido+='<h4>Informaci&oacute;n!</h4>';
								contenido+='<p>El supernumerario ya tiene movimiento</p>';
								contenido+='<a href="#" style="color:#fff;"  id="aceptar_cofirm" class="btn btn-primary">Aceptar</a>';
								contenido+='</div>';
								$("#cubrimiento").append(contenido);
								$("#aceptar_cofirm").click(function(){
								
									$('#myModal4').modal('hide');
									
								 });
							
						}else{
							var contenido="";
								contenido+='<div class="alert alert-error" style="text-align:center;">';
								contenido+='<h4>Alerta!</h4>';
								contenido+='<a href="#" style="color:#fff;"  id="aceptar_cofirm" class="btn btn-primary">Aceptar</a>';
								contenido+='<p>No se ingreso correctamente Contacta al administrador</p>';
								contenido+='</div>';
								$("#cubrimiento").append(contenido);
								$("#aceptar_cofirm").click(function(){
								
									$('#myModal4').modal('hide');
									
								 });
								
						}
						return false;
					}
				});
			
			});
		
			
			$("#cancelar_cubri").click(function(){		
				$(".alert").remove();
				$("#cubri_form").show("slow");
			});
					
			return false;
		}
	});
	
	$('#myTab a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	})
	
}

/*funcion para valdiar un rango de fechas*/
function validar_fechas(fecha_ini,fecha_fin){
	var nowTemp = new Date();
	var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
		
 	
	var checkin = $('#'+fecha_ini+'').datepicker({
			format: 'dd-mm-yyyy',
			onRender: function(date) {
				return date.valueOf() < now.valueOf() ? 'disabled' : '';
			}
		}).on('changeDate', function(ev) {
		
				
				if (ev.date.valueOf() >= checkout.date.valueOf()) {
					var newDate = new Date(ev.date)
					newDate.setDate(newDate.getDate() );
					checkout.setValue(newDate);
				}
				checkin.hide();
				$('#'+fecha_fin+'')[0].focus();
			}).data('datepicker');
			var checkout = $('#'+fecha_fin+'').datepicker({
				format: 'dd-mm-yyyy',
				onRender: function(date) {
					return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
				}
			}).on('changeDate', function(ev) {
				checkout.hide();
			}).data('datepicker');
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

//Funcion que envia los datos al correo del usuario
function enviar_email(){
	
	var ta= $(".texemail").val();
	
		$.ajax({
			url:"enviar_correo.php",
			type:"post",
			data:"correo="+$("#selectmultiple").val()+"&mens="+ta+"&info="+2,
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

/* Funcion unica de modal para el correo*/
function modals_supernumerario_admin(titulo,mensaje){

	var modal='<!-- Modal -->';
			modal+='<div id="myModal4" class="modal2 hide fade" style="margin-top: -1%; background-color: rgb(41, 76, 139); color: #fff; z-index: 900000; behavior: url(../../css/PIE.htc);width: 60%; left: 50%;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">';
			modal+='<div class="modal-header" style="border-bottom: 0px !important;">';
			modal+='<button type="button" class="close" style="color:#fff !important;" data-dismiss="modal" aria-hidden="true">×</button>';
			modal+='<h4 id="myModalLabel">'+titulo+'</h4>';
			modal+='</div>';
			modal+='<div class="modal-body" style="max-height: 560px; max-width: 92% !important; background-color:#fff; margin: 0 auto; margin-bottom: 1%; border-radius: 8px; behavior: url(../../css/PIE.htc);">';
			modal+='<p id="msj_modal">'+mensaje+'</p>';
			modal+='</div>';
		
			modal+='</div>';
	$("#main").append(modal);
	
	$('#myModal4').modal({
		keyboard: false,
		backdrop: "static" 
	});
	
	$('#myModal4').on('hidden', function () {
		$(this).remove();
	});
	
}
	
/* Funcion unica de modal para los alert*/
function confirm_dialog(mensaje) {

     var contenido='<div id="mensaje">';
	     contenido+='<p style="color:black; text-align:center;" class="mensaje">Esta Seguro de '+mensaje+' el Usuario?</p>';
		 contenido+='<div class="botones" style="text-align:center;">';
		 contenido+='<a href="#" style="color:#fff;"  id="aceptar" class="btn btn-primary">Aceptar</a>';
		 contenido+='<a href="#" style="color:#fff; margin-left:10px;" id="cancelar" class="btn btn-primary">Cancelar</a>';
		 contenido+='</div>'
	     contenido+='</div>';
	 
	 modals("Informaci&oacute;n  <i class='icon-question-sign'></i>",contenido);
	 
	 $("#aceptar").click(function(){
	
		var cuanto=$(".cedula_super").length;
		if(cuanto >0){
			var cedula=$(".cedula_super").html();
			var estado=$(".estado_super").html();
			
			$.ajax({
				url:'activar_super.php',
				type:'POST',
				data:"cedula="+cedula+"&estado="+estado,
				success:function(data){
					//document.write(data); return false;
					if(data=='3'){
						$(".mensaje").html("");
						$(".mensaje").html('No se puede inactivar el usuario porque esta cubriendo un turno');
						$("#cancelar").css("display","none");
						 $("#aceptar").click(function(){
							$('#myModal2').modal('hide');
						 });	 			
						
					}else if(data=='1'){
						
						$(".mensaje").html("");
						$(".mensaje").html('Se hicieron los cambios correctamente');
						 $("#content").load('supernumerario_catalogo.php');
						 $("#cancelar").css("display","none");
						$("#aceptar").click(function(){
							$('#myModal2').modal('hide');
						 })
						
					}
					
					
				}
			});	
		}
		return false;
	 });
	 
	 $("#cancelar").click(function(){
		$('#myModal2').modal('hide');
	 });
	 
	 
}

/*Modal principal que agarra el html de crear, editar, eliminar*/
function modals(titulo,mensaje){

	var modal='<!-- Modal -->';
			modal+='<div id="myModal2" class="modal hide fade" style="margin-top: 10%; background-color: rgb(41, 76, 139); color: #fff; z-index: 900000; behavior: url(../../css/PIE.htc);width: 30%; left:55%;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">';
			modal+='<div class="modal-header" style="border-bottom: 0px !important;">';
			modal+='<button type="button" class="close" style="color:#fff !important;" data-dismiss="modal" aria-hidden="true">×</button>';
			modal+='<h4 id="myModalLabel">'+titulo+'</h4>';
			modal+='</div>';
			modal+='<div class="modal-body" style="max-width: 88% !important; background-color:#fff; margin: 0 auto; margin-bottom: 1%; border-radius: 8px; behavior: url(../../css/PIE.htc);">';
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

function imprimir_contenido(url){

	 window.open(url, '_blank');

}

//Funcion que realiza los filtros 
function filtros(){

	var recibe=$(this).val();
	var detector=$(this).attr('name');	
	
	$('#supernumerario tr').show();
	
	if(recibe.length>0 && detector=='cedula'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#supernumerario tr td.cedula").not(":Contains('"+recibe+"')").parent().hide();
		
	}
	if(recibe.length>0 && detector=='nombre'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#supernumerario tr td.nombre").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='costo'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#supernumerario tr td.costo").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='cargo'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#supernumerario tr td.cargo").not(":Contains('"+recibe+"')").parent().hide();
	}
	
	if(recibe.length>0 && detector=='estado'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#supernumerario tr td.estado").not(":Contains('"+recibe+"')").parent().hide();
	}
	return false;
}

//Funcion que realiza los filtros 
function filtros1(){
	
	
	var recibe=$(this).val();
	var detector=$(this).attr('name');	
	
	$('#empleados tr').show();
	
	if(recibe.length>0 && detector=='cedula'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#empleados tr td.cedula").not(":Contains('"+recibe+"')").parent().hide();
		
	}
	if(recibe.length>0 && detector=='nombre'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#empleados tr td.nombre").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='costo'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#empleados tr td.costo").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='cargo'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#empleados tr td.cargo").not(":Contains('"+recibe+"')").parent().hide();
	}
	
	
	return false;
}

//Funcion que realiza los filtros 
function filtros2(){
	
	
	var recibe=$(this).val();
	var detector=$(this).attr('name');	
	
	$('#externos tr').show();
	
	if(recibe.length>0 && detector=='cedula'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#externos tr td.cedula").not(":Contains('"+recibe+"')").parent().hide();
		
	}
	if(recibe.length>0 && detector=='nombre'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#externos tr td.nombre").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='costo'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#externos tr td.costo").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='cargo'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#externos tr td.cargo").not(":Contains('"+recibe+"')").parent().hide();
	}
	
	
	return false;
}

//Funcion que realiza los filtros admin
function filtros3(){
	
	
	var recibe=$(this).val();	
	var detector=$(this).attr('name');	
	
	$('#admin tr').show();
	
	if(recibe.length>0 && detector=='nombre'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#admin tr td.nombre").not(":Contains('"+recibe+"')").parent().hide();
		
	}
	if(recibe.length>0 && detector=='area'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#admin tr td.area").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='super'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#admin tr td.super").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='baja'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#admin tr td.baja").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='inicio'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#admin tr td.inicio").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='fin'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#admin tr td.fin").not(":Contains('"+recibe+"')").parent().hide();
	}
	if(recibe.length>0 && detector=='jefe'){
		 // con la clase .nombre le decimos en cual de las celdas buscar y si no coincide, ocultamos el tr que contiene a esa celda. 
        $("#admin tr td.jefe").not(":Contains('"+recibe+"')").parent().hide();
	}
	
	
	return false;
}

