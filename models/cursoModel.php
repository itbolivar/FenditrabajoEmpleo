<?php

require 'models/entity/curso.php';

class CursoModel extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function listaUser()
    {
        $items = [];
        try {
            $query = $this->db->connect()->query('SELECT * FROM tb_curso ORDER BY rand() LIMIT 4');
            while ($row = $query->fetch()) {
                $item = new Curso();
                $item->id = $row['cu_id'];
                $item->nombre = $row['cu_nombre'];
                $item->descripcion = $row['cu_descripcion'];
                $item->link = $row['cu_link'];
                $item->entidad = $row['cu_entidad'];
                $item->isotipo = $row['cu_isotipo'];
                array_push($items, $item);
            }

            return $items;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function listar($datos)
    {
        $items = [];
        try {
            $sql = "SELECT * FROM tb_curso WHERE cu_nombre LIKE " . "'%" . $datos['nombre'] . "%' LIMIT ".$datos['limPagina']. ",15";
            $query = $this->db->connect()->prepare($sql);
            $query->execute();
            while ($row = $query->fetch()) {
                $item = new Curso();
                $item->id = $row['cu_id'];
                $item->nombre = $row['cu_nombre'];
                $item->descripcion = $row['cu_descripcion'];
                $item->link = $row['cu_link'];
                $item->entidad = $row['cu_entidad'];
                $item->isotipo = $row['cu_isotipo'];
                array_push($items, $item);
            }

            return $items;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function numPaginasCursos()
    {
        try {
            $query = $this->db->connect()->prepare('SELECT COUNT(*) FROM tb_curso');
            $query->execute([]);

            $numero = 0;
            while ($row = $query->fetch()) {
                $numero = $row[0];
            }
            if ($numero != 0) {
                $numero = $numero / 15;
                $numero = ceil($numero);
                if ($numero > 20) {
                    $numero = 20;
                }
            }
            return $numero;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function detallesCurso($id)
    {
        try {
            $query = $this->db->connect()->prepare('SELECT * FROM tb_curso WHERE cu_id=:id');
            $query->execute([
                'id' => $id
            ]);

            $item = new Curso();
            while ($row = $query->fetch()) {
                $item->id = $row['cu_id'];
                $item->nombre = $row['cu_nombre'];
                $item->descripcion = $row['cu_descripcion'];
                $item->link = $row['cu_link'];
                $item->entidad = $row['cu_entidad'];
                $item->isotipo = $row['cu_isotipo'];
            }

            return $item;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function nuevoCurso($datos)
    {
        try {
            $query = $this->db->connect()->prepare('INSERT INTO tb_curso ( cu_nombre, cu_descripcion, cu_link, cu_entidad, cu_isotipo) VALUES (:nombre,:descripcion,:link,:entidad,:isotipo)');
            $query->execute([
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'],
                'link' => $datos['link'],
                'entidad' => $datos['entidad'],
                'isotipo' => $datos['isotipo']
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function editarCurso($datos)
    {
        try {
            $query = $this->db->connect()->prepare('UPDATE tb_curso SET cu_nombre=:nombre,cu_descripcion=:descripcion,cu_link=:link,cu_entidad=:entidad,cu_isotipo=:isotipo WHERE cu_id=:id');
            $query->execute([
                'id' => $datos['id'],
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'],
                'link' => $datos['link'],
                'entidad' => $datos['entidad'],
                'isotipo' => $datos['isotipo']
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function eliminar($id)
    {
        try {
            $query = $this->db->connect()->prepare('DELETE FROM tb_curso WHERE cu_id =:id');
            $query->execute([
                'id' => $id
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }
}
