<?php

class pokemonControlador extends CControlador
{

    public function accionModificar()
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
         * Si no tiene el permiso 5 se mostrará un error en el que se indicará que no posee el permiso
         * para avanzar a la página
         */
        if (!Sistema::app()->acceso()->puedePermiso(5)) {
            Sistema::app()->paginaError(404, "Acceso no permitido");
            exit;
        }
        $poke = new Pokemon();

        $id = intval($_REQUEST["id"]);
        if ($poke->buscarPorId($id)) {

            //Recogida de todos los datos del Pokémon a modificar
            if (isset($_POST["modificar"])) {
                if (isset($_POST["nombre"])) {
                    $datos["nombre"] = $_POST["nombre"];
                }

                if (isset($_POST["vida"])) {
                    $datos["vida"] = $_POST["vida"];
                }

                if (isset($_POST["ataque"])) {
                    $datos["ataque"] = $_POST["ataque"];
                }

                if (isset($_POST["defensa"])) {
                    $datos["defensa"] = $_POST["defensa"];
                }

                if (isset($_POST["ataque_especial"])) {
                    $datos["ataque_especial"] = $_POST["ataque_especial"];
                }


                if (isset($_POST["defensa_especial"])) {
                    $datos["defensa_especial"] = $_POST["defensa_especial"];
                }

                if (isset($_POST["velocidad"])) {
                    $datos["velocidad"] = $_POST["velocidad"];
                }

                $errores = [];
                //Recogida de la foto nueva si la hay
                if ($_FILES["foto"]['error'] != UPLOAD_ERR_NO_FILE) {


                    if ($_FILES["foto"]["error"] != 0) {
                        $errores["fichero"] = "Se ha producido un error al subir el fichero";
                    }
                    if (!$errores && !($_FILES["foto"]["type"] == 'image/png' || $_FILES["foto"]["type"] == 'image/jpeg')) {
                        $errores["tipo"] = 'El tipo de fichero no es correcto';
                    }

                    if (!$errores && $_FILES["foto"]["size"] > 2097152) {
                        $errores['tamaño'] = "El archivo no puede ser tan grande";
                    }

                    if (!file_exists(RUTA_BASE . '/imagenes/fotosPokemon')) {
                        mkdir(RUTA_BASE . '/imagenes/fotosPokemon/', 0777, true);
                    }

                    $_FILES["foto"]["name"] = $datos["foto"] = $datos["nombre"] . $_FILES["foto"]["name"];
                    $ruta = RUTA_BASE . "/imagenes/fotosPokemon/" . $_FILES["foto"]["name"];
                    if ($_FILES["foto"]["type"] == 'image/png' || $_FILES["foto"]["type"] == 'image/jpeg') {

                        move_uploaded_file($_FILES["foto"]["tmp_name"], $ruta);
                    }
                } else {
                    $datos["foto"] = $poke->foto;
                }

                //Conexión con la API para modificar el Pokémon seleccionado
                $enlaceCurl = curl_init();
                //se indican las opciones para una petición HTTP Post
                curl_setopt(
                    $enlaceCurl,
                    CURLOPT_URL,
                    "http://$_SERVER[SERVER_NAME]/pokemonAPI/API/"
                );
                curl_setopt($enlaceCurl, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($enlaceCurl, CURLOPT_HEADER, 0);
                curl_setopt(
                    $enlaceCurl,
                    CURLOPT_POSTFIELDS,
                    "id=$poke->cod_pokemonInvent&nombre=$datos[nombre]&vida=$datos[vida]&ataque=$datos[ataque]&defensa=$datos[defensa]&ataque_especial=$datos[ataque_especial]&defensa_especial=$datos[defensa_especial]&velocidad=$datos[velocidad]&foto=$datos[foto]"
                );
                curl_setopt($enlaceCurl, CURLOPT_RETURNTRANSFER, 1);
                //ejecuto la petición
                $devuelto = curl_exec($enlaceCurl);
                //cierro la sesión



                $devuelto = json_decode($devuelto, true);
                curl_close($enlaceCurl);

                //Si la consulta se ha realizado correctamente se mostrará un resumen del Pokémon y si no
                //se mostrarán los errores que se han producido
                if ($devuelto["correcto"]) {
                    Sistema::app()->irAPagina(array("pokemon", "ver"), array("id" => intval($devuelto["id"])));
                }
                else {
                    unset($devuelto["correcto"]);
                    //Muestro la vista inicalmente
                    $this->dibujaVista(
                        "modificar",
                        array("modelo"=>$poke,"errores" => $devuelto),
                        "Modificar pokemon"
                    );
                    exit;
                }
            } else {
                //Muestro la vista inicalmente
                $this->dibujaVista(
                    "modificar",
                    array("modelo" => $poke),
                    "Crear pokemon"
                );
            }
        }

    }

    public function accionVer()
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
        if (!isset($_GET["invent"])) {
            # code...
        
        $enlaceCurl = curl_init();

        //Se recogen los datos del Pokémon elegido
        curl_setopt(
            $enlaceCurl,
            CURLOPT_URL,
            "http://$_SERVER[SERVER_NAME]/pokemonAPI/API/id=$_REQUEST[id]"
        );

        curl_setopt($enlaceCurl, CURLOPT_HTTPGET, 1);
        curl_setopt($enlaceCurl, CURLOPT_HEADER, 0);
        curl_setopt($enlaceCurl, CURLOPT_RETURNTRANSFER, 1);
        //ejecuto la petición
        $respuesta = curl_exec($enlaceCurl);
        $respuesta = json_decode($respuesta, true);
        if (!$respuesta["correcto"]) {
            Sistema::app()->paginaError(404, "No se ha podido realizar la consulta");
            exit;
        }
        //cierro la sesión
        curl_close($enlaceCurl);
    }
    else{
        $cod_usuario=intval(Sistema::app()->aclbd()->getCodUsuario(Sistema::app()->acceso()->getNick()));
        $consulta = Sistema::app()->BD()->crearConsulta("select * from pokemon_usuarios where cod_pokemon_usuario = '$_REQUEST[id]' and cod_usuario = '$cod_usuario' ");
        $respuesta = $consulta->fila();
    }
        $this->dibujaVista("ver", ["respuesta" => $respuesta], "Ver Pokémon");
    }

    public function accionBorrar()
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
         * Si no tiene el permiso 5 se mostrará un error en el que se indicará que no posee el permiso
         * para avanzar a la página
         */
        if (!Sistema::app()->acceso()->puedePermiso(5)) {
            Sistema::app()->paginaError(404, "Acceso no permitido");
            exit;
        }
        $enlaceCurl = curl_init();

        //Se recoge la información del Pokémon elegido
        curl_setopt(
            $enlaceCurl,
            CURLOPT_URL,
            "http://$_SERVER[SERVER_NAME]/pokemonAPI/API/id=$_REQUEST[id]"
        );

        curl_setopt($enlaceCurl, CURLOPT_HTTPGET, 1);
        curl_setopt($enlaceCurl, CURLOPT_HEADER, 0);
        curl_setopt($enlaceCurl, CURLOPT_RETURNTRANSFER, 1);
        //ejecuto la petición
        $respuesta = curl_exec($enlaceCurl);
        $respuesta = json_decode($respuesta, true);
        if (!$respuesta["correcto"]) {
            Sistema::app()->paginaError(404, "No se ha podido realizar la consulta");
            exit;
        }
        //cierro la sesión
        curl_close($enlaceCurl);


        /**
         * Si se ha presionado en borrar se hará el borrado lógico del Pokémon elegido
         */
        if (isset($_POST["borrar"])) {
            $ec = curl_init();
            //se indican las opciones para una petición HTTP DELETE
            curl_setopt(
                $ec,
                CURLOPT_URL,
                "http://$_SERVER[SERVER_NAME]/pokemonAPI/API/"
            );
            curl_setopt($ec, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ec, CURLOPT_HEADER, 0);
            curl_setopt($ec, CURLOPT_POSTFIELDS, "id=$_REQUEST[id]");
            curl_setopt($ec, CURLOPT_RETURNTRANSFER, 1);

            $devuelto = curl_exec($ec);
            curl_close($ec);

            /**
             * Si la consulta no se ha podido realizar se mostrará una pagina de error o se volverá al Crud
             * si se ha realizado
             */
            if (!$devuelto["correcto"]) {
                Sistema::app()->paginaError(404, "No se ha podido realizar la consulta");
                exit;
            } else {
                Sistema::app()->irAPagina(array(
                    "pokemon",
                    "indice"
                ));
                exit;
            }
        }


        $this->dibujaVista("borrar", ["respuesta" => $respuesta], "Borrar Pokémon");
    }

    public function accionindice()
    {
        /**
         * Si no hay un pokemon registrado se redirigirá al login para que este se valide
         */
        if (!Sistema::app()->acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(array(
                "registro",
                "login"
            ));
            exit;
        }

        /**
         * Si no tiene el permiso 5 y 1 se mostrará un error en el que se indicará que no posee el permiso
         * para avanzar a la página
         */
        if (!Sistema::app()->acceso()->puedePermiso(1) || !Sistema::app()->acceso()->puedePermiso(5)) {
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
            Sistema::app()->irAPagina(array("pokemon", "indice"));
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
            /**
             * Filtrado de usuarios según si está borrado o no y se guardará el borrado
             * en el array condiciones que se pasará a la URL como parámetro
             */
            if (isset($_POST["borrado"])) {
                $condiciones["borrado"]=intval($_POST["borrado"]);

            }
            else $condiciones["borrado"]=0;
            Sistema::app()->irAPagina(array("pokemon","indice"), $condiciones);

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

        if (isset($_REQUEST["borrado"])) {
            $condiciones["borrado"]=$_REQUEST["borrado"];

                if ($sentWhere <> '')
                    $sentWhere .= " and ";
                $datos["borrado"] = $_REQUEST["borrado"];
                $sentWhere .= " borrado = '" . intval($datos["borrado"]) . "' ";
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
        if (!$filas) {
            $filas=[];
        }
        foreach ($filas as $clave => $valor) {

            //Mostrar Borrado Como SÍ o NO
            if ($filas[$clave]["borrado"] == 0) $filas[$clave]["borrado"] = "NO";
            else $filas[$clave]["borrado"] = "SÍ";


            //Creación de imágenes que redirigen a las distintas operaciones de los pokemon
            $cadena = CHTML::link(
                CHTML::imagen("/imagenes/24x24/ver.png"),
                Sistema::app()->generaURL(
                    array("pokemon", "Ver"),
                    array("id" => $filas[$clave]["cod_pokemonInvent"])
                )
            );
            $cadena .= CHTML::link(
                CHTML::imagen(
                    '/imagenes/24x24/modificar.png'
                ),
                Sistema::app()->generaURL(
                    array("pokemon", "modificar"),
                    array("id" => $filas[$clave]["cod_pokemonInvent"])
                )
            );

            $cadena .= CHTML::link(
                CHTML::imagen(
                    '/imagenes/24x24/borrar.png'
                ),
                Sistema::app()->generaURL(
                    array("pokemon", "borrar"),
                    array("id" => $filas[$clave]["cod_pokemonInvent"])
                ),
            );

            $cadena .= CHTML::link(
                CHTML::imagen(
                    '/imagenes/24x24/tipos.png'
                ),
                Sistema::app()->generaURL(
                    array("pokemon", "tipos"),
                    array("id" => $filas[$clave]["cod_pokemonInvent"])
                ),
            );


            $filas[$clave]["opciones"] = $cadena;
        }

        //Definiciones de las cabeceras de las columnas para el CGrid
        $cabecera = array(
            array(
                "ETIQUETA" => "CÓDIGO",
                "CAMPO" => "cod_pokemonInvent"
            ),
            array(
                "ETIQUETA" => "NOMBRE",
                "CAMPO" => "nombre"
            ),
            array(
                "CAMPO" => "vida",
                "ETIQUETA" => "VIDA"
            ),
            array(
                "CAMPO" => "ataque",
                "ETIQUETA" => "ATAQUE"
            ),
            array(
                "CAMPO" => "defensa",
                "ETIQUETA" => "DEFENSA"
            ),
            array(
                "CAMPO" => "foto",
                "ETIQUETA" => "FOTO",
            ),
            array(
                "CAMPO" => "borrado",
                "ETIQUETA" => "Borrado",
            ),
            array(
                "CAMPO" => "opciones",
                "ETIQUETA" => " OPERACIONES"
            )
        );

        //Definiciones de las opciones del CPager
        $opcPaginador = array(
            "URL" => Sistema::app()->generaURL(array("pokemon", "indice"), $condiciones),
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
        //Llamo a la vista con las definiciones para el CGrid y el CPager 
        $this->dibujaVista(
            "indice",
            array(
                "filas" => $filas,
                "cabe" => $cabecera,
                "opcPag" => $opcPaginador,
                "datos" => $datos
            ),
            "lista de pokemon"
        );
    }


    public function accionNuevo()
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
            "vida" => 1,
            "ataque" => 1,
            "defensa" => 1,
            "ataque_especial" => 1,
            "defensa_especial" => 1,
            "velocidad" => 1,
            "foto" => ""
        ];

        /**
         * Se recogen todos los datos del nuevo Pokémon
         */
        if (isset($_POST["crear"])) {
            if (isset($_POST["nombre"])) {
                $datos["nombre"] = $_POST["nombre"];
            }

            if (isset($_POST["vida"])) {
                $datos["vida"] = $_POST["vida"];
            }

            if (isset($_POST["ataque"])) {
                $datos["ataque"] = $_POST["ataque"];
            }

            if (isset($_POST["defensa"])) {
                $datos["defensa"] = $_POST["defensa"];
            }

            if (isset($_POST["ataque_especial"])) {
                $datos["ataque_especial"] = $_POST["ataque_especial"];
            }


            if (isset($_POST["defensa_especial"])) {
                $datos["defensa_especial"] = $_POST["defensa_especial"];
            }

            if (isset($_POST["velocidad"])) {
                $datos["velocidad"] = $_POST["velocidad"];
            }

            $errores = [];

            //Recogida de la foto del Pokémon
            if ($_FILES["foto"]['error'] != UPLOAD_ERR_NO_FILE) {


                if ($_FILES["foto"]["error"] != 0) {
                    $errores["fichero"] = "Se ha producido un error al subir el fichero";
                }
                if (!$errores && !($_FILES["foto"]["type"] == 'image/png' || $_FILES["foto"]["type"] == 'image/jpeg')) {
                    $errores["tipo"] = 'El tipo de fichero no es correcto';
                }

                if (!$errores && $_FILES["foto"]["size"] > 2097152) {
                    $errores['tamaño'] = "El archivo no puede ser tan grande";
                }

                if (!file_exists(RUTA_BASE . '/imagenes/fotosPokemon')) {
                    mkdir(RUTA_BASE . '/imagenes/fotosPokemon/', 0777, true);
                }

                $_FILES["foto"]["name"] = $datos["foto"] = $datos["nombre"] . $_FILES["foto"]["name"];
                $ruta = RUTA_BASE . "/imagenes/fotosPokemon/" . $_FILES["foto"]["name"];
                if ($_FILES["foto"]["type"] == 'image/png' || $_FILES["foto"]["type"] == 'image/jpeg') {

                    move_uploaded_file($_FILES["foto"]["tmp_name"], $ruta);
                }
            }

            /**
             * Conexión con la API para crear un nuevo Pokémon
             */
            //creo una sesión CUrl
            $enlaceCurl = curl_init();
            //se indican las opciones para una petición HTTP Post
            curl_setopt(
                $enlaceCurl,
                CURLOPT_URL,
                "http://$_SERVER[SERVER_NAME]/pokemonAPI/API/"
            );
            curl_setopt($enlaceCurl, CURLOPT_POST, 1);
            curl_setopt(
                $enlaceCurl,
                CURLOPT_POSTFIELDS,
                "nombre=$datos[nombre]&vida=$datos[vida]&ataque=$datos[ataque]&defensa=$datos[defensa]&ataque_especial=$datos[ataque_especial]&defensa_especial=$datos[defensa_especial]&velocidad=$datos[velocidad]&foto=$datos[foto]"
            );
            curl_setopt($enlaceCurl, CURLOPT_HEADER, 0);
            curl_setopt($enlaceCurl, CURLOPT_RETURNTRANSFER, 1);
            //ejecuto la petición
            $devuelto = curl_exec($enlaceCurl);
            //cierro la sesión



            /**
             * Dependiendo de si hay errores se mostrará un resumen del Pokémon o se vuelve a la vista
             * de crear Pokémon
             */
            $devuelto = json_decode($devuelto, true);
            curl_close($enlaceCurl);

            if ($devuelto["correcto"]) {
                Sistema::app()->irAPagina(array("pokemon", "tipos"), array("id" => intval($devuelto["id"])));
            } else {
                unset($devuelto["correcto"]);
                //Muestro la vista inicalmente
                $this->dibujaVista(
                    "nuevo",
                    array("datos"=>$datos,"errores" => $devuelto),
                    "Crear pokemon"
                );
                exit;
            }
        } else {
            //Muestro la vista inicalmente
            $this->dibujaVista(
                "nuevo",
                array("datos"=>$datos),
                "Crear pokemon"
            );
            exit;
        }
    }

    public function accionTipos()
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
         * Si no tiene el permiso 5 se mostrará un error en el que se indicará que no posee el permiso
         * para avanzar a la página
         */
        if (!Sistema::app()->acceso()->puedePermiso(5)) {
            Sistema::app()->paginaError(404, "Acceso no permitido");
            exit;
        }
        if (isset($_REQUEST["id"])) {
            $id = intval($_REQUEST["id"]);

            $tipos = new PokemonTipos();


            $nombre = $tipos->getNombre();
            if (isset($_POST[$nombre])) {

                $tipos->setValores($_POST[$nombre]);

                $tipos->cod_pokemonInvent = intval($_REQUEST["id"]);
                //Compruebo si son valido los datos del pokemon
                if ($tipos->validar()) { //son validos los datos del pokemon

                    $sentencia="delete from pokemon_tipos where cod_pokemonInvent = '$_GET[id]'"; 
                    $consulta=Sistema::App()->BD()->crearConsulta($sentencia); 
                    //Almaceno el pokemon en la base de datos
                    if (!$tipos->guardar()) {
                        Sistema::app()->paginaError(404, "No se ha podido guardar la consulta en la BD");
                        exit;
                    }




                    Sistema::app()->irAPagina(array("pokemon", "indice"));
                    exit;
                } else { //No es valido, vuelvo a mostrar los valores
                    $this->dibujaVista(
                        "tipos",
                        array("modelo" => $tipos),
                        "Asignar Tipos"
                    );
                    exit;
                }
            }
            //Muestro la vista inicalmente
            $this->dibujaVista(
                "tipos",
                array("modelo" => $tipos),
                "Asignar Tipos"
            );
        }
    }


    /**
     * Acción que descarga la información de los Pokémon filtrados
     */
    public function accionDescargaPokemon()
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


        $sentWhere="";


        $pokemon = new Pokemon();
        /**
         * Se añade al apartado del where lo recogido de los filtros realizados
         */
        if (isset($_REQUEST["nombre"])) {
            $condiciones["nombre"] = CGeneral::addSlashes($_REQUEST["nombre"]);
            if ($sentWhere <> '')
                $sentWhere .= " and ";
            $datos["nombre"] = $_REQUEST["nombre"];
            $sentWhere .= " nombre like '%$datos[nombre]%' ";
        }

        if (isset($_REQUEST["borrado"])) {
            $condiciones["borrado"]=$_REQUEST["borrado"];

                if ($sentWhere <> '')
                    $sentWhere .= " and ";
                $datos["borrado"] = $_REQUEST["borrado"];
                $sentWhere .= " borrado = '" . intval($datos["borrado"]) . "' ";
        }

        //Se añade a los filtros los datos del where
        $opciones = array("where" => $sentWhere);



        //Buscar todos lor pokemon filtrados para poder dibujarlos en el CGrid posteriormente
        $filas = $pokemon->buscarTodos($opciones);

        /**
         * Descarga de información de todos los productos
         */
        $nombreSalida = "descargaPokemon.txt";
        header('Content-Type:' . 'text/plain');
        header('Content-Disposition:attachment;filename="' . $nombreSalida . '"');
        foreach ($filas as $fila => $value) {
            echo "NOMBRE: " . $value["nombre"] . PHP_EOL;
            echo "VIDA: " . $value["vida"] . PHP_EOL;
            echo "ATAQUE: " . $value["ataque"] . PHP_EOL;
            echo "DEFENSA: " . $value["defensa"] . PHP_EOL;
            echo "ATAQUE_ESPECIAL: " . $value["ataque_especial"] . PHP_EOL;
            echo "DEFENSA_ESPECIAL: " . $value["defensa_especial"] . PHP_EOL;
            echo "VELOCIDAD: " . $value["velocidad"] . PHP_EOL;
            echo "FOTO: " . $value["foto"] . PHP_EOL . PHP_EOL;

            echo "-----------------------------------" . PHP_EOL . PHP_EOL;
        }
        exit;
    }
}
