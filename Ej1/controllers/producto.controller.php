
<?php 
require_once('../config/cors.php');
require_once('../models/producto.model.php');

$producto = new Clase_Productos();
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($_GET["op"]) {
    case 'todos':
        $datos = array();
        $datos = $producto->obtenerProductos();
        $todos = array();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
        
    case 'uno':
        if (isset($_GET["id"])) {
            $idProducto = intval($_GET["id"]);
            $datos = $producto->uno($idProducto);
            echo json_encode($datos); 
        } else {
            echo json_encode(array("message" => "ID no proporcionado"));
        }
        break;

        
    /*TODO: Procedimiento para insertar */
    case 'insertar':
        $Nombre = $_POST["Nombre"] ?? null;
        $Precio = $_POST["Precio"] ?? null;
        $Stock = $_POST["Stock"] ?? null;
        
        if ($Nombre && $Precio && $Stock) {
            $insertar = $producto->agregarProducto($Nombre, $Precio, $Stock);
            if ($insertar == 0) {
                echo json_encode(array("message" => "Insertado correctamente"));
            } else {
                echo json_encode(array("message" => "Error al insertar"));
            }
        } else {
            echo json_encode(array("message" => "Error, faltan datos"));
        }
        break;
        
    case 'actualizar':
        $ProductoId = $_POST["EditarProductoId"] ?? null;
        $Nombre = $_POST["EditarNombre"] ?? null;
        $Precio = $_POST["EditarPrecio"] ?? null;
        $Stock = $_POST["EditarStock"] ?? null;
        
        if ($ProductoId && $Nombre && $Precio && $Stock) {
            $actualizar = $producto->actualizar($ProductoId, $Nombre, $Precio, $Stock);
            if ($actualizar) {
                echo json_encode(array("message" => "Actualizado correctamente"));
            } else {
                echo json_encode(array("message" => "Error al actualizar"));
            }
        } else {
            echo json_encode(array("message" => "Error, faltan datos"));
        }
        break;
        

    case 'eliminar':
        if (isset($_POST["idProducto"])) {
            $idProducto = intval($_POST["idProducto"]);
            $eliminar = $producto->eliminarProducto($idProducto);
            if ($eliminar) {
                echo json_encode(array("message" => "Eliminado correctamente"));
            } else {
                echo json_encode(array("message" => "Error al eliminar"));
            }
        } else {
            echo json_encode(array("message" => "ID no proporcionado"));
        }
        break;

    default:
        echo json_encode(array("message" => "Operación no válida"));
        break;
}