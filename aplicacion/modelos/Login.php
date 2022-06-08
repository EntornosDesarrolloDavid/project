<?php

class Login extends CActiveRecord
{


    /**
     * Este método devuelve el nombre que se asignará al modelo. Este nombre es usado dentro del framework 
     * en otros componentes
     */
    protected function fijarNombre()
    {
        return 'login';
    }


    /**
     * En este método se devuelve un array con la lista de atributos que tendrá el modelo.
     */
    protected function fijarAtributos()
    {
        return array(
            "nick", "password"
        );
    }

    protected function afterCreate()
    {
        $this->nick = "";
        $this->password = "";

    }

    /**
     * Método que asignas descripciones devolviendo un array asociativo con cada elemento de la forma 
     * “atributo” => “descripción”
     */
    protected function fijarDescripciones()
    {
        return array(
            "nick" => "Nick",
            "password" => "Contraseña"
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
                    "ATRI" => "nick, password",
                    "TIPO" => "REQUERIDO"
                ),
 
                array(
                    "ATRI" => "nick, password", "TIPO" => "CADENA",
                    "TAMANIO" => 20
                )
            );
    }


    /**
     * Comprobación de si el usuario existe en la ACL
     */
    public function autenticar(){
        if (Sistema::app()->aclbd()->esvalido($this->nick, $this->password)) {

            $nombre=Sistema::app()->aclbd()->getNombre(Sistema::app()->aclbd()->getCodUsuario($this->nick));
            $permisos=Sistema::app()->aclbd()->getPermisos(Sistema::app()->aclbd()->getCodUsuario($this->nick));
            Sistema::app()->Acceso()->registrarUsuario($this->nick, $nombre, $permisos);
            return true;
        }
        $this->setError(
            "password",
            "Login no Válido"
        );

        return false;
    }
}
