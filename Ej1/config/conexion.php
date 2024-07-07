<?php
//POO
class Clase_Conectar {
    // Propiedades
    private $conexion;
    private $server = "localhost";
    private $usuario = "root"; // Usuario root
    private $pass = ""; // Contraseña vacía
    private $base = "quinto_bdd";

    public function conectar() {
        $this->conexion = new mysqli($this->server, $this->usuario, $this->pass, $this->base);
        
        if ($this->conexion->connect_error) {
            die("Error al conectar con MySQL: " . $this->conexion->connect_error);
        }

        if (!$this->conexion->set_charset("utf8")) {
            die("Error al establecer el charset UTF-8: " . $this->conexion->error);
        }
        return $this->conexion;
    }   
}
?>
