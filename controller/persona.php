<?php
/**
* 
*/
class persona{
        
    
        protected $id_persona;
	protected $apenom_razon_social;
	protected $fisica_o_juridica;
	protected $nacionalidad;
        protected $telefono1;
        protected $telefono2;
        protected $email;
        protected $cuenta_tipo;
        protected $numero_cta;
        protected $cbu;
        protected $estado_persona;
           
        function getId_persona() {
            return $this->id_persona;
        }

        function getApenom_razon_social() {
            return $this->apenom_razon_social;
        }

        function getFisica_o_juridica() {
            return $this->fisica_o_juridica;
        }

        function getNacionalidad() {
            return $this->nacionalidad;
        }

        function getTelefono1() {
            return $this->telefono1;
        }

        function getTelefono2() {
            return $this->telefono2;
        }

        function getEmail() {
            return $this->email;
        }

        function getCuenta_tipo() {
            return $this->cuenta_tipo;
        }

        function getNumero_cta() {
            return $this->numero_cta;
        }

        function getCbu() {
            return $this->cbu;
        }

        function getEstado_persona() {
            return $this->estado_persona;
        }

        function setId_persona($id_persona) {
            $this->id_persona = $id_persona;
        }

        function setApenom_razon_social($apenom_razon_social) {
            $this->apenom_razon_social = $apenom_razon_social;
        }

        function setFisica_o_juridica($fisica_o_juridica) {
            $this->fisica_o_juridica = $fisica_o_juridica;
        }

        function setNacionalidad($nacionalidad) {
            $this->nacionalidad = $nacionalidad;
        }

        function setTelefono1($telefono1) {
            $this->telefono1 = $telefono1;
        }

        function setTelefono2($telefono2) {
            $this->telefono2 = $telefono2;
        }

        function setEmail($email) {
            $this->email = $email;
        }

        function setCuenta_tipo($cuenta_tipo) {
            $this->cuenta_tipo = $cuenta_tipo;
        }

        function setNumero_cta($numero_cta) {
            $this->numero_cta = $numero_cta;
        }

        function setCbu($cbu) {
            $this->cbu = $cbu;
        }

        function setEstado_persona($estado_persona) {
            $this->estado_persona = $estado_persona;
        }

        function __construct($id_persona, $apenom_razon_social, $fisica_o_juridica, $nacionalidad, $telefono1, $telefono2 = null, $email, $cuenta_tipo, $numero_cta, $cbu, $estado_persona) {
            $this->id_persona = $id_persona;
            $this->apenom_razon_social = $apenom_razon_social;
            $this->fisica_o_juridica = $fisica_o_juridica;
            $this->nacionalidad = $nacionalidad;
            $this->telefono1 = $telefono1;
            $this->telefono2 = $telefono2;
            $this->email = $email;
            $this->cuenta_tipo = $cuenta_tipo;
            $this->numero_cta = $numero_cta;
            $this->cbu = $cbu;
            $this->estado_persona = $estado_persona;
             }

            if (!empty($telefono2)) {
                $telefono2 = null;
		} 
        
	function algo(){
		$test = 'Hola';
		return true;
	}





}
?>
