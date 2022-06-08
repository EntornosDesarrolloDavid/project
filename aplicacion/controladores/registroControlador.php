<?php
	 
	class registroControlador extends CControlador
	{
		public function accionRegister()
		{
			//Creo un nuevo objeto Login
            $usuario = new Usuario();

            //Nombre del modelo= nombre del array por post
            $nombre = $usuario->getNombre();
            if (isset($_POST[$nombre])) {
                
                //Asigno los valores al login a partir de lo recogido 
                $usuario->setValores($_POST[$nombre]);
    
                //Compruebo si son validos los datos del login
                if ($usuario->validar()) { //Son validos los datos del login
    
                    if($usuario->verificar()){

                        //Almaceno el usuario en la base de datos
                        if (!$usuario->guardar()) {
                            Sistema::app()->paginaError(404, "No se ha podido guardar la consulta en la BD");
                            exit;
                        }

                        if(!$usuario->registrar()){
                            Sistema::app()->paginaError(404, "No se ha podido guardar la consulta en la BD");
                            exit;
                        }

                        //Al mismo tiempo que se registra se le permitirá logearse sin necesidad
                        //de volver a introducir los datos
                        $login= new Login();
                        $login->nick=$usuario->nick;
                        $login->password=$usuario->contrasenia;

                                    //Compruebo si son validos los datos del login
                        if ($login->validar()) { //Son validos los datos del login

                            //Se comprueba si los datos existen en la ACL
                            if($login->autenticar()){
                                Sistema::app()->IrAPagina(array("principales", "index"));
                                exit;
                            }
                            else{
                                $this->dibujaVista(
                                    "login",
                                    array("modelo" => $login),
                                    "Login"
                                );
                                exit;
                            }

            
                            
                        }
                    }
                    else{
                        $this->dibujaVista(
                            "register",
                            array("modelo" => $usuario),
                            "Registrarse"
                        );
                        exit;
                    }
    
     
                    
                } else { //No es valido, vuelvo a mostrar los valores
                    $this->dibujaVista(
                        "register",
                        array("modelo" => $usuario),
                        "Registrarse"
                    );
                    exit;
                }
            }
			//Muestro la vista inicialmente
            $this->dibujaVista(
                "register",
                array("modelo" => $usuario),
                "Registrarse"
            );

		
    }

        public function accionLogin(){

        //Creo un nuevo objeto Login
        $login = new Login();

        //Nombre del modelo= nombre del array por post
        $nombre = $login->getNombre();
        if (isset($_POST[$nombre])) {
            
            //Asigno los valores al login a partir de lo recogido 
            $login->setValores($_POST[$nombre]);

            //Compruebo si son validos los datos del login
            if ($login->validar()) { //Son validos los datos del login

                if($login->autenticar()){
					Sistema::app()->IrAPagina(array("principales", "index"));
                    exit;
                }
                else{
                    $this->dibujaVista(
                        "login",
                        array("modelo" => $login),
                        "Login"
                    );
                    exit;
                }

 
                
            } else { //No es valido, vuelvo a mostrar los valores
                $this->dibujaVista(
                    "login",
                    array("modelo" => $login),
                    "Login"
                );
                exit;
            }
        }

        //Muestro la vista inicialmente
        $this->dibujaVista(
            "login",
            array("modelo" => $login),
            "Login"
        );
        }

        public function accionCerrarSesion(){

            if (Sistema::app()->acceso()->hayUsuario()) {
                Sistema::app()->acceso()->quitarRegistroUsuario();
                Sistema::app()->irAPagina(array("principales", "index"));
            }
        }
		
	}
