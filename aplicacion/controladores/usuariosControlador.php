<?php
	 
	class usuariosControlador extends CControlador
	{
		public function acciongetuser(){
            echo Sistema::app()->acceso()->getNombre();
        }
        
        public function accionindice()
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
        $datos=[
            "nombre"=>"",
            "rol"=>"",
            "borrado"=>0
        ];

        //Creación del modelo del usuario
        $usuario = new Usuario();

        // //Establezco las opciones de filtrado
        $opciones = array();
        $sentWhere="";

        $condiciones=[];

        /**
         * Si se desea eliminar el filtrado se eliminarán todos los parámetros de la URL
         */
        if (isset($_POST["todos"])) {
            Sistema::app()->irAPagina(array("usuarios","indice"));

        }

        /**
         * Si se ha presionado en filtrar
         */
        if (isset($_POST["fil"])) {


            /**
             * Si se ha indicado el nombre se filtrarán los usuarios que sean similares a éste y se guardará el nombre
             * en el array condiciones que se pasará a la URL como parámetro
             */
            if (isset($_POST["nombre"]) && $_POST["nombre"] != "") {
                $condiciones["nombre"]=trim($_POST["nombre"]);

            }

            /**
             * Si se ha indicado rol se filtrarán usuarios de esa misma y se guardará el código de rol
             * en el array condiciones que se pasará a la URL como parámetro
             */
            if (isset($_POST["rol"]) && $_POST["rol"] != "") {
                $condiciones["rol"]=intval($_POST["rol"]);

            }

            /**
             * Filtrado de usuarios según si está borrado o no y se guardará el borrado
             * en el array condiciones que se pasará a la URL como parámetro
             */
            if (isset($_POST["borrado"])) {
                $condiciones["borrado"]=intval($_POST["borrado"]);

            }
            else $condiciones["borrado"]=0;
            Sistema::app()->irAPagina(array("usuarios","indice"), $condiciones);
        }

        /**
         * Si están establecidos como parámetros de la URL alguno de los campos anteriores, se añadirá al
         * sentWhere para filtrar por ese campo
         */
        if (isset($_REQUEST["nombre"])) {
            $condiciones["nombre"]=CGeneral::addSlashes($_REQUEST["nombre"]);
            if ($sentWhere <> '')
                $sentWhere .= " and ";
            $datos["nombre"] = $_REQUEST["nombre"];
            $sentWhere .= " nombre like '%$datos[nombre]%' ";
        }

        if (isset($_REQUEST["rol"])) {
            $condiciones["rol"]=$_REQUEST["rol"];

            if ($sentWhere <> '')
                $sentWhere .= " and ";
            $datos["rol"] = $_REQUEST["rol"];
            $sentWhere .= " cod_acl_role = '" . intval($datos["rol"]) . "' ";
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
        $opciones=array("where"=>$sentWhere);


        /**
         * Control del funcionamiento del CPager
         */
        $pag=1;
        if (isset($_GET["pag"]))
            $pag=intval($_GET["pag"]);

        $regPagina=10;
        if (isset($_GET["reg_pag"]))
            $regPagina=intval($_GET["reg_pag"]);



        //Busco el número de registros tras el filtro
        $total=$usuario->buscarTodosNRegistros();

        $paginas=ceil($total/$regPagina);

        if ($pag>$paginas) {
            $pag=$paginas;
        }

        $condLimit=(($pag-1)*$regPagina).",".$regPagina;

        $opciones["limit"]=$condLimit;

        //Buscar todos lor usuarios filtrados para poder dibujarlos en el CGrid posteriormente
        $filas = $usuario->buscarTodos($opciones);
        foreach ($filas as $clave => $valor) {

                //Mostrar Borrado Como SÍ o NO
                if($filas[$clave]["borrado"]==0) $filas[$clave]["borrado"]="NO";
                else $filas[$clave]["borrado"]="SÍ";


            //Creación de imágenes que redirigen a las distintas operaciones de los usuarios
            $cadena = CHTML::link(
                CHTML::imagen("/imagenes/24x24/ver.png"),
                Sistema::app()->generaURL(
                    array("usuarios", "ver"),
                    array("id" => $filas[$clave]["cod_usuario"])
                )
            );
            $cadena .= CHTML::link(
                CHTML::imagen(
                    '/imagenes/24x24/modificar.png'
                ),
                Sistema::app()->generaURL(
                    array("usuarios", "modificar"),
                    array("id" => $filas[$clave]["cod_usuario"])
                )
            );

            //Si el usuario ya está borrado no aparecerá la opción de borrar
            $cadena .= CHTML::link(
                CHTML::imagen(
                    '/imagenes/24x24/borrar.png'
                ),
                Sistema::app()->generaURL(
                    array("usuarios", "borrar"),
                    array("id" => $filas[$clave]["cod_usuario"])
                ),
            );
            
            $filas[$clave]["opciones"] = $cadena;
        }

        //Definiciones de las cabeceras de las columnas para el CGrid
        $cabecera = array(
            array(
                "ETIQUETA" => "CÓDIGO",
                "CAMPO" => "cod_usuario"
            ),
            array(
                "ETIQUETA" => "NOMBRE",
                "CAMPO" => "nombre"
            ),
            array(
                "CAMPO" => "nick",
                "ETIQUETA" => "Nick"
            ),
            array(
                "CAMPO" => "nombre_rol",
                "ETIQUETA" => "ROL",
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
            "URL" => Sistema::app()->generaURL(array("usuarios", "indice"),
            $condiciones),
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
            "lista de usuarios"
        );
    }

    public function accionModificar(){
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
        //Creación de un modelo usuario
        $usuario = new Usuario();

        if (isset($_REQUEST["id"])) {

        //Buscar por Id el usuario elegido
        $usuario->buscarPorId(intval($_REQUEST["id"]));

        $usuario->contrasenia="";
        $nombre = $usuario->getNombre();

        if (isset($_POST["modificar"])) {
            $usuario->setValores($_POST[$nombre]);

                    //Compruebo si son valido los datos del usuario
                    if ($usuario->validar()) { //son validos los datos del usuario


                        //Almaceno el usuario en la ACL
                        if (!$usuario->actualizarACL(false)) {
                            Sistema::app()->paginaError(404, "No se ha podido guardar la consulta en la BD");
                            exit;
                        }
                        //Almaceno el usuario en la base de datos
                        if (!$usuario->guardar()) {
                            Sistema::app()->paginaError(404, "No se ha podido guardar la consulta en la BD");
                            exit;
                        }


        
                        //Redirecciono a la página de listado de todos los usuarios
                        Sistema::app()->irAPagina(array(
                            "usuarios",
                            "indice"
                        ));
                        exit;
                    } else { //No es valido, vuelvo a mostrar los valores
                        $this->dibujaVista(
                            "modificar",
                            array("modelo" => $usuario),
                            "Crud usuarios"
                        );
                        exit;
                    }

        Sistema::app()->irAPagina(array(
            "usuarios",
            "indice"
        ));
        exit;
    }
        //muestro la vista inicalmente
        $this->dibujaVista(
            "modificar",
            array("modelo" => $usuario),
            "Modificar usuario"
        );
    }
    else{
        Sistema::app()->paginaError(404, "ID no indicado");
        exit;
    }
    }

    public function accionVer(){
        
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
        //Creación de un nuevo modelo usuario
        $usuario=new Usuario();

        if (isset($_REQUEST["id"])) {

        //Buscar por Id el usuario elegido
        $usuario->buscarPorId(intval($_REQUEST["id"]));


        //Dibujar la vista Ver
        $this->dibujaVista(
            "ver",
            array("modelo" => $usuario),
            "Ver usuario"
        );
    }
    else{
        Sistema::app()->paginaError(404, "ID no indicado");
        exit;
    }
    }

    public function accionBorrar(){
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
        //Creación de un modelo usuario
        $usuario = new Usuario();

        if (isset($_REQUEST["id"])) {

        //Buscar por Id el usuario elegido
        $usuario->buscarPorId(intval($_REQUEST["id"]));

        //Cambiar el borrado a 1 (borrado lógico)
        $usuario->borrado^=1;

        $usuario->confirmar_contrasenia=$usuario->contrasenia;
        if (isset($_POST["borrar"])) {
        
                    //Compruebo si son valido los datos del usuario
                    if ($usuario->validar()) { //son validos los datos del usuario


                        if (!$usuario->actualizarACL(true)) {
                            Sistema::app()->paginaError(404, "No se ha podido guardar la consulta en la BD");
                            exit;
                        }
                        //Almaceno el usuario en la base de datos
                        if (!$usuario->guardar()) {
                            Sistema::app()->paginaError(404, "No se ha podido guardar la consulta en la BD");
                            exit;
                        }


        
                        //Redirecciono a la página de listado de todos los usuarios
                        Sistema::app()->irAPagina(array(
                            "usuarios",
                            "indice"
                        ));
                        exit;
                    } else { //No es valido, vuelvo a mostrar los valores
                        $this->dibujaVista(
                            "borrar",
                            array("modelo" => $usuario),
                            "Crud usuarios"
                        );
                        exit;
                    }

        Sistema::app()->irAPagina(array(
            "usuarios",
            "indice"
        ));
        exit;
    }
        //muestro la vista inicalmente
        $this->dibujaVista(
            "borrar",
            array("modelo" => $usuario),
            "Borrar usuario"
        );
    }
    else{
        Sistema::app()->paginaError(404, "ID no indicado");
        exit;
    }
    }

    public function accionNuevo(){

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
        //Creo un nuevo objeto usuario
        $usuario = new Usuario();

        //Nombre del modelo= nombre del array por post
        $nombre = $usuario->getNombre();
        if (isset($_POST[$nombre])) {
            //Asigno los valores al usuario a partir de lo recogido del formulario
            $usuario->setValores($_POST[$nombre]);

            //Compruebo si son valido los datos del usuario
            if ($usuario->validar()) { //son validos los datos del usuario

                //Almaceno el usuario en la base de datos
                if (!$usuario->guardar()) {
                    Sistema::app()->paginaError(404, "No se ha podido guardar la consulta en la BD");
                    exit;
                }
                if(!$usuario->registrar()){
                    Sistema::app()->paginaError(404, "No se ha podido guardar la consulta en la BD");
                    exit;
                }
                
                Sistema::app()->irAPagina(array("principales", "index"));
                exit;
                
                exit;
            } else { //No es valido, vuelvo a mostrar los valores
                $this->dibujaVista(
                    "nuevo",
                    array("modelo" => $usuario),
                    "Crear Usuario"
                );
                exit;
            }
        }

        //Muestro la vista inicalmente
        $this->dibujaVista(
            "nuevo",
            array("modelo" => $usuario),
            "Crear Usuario"
        );
    }
}
