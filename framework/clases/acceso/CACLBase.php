<?php
    /**
     * Clase CACLBase
     * Clase abstracta que define el comportamiento
     *  de una ACL 
     */
    abstract class CACLBase{
        /**
         * Añade un role a nuesta ACL
         * @param string $nombre Nombre del role a añadir 
         */
        abstract function anadirRole($nombre, $permisos=array());
        abstract function getCodRole($nombre);
        abstract function existeRole($codRole);
        abstract function getPermisosRole($codRole);
        abstract function getPermisoRole($codRole, $numero);
        abstract function anadirUsuario($nombre, $nick, $contrasena, $codRole);
        abstract function getCodUsuario($nick);
        abstract function existeCodUsuario($codUsuario);
        abstract function existeUsuario($nick);
        abstract function esValido($nick, $contrasena);
        abstract function getPermiso($codUsuario, $numero);
        abstract function getPermisos($codUsuario);
        abstract function getNombre($codUsuario);
        abstract function getBorrado($codUsuario);
        abstract function getUsuarioRole($codUsuario);
        abstract function setNombre($codUsuario,$nombre);
        abstract function setContrasenia($codUsuario, $borrado);
        abstract function setBorrado($codUsuario, $borrado);
        abstract function setUsuarioRole($codUsuario, $role);
        abstract function dameUsuarios();
        abstract function dameRoles();
    }