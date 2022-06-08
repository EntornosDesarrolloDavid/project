<?php

class CMenu extends CWidget
{
    private $_links = array();
    private $_elementos = array();
    private $_atributosHTML = array();

    /**
     * Constructor al que se le pasan una serie de títulos (texto del menú), y los links de esos títulos
     */
    public function __construct($titulos, $links, $atributosHTML = array())
    {

        $this->_elementos = $titulos;
        $this->_links= $links;
        $this->_atributosHTML = $atributosHTML;

        if (!isset($this->_atributosHTML["class"]))
            $this->_atributosHTML["class"] = "nav justify-content-center";
        if (!isset($this->_atributosHTML["border"]))
            $this->_atributosHTML["border"] = "0";
    }

    /**
     * Función que dibuja todo el menú
     */
    public function dibujate()
    {
        return $this->dibujaApertura() . $this->dibujaFin();
    }

    /**
     * Función que dibuja gran parte del menú
     */
    public function dibujaApertura()
    {
        ob_start();

        echo CHTML::dibujaEtiqueta(
            "nav",
            array(),
            "",
            false
        );

        echo CHTML::dibujaEtiqueta(
            "ul",
            $this->_atributosHTML,
            "",
            false
        );


        /**
         * Cabe la posibilidad de que se quiera hacer una opción desplegable. Para ello se le deberá
         * pasar un array en el que se encuentre un texto principal de la opción y una serie de arrays
         * que serán las opciones desplegables. Estos arrays deben tener un título y un link al que
         * redirigirán al hacer click
         */
        foreach ($this->_links as $key => $value) 
        { 
            /**
             * Opciones desplegables
             */
                if (is_array($this->_elementos[$key])) {
                    echo CHTML::dibujaEtiqueta("li", ["class"=>"nav-item dropdown"], "", false);

                    echo CHTML::dibujaEtiqueta("a",array("id"=>"navbarDropdown", "class"=>"nav-link dropdown-toggle", "role"=> "button", "data-bs-toggle"=>"dropdown", "aria-haspopup"=>"true", "aria-expanded"=>"false") ,$this->_elementos[$key][0],true);
                    echo CHTML::dibujaEtiqueta("div", ["class"=>"dropdown-menu",  "aria-labelledby"=>"navbarDropdown"], "", false);
                    
                        foreach ($this->_elementos[$key] as $clave => $valor) {
                            if (is_array($this->_elementos[$key][$clave])) {
                                echo CHTML::link($this->_elementos[$key][$clave][0], array($this->_elementos[$key][$clave][1], $this->_elementos[$key][$clave][2]), ["class"=>"dropdown-item"]);
                            }
                        }
                    
                    echo CHTML::dibujaEtiquetaCierre("div");
                }
                /**
                 * Opciones no desplegables (normales)
                 */
                else{
                    echo CHTML::dibujaEtiqueta("li", ["class"=>"nav-item"], "", false);
                echo CHTML::link($this->_elementos[$key], $this->_links[$key], array("class"=>"nav-link"));
                }

            echo CHTML::dibujaEtiquetaCierre("li");
        }


        $escrito = ob_get_contents();
        ob_end_clean();

        return $escrito;
    }


    /**
     * Función que dibuja las etiquetas de cierre del Menú
     */
    public function dibujaFin()
    {
        ob_start();

        echo CHTML::dibujaEtiquetaCierre("nav");

        echo CHTML::dibujaEtiquetaCierre("ul");
        $escrito = ob_get_contents();
        ob_end_clean();

        return $escrito;
    }







}
