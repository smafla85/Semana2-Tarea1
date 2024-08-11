<?php
// Clase para manejar operaciones de Clientes
require_once('../config/config.php');

class Clientes
{
    private $con;

    public function __construct()
    {
        $conectar = new ClaseConectar();
        $this->con = $conectar->ProcedimientoParaConectar();
    }

    // Método para ejecutar consultas SQL
    private function ejecutarConsulta($cadena)
    {
        $datos = mysqli_query($this->con, $cadena);
        if (!$datos) {
            throw new Exception(mysqli_error($this->con));
        }
        return $datos;
    }

    // Obtener todos los clientes
    public function todos() 
    {
        $cadena = "SELECT * FROM `Clientes`";
        return $this->ejecutarConsulta($cadena);
    }

    // Obtener un cliente específico
    public function uno($idClientes) 
    {
        $idClientes = mysqli_real_escape_string($this->con, $idClientes);
        $cadena = "SELECT * FROM `clientes` WHERE `idClientes`='$idClientes'";
        return $this->ejecutarConsulta($cadena);
    }

    // Insertar un nuevo cliente
    public function insertar($Nombres, $Direccion, $Telefono, $Cedula, $Correo) 
    {
        try {
            // Escapar datos para prevenir inyección SQL
            $Nombres = mysqli_real_escape_string($this->con, $Nombres);
            $Direccion = mysqli_real_escape_string($this->con, $Direccion);
            $Telefono = mysqli_real_escape_string($this->con, $Telefono);
            $Cedula = mysqli_real_escape_string($this->con, $Cedula);
            $Correo = mysqli_real_escape_string($this->con, $Correo);

            $cadena = "INSERT INTO `Clientes` (`Nombres`, `Direccion`, `Telefono`, `Cedula`, `Correo`) 
                       VALUES ('$Nombres', '$Direccion', '$Telefono', '$Cedula', '$Correo')";
            $this->ejecutarConsulta($cadena);
            return $this->con->insert_id;
        } catch (Exception $th) {
            return "Error: " . $th->getMessage();
        }
    }

    // Actualizar un cliente existente
    public function actualizar($idClientes, $Nombres, $Direccion, $Telefono, $Cedula, $Correo) 
    {
        try {
            // Escapar datos para prevenir inyección SQL
            $idClientes = mysqli_real_escape_string($this->con, $idClientes);
            $Nombres = mysqli_real_escape_string($this->con, $Nombres);
            $Direccion = mysqli_real_escape_string($this->con, $Direccion);
            $Telefono = mysqli_real_escape_string($this->con, $Telefono);
            $Cedula = mysqli_real_escape_string($this->con, $Cedula);
            $Correo = mysqli_real_escape_string($this->con, $Correo);

            $cadena = "UPDATE `Clientes` SET 
                       `Nombres`='$Nombres', 
                       `Direccion`='$Direccion', 
                       `Telefono`='$Telefono', 
                       `Cedula`='$Cedula', 
                       `Correo`='$Correo' 
                       WHERE `idClientes` = '$idClientes'";
            $this->ejecutarConsulta($cadena);
            return $idClientes;
        } catch (Exception $th) {
            return "Error: " . $th->getMessage();
        }
    }

    // Eliminar un cliente
    public function eliminar($idClientes) 
    {
        try {
            $idClientes = mysqli_real_escape_string($this->con, $idClientes);
            $cadena = "DELETE FROM `Clientes` WHERE `idClientes`= '$idClientes'";
            $this->ejecutarConsulta($cadena);
            return 1;
        } catch (Exception $th) {
            return "Error: " . $th->getMessage();
        }
    }

    // Cerrar la conexión al destruir el objeto
    public function __destruct()
    {
        if ($this->con) {
            $this->con->close();
        }
    }
}
?>