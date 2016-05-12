$(document).ready(mains);

function mains(){
	
	/**/
	
	
    //Funcion para que el primer texto u opcion del menu aparezca en el content
	var url_inicial=$(".dropdown-menu li .text").eq(1).attr('href');
	
	if(url_inicial == '#supernumerario_catalogo'){
		var url=url_inicial;
	}else{
		var url=$(".dropdown-menu li .text").eq(0).attr('href');
	}
	var n=url.replace("#","");
	$('#content').load(n+'.php');
    
	$(".dropdown-menu li .text").click(capturar_text);
	$("#drop3").click(click_menu);
	
}
//Funcion para capturar el texto del menu drop-down y ubicarlo en la parte superior izquierda
function capturar_text(event){
	/*nuevo*/
	event.preventDefault();
	var texto = $(this).html();
	$("#titulo").html(texto);
	var url=$(this).attr('href');
	var n=url.replace("#","");
	
	/*si es programacion turnos no cargue Espere por favor*/
	/*algoritmo para que cargue bien los contenidos*/
	
	/*Dos formas para cargar los archivos*/
	
	$.ajax({
		
			url:n+'.php',
			type:"post",
			beforeSend:function(){
			
				$("#content").html("<h1 id='cerrar_se'>Espere Por favor<span>.</span><span>.</span><span>.</span></h1>");
			
			},
			success:function(data){
				
				$('#content').html(data);
			}
	
		})
	
	/*if(n=='programacion_turnos'){
	
		$('#content').load(n+'.php');
	
	}else{
	
		$("#content").html("<h1 id='cerrar_se'>Espere Por favor<span>.</span><span>.</span><span>.</span></h1>");
			setTimeout(function() {
				$('#content').load(n+'.php');
		}, 1500);
	}*/
	
	
	return false;
}

//Funcion para desaparecer y aparecer el drop-down
function click_menu(){
	/*nuevo*/
	

	$(".dropdown").addClass("open");
	$(".dropdown-menu li .text").click(function(){
		$(".dropdown").removeClass("open");
	
	})
							
	return false;
}




