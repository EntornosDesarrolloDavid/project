<?php
	 
	class combateControlador extends CControlador
	{

        
		public function accionPokemonList()
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
        $datos = [
            "nombre" => "",
            "categoria" => "",
            "borrado" => 0
        ];

        //Creación del modelo del pokemon
        $pokemon = new Pokemon();

        //Establezco las opciones de filtrado
        $opciones = array();
        $sentWhere = "";

        $condiciones = [];

        /**
         * Si se desea eliminar el filtrado se eliminarán todos los parámetros de la URL
         */
        if (isset($_POST["todos"])) {
            Sistema::app()->irAPagina(array("combate", "PokemonList"));
        }

        // /**
        //  * Si se ha presionado en filtrar
        //  */
        if (isset($_POST["fil"])) {


            /**
             * Si se ha indicado el nombre se filtrarán los pokemon que sean similares a éste y se guardará el nombre
             * en el array condiciones que se pasará a la URL como parámetro
             */
            if (isset($_POST["nombre"]) && $_POST["nombre"] != "") {
                $condiciones["nombre"] = trim($_POST["nombre"]);
            }
            Sistema::app()->irAPagina(array("combate","PokemonList"), $condiciones);

        }



        /**
         * Si están establecidos como parámetros de la URL alguno de los campos anteriores, se añadirá al
         * sentWhere para filtrar por ese campo
         */
        if (isset($_REQUEST["nombre"])) {
            $condiciones["nombre"] = CGeneral::addSlashes($_REQUEST["nombre"]);
            if ($sentWhere <> '')
                $sentWhere .= " and ";
            $datos["nombre"] = $_REQUEST["nombre"];
            $sentWhere .= " nombre like '%$datos[nombre]%' ";
        }


        /**
         * Se añade al apartado del where lo recogido de los filtros realizados
         */
        $opciones = array("where" => $sentWhere);


        /**
         * Control del funcionamiento del CPager
         */
        $pag = 1;
        if (isset($_GET["pag"]))
            $pag = intval($_GET["pag"]);

        $regPagina = 10;
        if (isset($_GET["reg_pag"]))
            $regPagina = intval($_GET["reg_pag"]);



        //Busco el número de registros tras el filtro
        $total = $pokemon->buscarTodosNRegistros($opciones);

        $paginas = ceil($total / $regPagina);

        if ($pag > $paginas) {
            $pag = $paginas;
        }

        $condLimit = (($pag - 1) * $regPagina) . "," . $regPagina;

        $opciones["limit"] = $condLimit;

        //Buscar todos lor pokemon filtrados para poder dibujarlos en el CGrid posteriormente
        $filas = $pokemon->buscarTodos($opciones);
        
                //Definiciones de las opciones del CPager
                $opcPaginador = array(
                    "URL" => Sistema::app()->generaURL(array("combate", "combate"), $condiciones),
                    "TOTAL_REGISTROS" => $total,
                    "PAGINA_ACTUAL" => $pag,
                    "REGISTROS_PAGINA" => $regPagina,
                    "TAMANIOS_PAGINA" => array(
                        5 => "5",
                        10 => "10",
                        20 => "20",
                        30 => "30",
                        40 => "40",
                        50 => "50"
                    ),
                    "MOSTRAR_TAMANIOS" => true,
                    "PAGINAS_MOSTRADAS" => $paginas,
                );

                $cod_usuario=intval(Sistema::app()->aclbd()->getCodUsuario(Sistema::app()->acceso()->getNick()));
                $sentencia="select * from pokemon_usuarios where cod_usuario = $cod_usuario"; 
                $equipo=Sistema::App()->BD()->crearConsulta($sentencia); 

                //Llamo a la vista con las definiciones para el CGrid y el CPager 
                $this->dibujaVista(
                    "pokemonList",
                    array(
                        "equipo" => $equipo->filas(),
                        "filas" => $filas,
                        "opcPag" => $opcPaginador,
                        "datos" => $filas,
                        "data" => $datos
                        
                    ),
                    "lista de pokemon"
                );


		}

        public function accionCombate(){
            $cod_usuario=intval(Sistema::app()->aclbd()->getCodUsuario(Sistema::app()->acceso()->getNick()));

            $equipo=Sistema::App()->BD()->crearConsulta("select * from pokemon_usuarios where cod_usuario = '$cod_usuario'"); 

                            //Llamo a la vista con las definiciones para el CGrid y el CPager 
                            $this->dibujaVista(
                                "combates",
                                array(  "members"=>$equipo->filas()                               
                                ),
                                "Combate Pokémon"
                            );
        }

        /**
         * Función que añade el resultado de un combate a la BD
         */
        public function accionAddPoke()
		{
            // Obtenemos el json enviado
            $id=intval($_POST["id"]);
            $resultado=$_POST["resultado"];
            $combate= new Combate();

            //Establecer valores del modelo
            $combate->cod_pokemonInvent=$id;
            $combate->resultado=$resultado;

            //Validación y guardado de los datos
            if ($combate->validar()) {
                if (!$combate->guardar()) {
                    Sistema::app()->paginaError(404, "No se ha podido guardar el resultado");
                    exit;
                }
            }
            else{
                Sistema::app()->paginaError(404, "No se ha podido guardar el resultado");
                exit;
            }
	}

        /**
         * Función que añade el Pokémon seleccionado al equipo del usuario conectado
         */
        public function accioncatchPoke()
		{
            // Obtenemos el json enviado
            $id=intval($_POST["id"]);
            $cod_usuario=intval(Sistema::app()->aclbd()->getCodUsuario(Sistema::app()->acceso()->getNick()));
            $pokemon= new Pokemon();
            $pokemon->buscarPorId($id);

            $sentencia="INSERT INTO `pokemon_usuarios`(`cod_usuario`, `cod_pokemonInvent`, `nombre`, `vida`, `ataque`, `defensa`, `ataque_especial`, `defensa_especial`, `velocidad`, `foto`) VALUES 
            ('$cod_usuario','$id','$pokemon->nombre','$pokemon->vida','$pokemon->ataque','$pokemon->defensa','$pokemon->ataque_especial','$pokemon->defensa_especial','$pokemon->velocidad','$pokemon->foto')"; 
            $consulta=Sistema::App()->BD()->crearConsulta($sentencia); 
            $id = $consulta->idGenerado();
            $data = Sistema::App()->BD()->crearConsulta("select * from pokemon_usuarios where cod_pokemon_usuario = '$id'")->fila(); 
            $data = json_encode($data, JSON_PRETTY_PRINT);

            echo $data;
            
            //Establecer valores del modelo

            //Validación y guardado de los datos
            // if ($combate->validar()) {
            //     if (!$combate->guardar()) {
            //         Sistema::app()->paginaError(404, "No se ha podido guardar el resultado");
            //         exit;
            //     }
            // }
            // else{
            //     Sistema::app()->paginaError(404, "No se ha podido guardar el resultado");
            //     exit;
            // }
	}


    public function accionfreePoke()
    {
        // Obtenemos el json enviado
        $id=intval($_POST["id"]);
        $cod_usuario=intval(Sistema::app()->aclbd()->getCodUsuario(Sistema::app()->acceso()->getNick()));
        $sentencia="delete from pokemon_usuarios where cod_pokemon_usuario = '$id' and cod_usuario = '$cod_usuario'"; 
                    $consulta=Sistema::App()->BD()->crearConsulta($sentencia); 
        //Establecer valores del modelo

}
		
	}
