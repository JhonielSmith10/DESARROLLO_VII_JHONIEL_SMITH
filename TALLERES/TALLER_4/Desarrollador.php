<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';
class Desarrollador extends Empleado implements Evaluable {
    private $lenguaje;
    private $experiencia;
    // Constructor para inicializar la clase Desarrollador
    public function __construct($nombre, $idEmpleado, $salarioBase, $lenguaje, $experiencia) {
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        $this->lenguaje = $lenguaje;
        $this->experiencia = $experiencia;
    }
    //Funciones get y set de la clase
    public function getLenguajePrincipal() {
        return $this->lenguaje;
    }

    public function setLenguajePrincipal($lenguaje) {
        $this->lenguaje = $lenguaje;
    }

    public function getNivelExperiencia() {
        return $this->experiencia;
    }

    public function setNivelExperiencia($experiencia) {
        $this->experiencia = $experiencia;
    }
    // Método para obtener la información completa del desarrollador
    public function obtenerInformacion() {
        return parent::obtenerInformacion() . " Lenguaje Principal: {$this->lenguaje}</br> Nivel de Experiencia: {$this->experiencia} </br>";
    }
    // Implementación del método de la interfaz Evaluable para evaluar el desempeño
    public function evaluarDesempenio() {
        return "Evaluando el desempeño del Desarrollador: {$this->getNombre()} </br>";
    }
}
