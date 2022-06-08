<?php

class Pokemon extends CActiveRecord
{


    /**
     * Este método devuelve el nombre que se asignará al modelo. Este nombre es usado dentro del framework 
     * en otros componentes
     */
    protected function fijarNombre()
    {
        return 'poke';
    }

    /**
     * Función que establece el nombre de la tabla en la BD relacionada con el modelo
     */
    protected function fijarTabla()
    {
        return "pokemon";
    }

    /**
     * Función que establece el campo que se corresponde con la clave principal de la tabla
     */
    protected function fijarId()
    {
        return "cod_pokemonInvent";
    }

    /**
     * En este método se devuelve un array con la lista de atributos que tendrá el modelo.
     */
    protected function fijarAtributos()
    {
        return array(
            "cod_pokemonInvent","foto", "nombre", "vida", "ataque", "defensa", "ataque_especial", "defensa_especial", "velocidad", "borrado"
        );
    }

    /**
     * Método que asignas descripciones devolviendo un array asociativo con cada elemento de la forma 
     * “atributo” => “descripción”
     */
    protected function fijarDescripciones()
    {
        return array(
            "cod_pokemonInvent" => "Código de Pokémon",
            "nombre" => "Nombre",
            "vida" => "Vida",
            "ataque" => "Ataque",
            "defensa" => "Defensa",
            "ataque_especial" => "Ataque Especial",
            "defensa_especial" => "Defensa Especial",
            "velocidad" => "Velocidad",
            "borrado" => "Borrado",
            "foto" => "Foto"

        );
    }

    /**
     * Método que indica las restricciones de los campos. Estas restricciones incluyen desde la definición 
     * de los tipos de datos a la comprobación de los valores
     */
    protected function fijarRestricciones()
    {
        return
            array(
                array(
                    "ATRI" => "nombre",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "nombre, foto", "TIPO" => "CADENA",
                    "TAMANIO" => 40
                ),
                array(
                    "ATRI" => "vida, ataque, defensa, ataque_especial, defensa_especial, velocidad", "TIPO" => "ENTERO",
                    "MIN" => 1, "MAX" => 255,
                    "MENSAJE"=>"El Número debe estar entre 1 y 255"
                ),
                array(
                    "ATRI" => "borrado", "TIPO" => "ENTERO",
                    "MIN" => 0, "MAX" => 1
                )

            );
    }


    /**
     * Operaciones a realizar al cargar el modelo desde la base de datos
     */
    protected function afterBuscar()
    {

    }



    /**
     * Función que permite el correcto funcionamiento del método guardar, indicando la sentencia insert
     */
    protected function fijarSentenciaInsert()
    {
        $nombre = CGeneral::addSlashes($this->nombre);
        $ataque = intval($this->ataque);
        $defensa = intval($this->defensa);
        $ataqueEspecial = intval($this->ataque_especial);
        $defensaEspecial = intval($this->defensa_especial);
        $velocidad = intval($this->velocidad);
        $vida = intval($this->vida);
        $foto = CGeneral::addSlashes($this->foto);
        $borrado=intval(0);

        return "INSERT INTO `pokemon`(`nombre`, `vida`, `ataque`, `defensa`, 
        `ataque_especial`, `defensa_especial`, `velocidad`, `foto`, `borrado`) 
        VALUES ('$nombre','$vida','$ataque','$defensa','$ataqueEspecial','$defensaEspecial',
        '$velocidad', '$foto', '$borrado')";

    }

    /**
     * Función que permite el correcto funcionamiento del método guardar, indicando la sentencia update
     */
    protected function fijarSentenciaUpdate()
    {
        $cod_pokemon=intval($this->cod_pokemonInvent);
        $nombre = CGeneral::addSlashes($this->nombre);
        $ataque = intval($this->ataque);
        $defensa = intval($this->defensa);
        $ataqueEspecial = intval($this->ataque_especial);
        $defensaEspecial = intval($this->defensa_especial);
        $velocidad = intval($this->velocidad);
        $vida = intval($this->vida);
        $foto = CGeneral::addSlashes($this->foto);
        $borrado=intval($this->borrado);

        return "update pokemon set " .
            "nombre = '$nombre',
            vida = '$vida',
            ataque = '$ataque',
            defensa = '$defensa',
            ataque_especial = '$ataqueEspecial',
            defensa_especial = '$defensaEspecial',
            velocidad = '$velocidad',
            foto = '$foto',
            borrado= '$borrado'" .
            " where cod_pokemonInvent='$cod_pokemon' ";
    }



    /**
     * Función que verifica si el nombre del Pokémon ya existe o no
     */
    public function verificar(){
        $sentencia="select * from pokemon";
        //ejecuto la sentencia
        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        $filas=$consulta->filas();
        foreach ($filas as $valor => $fila) {
            if ($this->nombre==$fila["nombre"]) {
                $this->setError(
                    "nombre",
                    "Nombre ya existente"
                );
                return false;
            }
        }
        return true;
    }



}
