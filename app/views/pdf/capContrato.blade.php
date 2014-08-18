<<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/normalize.css">
	<style>
	     @page { margin: 100px 90px; }
	     #header {margin: 0px; position: fixed; left: 0px; top: -76px; right: 0px;  text-align: center; }
	     #footer { position: fixed; left: 0px; bottom: -140px; right: 0px; height: 150px;  }
	     #footer .page:after { content: counter(page, upper-roman); }
	     #contenido {font-family: "arial black" ;margin: 0px; padding: 0px; text-align:justify; font-size: 14px; line-height: 20px}
	     #footer .left {float: left}
	     #footer .right {position: absolute; right: 10px}

	     .firmas {text-align: center;}
	     .firmas .firm { display: inline-block; position: absolute; }
	     .apoderado {left: 37%}
	     .consultor {right: 0}

	     .clausula {color: #707070  }
	   </style>

	<title>Contrato de trabajo</title>
</head>
<body>

<div id="header" >
	<img src="assets/img/cdmype-logo.jpg" width="150px"/>
</div>

<div id="footer">
	<img src="assets/img/conamype-logo.jpg" width="150px" class="left" />

	<img src="assets/img/unicaes-logo.jpg" width="75px" class="right" />

</div>

	<?php
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$date = strtotime($capacitacion->fecha);
		$dia = date('d', $date);
		$mes = $meses[date('m', $date) - 1];
		$ano = date('Y', $date);
	?>

<div id="contenido">
	<h4 style="text-align:center">
		CONTRATO PROFESIONAL ENTRE CONSULTOR Y EL CDMYPE PARA LA 
		PRESTACIÓN DE SERVICIOS DE CAPACITACIÓN
	</h4>

	<p>
	NOSOTROS, UNIVERSIDAD CÁTOLICA DE EL SALVADOR, en su calidad de Centro de
	Desarrollo de la Micro y Pequeña Empresa CDMYPE y 
	{{$consultor->nombre}}, 
	mayor de edad, de nacionalidad salvadoreña, del domicilio de 
	{{$consultor->direccion}}
	con Documento Único de Identidad (DUI), número 
	{{$consultor->dui}}
	, quien en adelante se denominará el consultor, convenimos celebrar el presente contrato con el objeto de que realice a favor 
	y a satisfacción de: CDMYPE, UNICAES-Ilobasco, la capacitación denominada:
	{{ $capacitacion->tema}}, para un grupo de empresarios, ubicados en: los Departamentos de Cabañas, San Vicente y Cuscatlán.
	
	<p>Las partes sujetamos el contrato en referencia a las siguientes cláusulas:</p>
	

	<p class="clausula">PRIMERA: PRODUCTOS ESPERADOS </p>
	
	Los productos esperados a realizar por el consultor son los siguientes de acuerdo a los solicitados en los TDR:
	
		<?php
			$productos = explode(",", $capacitacion->productos)
		?>
		<ul>
			@foreach($productos as $producto)
				<li>
					{{$producto}}
				</li>
			@endforeach
		</ul>
<br/>
	<p class="clausula"> SEGUNDA: PLAZO </p>
	<?php
		$h1 = (date("G",strtotime($capacitacion->hora_ini)));
		$h2 = (date("G",strtotime($capacitacion->hora_fin)));
		$horas = $h2 - $h1;
	?>

	El presente contrato tendrá una duración de OCHO HORAS, la capacitación brindada el dia {{$dia}} de {{$mes}} de {{$ano}}. Durante este período el consultor se compromete a hacer cumplir las actividades objeto de este contrato contenidas en la oferta técnica y económica y a dar fiel cumplimiento a los compromisos establecidos en los planes de trabajo aprobados y productos esperados.	

<br/>
	<p class="clausula">TERCERA: INFORMES </p>
	
	El consultor se obliga a presentar en tiempo y forma al CDMYPE UNICAES el informe final de la capacitación brindada a los empresarios.
	
<br/>
	<p class="clausula">CUARTA: FORMA DE PAGO </p>
	
	El CDMYPE UNICAES, en virtud de este contrato, pagará al consultor en concepto de honorarios por la capacitación efectuada, la cantidad de $ {{$contrato->pago }} (INCLUYE IVA) que corresponde al 100% del costo total de la capacitación. 

	No se reconocerá ninguna cantidad anticipadamente ni adicional. La forma de pago será: un solo 
	pago al final de la capacitación.	

<br/>
	<p class="clausula">QUINTA: SELECCIÓN DEL CONSULTOR </p>

	
	El CDMYPE, selecciona al consultor: {{$consultor->nombre}}, de los consultores que ofertaron según el siguiente listado:
		<ol>
			@foreach($capacitacion->ofertantes as $ofertante)
				<li>
					{{$ofertante->consultor->nombre}}
				</li>
			@endforeach
		</ol>

	<p class="clausula"> SEXTA: ESTIPULACIONES ESPECIALES. </p>
	
		<ol>	
			<li>
				El Consultor se obliga a guardar estricta confidencialidad sobre la información obtenida de los participantes.
			</li>
			<li>
				El Consultor no podrá desarrollar más de 3 consultorías de manera simultánea.
			</li>
			<li>
				El Consultor se obliga entregar un informe final al CDMYPE de la capacitación realizada.
			</li>
			<li>
				Al finalizar la capacitación, el consultor presentará factura de consumidor final a nombre de 
				CDMYPE-UNICAES, por la cantidad correspondiente al costo de la capacitación.
			</li>
			<li>
				Todos los precios detallados en el presente contrato, incluyen cualquier tipo de impuestos.
			</li>
		</ol>

	<p class="clausula">
		SEPTIMA: TERMINACIÓN.
	</p>
		El contrato podrá darse por terminado según las causas siguientes: 
		<ol type="a">
			<li> Por común acuerdo entre las partes; </li>
			<li> a solicitud de una de las partes, por motivo de fuerza mayor debidamente justificado y aceptado por la otra; </li>
			<li> Si cualquiera de las partes incumpliere cualquier obligación derivada del presente contrato; </li>
			<li> por causas imprevistas que hicieren imposible obtener la capacitación contratada, dando aviso a la otra parte con quince días de anticipación a la fecha de suspensión del contrato; </li>
			<li> Por faltas a la ética profesional. Cuando el contrato se dé por terminado por las razones descritas en los literales (a), (c) y (d) las cuales sean imputables a la empresa (s) beneficiaria (s).</li>
		</ol>
		El CDMYPE UNICAES, a su discreción, podrá reconocer al consultor los gastos razonables que hubiere efectuado, siempre que éstos estén justificados y se compruebe en forma fehaciente que corresponden al objeto de este contrato.

<br/>
			<p class="clausula"> OCTAVA: OBLIGACIONES DE LOS EMPRESARIOS. </p>
			<ol>
				<li>
					Facilitar toda la información que sea necesaria para efecto del desarrollo de la capacitación.
				</li>
				<li>
					Destinar el tiempo requerido para la ejecución de la capacitación.
				</li>
				<li>
					Implementar las recomendaciones realizadas por el consultor para el logro de los objetivos de la 
					capacitación.
				</li>
				<li>
					Acceder a la realización de la encuesta de evaluación de impacto del o los servicios recibidos.
				</li>
			</ol>
			
			<p class="clausula"> NOVENA: VIGENCIA, ORDEN DE INICIO</p>

				
			Este contrato entrará en vigencia a partir de la fecha de su firma y a partir de la misma autoriza al consultor a dar inicio a la capacitación.

			En fe de lo cual firmamos el presente contrato en original, en la ciudad de {{$contrato->lugar_firma}} a los {{$dia}} días del mes
			de {{$mes}} de {{$ano}}.
	</p>

	<div class="firmas">
			<br><br><br>
		<div class="firm directora">
			F._____________________	<br/>
			Msc.Yessenia Escobar de Hernández <br/>
			Directora<br/>
			CDMYPE UNICAES
		</div>
		<div class="firm apoderado">
			F._____________________	<br/>
			Lic. Roberto Antonio López <br/>
			Apoderado Especial Administrativo <br/>
			Universidad Católica de El Salvador
		</div>
		<div class="firm consultor">
			F._____________________	<br/>
			{{$consultor->nombre}} <br/>
			Consultor
		</div>
	</div>
</div>
</body>
</html>






