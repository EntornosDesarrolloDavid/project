<?php

class Shiny extends CActiveRecord
{


    /**
     * Este método devuelve el nombre que se asignará al modelo. Este nombre es usado dentro del framework 
     * en otros componentes
     */
    protected function fijarNombre()
    {
        return 'shiny';
    }

    /**
     * Función que establece el nombre de la tabla en la BD relacionada con el modelo
     */
    protected function fijarTabla()
    {
        return "shiny";
    }

    /**
     * Función que establece el campo que se corresponde con la clave principal de la tabla
     */
    protected function fijarId()
    {
        return "cod_shiny";
    }

    /**
     * En este método se devuelve un array con la lista de atributos que tendrá el modelo.
     */
    protected function fijarAtributos()
    {
        return array(
            "cod_shiny", "cod_usuario","id_pokemon", "nombre", "foto"
        );
    }

    /**
     * Método que asignas descripciones devolviendo un array asociativo con cada elemento de la forma 
     * “atributo” => “descripción”
     */
    protected function fijarDescripciones()
    {
        return array(
            "cod_shiny" => "Código de Shiny",
            "cod_usuario"=>"Código de Usuario",
            "nombre" => "Nombre",
            "id_pokemon" => "Id del Pokémon",
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
                    "ATRI" => "id_pokemon, nombre, foto",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "id_pokemon", "TIPO" => "ENTERO"
                ),
                array(
                    "ATRI" => "nombre", "TIPO" => "CADENA",
                    "TAMANIO" => 40
                ),
                array(
                    "ATRI" => "foto", "TIPO" => "CADENA",
                    "TAMANIO" => 100
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
        $id_pokemon = intval($this->id_pokemon);
        $foto =CGeneral::addSlashes($this->foto);
        $cod_usuario=intval(Sistema::app()->aclbd()->getCodUsuario(Sistema::app()->acceso()->getNick()));

        return "INSERT INTO `shiny`(`cod_usuario`, `id_pokemon`, `nombre`, `foto`) 
        VALUES ('$cod_usuario', '$id_pokemon','$nombre','$foto')";

    }

    /**
     * Función que permite el correcto funcionamiento del método guardar, indicando la sentencia update
     */
    protected function fijarSentenciaUpdate()
    {
        $cod_shiny=intval($this->cod_shiny);
        $nombre = CGeneral::addSlashes($this->nombre);
        $id_pokemon = intval($this->id_pokemon);
        $foto =CGeneral::addSlashes($this->foto);
        $cod_usuario=intval($this->cod_usuario);

        return "update shiny set " .
            "id_pokemon = '$id_pokemon',
            cod_usuario = '$cod_usuario',
            nombre = '$nombre',
            foto = '$foto'" .
            " where cod_shiny='$cod_shiny' ";
    }



}
