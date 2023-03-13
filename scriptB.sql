DROP TABLE IF EXISTS Factura;
DROP TABLE IF EXISTS Ticket;
DROP TABLE IF EXISTS Usuario;
DROP TABLE IF EXISTS Trabajo;

CREATE TABLE Trabajo (
  id_trabajo serial,
  nombre_trabajo varchar(50) not null,
  estado_trabajo varchar(1),
  CONSTRAINT pk_trabajo PRIMARY KEY (id_trabajo)
);

CREATE TABLE Usuario (
  id_usuario SERIAL,
  nombre_usuario varchar(50) not null,
  apellido_usuario varchar(50) not null,
  username varchar(100) not null,
  email varchar(100) not null,
  clave varchar(100) not null,
  roles json not null,
  estado_usuario varchar(1),
  CONSTRAINT pk_usuario PRIMARY KEY (id_usuario)
);

CREATE TABLE Ticket (
  id_ticket SERIAL,
  id_usuario int,
  id_trabajo int,
  descripcion_ticket varchar(500),
  fecha_ticket date not null,
  horas_ticket int not null,
  estado_ticket varchar(1),
  CONSTRAINT pk_ticket PRIMARY KEY (id_ticket),
  CONSTRAINT fk_ticket_usuario FOREIGN KEY (id_usuario) REFERENCES Usuario (id_usuario),
  CONSTRAINT fk_ticket_trabajo FOREIGN KEY (id_trabajo) REFERENCES Trabajo (id_trabajo)
);

CREATE TABLE Factura (
  id_factura SERIAL,
  id_usuario int,
  id_ticket int,
  descripcion_factura varchar(500),
  total_factura real not null,
  estado_factura varchar(1),
  CONSTRAINT pk_factura PRIMARY KEY (id_factura),
  CONSTRAINT fk_factura_usuario FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
  CONSTRAINT fk_factura_ticket FOREIGN KEY (id_ticket) REFERENCES Ticket(id_ticket)
);

