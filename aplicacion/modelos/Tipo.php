<?php

class Tipo extends CActiveRecord
{


    /**
     * Este método devuelve el nombre que se asignará al modelo. Este nombre es usado dentro del framework 
     * en otros componentes
     */
    protected function fijarNombre()
    {
        return 'tipo';
    }

    /**
     * Función que establece el nombre de la tabla en la BD relacionada con el modelo
     */
    protected function fijarTabla()
    {
        return "tipos";
    }

    /**
     * Función que establece el campo que se corresponde con la clave principal de la tabla
     */
    protected function fijarId()
    {
        return "cod_tipo";
    }

    /**
     * En este método se devuelve un array con la lista de atributos que tendrá el modelo.
     */
    protected function fijarAtributos()
    {
        return array(
            "cod_tipo", "nombre"
        );
    }

    /**
     * Método que asignas descripciones devolviendo un array asociativo con cada elemento de la forma 
     * “atributo” => “descripción”
     */
    protected function fijarDescripciones()
    {
        return array(
            "cod_tipo" => "Código de Tipo",
            "nombre" => "Nombre"
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
                    "ATRI" => "nombre", "TIPO" => "CADENA",
                    "TAMANIO" => 20
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
        return "INSERT INTO `tipos`(`nombre`) 
        VALUES ('$nombre')";

    }

    /**
     * Función que permite el correcto funcionamiento del método guardar, indicando la sentencia update
     */
    protected function fijarSentenciaUpdate()
    {
        $cod_tipo=intval($this->cod_tipo);
        $nombre = CGeneral::addSlashes($this->nombre);

        return "update tipos set " .
            "nombre = '$nombre'" .
            " where cod_producto='$cod_tipo' ";
    }


    /**
     * Método estático que devuelve todos los tipos posibles. Si no se indica un tipo devuelve  todos los tipos
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
