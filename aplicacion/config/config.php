<?php

	$config=array("CONTROLADOR"=> array("principales", "index"),
				  "RUTAS_INCLUDE"=>array("aplicacion/modelos", "scripts/tcpdf"),
				  "URL_AMIGABLES"=>true,
				  "VARIABLES"=>array("autor"=>"David Mateos Pozo",
				  					"direccion"=>"C/ Carrera Madre Carmen, 12",
									"API"=>"PokeAPI.co"),
				  "sesion"=>array("controlAutomatico"=>true),
				  "BD"=>array("hay"=>true,
								"servidor"=>"localhost",
								"usuario"=>"proyecto",
								"contra"=>"proyecto",
								"basedatos"=>"proyecto"),
					"ACL"=>array("controlAutomatico"=>true)
				  );

