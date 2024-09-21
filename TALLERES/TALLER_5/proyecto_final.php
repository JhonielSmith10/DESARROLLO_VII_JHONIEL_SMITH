<?php
class Estudiante {
    private int $id;
    private string $nombre;
    private int $edad;
    private string $carrera;
    private array $materias = [];
    //Constructor de la clase
    public function __construct(int $id, string $nombre, int $edad, string $carrera) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->carrera = $carrera;
    }
    //Función que Agrega una materia y su calificación
    public function agregarMateria(string $materia, float $calificacion): void {
        $this->materias[$materia] = $calificacion;
    }
    //Calcula y devuelve el promedio de calificaciones
    public function obtenerPromedio(): float {
        return count($this->materias) ? array_sum($this->materias) / count($this->materias) : 0;
    }
    //Devuelve los detalles del estudiante
    public function obtenerDatos(): array {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'edad' => $this->edad,
            'carrera' => $this->carrera,
            'materias' => $this->materias,
            'promedio' => $this->obtenerPromedio()
        ];
    }
    //Imprime los datos del estudiante
    public function __toString(): string {
        return "{$this->nombre} (ID: {$this->id}, Carrera: {$this->carrera}, Promedio: {$this->obtenerPromedio()})";
    }
}

class SistemaGestionEstudiantes {
    private array $estudiantes = [];
    private array $graduados = [];
    //Agrega un estudiante al sistema
    public function agregarEstudiante(Estudiante $estudiante): void {
        $this->estudiantes[$estudiante->obtenerDatos()['id']] = $estudiante;
    }
    //Obtiene un estudiante por su ID
    public function obtenerEstudiante(int $id): ?Estudiante {
        return $this->estudiantes[$id] ?? null;
    }
    //Lista todos los estudiantes
    public function listaEstudiantes(): array {
        return $this->estudiantes;
    }
    //Calcula el promedio general de todos los estudiantes
    public function calcularPromedioGeneral(): float {
        if (empty($this->estudiantes)) return 0;
        return array_sum(array_map(fn($estudiante) => $estudiante->obtenerPromedio(), $this->estudiantes)) / count($this->estudiantes);
    }
    //Obtiene estudiantes por carrera
    public function obtenerEstudiantesPorCarrera(string $carrera): array {
        return array_filter($this->estudiantes, fn($estudiante) => $estudiante->obtenerDatos()['carrera'] === $carrera);
    }

    //Obtiene el mejor estudiante
    public function obtenerMejorEstudiante(): ?Estudiante {
        return array_reduce($this->estudiantes, function(?Estudiante $mejorEstudiante, Estudiante $estudianteActual) {
            return ($mejorEstudiante === null || $estudianteActual->obtenerPromedio() > $mejorEstudiante->obtenerPromedio()) 
                ? $estudianteActual : $mejorEstudiante;
        });
    }
    //Gradua a un estudiante y lo mueve a la lista de graduados
    public function graduarEstudiante(int $id): void {
        if (isset($this->estudiantes[$id])) {
            $this->graduados[$id] = $this->estudiantes[$id];
            unset($this->estudiantes[$id]);
        }
    }
    //Genera un ranking de estudiantes según su promedio
    public function generarRanking(): array {
        uasort($this->estudiantes, fn($a, $b) => $b->obtenerPromedio() <=> $a->obtenerPromedio());
        return $this->estudiantes;
    }
    //Genera un reporte de rendimiento por materia
    public function generarReporteRendimiento(): array {
        $materiasReporte = [];
        foreach ($this->estudiantes as $estudiante) {
            foreach ($estudiante->obtenerDatos()['materias'] as $materia => $calificacion) {
                if (!isset($materiasReporte[$materia])) {
                    $materiasReporte[$materia] = [
                        'total' => 0,
                        'count' => 0,
                        'max' => $calificacion,
                        'min' => $calificacion
                    ];
                }
                $materiasReporte[$materia]['total'] += $calificacion;
                $materiasReporte[$materia]['count']++;
                $materiasReporte[$materia]['max'] = max($materiasReporte[$materia]['max'], $calificacion);
                $materiasReporte[$materia]['min'] = min($materiasReporte[$materia]['min'], $calificacion);
            }
        }
        //Calcular el promedio por materia
        foreach ($materiasReporte as &$datos) {
            $datos['promedio'] = $datos['total'] / $datos['count'];
        }
        return $materiasReporte;
    }
    //Busca estudiantes por nombre o carrera
    public function buscarEstudiantes(string $termino): array {
        $termino = strtolower($termino);
        return array_filter($this->estudiantes, function(Estudiante $estudiante) use ($termino) {
            $detalles = $estudiante->obtenerDatos();
            return strpos(strtolower($detalles['nombre']), $termino) !== false ||
                strpos(strtolower($detalles['carrera']), $termino) !== false;
        });
    }
    //Genera estadísticas por carrera
    public function generarEstadisticasPorCarrera(): array {
        $estadisticas = [];
        foreach ($this->estudiantes as $estudiante) {
            $carrera = $estudiante->obtenerDatos()['carrera'];
            if (!isset($estadisticas[$carrera])) {
                $estadisticas[$carrera] = [
                    'total' => 0,
                    'promedio' => 0,
                    'mejor_estudiante' => null
                ];
            }
            $promedioEstudiante = $estudiante->obtenerPromedio();
            $estadisticas[$carrera]['total']++;
            $estadisticas[$carrera]['promedio'] += $promedioEstudiante;
            if (is_null($estadisticas[$carrera]['mejor_estudiante']) || 
                $promedioEstudiante > $estadisticas[$carrera]['mejor_estudiante']->obtenerPromedio()) {
                $estadisticas[$carrera]['mejor_estudiante'] = $estudiante;
            }
        }
        // Calcular el promedio por carrera
        foreach ($estadisticas as &$data) {
            $data['promedio'] /= $data['total'];
        }
        return $estadisticas;
    }
    //Marca estudiantes con "flags"
    public function aplicarFlags(): void {
        foreach ($this->estudiantes as $estudiante) {
            $promedio = $estudiante->obtenerPromedio();
            if ($promedio < 6) {
                echo "{$estudiante->obtenerDatos()['nombre']} está en riesgo académico.\n";
            } elseif ($promedio >= 9) {
                echo "{$estudiante->obtenerDatos()['nombre']} está en honor roll.\n";
            }
        }
    }
}
// crea la instancia del sistema de gestión de estudiantes
$sistema = new SistemaGestionEstudiantes();
// Datos de 10 estudiantes
$estudiantesData = [
    [1, "Ana", 20, "Ingeniería de Software", ["Programación I" => 9, "Estructura de Datos" => 8]],
    [2, "Luis", 22, "Ciencias de la Computación", ["Bases de Datos" => 10, "Programación Móvil" => 7]],
    [3, "Pedro", 23, "Desarrollo de Software", ["Diseño de Software" => 8, "Testing de Software" => 6]],
    [4, "Maria", 21, "Ciberseguridad", ["Estructura de Datos" => 3, "Programación I" => 7]],
    [5, "Carlos", 24, "Sistemas de Información", ["Programación Móvil" => 9, "Testing de Software" => 7]],
    [6, "Laura", 20, "Ingeniería de Software", ["Bases de Datos" => 7, "Diseño de Software" => 9]],
    [7, "Jorge", 22, "Ciencias de la Computación", ["Programación I" => 8, "Programación Móvil" => 6]],
    [8, "Sofia", 19, "Desarrollo de Software", ["Diseño de Software" => 10, "Testing de Software" => 9]],
    [9, "Miguel", 23, "Sistemas de Información", ["Bases de Datos" => 7, "Estructura de Datos" => 8]],
    [10, "Andrea", 20, "Ciberseguridad", ["Programación I" => 10, "Diseño de Software" => 9]]
];
//Agrega los estudiates a la clase estudiantes y, materias y calificacion al sistema 
foreach ($estudiantesData as $data) {
    $estudiante = new Estudiante($data[0], $data[1], $data[2], $data[3]);
    foreach ($data[4] as $materia => $calificacion) {
        $estudiante->agregarMateria($materia, $calificacion);
    }
    $sistema->agregarEstudiante($estudiante);
}
//Listado de estudiantes
echo "--- Listado de estudiantes ---</br>";
foreach ($sistema->listaEstudiantes() as $estudiante) {
    echo $estudiante . "</br>";
}
//Promedio general
echo "--- Promedio general de todos los estudiantes ---</br>";
printf("Promedio General: %.2f<br>", $sistema->calcularPromedioGeneral());
//Mejor estudiante
echo "--- Mejor estudiante ---</br>";
$mejorEstudiante = $sistema->obtenerMejorEstudiante();
echo "El mejor estudiante es: " . $mejorEstudiante . "</br>";
//Ranking de estudiantes
echo "--- Ranking de estudiantes por promedio ---</br>";
$ranking = $sistema->generarRanking();
$contador = 1;
foreach ($ranking as $estudiante) {
    printf("%d. %s - Promedio: %.2f</br>", $contador, $estudiante->obtenerDatos()['nombre'], $estudiante->obtenerPromedio());
    $contador++;
}
//Reporte de rendimiento por materia
echo "--- Reporte de rendimiento por materia ---</br>";
$reporte = $sistema->generarReporteRendimiento();
foreach ($reporte as $materia => $datos) {
    printf(
        "%s: Promedio: %.2f, Máx: %.2f, Mín: %.2f</br>", 
        $materia, 
        $datos['promedio'], 
        $datos['max'], 
        $datos['min']
    );
}
//Estadísticas por carrera
echo "--- Estadísticas por carrera ---</br>";
$estadisticas = $sistema->generarEstadisticasPorCarrera();
foreach ($estadisticas as $carrera => $datos) {
    printf(
        "Carrera: %s | Total Estudiantes: %d | Promedio Carrera: %.2f | Mejor Estudiante: %s</br>", 
        $carrera, 
        $datos['total'], 
        $datos['promedio'], 
        $datos['mejor_estudiante']->obtenerDatos()['nombre']
    );
}
//flags
echo "\--- Flags de honor y riesgo ---</br>";
$sistema->aplicarFlags();
