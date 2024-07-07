<?php 

require_once('../config/conexion.php');

class Clase_Productos{

  public function agregarProducto($nombre, $precio, $stock) {
    try {
        $con = new Clase_Conectar();
        $conexion = $con->conectar();
        $sql = "INSERT INTO productos (nombre, precio, stock) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sdi", $nombre, $precio, $stock);

        if ($stmt->execute()) {
            return 'Insertado correctamente';
        } else {
            return 'Error al insertar en la base de datos: ' . $stmt->error;
        }
    } catch (Exception $e) { 
        return 'Error al insertar en la base de datos: ' . $e->getMessage();
    }
  }


  public function obtenerProductos(){
    try {
      $con= new Clase_Conectar();
      $conexion = $con->conectar();
      $sql = "SELECT * FROM productos";
      $stmt = $conexion->prepare($sql);
      $stmt->execute();
      $result = $stmt->get_result();
      return $result;

    }catch(Exception $e){
      return 'Error al obtener los productos: '. $e->getMessage();
    } 
  }


  public function uno($idProducto)
    {
        $con = new Clase_Conectar();
        $con = $con->conectar();

        $cadena = "SELECT id, nombre, precio , stock FROM productos WHERE id = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('i', $idProducto);
        $stmt->execute();
        $datos = $stmt->get_result()->fetch_assoc(); 
        return $datos;
        $con->close(); 
    }


    public function actualizar($idProducto, $nombre, $precio, $stock)
    {
        $con = new Clase_Conectar();
        $con = $con->conectar();

        $cadena = "UPDATE productos SET nombre = ?, precio = ?,  stock = ? WHERE id = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('sssi', $nombre, $precio, $stock, $idProducto);

        if ($stmt->execute()) {
            return $idProducto;
        } else {
            return 'Error al actualizar el registro: ' . $stmt->error;
        }

        $con->close();
    }

  public function eliminarProducto($id){
    try{
      $con = new Clase_Conectar();
      $conexion = $con->conectar();
      $sql = "DELETE FROM productos WHERE id =?";
      $stmt = $conexion->prepare($sql);
      $stmt->bind_param("i", $id);
      if($stmt->execute()){
        return 'Producto eliminado correctamente';
      }else{
        return 'Error al eliminar el producto: '. $stmt->error;
      }
    }catch(Exception $e){
      return 'Error al conectar con la base de datos: '. $e->getMessage();
    }
  }
}