<?php
	 
	class principalesControlador extends CControlador
	{
		
		public function __construct()
		{
			$this->accionDefecto="Index";
		}

		//Acción que carga la página principal de la web. En ella el usuario esté logueado o no se
		//encontrará un pokémon del día que será almacenado en una cookie y permanecerá durante un día
		public function accionIndex(){

			setcookie("API", Sistema::app()->API,  "", "/");
			$_COOKIE["API"]=Sistema::app()->API;
			/**
			 * Si no está establecida la cookie se realizan las consultas para poder crearla
			 */
			if (!isset($_COOKIE["dailyPokemonId"])) {
				# code...
			
			// Conexión para recoger el número total de Pokémon existentes
			$ch = curl_init();
			// set url
			curl_setopt($ch, CURLOPT_URL, "https://pokeapi.co/api/v2/pokemon?limit=0");
			//return the transfer as a string
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// curl_setopt($ch, CURLOPT_PROXY, "192.168.2.254:3128");
			// $output contains the output string
			$output = curl_exec($ch);
			// close curl resource to free up system resources
			curl_close($ch); 
			$output=json_decode($output);

			$total=$output->count;

			$aleatorio= rand(1, $total);

			// Conexión para recoger el id del Pokémon aleatorio generado tras la consulta anterior

				$enlaceCurl=curl_init();
				//se indican las opciones para una petición HTTP GET
				curl_setopt($enlaceCurl,
				CURLOPT_URL,"https://pokeapi.co/api/v2/pokemon/$aleatorio");

				curl_setopt($enlaceCurl, CURLOPT_HTTPGET, 1);
				curl_setopt($enlaceCurl, CURLOPT_HEADER, 0);
				curl_setopt($enlaceCurl, CURLOPT_RETURNTRANSFER,1);
				// curl_setopt($enlaceCurl, CURLOPT_PROXY, "192.168.2.254:3128");
				//ejecuto la petición
				$respuesta=curl_exec($enlaceCurl);
				$respuesta = json_decode($respuesta, true);
				//cierro la sesión
				curl_close($enlaceCurl);

			//Creación de la cookie y asignación de valor para su uso inmediato
			setcookie("dailyPokemonId", $respuesta["id"],  time()+40000, "/");
			$_COOKIE["dailyPokemonId"]=$respuesta["id"];
			}
			
			//Si la cookie existe se realiza una petición para buscar el sprite del id del pokémon almacenado
			else{

		
			//Conexión con la API externa

			$enlaceCurl=curl_init();
			//se indican las opciones para una petición HTTP GET
			curl_setopt($enlaceCurl,
			CURLOPT_URL,"https://pokeapi.co/api/v2/pokemon/$_COOKIE[dailyPokemonId]");

			curl_setopt($enlaceCurl, CURLOPT_HTTPGET, 1);
			curl_setopt($enlaceCurl, CURLOPT_HEADER, 0);
			curl_setopt($enlaceCurl, CURLOPT_RETURNTRANSFER,1);
			// curl_setopt($enlaceCurl, CURLOPT_PROXY, "192.168.2.254:3128");
			//ejecuto la petición
			$respuesta=curl_exec($enlaceCurl);
			$respuesta = json_decode($respuesta, true);
			//cierro la sesión
			curl_close($enlaceCurl);

			}

			$this->dibujaVista("index", ["imagen"=>$respuesta["sprites"]["other"]["official-artwork"]["front_default"], "id"=>$_COOKIE["dailyPokemonId"]], "Index");
			exit;
		}

		
		/**
		 * Dibujo de la Vista de la Pokédex con una variable de sesión que controla si se reproducirá
		 * una pista de audio una vez se entre en la acción
		 */
		public function accionPokedex()
		{
			if (!isset($_SESSION["audio"])) {
				$_SESSION["audio"]=false;
			}
			if (isset($_POST["bAudio"])) {
				$_SESSION["audio"]=!$_SESSION["audio"];
			}
			$this->dibujaVista("pokedex", [], "Pokédex");

			

		}


		/**
		 * Acción que dibuja la Vista para buscar shinies
		 */
		public function accionShiny()
		{
        /**
         * Si no hay un usuario registrado se redirigirá al login para que este se valide
         */
        if (!Sistema::app()->acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(array(
                "registro",
                "login"
            ));
            exit;
        }

        /**
         * Si no tiene el permiso 1 se mostrará un error en el que se indicará que no posee el permiso
         * para avanzar a la página
         */
        if (!Sistema::app()->acceso()->puedePermiso(1)) {
            Sistema::app()->paginaError(404, "Acceso no permitido");
            exit;
        }
		// if (!isset($_SESSION["intentos"][Sistema::app()->acceso()->getNombre()])) {
		// 	$_SESSION["intentos"][Sistema::app()->acceso()->getNombre()]["intentos"]=1;
		// }
		// $_SESSION["intentos"][Sistema::app()->acceso()->getNombre()]["intentos"]++;
			$this->dibujaVista("shiny", [], "Búsqueda de Shinies");

			

		}


		/**
		 * Acción que recoge desde un fichero txt 15 palabras. Estas palabras serán filtradas para que
		 * no tengan ni tildes ni carácteres como la Ñ o la Ç
		 */
		public function accionAdivinar(){

			//Se recogen los valores del txt
			$var = file_get_contents("http://$_SERVER[SERVER_NAME]/javascript/palabras.txt", true); //Take the contents from the file to the variable
			
			//Se separa el contenido en palabras
			$result = explode('  ',$var); //Split por '  '

			$palabras=[];

			//Se rellena el array de palabras hasta que su longitud sea 15
			while(count($palabras)<15){
				$palabraAleatoria=$result[array_rand($result)];

				$palabraAleatoria=$this->eliminar_acentos($palabraAleatoria);


				//se añade la palabra al array
				array_push($palabras, $palabraAleatoria);

				//Se eliminan las palabras iguales
				$palabras=array_unique($palabras);
			}
			


			//Dibujo de la vista
			$this->dibujaVista("adivinar", ["palabras"=>$palabras], "Adivina el Texto");

		}

		//Acción que tras recibir el id del pokémon requerido haga una consulta a la API externa y muestre
		//sus datos en la vista correspondiente
		public function accionInfo(){
			if (isset($_REQUEST["id"])) {

				//Consulta a la API
				$ch = curl_init();
				// set url
				curl_setopt($ch, CURLOPT_URL, "https://pokeapi.co/api/v2/pokemon/$_REQUEST[id]");
				//return the transfer as a string
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				// curl_setopt($ch, CURLOPT_PROXY, "192.168.2.254:3128");

				// Se recogen los valores, se transforman en array asociativo y se envían a la vista
				$output = curl_exec($ch);
				curl_close($ch); 
				$output=json_decode($output, true);

				$this->dibujaVista("info", ["data"=>$output], "Información");
			}
		} 





function eliminar_acentos($cadena){
		
		//Reemplazamos la A y a
		$cadena = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$cadena
		);
 
		//Reemplazamos la E y e
		$cadena = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$cadena );
 
		//Reemplazamos la I y i
		$cadena = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$cadena );
 
		//Reemplazamos la O y o
		$cadena = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$cadena );
 
		//Reemplazamos la U y u
		$cadena = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$cadena );
 
		//Reemplazamos la N, n, C y c
		$cadena = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$cadena
		);
		
		return $cadena;
	}
		
	}
