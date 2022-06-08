<?php

class Combate extends CActiveRecord
{


    /**
     * Este método devuelve el nombre que se asignará al modelo. Este nombre es usado dentro del framework 
     * en otros componentes
     */
    protected function fijarNombre()
    {
        return 'combate';
    }

    /**
     * Función que establece el nombre de la tabla en la BD relacionada con el modelo
     */
    protected function fijarTabla()
    {
        return "combates";
    }

    /**
     * Función que establece el campo que se corresponde con la clave principal de la tabla
     */
    protected function fijarId()
    {
        return "cod_combate";
    }

    /**
     * En este método se devuelve un array con la lista de atributos que tendrá el modelo.
     */
    protected function fijarAtributos()
    {
        return array(
            "cod_combate", "cod_pokemonInvent", "resultado", "fecha"
        );
    }

    /**
     * Método que asignas descripciones devolviendo un array asociativo con cada elemento de la forma 
     * “atributo” => “descripción”
     */
    protected function fijarDescripciones()
    {
        return array(
            "cod_combate" => "Código de Combate",
            "cod_pokemonInvent" => "Código de Pokémon",
            "resultado" => "Resultado",
            "fecha" => "Fecha"
        );
    }


    /**
     * Operaciones a realizar tras cargar el modelo desde base de datos
     */
    protected function afterCreate()
    {
        $actual = new DateTime();
        $fecha=$actual->format('d/m/Y');

        $this->fecha = $fecha;


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
                    "ATRI" => "cod_pokemonInvent, resultado, fecha",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_pokemonInvent", "TIPO" => "ENTERO"
                ),
                array(
                    "ATRI" => "resultado", "TIPO" => "CADENA",
                    "TAMANIO" => 10
                ),
                array("ATRI" => "fecha", "TIPO" => "FECHA"),

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
        $resultado = CGeneral::addSlashes($this->resultado);
        $fecha = CGeneral::fechaNormalAMysql($this->fecha);
        $cod_pokemonInvent =intval($this->cod_pokemonInvent);

        return "INSERT INTO `combates`(`cod_pokemonInvent`, `resultado`, `fecha`) 
        VALUES ('$cod_pokemonInvent','$resultado','$fecha')";

    }

    /**
     * Función que permite el correcto funcionamiento del método guardar, indicando la sentencia update
     */
    protected function fijarSentenciaUpdate()
    {
        $cod_combate=intval($this->cod_combate);
        $resultado = CGeneral::addSlashes($this->resultado);
        $fecha = CGeneral::fechaNormalAMysql($this->fecha);
        $cod_pokemonInvent =intval($this->cod_pokemonInvent);

        return "update combates set " .
            "cod_pokemonInvent = '$cod_pokemonInvent',
            resultado = '$resultado',
            fecha = '$fecha'" .
            " where cod_combate='$cod_combate' ";
    }
}
