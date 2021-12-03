<?php

require 'models/entity/formacion.php';

class FormacionModel extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function listar($usuario)
    {
        $items = [];
        try {
            $query = $this->db->connect()->prepare('SELECT * FROM tb_formacion WHERE fk_fo_usuario = :usuario');
            $query->execute([
                'usuario' => $usuario
            ]);

            while ($row = $query->fetch()) {
                $item = new Formacion();
                $item->id = $row['fo_id'];
                $item->tituloF = $row['fo_titulo'];
                $item->centro = $row['fo_centro_educativo'];
                $item->nivel = $row['fo_nivel_estudios'];
                $item->estado = $row['fo_estado'];
                $item->fechaInicio = $row['fo_fecha_inicio'];
                $item->fechaFin = $row['fo_fecha_fin'];
                $item->usuario = $row['fk_fo_usuario'];
                array_push($items, $item);
            }

            return $items;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function detalles($id)
    {
        try {
            $query = $this->db->connect()->prepare('SELECT * FROM tb_formacion WHERE fo_id = :id');
            $query->execute([
                'id' => $id
            ]);
            $item = new Formacion();
            while ($row = $query->fetch()) {
                $item->id = $row['fo_id'];
                $item->tituloF = $row['fo_titulo'];
                $item->centro = $row['fo_centro_educativo'];
                $item->nivel = $row['fo_nivel_estudios'];
                $item->estado = $row['fo_estado'];
                $item->fechaInicio = $row['fo_fecha_inicio'];
                $item->fechaFin = $row['fo_fecha_fin'];
                $item->usuario = $row['fk_fo_usuario'];
            }
            return $item;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function agregar($datos)
    {
        try {
            $query = $this->db->connect()->prepare('INSERT INTO tb_formacion(fo_titulo, fo_centro_educativo, fo_nivel_estudios, fo_estado, fo_fecha_inicio, fo_fecha_fin, fk_fo_usuario) VALUES (:titulo,:centro,:nivel,:estado,:fechaInicio,:fechaFin,:usuario)');
            $query->execute([
                'titulo' => $datos['tituloF'],
                'centro' => $datos['centro'],
                'nivel' => $datos['nivel'],
                'estado' => $datos['estado'],
                'fechaInicio' => $datos['fechaInicio'],
                'fechaFin' => $datos['fechaFin'],
                'usuario' => $datos['usuario']
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function eliminar($experiencia)
    {
        try {
            $query = $this->db->connect()->prepare('DELETE FROM tb_formacion WHERE fo_id = :id');
            $query->execute([
                'id' => $experiencia
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
            return false;
        }
    }

    function editar($datos)
    {
        try {
            $query = $this->db->connect()->prepare('UPDATE tb_formacion SET fo_titulo=:titulo,fo_centro_educativo=:centro,fo_nivel_estudios=:nivel,fo_estado=:estado,fo_fecha_inicio=:fechaInicio,fo_fecha_fin=:fechaFin WHERE fo_id=:id');
            $query->execute([
                'id' => $datos['id'],
                'titulo' => $datos['tituloF'],
                'centro' => $datos['centro'],
                'nivel' => $datos['nivel'],
                'estado' => $datos['estado'],
                'fechaInicio' => $datos['fechaInicio'],
                'fechaFin' => $datos['fechaFin']
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
            return false;
        }
    }
}
