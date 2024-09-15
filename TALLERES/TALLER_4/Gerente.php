<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';
//se define la clase gerencia que extiende de empleado e implementa la interfaz evaluable
class Gerente extends Empleado implements Evaluable {
    private $departamento;
    private $bono;
    //constructor de la clase
    public function __construct($nombre, $idEmpleado, $salarioBase, $departamento, $bono) {
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        $this->departamento = $departamento;
        $this->bono = $bono;
    }
     //Funciones get y set de la clase
    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    public function getBono() {
        return $this->bono;
    }

    public function setBono($bono) {
        $this->bono = $bono;
    }
    // Funcion para obtener la información completa del gerente
    public function obtenerInformacion() {
        return parent::obtenerInformacion() . " Departamento: {$this->departamento}</br> Bono: {$this->bono} </br></br>";
    }
     // Implementación de la funcion de la interfaz Evaluable para evaluar el desempeño
    public function evaluarDesempenio() {
        return "Evaluando el desempeño del Gerente: {$this->getNombre()} </br>";
    }
}
