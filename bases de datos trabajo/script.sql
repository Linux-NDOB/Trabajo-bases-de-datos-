CREATE TABLE autor (
                       id INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
                       nombre VARCHAR(100)  NOT NULL  ,
                       apellido VARCHAR(100)  NOT NULL  ,
                       pais VARCHAR(100)  NOT NULL  ,
                       fecha_nacimiento DATE  NOT NULL  ,
                       ciudad_nacimiento VARCHAR(100)  NOT NULL    ,
                       PRIMARY KEY(id));



CREATE TABLE libro (
                       id INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
                       autor_id INTEGER UNSIGNED  NOT NULL  ,
                       titulo VARCHAR(100)  NOT NULL  ,
                       genero VARCHAR(100)  NOT NULL  ,
                       fecha_publicacion DATE  NOT NULL  ,
                       precio FLOAT  NOT NULL    ,
                       PRIMARY KEY(id)  ,
                       INDEX libro_FKIndex1(autor_id),
                       FOREIGN KEY(autor_id)
                           REFERENCES autor(id)
                           ON DELETE CASCADE
                           ON UPDATE CASCADE);



CREATE TABLE editorial (
                           id INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
                           libro_id INTEGER UNSIGNED  NOT NULL  ,
                           nombre VARCHAR(200)  NOT NULL  ,
                           direccion TEXT  NOT NULL  ,
                           pais VARCHAR(100)  NOT NULL  ,
                           ciudad VARCHAR(100)  NOT NULL  ,
                           telefono VARCHAR(10)  NOT NULL  ,
                           email VARCHAR(100)  NOT NULL    ,
                           PRIMARY KEY(id)  ,
                           INDEX editorial_FKIndex1(libro_id),
                           FOREIGN KEY(libro_id)
                               REFERENCES libro(id)
                               ON DELETE CASCADE
                               ON UPDATE CASCADE);



CREATE TABLE resenia (
                         id INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
                         libro_id INTEGER UNSIGNED  NOT NULL  ,
                         estrellas INTEGER UNSIGNED  NOT NULL  ,
                         nombre_usuario VARCHAR(100)  NOT NULL  ,
                         comentario TEXT  NOT NULL  ,
                         email_usuario VARCHAR(100)  NOT NULL  ,
                         fecha_resenia DATE  NOT NULL    ,
                         PRIMARY KEY(id)  ,
                         INDEX Table_04_FKIndex1(libro_id),
                         FOREIGN KEY(libro_id)
                             REFERENCES libro(id)
                             ON DELETE CASCADE
                             ON UPDATE CASCADE);



