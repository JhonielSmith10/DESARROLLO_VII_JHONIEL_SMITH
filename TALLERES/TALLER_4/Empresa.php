<?php
require_once 'Gerente.php';
require_once 'Desarrollador.php';

class Empresa {
    //array para guardar empleados
    private $empleados = [];

    //Funcion para agregar el empleado al array empleados
    public function agregarEmpleado(Empleado $empleado) {
        $this->empleados[] = $empleado;
    }

    //Funcion para mostrar todos los empleados de la empresa
    public function mostrarEmpleados() {
    // Recorre todos los empleados y muestra su información
        foreach ($this->empleados as $empleado) {
            echo $empleado->obtenerInformacion() . "\n";
        }
    }

    //Funcion para mostrar la nomina total de la empresa
    public function calcularNominaTotal() {
        $total = 0;
    //Recorre todos los empleados y acumula sus salarios base
        foreach ($this->empleados as $empleado) {
            $total += $empleado->getSalarioBase();
        }
        return $total;
    }
    //Funcion para evaluar el desempeño de todos los empleados
    public function evaluarDesempenioEmpleados() {
        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Evaluable) {
                echo $empleado->evaluarDesempenio();
            } else {
                echo "El empleado {$empleado->getNombre()} no es evaluable.";
            }
        }
    }
}
