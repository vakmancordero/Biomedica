// $(document).ready(function(){
// 	var infoRows = null;
// 	$(".personaEsta").css("display","none");
// 	$(".personaNoEsta").css("display","none");
// 	$(".formAnadirAlumno").css("display","none");
// 	$(".asignar").css("display","none");
// 	$(".anadirAlumno").css("display","none");
// 	$(".asignarT").css("display","none");
//
// 	$(".asignar2").click(function(e){
// 		e.preventDefault();
// 		var $table = $("#table");
// 		infoRows = JSON.stringify($table.bootstrapTable('getSelections'));
// 		$("#mostrarmodal").modal("show");
// 	});
//
// 	$(".alumnoButton").click(function(e){
// 		e.preventDefault();
// 		window.location.href = "alumno.php?tuser=1&infoRows="+infoRows;
// 	});
// 	$(".docenteButton").click(function(e){
// 		e.preventDefault();
// 		window.location.href = "alumno.php?tuser=2&infoRows="+infoRows;
// 	});
// 	$(".anadirAlumno").click(function(e){
// 		e.preventDefault();
// 		$(".formAnadirAlumno").css("display","block");
// 	});
// 	$(".cancelarAnadirAlumno").click(function(e){
// 		e.preventDefault();
// 		$(".formAnadirAlumno").css("display","none");
// 	});
// 	$("#buscarPersona").click(function(e){
// 		e.preventDefault();
//
// 		$.post( "search.php", { matcont: $("#matcont").val()} )
// 		.done(function( data ) {
// 			if(data=="Error"){
// 				$(".personaNoEsta").css("display","block");
// 				$(".anadirAlumno").css("display","block");
// 				$(".personaEsta").css("display","none");
// 				$(".asignar").css("display","none");
// 				$( "#nombre" ).css( "display", "none" );
// 		    	$( "#matcont2" ).css( "display", "none" );
// 		    	$( "#carrera" ).css( "display", "none" );
// 		    	$(".asignarT").css("display","none");
// 			}else{
// 				var datos = data.split(",");
// 				$( "#nombre" ).css( "display", "block" );
// 		    	$( "#matcont2" ).css( "display", "block" );
// 		    	$( "#carrera" ).css( "display", "block" );
// 				$(".personaEsta").css("display","block");
// 				$(".asignar").css("display","block");
// 				$(".asignarT").css("display","block");
// 				$(".personaNoEsta").css("display","none");
// 				$(".anadirAlumno").css("display","none");
// 		    	$( "#nombre" ).html( datos[0] );
// 		    	$( "#matcont2" ).html( datos[1] );
// 		    	$( "#carrera" ).html( datos[2] );
// 		    	var valor = datos[3];
// 		    	var idPersona = document.getElementById("idPersona");
// 		    	idPersona.value=valor;
// 			}
//
//
// 	  	});
// 	});
// });