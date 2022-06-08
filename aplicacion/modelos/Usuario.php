<?php

class Usuario extends CActiveRecord
{


    /**
     * Este método devuelve el nombre que se asignará al modelo. Este nombre es usado dentro del framework 
     * en otros componentes
     */
    protected function fijarNombre()
    {
        return 'user';
    }

    /**
     * Función que establece el nombre de la tabla en la BD relacionada con el modelo
     */
    protected function fijarTabla()
    {
        return "info_usuarios";
    }

    /**
     * Función que establece el campo que se corresponde con la clave principal de la tabla
     */
    protected function fijarId()
    {
        return "cod_usuario";
    }

    /**
     * En este método se devuelve un array con la lista de atributos que tendrá el modelo.
     */
    protected function fijarAtributos()
    {
        return array(
            "cod_usuario", "cod_rol","nick", "nombre", "borrado", "foto", "contrasenia", "confirmar_contrasenia"
        );
    }

    /**
     * Método que asignas descripciones devolviendo un array asociativo con cada elemento de la forma 
     * “atributo” => “descripción”
     */
    protected function fijarDescripciones()
    {
        return array(
            "cod_usuario" => "Código de Usuario",
            "nick" => "Nick",
            "cod_rol"=>"Código de Rol",
            "nombre" => "Nombre",
            "foto" => "Foto",
            "borrado" => "Borrado",
            "contrasenia"=> "Contraseña",
            "confirmar_contrasenia"=>"Confirmar Contraseña"
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
                    "ATRI" => "nick, nombre",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_usuario", "TIPO" => "ENTERO"
                ),
                array(
                    "ATRI" => "nick", "TIPO" => "CADENA",
                    "TAMANIO" => 30
                ),
                array(
                    "ATRI" => "nombre", "TIPO" => "CADENA",
                    "TAMANIO" => 30
                ),
                array(
                    "ATRI" => "foto", "TIPO" => "CADENA",
                    "TAMANIO" => 70
                ),
                array(
                    "ATRI" => "borrado", "TIPO" => "ENTERO",
                    "MIN" => 0, "MAX" => 1
                ),
                array(
                    "ATRI" => "cod_rol", "TIPO" => "RANGO",
                    "RANGO"=>array_keys(Rol::dameRoles())
                ),
                array("ATRI" => "confirmar_contrasenia",
                "TIPO" => "FUNCION",
                "FUNCION" => "validaConfirmarContraseña"

                ),
            );
    }

    /**
     * Asignación de valores por defecto tras crear el modelo
     */
    protected function afterCreate()
    {

        $this->borrado=0;
        $this->cod_usuario="";
        $roles=Rol::dameRoles();
        $this->cod_rol=key($roles);
    }

    /**
     * Operaciones a realizar al cargar el modelo desde la base de datos
     */
    protected function afterBuscar()
    {

    }

    /**
     * Método que comprueba que el confimar_contraseña es igual a la contraseña
     */
    public function validaConfirmarContraseña(){
        if ($this->confirmar_contrasenia!=$this->contrasenia) {
            $this->setError(
                "confirmar_contrasenia",
                "Error al confirmar la contraseña"
            );
        }
    }

    /**
     * Función que permite el correcto funcionamiento del método guardar, indicando la sentencia insert
     */
    protected function fijarSentenciaInsert()
    {
        $nombre = CGeneral::addSlashes($this->nombre);
        $nick = CGeneral::addSlashes($this->nick);
        $foto =CGeneral::addSlashes($this->foto);
        $borrado=intval(0);
        return "INSERT INTO `usuarios`(`nick`, `nombre`, `borrado`, `foto`) 
        VALUES ('$nick','$nombre','$borrado','$foto')";

    }

    /**
     * Función que permite el correcto funcionamiento del método guardar, indicando la sentencia update
     */
    protected function fijarSentenciaUpdate()
    {
        $cod_usuario= intval($this->cod_usuario);
        $nombre = CGeneral::addSlashes($this->nombre);
        $nick = CGeneral::addSlashes($this->nick);
        $foto =CGeneral::addSlashes($this->foto);
        $borrado=intval($this->borrado);
        return "update usuarios set " .
            "nombre = '$nombre',
            nick = '$nick',
            foto = '$foto',
            borrado = '$borrado',
            foto= '$foto'" .
            " where cod_usuario='$cod_usuario' ";
    }

    public function registrar(){
    
        if (!Sistema::app()->aclbd()->existeUsuario($this->nick)) {
            Sistema::app()->aclbd()->anadirUsuario($this->nombre, $this->nick, $this->contrasenia, $this->cod_rol);
        }
        return true;

        
    }

    public function actualizarACL($borrar){
        $borrar=boolval($borrar);
        if (Sistema::app()->aclbd()->existeUsuario($this->nick)) {
            # code...

        if ($borrar) {
            Sistema::app()->aclbd()->setBorrado(Sistema::app()->aclbd()->getCodUsuario($this->nick), $this->borrado);
        }
        else{

        
        Sistema::app()->aclbd()->setNombre(Sistema::app()->aclbd()->getCodUsuario($this->nick),$this->nombre);
        Sistema::app()->aclbd()->setContrasenia(Sistema::app()->aclbd()->getCodUsuario($this->nick), $this->contrasenia);
        Sistema::app()->aclbd()->setUsuarioRole(Sistema::app()->aclbd()->getCodUsuario($this->nick), $this->cod_rol);
    }
        return true;
    }
    return false;
}

    public function verificar(){
        $sentencia="select * from usuarios";
        //ejecuto la sentencia
        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        $filas=$consulta->filas();
        foreach ($filas as $valor => $fila) {
            if ($this->nick==$fila["nick"]) {
                $this->setError(
                    "nick",
                    "Nick ya existente"
                );
                return false;
            }
        }
        return true;
    }
}
