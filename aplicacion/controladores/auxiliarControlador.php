<?php
	 
	class auxiliarControlador extends CControlador
	{
		public function __construct() 
        { 
        $this->accionDefecto="verTodos"; 
        $this->plantilla="auxiliar"; 
        }

	
        /**
		 * Acción encargada de mostrar una ventana auxiliar que permite ver todas las formas de un Pokémon
		 * Si el Pokémon solo tiene una forma se mostrará solamente esa
		 */
        public function accionVariantes(){

			//Comprobación de llegada de id por parámetros en la URL
			if (isset($_REQUEST["id"])) {

				/**
				 * Conexión Con la API para la información del Pokémon
				 */
				$ch = curl_init();
				// set url
				curl_setopt($ch, CURLOPT_URL, "https://pokeapi.co/api/v2/pokemon-species/$_REQUEST[id]");
				//return the transfer as a string
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				// curl_setopt($ch, CURLOPT_PROXY, "192.168.2.254:3128");

				// $output contains the output string
				$output = curl_exec($ch);
				// close curl resource to free up system resources
				curl_close($ch); 
				/**
				 * Se recogen los resultados de la consulta y decodifica el JSON recibido en un array asociativo
				 */
				$output=json_decode($output, true);

				//Creación de los arrays que contienen los nombres y las imágenes de las variantes
				$nombres=[];
				$imagenes=[];

				//Por cada una de las variantes recibidas anteriormente se realizará una consulta en la que se
				//recogerán los nombres y los sprites de cada una
				foreach ($output["varieties"] as $key => $value) {

					$ch = curl_init();
					// set url
					curl_setopt($ch, CURLOPT_URL, $value["pokemon"]["url"]);
					//return the transfer as a string
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					// curl_setopt($ch, CURLOPT_PROXY, "192.168.2.254:3128");
	
					// $output contains the output string
					$result = curl_exec($ch);
					// close curl resource to free up system resources
					curl_close($ch); 

					//Se recibe una respuesta y se introducen los valores necesarios en los arrays anteriormente definidos
					$result=json_decode($result, true);
					array_push($nombres, $value["pokemon"]["name"]);
					array_push($imagenes, $result["sprites"]["other"]["official-artwork"]["front_default"]);
				}



				//Se dibuja la vista pasando los dos arrays como variables
				$this->dibujaVista("variantes", ["nombres"=>$nombres, "fotos"=>$imagenes], "Información");
			}
		}
	}
