<?php

require 'models/entity/publicidad.php';

class PublicidadModel extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function nuevaPublicidad($datos)
    {
        try {
            $query = $this->db->connect()->prepare('INSERT INTO tb_publicidad ( pu_nombre_empresa, pu_lema, pu_imagen, pu_tipo_publicidad, pu_link) VALUES (:nombre,:lema,:imagen,:tipo,:link)');
            $query->execute([
                'nombre'    => $datos['nombre'],
                'lema'      => $datos['lema'],
                'imagen'    => $datos['imagen'],
                'tipo'      => $datos['tipo'],
                'link'      => $datos['link']
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function editarPublicidad($datos)
    {
        try {
            $query = $this->db->connect()->prepare('UPDATE tb_publicidad SET pu_nombre_empresa=:nombre, pu_lema=:lema, pu_imagen=:imagen, pu_link=:link WHERE pu_id= :id');
            $query->execute([
                'id'            => $datos['id'],
                'nombre'        => $datos['nombre'],
                'lema'          => $datos['lema'],
                'imagen'        => $datos['imagen'],
                'link'          => $datos['link']
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function listarPublicidad($datos)
    {
        try {
            $sql = "SELECT * FROM tb_publicidad WHERE" . "(pu_nombre_empresa LIKE " . "'%" . $datos['nombre'] . "%') LIMIT " . $datos['limPagina'] . ",15";
            $query = $this->db->connect()->prepare($sql);
            $query->execute([]);
            $items = [];
            while ($row = $query->fetch()) {
                $item           = new Publicidad();
                $item->id       = $row['pu_id'];
                $item->nombre   = $row['pu_nombre_empresa'];
                $item->lema     = $row['pu_lema'];
                $item->imagen   = $row['pu_imagen'];
                $item->tipo     = $row['pu_tipo_publicidad'];
                $item->link     = $row['pu_link'];
                array_push($items, $item);
            }
            return $items;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function listarTres()
    {
        try {
            $items = [];
            $query = $this->db->connect()->query('SELECT * FROM tb_publicidad ORDER BY rand() LIMIT 3');
            while ($row = $query->fetch()) {
                $item           = new Publicidad();
                $item->id       = $row['pu_id'];
                $item->nombre   = $row['pu_nombre_empresa'];
                $item->lema     = $row['pu_lema'];
                $item->imagen   = $row['pu_imagen'];
                $item->tipo     = $row['pu_tipo_publicidad'];
                $item->link     = $row['pu_link'];
                array_push($items, $item);
            }
            return $items;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function numPaginasPublicidad()
    {
        try {
            $query = $this->db->connect()->prepare('SELECT COUNT(*) FROM tb_publicidad');
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

    function detallesPublicidad($id)
    {
        try {
            $query = $this->db->connect()->prepare('SELECT * FROM tb_publicidad WHERE pu_id =:id ');
            $query->execute(['id' => $id]);
            $item = new Publicidad();
            while ($row = $query->fetch()) {
                $item->id       = $row['pu_id'];
                $item->nombre   = $row['pu_nombre_empresa'];
                $item->lema     = $row['pu_lema'];
                $item->imagen   = $row['pu_imagen'];
                $item->tipo     = $row['pu_tipo_publicidad'];
                $item->link     = $row['pu_link'];
            }
            return $item;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function eliminar($id)
    {
        try {
            $query = $this->db->connect()->prepare('DELETE FROM tb_publicidad WHERE pu_id =:id');
            $query->execute([
                'id' => $id
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }
}