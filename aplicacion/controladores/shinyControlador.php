<?php
	 
	class shinyControlador extends CControlador
	{
		

        //Acción que espera la llegada de contenido en JSON, lo recibe y lo añade a la tabla Shiny mediante
        //el modelo correspondiente
        public function accionAddShiny()
		{
            // Obtenemos el json enviado
            $data = file_get_contents('php://input');
            
            // Los convertimos en un array
            $data = json_decode( $data, true );

            if (isset($data["id"], $data["nombre"], $data["foto"])) {
                $shiny=new Shiny();
                $id=intval($data["id"]);
                $nombre=trim($data["nombre"]);
                $foto=trim($data["foto"]);

                //Se establecen los valores en elmodelo
                $shiny->id_pokemon=$id;
                $shiny->nombre=$nombre;
                $shiny->foto=$foto;


                if ($shiny->validar()) { //Son validos los datos del login

                    if(!$shiny->guardar()){ //Se guarda el modelo en la BD
                        Sistema::app()->paginaError(404, "Error al insertar en la BD");
                        exit;
                    }
                    
            }
        }
	}
}
