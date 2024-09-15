<?php
class Empleado {
    private $nombre;
    private $idEmpleado;
    private $salarioBase;
    //constructor de la clase
    public function __construct($nombre, $idEmpleado, $salarioBase) {
        $this->nombre = $nombre;
        $this->idEmpleado = $idEmpleado;
        $this->salarioBase = $salarioBase;
    }
    //Funciones get y set de la clase
    public function getNombre() {
        return $this->nombre;
    }

    public function getIdEmpleado() {
        return $this->idEmpleado;
    }

    public function getSalarioBase() {
        return $this->salarioBase;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

    public function setSalarioBase($salarioBase) {
        $this->salarioBase = $salarioBase;
    }
    //Funcion para obtener la información completa del empleado
    public function obtenerInformacion() {
        return "ID: {$this->idEmpleado}</br> Nombre: {$this->nombre}</br> Salario Base: {$this->salarioBase}</br>";
    }
}
