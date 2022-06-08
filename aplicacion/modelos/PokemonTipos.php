<?php

class PokemonTipos extends CActiveRecord
{


    /**
     * Este método devuelve el nombre que se asignará al modelo. Este nombre es usado dentro del framework 
     * en otros componentes
     */
    protected function fijarNombre()
    {
        return 'poketipo';
    }

    /**
     * Función que establece el nombre de la tabla en la BD relacionada con el modelo
     */
    protected function fijarTabla()
    {
        return "pokemon_tipos";
    }

    /**
     * Función que establece el campo que se corresponde con la clave principal de la tabla
     */
    protected function fijarId()
    {
        return "cod_pokemon_tipo";
    }

    /**
     * En este método se devuelve un array con la lista de atributos que tendrá el modelo.
     */
    protected function fijarAtributos()
    {
        return array(
            "cod_pokemon_tipo", "cod_pokemonInvent", "cod_tipo1", "cod_tipo2"
        );
    }

    /**
     * Método que asignas descripciones devolviendo un array asociativo con cada elemento de la forma 
     * “atributo” => “descripción”
     */
    protected function fijarDescripciones()
    {
        return array(
            "cod_tipo1" => "Primer Tipo",
            "cod_tipo2" => "Segundo Tipo",
            "cod_pokemon_tipo" => "Tipo",
            "cod_pokemonInvent" => "Código de Pokémon"
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
                    "ATRI" => "cod_pokemonInvent, cod_tipo1",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_pokemonInvent, cod_tipo1, cod_tipo2", "TIPO" => "ENTERO"
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
        $cod_pokemon = intval($this->cod_pokemonInvent);
        $cod_tipo1= intval($this->cod_tipo1);
        $cod_tipo2= intval($this->cod_tipo2);
        if ($cod_tipo2==0) {
            return "INSERT INTO `pokemon_tipos`(`cod_pokemonInvent`, `cod_tipo`) 
            VALUES ('$cod_pokemon','$cod_tipo1')";
        }
        else{
            return "INSERT INTO `pokemon_tipos`(`cod_pokemonInvent`, `cod_tipo`) 
            VALUES ('$cod_pokemon','$cod_tipo1'),
            ('$cod_pokemon','$cod_tipo2')";
        }


    }

    /**
     * Función que permite el correcto funcionamiento del método guardar, indicando la sentencia update
     */
    protected function fijarSentenciaUpdate()
    {
        $cod_pokemon_tipo=intval($this->cod_pokemon_tipo);
        $cod_pokemon = intval($this->cod_pokemonInvent);
        $cod_tipo= intval($this->cod_tipo);

        return "update pokemon_tipos set " .
            "cod_pokemonInvent = '$cod_pokemon',
            cod_Tipo='$cod_tipo'" .
            " where cod_pokemon_tipo='$cod_pokemon_tipo' ";
    }


    /**
     * Método estático que devuelve todos los roles posibles. Si no se indica un rol devuelve  todos los roles
     * y si se indica devuelve el indicado o false si no existe
     */
    public static function dameTipos($codigo = null)
    {

        $sentencia="select * from tipos";
        //ejecuto la sentencia
        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        $filas=$consulta->filas();
        foreach ($filas as $valor => $fila) {
            $tipos[$fila["cod_tipo"]]=$fila["nombre"];
        }

        if ($codigo === null)
            return $tipos;
        else {
            if (isset($tipos[$codigo]))
                return $tipos[$codigo];

            else
                return false;
        }
    }
}
