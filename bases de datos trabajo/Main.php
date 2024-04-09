<?php
class Database {
    private $host = 'localhost';
    private $user = '';
    private $pass = '';
    private $db = 'libros';
    private $con;
    public function __construct() {
        $this->con = new mysqli($this->host, $this->user, $this->pass, $this->db);

        if ($this->con->connect_error) {
            die("Error de conexión: " . $this->con->connect_error);
        }
    }

    public function create($table, $payload) {
        $data = json_decode($payload, true);

        $columns = implode(', ', array_keys($data));
        $placeholders = str_repeat('?, ', count($data) - 1) . '?';
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $stmt = $this->con->prepare($sql);

        $types = str_repeat('s', count($data));
        $stmt->bind_param($types, ...array_values($data));

        if ($stmt->execute()) {
            header('Content-type: application/json;charset=utf-8');
            echo json_encode(array("success" => "Registro insertado con exito!"));
        } else {
            header('Content-type: application/json;charset=utf-8');
            echo json_encode(array("error" => "Error al insertar el registro: " . $stmt->error));
        }
    }

    public function read($table, $id) {
        $sql = "SELECT * FROM $table WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header('Content-type: application/json;charset=utf-8');
            echo json_encode($result->fetch_assoc());
        } else {
            header('Content-type: application/json;charset=utf-8');
            echo json_encode(array("error" => "No se encontraron resultados para el ID proporcionado."));
        }
    }
    public function update($table, $id, $payload) {
        $data = json_decode($payload, true);

        $setClause = '';
        foreach ($data as $key => $value) {
            $setClause .= "$key=?, ";
        }
        $setClause = rtrim($setClause, ', ');

        $sql = "UPDATE $table SET $setClause WHERE id=?";

        $stmt = $this->con->prepare($sql);

        $types = str_repeat('s', count($data)) . 'i';
        $values = array_values($data);
        $values[] = $id;
        $stmt->bind_param($types, ...$values);

        if ($stmt->execute()) {
            header('Content-type: application/json;charset=utf-8');
            echo json_encode(array("sucess" => "Registro actualizado con exito!"));
        } else {
            header('Content-type: application/json;charset=utf-8');
            echo json_encode(array("error" => "Error al actualizar el registro: " . $stmt->error));
        }
    }


    public function delete($table, $id) {
        $sql = "DELETE FROM $table WHERE id=?";

        $stmt = $this->con->prepare($sql);

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header('Content-type: application/json;charset=utf-8');
            echo json_encode(array("message" => "Registro eliminado correctamente."));
        } else {
            header('Content-type: application/json;charset=utf-8');
            echo json_encode(array("error" => "Error al eliminar el registro: " . $stmt->error));
        }
    }

    public function point32($id){
        $sql = "SELECT 
                autor.nombre AS autor_nombre, autor.apellido AS autor_apellido, autor.pais AS autor_pais,
                editorial.nombre AS editorial_nombre, editorial.direccion AS editorial_direccion, editorial.pais AS editorial_pais,
                libro.titulo AS libro_titulo, libro.genero AS libro_genero, libro.precio AS libro_precio,
                resenia.estrellas AS resenia_estrellas, resenia.nombre_usuario AS resenia_nombre_usuario, resenia.comentario AS resenia_comentario

            FROM libro 
                
            INNER JOIN autor ON libro.id = autor.id
                
            INNER JOIN editorial ON libro.id = editorial.id
                
            INNER JOIN resenia ON libro.id = resenia.id
            
            WHERE libro.id = ?
            LIMIT 1";

        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header('Content-type: application/json;charset=utf-8');
            echo json_encode(array("success" => $result->fetch_assoc()));
        } else {
            header('Content-type: application/json;charset=utf-8');
            echo json_encode(array("error" => "No se encontraron resultados para el pedido proporcionado."));
        }
    }

    public function point33($id){
        $sql = "SELECT 
                editorial.nombre AS editorial_nombre, editorial.direccion AS editorial_direccion, editorial.pais AS editorial_pais,
                libro.titulo AS libro_titulo, libro.genero AS libro_genero, libro.fecha_publicacion AS fecha_publicacion_libro

            FROM editorial 
                
            INNER JOIN libro ON editorial.id = libro.id
                
            WHERE editorial.id = ?";

        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header('Content-type: application/json;charset=utf-8');
            echo json_encode(array("success" => $result->fetch_assoc()));
        } else {
            header('Content-type: application/json;charset=utf-8');
            echo json_encode(array("error" => "No se encontraron resultados para la consulta dada."));
        }
    }

}

