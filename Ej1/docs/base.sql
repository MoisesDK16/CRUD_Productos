create table
    Productos (
        id int AUTO_INCREMENT primary key,
        nombre varchar(50),
        precio decimal(10, 2),
        stock int
    );

create table
    Clientes (
        id int AUTO_INCREMENT primary key,
        nombre varchar(50),
        apellido varchar(50),
        email varchar(100),
        telefono varchar(20)
    );

create table
    Ventas (
        id int AUTO_INCREMENT primary key,
        fecha datetime,
        cliente_id int,
        total decimal(10, 2),
        foreign key (cliente_id) references Clientes (id)
    );

create table
    VentasDetalle (
        id int AUTO_INCREMENT primary key,
        venta_id int,
        producto_id int,
        cantidad int,
        precio decimal(10, 2),
        foreign key (venta_id) references Ventas (id),
        foreign key (producto_id) references Productos (id)
    );