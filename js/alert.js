var Alert={

	alert: function (mensaje,callback){
	
	 var contenido='<div id="mensaje">';
	     contenido+='<p style="color:black; text-align:center;">'+mensaje+'</p>';
		 contenido+='<div class="botones" style="text-align:center;">';
		 contenido+='<a href="#" style="color:#fff;"  id="aceptar" class="btn btn-primary">Aceptar</a>';
		 contenido+='</div>'
	     contenido+='</div>';
	 
		 this.modals3("Informaci&oacute;n  <i class='icon-exclamation-sign'></i>",contenido);
		 
		 $("#aceptar").click(function(){
			
			 callback();
		 
		 })
    },

	modals3:function (titulo,mensaje){
	       var modal='<!-- Modal -->';
			modal+='<div id="myModal6" class="modal hide fade" style="margin-top: 10%; background-color: rgb(41, 76, 139); color: #fff; z-index: 900000; behavior: url(../../css/PIE.htc);width: 30%; left:55%;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">';
			modal+='<div class="modal-header" style="border-bottom: 0px !important;">';
			modal+='<button type="button" class="close" style="color:#fff !important;" data-dismiss="modal" aria-hidden="true">x</button>';
			modal+='<h4 id="myModalLabel">'+titulo+'</h4>';
			modal+='</div>';
			modal+='<div class="modal-body" style="max-width: 88% !important; background-color:#fff; margin: 0 auto; margin-bottom: 1%; border-radius: 8px; behavior: url(../../css/PIE.htc);">';
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
	},
	preload: function(mensaje){
		
		 var contenido='<div id="mensaje">';
	     contenido+='<p style="color:black; text-align:center;">'+mensaje+'</p>';
		 
	     contenido+='</div>';
	 
		 this.modals8("Cargando Datos Porfavor espere...",contenido);
	
	
	},
	
	aprobacion : function (){
		
		var contenido='<div id="mensaje">';
	     contenido+="<p style='color:rgb(41, 76, 139); text-align:center; font-weight: bold;'>Aprobaci&oacute;n exitosa</p>";
		 contenido+="<p style='color:rgb(41, 76, 139); text-align:center; font-weight: bold;'>de horas extras</p>";
	     contenido+='</div>';
	 
		 this.modals4(contenido);
	},
	
	preloadCerrar: function(callback){
		
		callback();
	
	
	},
	
	modals4:function (mensaje){
	       var modal='<!-- Modal -->';
			modal+='<div id="myModal6" class="modal hide fade" style="margin-top: 10%; background-color: rgb(41, 76, 139); color: #fff; z-index: 900000; behavior: url(../../css/PIE.htc);width: 30%; left:55%;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">';
			modal+='<div class="modal-header" style="border-bottom: 0px !important;">';
			modal+='<button type="button" class="close" style="color:#fff !important;" data-dismiss="modal" aria-hidden="true">x</button>';
			modal+='<h4 id="myModalLabel">Informaci&oacute;n</h4>';
			modal+='</div>';
			modal+='<div class="modal-body" style="max-width: 88% !important; background-color:#fff; margin: 0 auto; margin-bottom: 1%; border-radius: 8px; behavior: url(../../css/PIE.htc);">';
			modal+='<p>'+mensaje+'</p>';
			modal+='</div>';
			modal+='</div>';
					
			$("#main").append(modal);
			
			$('#myModal6').modal({
				keyboard: false,
				backdrop: "static" 
			});
			
	},
	
	modals8 : function(titulo, mensaje){
	
		var modal='<!-- Modal -->';
			modal+='<div id="myModal9" class="modal hide fade" style="margin-top: 10%; background-color: rgb(41, 76, 139); color: #fff; z-index: 900000; behavior: url(../../css/PIE.htc);width: 30%; left:55%;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">';
			modal+='<div class="modal-header" style="border-bottom: 0px !important;">';
			modal+='<h4 id="myModalLabel">'+titulo+'</h4>';
			modal+='</div>';
			modal+='<div class="modal-body" style="max-width: 88% !important; background-color:#fff; margin: 0 auto; margin-bottom: 1%; border-radius: 8px; behavior: url(../../css/PIE.htc);">';
			modal+='<p>'+mensaje+'</p>';
			modal+='</div>';
			modal+='</div>';
					
			$("#main").append(modal);
			
			$('#myModal9').modal({
				keyboard: false,
				backdrop: "static" 
			});
			
	
	
	}

}