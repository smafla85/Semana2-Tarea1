<?php
// Configuración de cabeceras para CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

require_once('../models/clientes.model.php');
error_reporting(0);
$clientes = new Clientes;

// Función para enviar respuesta en formato JSON
function responseJson($data) {
    echo json_encode($data);
    exit;
}

switch ($_GET["op"]) {
    case 'todos': 
        // Obtener todos los clientes
        $datos = $clientes->todos(); 
        $todos = mysqli_fetch_all($datos, MYSQLI_ASSOC);
        responseJson($todos);
        break;

    case 'uno':
        // Obtener un cliente específico
        $idClientes = $_POST["idClientes"];
        $datos = $clientes->uno($idClientes);
        $res = mysqli_fetch_assoc($datos);
        responseJson($res);
        break;

    case 'insertar':
        // Insertar un nuevo cliente
        $Nombres = $_POST["Nombres"];
        $Direccion = $_POST["Direccion"];
        $Telefono = $_POST["Telefono"];
        $Cedula = $_POST["Cedula"];
        $Correo = $_POST["Correo"];

        $datos = $clientes->insertar($Nombres, $Direccion, $Telefono, $Cedula, $Correo);
        responseJson($datos);
        break;

    case 'actualizar':
        // Actualizar un cliente existente
        $idClientes = $_POST["idClientes"];
        $Nombres = $_POST["Nombres"];
        $Direccion = $_POST["Direccion"];
        $Telefono = $_POST["Telefono"];
        $Cedula = $_POST["Cedula"];
        $Correo = $_POST["Correo"];

        $datos = $clientes->actualizar($idClientes, $Nombres, $Direccion, $Telefono, $Cedula, $Correo);
        responseJson($datos);
        break;

    case 'eliminar':
        // Eliminar un cliente
        $idClientes = $_POST["idClientes"];
        $datos = $clientes->eliminar($idClientes);
        responseJson($datos);
        break;

    default:
        // Operación no válida
        responseJson(["error" => "Operación no válida"]);
}