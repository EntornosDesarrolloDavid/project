<?php 
class CAcceso {
 
    private $_sesion;
 
    // Variables de instancia
    private $_validado;
    private $_nick;
    private $_nombre;
    private $_permisos;
    
    
    // Constructor
    public function __construct() {
        $this->_sesion=new CSesion();

        if (!$this->_sesion->haySesion())
              $this->_sesion->crearSesion();


        $this->_validado=false;
        $this->_nick="";
        $this->_nombre="";
        $this->_permisos=[];
        
        $this->recogerDeSesion();
        
    }
    
    private function escribirASesion()
    {
     if (!isset($_SESSION))    
         return false;
     
     if ($this->_validado)
     {
         $_SESSION["acceso"]["validado"]=true;
         $_SESSION["acceso"]["nick"]=$this->_nick;
         $_SESSION["acceso"]["nombre"]=$this->_nombre;
         $_SESSION["acceso"]["permisos"]=$this->_permisos;
         
     }
     else 
     {
         $_SESSION["acceso"]["validado"]=false;
     }
    }
    
    private function recogerDeSesion()
    {
       if (!isset($_SESSION) ||
           !isset($_SESSION["acceso"]) ||
           !isset($_SESSION["acceso"]["validado"]) ||
           $_SESSION["acceso"]["validado"]==false)
       {
           $this->_validado=false;
       }
       else 
       {
           $this->_validado=true;
           $this->_nick=$_SESSION["acceso"]["nick"];
           $this->_nombre=$_SESSION["acceso"]["nombre"];
           $this->_permisos=$_SESSION["acceso"]["permisos"];
           
       }
        
    }
    /* 
     * Sirve para registrar un usuario en la aplicación. Almacena
     * los valores en las propiedades apropiadas y en la sesión 
     * para guardar en la sesión la información del usuario validado.
     */
    public function registrarUsuario($nick, $nombre, $permisos) {
        if ($nick == "")
            $this->_validado = false;
        else
            $this->_validado = true;
        $this->_nick = $nick;
        $this->_nombre = $nombre;
        $this->_permisos = $permisos;
        
        $this->escribirASesion();
    }
    
    
    /*
     * Hace que no haya ningún usuario registrado en el sistema
     */
    public function quitarRegistroUsuario() {
        $this->_validado = false;
        $this->escribirASesion();
    }
    
    
    /*
     * Devuelve true si hay un usuario validado y false en caso contrario.
     */
    public function hayUsuario() {
        return $this->_validado;
    }
    
    
    /*
     * Devuelve true si tiene el permiso $numero.
     */
    public function puedePermiso($numero) {
        if (!$this->hayUsuario())
            return false;
        if (!isset($this->_permisos[$numero]))
             return false;

        return $this->_permisos[$numero] == true;
    }
    
    
    /*
     * Métodos get
     */
    public function getNick() 
    { 
        if (!$this->hayUsuario())
            return false;
            
        return $this->_nick; 
    }
    public function getNombre() 
    { 
        if (!$this->hayUsuario())
            return false;
        
        return $this->_nombre; 
    }    
    
}
