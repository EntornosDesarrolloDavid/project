<?php

class pokemonAPIControlador extends CControlador
{
    public function accionAPI()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            

            $datos = [
                "id" => "",
                "borrado" => ""
            ];

            /**
             * Se recogen los parámetros indicados y se guardan en la condición where para poder filtrar
             */
            $sentWhere = "";
            if (isset($_GET["id"])) {
                $condiciones["id"] = $_GET["id"];

                if ($sentWhere <> '')
                    $sentWhere .= " and ";
                $datos["id"] = $_GET["id"];
                $sentWhere .= " cod_pokemonInvent = '" . intval($datos["id"]) . "' ";
            }

            if (isset($_GET["borrado"])) {
                $condiciones["borrado"] = $_GET["borrado"];

                if ($sentWhere <> '')
                    $sentWhere .= " and ";
                $datos["borrado"] = $_GET["borrado"];
                $sentWhere .= " borrado = '" . intval($datos["borrado"]) . "' ";
            }

            $data = [];

            //Se crea un modelo y se busca según lo establecido anteriormente
            $poke = new Pokemon();
            $opciones=array("where"=>$sentWhere);

            /**
             * Se validan y verifican los datos. En caso de que se produzca un error se enviará el parámetro
             * correcto a false y una lista de los errores
             */
            if ($poke->buscarPor($opciones)) {
                $data["correcto"] = true;
                foreach ($poke as $key => $value) {
                    $data[$key] = $value;
                }
            } else $data["correcto"] = false;




            $res = json_encode($data, JSON_PRETTY_PRINT);
            echo $res;
            exit;
        }


        /**
         * 
         * 
         * Inserción de un nuevo Pokémon por POST
         * 
         * 
         */
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $poke = new Pokemon();
            /**
             * Se recogen los valores y se introducen en un array para realizar un setValores
             */
            $valores = array(
                "nombre" => $_POST["nombre"],
                "vida" => $_POST["vida"],
                "ataque" => $_POST["ataque"],
                "defensa" => $_POST["defensa"],
                "ataque_especial" => $_POST["ataque_especial"],
                "defensa_especial" => $_POST["defensa_especial"],
                "velocidad" => $_POST["velocidad"],
                "foto" => $_POST["foto"]
            );

            $poke->setValores($valores);

            /**
             * Se validan y verifican los datos. En caso de que se produzca un error se enviará el parámetro
             * correcto a false y una lista de los errores
             */
            if ($poke->validar()) { //son validos los datos del pokemon

                if ($poke->verificar()) {


                    //Almaceno el pokemon en la base de datos
                    if (!$poke->guardar()) {
                        $res = $poke->getErrores();
                        $res["correcto"] = false;

                        $res = json_encode($res, JSON_PRETTY_PRINT);

                        echo $res;
                        exit;
                    }

                    $consulta = Sistema::app()->BD()->crearConsulta("select cod_pokemonInvent from pokemon where nombre='$poke->nombre'");
                    $filas = $consulta->filas();
                    $res["id"] = $filas[0]["cod_pokemonInvent"];
                    $res["correcto"] = true;

                    $res = json_encode($res, JSON_PRETTY_PRINT);

                    echo $res;
                    exit;
                }
                $res = $poke->getErrores();
                $res["correcto"] = false;

                $res = json_encode($res, JSON_PRETTY_PRINT);

                echo $res;
                exit;
            }

            $res = $poke->getErrores();
            $res["correcto"] = false;
            $res = json_encode($res, JSON_PRETTY_PRINT);
            echo $res;
            exit;
        }



        /**
         * 
         * 
         * Método de modificación a través de PUT
         * 
         * 
         */
        if ($_SERVER["REQUEST_METHOD"] == "PUT") {


            $poke = new Pokemon();

            //Recogida de los parámetros
            $parametros = $this->recogerParametros();

            /**
             * Se busca el Pokémon indicado y si no se le ha pasado foto, ésta no se modificará
             */
            if (isset($parametros["id"])) {
                $poke->buscarPorId(intval($parametros["id"]));
            }

            if ($parametros["foto"] == "") {
                unset($parametros["foto"]);
            }

            $poke->setValores($parametros);


            /**
             * Se validan y verifican los datos. En caso de que se produzca un error se enviará el parámetro
             * correcto a false y una lista de los errores
             */
            if ($poke->validar()) { //son validos los datos del pokemon


                //Almaceno el pokemon en la base de datos
                if (!$poke->guardar()) {
                    if (!$poke->getErrores()) {
                        $res["correcto"] = false;
                        $res["Nombre"]="Nombre ya existente";
                        $res = json_encode($res, JSON_PRETTY_PRINT);
    
                        echo $res;
                        exit;
                    }
                    $res = $poke->getErrores();
                    $res["correcto"] = false;

                    $res = json_encode($res, JSON_PRETTY_PRINT);

                    echo $res;
                    exit;
                }

                $consulta = Sistema::app()->BD()->crearConsulta("select cod_pokemonInvent from pokemon where nombre='$poke->nombre'");
                $filas = $consulta->filas();
                $res["id"] = $filas[0]["cod_pokemonInvent"];
                $res["correcto"] = true;

                $res = json_encode($res, JSON_PRETTY_PRINT);

                echo $res;
                exit;
            }

            $res = $poke->getErrores();
            $res["correcto"] = false;
            $res = json_encode($res, JSON_PRETTY_PRINT);
            echo $res;
            exit;
        }




        /**
         * 
         * 
         * Borrado lógico de un Pokémon a través de DELETE
         * 
         * 
         */

        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            //petición por DELETE-> es un borrado
            
            
            //recojo los parámetros
            $parametros = $this->recogerParametros();
            //se recoge el id del Pokémon a borrar, se busca y se borra. En caso de que se produzca
            //algún error se devolverá el parámetro correcto a false y a true si no hay errores
            $data = [];
            if (isset($parametros["id"])) //se ha pasado id
            {
                $id = intval($parametros["id"]);

                $poke = new Pokemon();

                if ($poke->buscarPorId($id)) {
                    $poke->borrado ^= 1;

                    if (!$poke->guardar()) {
                        $data["correcto"] = false;
                    } else $data["correcto"] = true;
                } else $data["correcto"] = false;
            } else $data["correcto"] = false;

            $res = json_encode($data, JSON_PRETTY_PRINT);
            echo $res;
            exit;
        }
    }



    function recogerParametros()
    {
        //recojo los parámetros
        $ficEntrada = fopen("php://input", "r");
        $datos = "";
        while ($leido = fread($ficEntrada, 1024)) {
            $datos .= $leido;
        }
        fclose($ficEntrada);
        //convierto los datos en variables
        $par = [];
        $partes = explode("&", $datos);
        foreach ($partes as $parte) {
            $p = explode("=", $parte);
            if (count($p) == 2)
                $par[$p[0]] = $p[1];
        }
        return $par;
    }
}
