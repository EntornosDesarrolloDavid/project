<?php

class Rol extends CActiveRecord
{


    /**
     * Este método devuelve el nombre que se asignará al modelo. Este nombre es usado dentro del framework 
     * en otros componentes
     */
    protected function fijarNombre()
    {
        return 'rol';
    }

    /**
     * Función que establece el nombre de la tabla en la BD relacionada con el modelo
     */
    protected function fijarTabla()
    {
        return "acl_roles";
    }

    /**
     * Función que establece el campo que se corresponde con la clave principal de la tabla
     */
    protected function fijarId()
    {
        return "cod_acl_role";
    }

    /**
     * En este método se devuelve un array con la lista de atributos que tendrá el modelo.
     */
    protected function fijarAtributos()
    {
        return array(
            "cod_acl_role", "nombre", "perm1", "perm2", "perm3", "perm4", "perm5", "perm6", "perm7", "perm8", "perm9", "perm10"
        );
    }

    /**
     * Método que asignas descripciones devolviendo un array asociativo con cada elemento de la forma 
     * “atributo” => “descripción”
     */
    protected function fijarDescripciones()
    {
        return array(
            "cod_acl_role" => "Código de Rol",
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
                    "ATRI" => "cod_acl_role, nombre",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_acl_role", "TIPO" => "ENTERO"
                ),
                array(
                    "ATRI" => "nombre", "TIPO" => "CADENA",
                    "TAMANIO" => 40
                ),
                array(
                    "ATRI" => "perm1, perm2, perm3, perm4, perm5, perm6, perm7, perm8, perm9, perm10, ", "TIPO" => "ENTERO",
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
        $perm1 = intval($this->perm1);
        $perm2 = intval($this->perm2);
        $perm3 = intval($this->perm3);
        $perm4 = intval($this->perm4);
        $perm5 = intval($this->perm5);
        $perm6 = intval($this->perm6);
        $perm7 = intval($this->perm7);
        $perm8 = intval($this->perm8);
        $perm9 = intval($this->perm9);
        $perm10 = intval($this->perm10);

        $borrado=intval(0);
        return "INSERT INTO `acl_roles`(`nombre`, `perm1`, `perm2`, `perm3`, `perm4`, `perm5`, 
        `perm6`, `perm7`, `perm8`, `perm9`, `perm10`) 
        VALUES ('$nombre', '$perm1','$perm2','$perm3','$perm4','$perm5','$perm6','$perm7','$perm8','$perm9','$perm10')";

    }

    /**
     * Función que permite el correcto funcionamiento del método guardar, indicando la sentencia update
     */
    protected function fijarSentenciaUpdate()
    {
        $cod_acl_rol=intval($this->cod_acl_role);
        $nombre = CGeneral::addSlashes($this->nombre);
        $perm1 = intval($this->perm1);
        $perm2 = intval($this->perm2);
        $perm3 = intval($this->perm3);
        $perm4 = intval($this->perm4);
        $perm5 = intval($this->perm5);
        $perm6 = intval($this->perm6);
        $perm7 = intval($this->perm7);
        $perm8 = intval($this->perm8);
        $perm9 = intval($this->perm9);
        $perm10 = intval($this->perm10);
        return "update acl_roles set " .
            "nombre = '$nombre',
            perm1 = '$perm1',
            perm2 = '$perm2',
            perm3 = '$perm3',
            perm4 = '$perm4',
            perm5 = '$perm5',
            perm6 = '$perm6',
            perm7= '$perm7',
            perm8= '$perm8',
            perm9= '$perm9',
            perm10= '$perm10'" .
            " where cod_producto='$cod_acl_rol' ";
    }


        /**
     * Método estático que devuelve todos los roles posibles. Si no se indica un rol devuelve  todos los roles
     * y si se indica devuelve el indicado o false si no existe
     */
    public static function dameRoles($codigo = null)
    {

        $sentencia="select * from acl_roles";
        //ejecuto la sentencia
        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        $filas=$consulta->filas();
        foreach ($filas as $valor => $fila) {
            $categorias[$fila["cod_acl_role"]]=$fila["nombre"];
        }

        if ($codigo === null)
            return $categorias;
        else {
            if (isset($categorias[$codigo]))
                return $categorias[$codigo];

            else
                return false;
        }
    }
}
