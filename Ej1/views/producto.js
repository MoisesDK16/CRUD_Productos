// Inicialización
function init() {
    $("#frm_productos").on("submit", function (e) {
        guardarProducto(e);
    });

    $("#frm_editar_productos").on("submit", function (e) {
        editarProducto(e);
    });

}

$(document).ready(() => {
    cargaTabla();
});

// Cargar la tabla de productos
var cargaTabla = () => {
    var html = "";

    $.get("../controllers/producto.controller.php?op=todos", (listadoProductos) => {
        console.log(listadoProductos);
        $.each(listadoProductos, (index, Producto) => {
            html += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${Producto.nombre}</td>
                    <td>${Producto.precio}</td>
                    <td>${Producto.stock}</td>
                    <td>
                        <button class="btn btn-primary" onclick="cargarProducto(${Producto.id})">Editar</button>
                        <button class="btn btn-danger" onclick="eliminar(${Producto.id})">Eliminar</button>
                    </td>
                </tr>
            `;
        });
        $("#cuerpoproductos").html(html);
    });
};

var cargarProducto = (id) => {
    $.get("../controllers/producto.controller.php?op=uno&id=" + id, (Producto) => {
        console.log(Producto);
        $("#EditarProductoId").val(Producto.id);
        $("#EditarNombre").val(Producto.nombre);
        $("#EditarPrecio").val(Producto.precio);
        $("#EditarStock").val(Producto.stock);
        $("#modalEditarProducto").modal("show");
    });
};

// Función para Guardar un Producto
var guardarProducto = (e) => {
    e.preventDefault();

    var frm_productos = new FormData($("#frm_productos")[0]);
    frm_productos.delete("ProductoId");

    var ruta = "../controllers/producto.controller.php?op=insertar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_productos,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            location.reload();
            $("#modalProducto").modal("hide");
        },
        error: function (xhr, status, error) {
            console.error("Error al guardar:", error);
        }
    });
};

// Eliminar producto
var eliminar = (ProductoId) => { // Cambio aquí
    Swal.fire({
        title: "Productos", // Cambio aquí
        text: "¿Está seguro que desea eliminar el producto?", // Cambio aquí
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../controllers/producto.controller.php?op=eliminar",
                type: "POST",
                data: { idProducto: ProductoId }, // Cambio aquí
                success: (resultado) => {
                    console.log("Respuesta del servidor:", resultado);
                    if (resultado.message === "Eliminado correctamente") {
                        Swal.fire({
                            title: "Producto", // Cambio aquí
                            text: "Se eliminó con éxito",
                            icon: "success",
                        });
                        location.reload(); // Recargar la página
                    } else {
                        Swal.fire({
                            title: "Productos", 
                            text: "No se pudo eliminar",
                            icon: "error",
                        });
                    }
                },
                error: () => {
                    Swal.fire({
                        title: "Productos", 
                        text: "Ocurrió un error al intentar eliminar",
                        icon: "error",
                    });
                }
            });
        }
    });
};

// Función para Editar un Producto
var editarProducto = (e) => {
    e.preventDefault();

    var frm_editar_productos = new FormData($("#frm_editar_productos")[0]);
    var ruta = "../controllers/producto.controller.php?op=actualizar";

    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_editar_productos,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            location.reload();
            $("#modalEditarProducto").modal("hide");
        },
        error: function (xhr, status, error) {
            console.error("Error al actualizar:", error);
        }
    });
};

init();