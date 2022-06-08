<?php

	class CCaja extends CWidget
	{
		private $_titulo=array();
		private $_contenido=array();
		private $_atributosHTML=array();
	
		public function __construct($titulo,$contenido,$atributosHTML=array())
		{

            $this->_titulo=$titulo;
			$this->_contenido=$contenido;
			$this->_atributosHTML=$atributosHTML;
			
			if (!isset($this->_atributosHTML["class"]))
				$this->_atributosHTML["class"]="caja";
			if (!isset($this->_atributosHTML["border"]))
				$this->_atributosHTML["border"]="0";
							
			
		}
		
		public function dibujate()
		{
			return $this->dibujaApertura().$this->dibujaFin();
		}
		
		public function dibujaApertura()
		{
			ob_start();
			
			echo CHTML::dibujaEtiqueta("div",$this->_atributosHTML,
										"",false);
			
            
            echo CHTML::dibujaEtiqueta("div", array("class"=>"titulo"), $this->_titulo, false);
            echo CHTML::botonHtml("Ocultar Contenido", array("id"=>"content", "onclick"=>"HideShowContent()"));
		    echo CHTML::dibujaEtiquetaCierre("div");

            echo CHTML::dibujaEtiqueta("div", array("class"=>"cuerpo"), $this->_contenido, false);


			$escrito=ob_get_contents();
			ob_end_clean();
			
			return $escrito;		
		}
				
		public function dibujaFin()
		{
            ob_start();

		    echo CHTML::dibujaEtiquetaCierre("div");

		    echo CHTML::dibujaEtiquetaCierre("div");
            $escrito=ob_get_contents();
			ob_end_clean();
			
			return $escrito;		
		}






        public static function requisitos()
		{
			$codigo=<<<EOF
            function HideShowContent()
			{
                    var cuerpo = document.getElementsByClassName("cuerpo");
                
                    if (cuerpo[0].style.display=="none") {
                        cuerpo[0].style.display="block";
                        document.getElementById('content').innerHTML="Ocultar Contenido"
                
                    }
                    else{
                        cuerpo[0].style.display="none";
                        document.getElementById('content').innerHTML="Mostrar Contenido"
                
                    }
                
                
			}
EOF;
			return CHTML::script($codigo);
		}
		
	}
