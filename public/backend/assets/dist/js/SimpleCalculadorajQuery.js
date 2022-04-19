
 jQuery.fn.extend({Calculadora: function(op) {
					var LaCalculadora=this;
					var idInstancia=$(LaCalculadora).attr('id');
					var NombreBotonesClase=idInstancia+'tcl';
					var Clase;
    				var Botones;
					var Signos;
					
					defaults = {
						Botones:["7","8","9","+","4","5","6","-","3","2","1","*","0",".","=","/"],
						Signos:["+", "-", "*", "/"],
						ClaseBtns1: 'primary',
						ClaseBtns2: 'success',
						ClaseBtns3: 'warning',
						ClaseColumnas:'col-md-3 col-xs-3 mbottom',
						ClaseBotones:'btn3d btn-lg btn-block btn btn-',
						txtSalida:idInstancia+'txtResultado',
						ClasetxtSalida:'form-control txtr',
						InputBorrar:idInstancia+'clear',
						ClaseInputBorrar:'btn3d btn btn-danger btn-lg btn-block',
						EtiquetaBorrar:'clear'
					}
					
                    var op = $.extend({}, defaults, op);
					Botones=op.Botones;
					Signos=op.Signos;
                    $(LaCalculadora).append('<input type="text" class="'+op.ClasetxtSalida+'" id="'+op.txtSalida+'" value="0" >');
					$(LaCalculadora).append('<div class="row" id="'+idInstancia+'btns"></div>');					$.each(Botones, function(index,value) {	
						Clase=op.ClaseBtns1			
						if(Signos.indexOf(value)>-1){Clase=op.ClaseBtns2;}
						if(value=='='){Clase=op.ClaseBtns3;}
						$('#'+idInstancia+'btns').append('<div class="'+op.ClaseColumnas+'"><input type="button" class="'+NombreBotonesClase+' '+op.ClaseBotones+Clase+'" value="'+value+'"/></div>');
					});
					$(LaCalculadora).append('<input type="button" id="'+op.InputBorrar+'" class="'+op.ClaseInputBorrar+'" value="'+op.EtiquetaBorrar+'">');
					$(LaCalculadora).html('<div class="panel panel-primary btn-block calculadoraBase  mtop">'+ "" +'<div class="panel-body"><div class="col-md-12" style="margin-bottom: 10px;">'+$(LaCalculadora).html()+'</div></div> </div>');
					
					$('.'+NombreBotonesClase).click(function(){
						var vTecla=$(this).val();
						var salida=$('#'+op.txtSalida);
						if(vTecla=='='){salida.val(eval(salida.val()));}
						else{if((salida.val()==0)){
							if(Signos.indexOf(vTecla)>-1){salida.val(0)}
							else{salida.val(vTecla);}
						}else{salida.val(salida.val()+vTecla);} 
						}
					});
					$("#"+op.InputBorrar).click(function(){$('#'+op.txtSalida).val("0");});		
	}
});