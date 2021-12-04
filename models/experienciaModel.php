<?php

require 'models/entity/experiencia.php';

class ExperienciaModel extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function listar($usuario)
    {
        $items = [];
        try {            
            $query = $this->db->connect()->prepare('SELECT * FROM tb_experiencia WHERE fk_ex_usuario = :usuario');
            $query->execute([
                'usuario' => $usuario
            ]);

            while ($row = $query->fetch()) {
                $item = new Experiencia();
                $item->id = $row['ex_id'];
                $item->empresa = $row['ex_empresa'];
                $item->departamento = $row['ex_departamento'];
                $item->sector = $row['ex_sector'];
                $item->cargo = $row['ex_cargo'];
                $item->area = $row['ex_area'];
                $item->fechaInicio = $row['ex_fecha_inicio'];
                $item->fechaFin = $row['ex_fecha_fin'];
                $item->usuario = $row['fk_ex_usuario'];
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
            $query = $this->db->connect()->prepare('SELECT * FROM tb_experiencia WHERE ex_id = :id');
            $query->execute([
                'id' => $id
            ]);
            $item = new Experiencia();
            while ($row = $query->fetch()) {                
                $item->id = $row['ex_id'];
                $item->empresa = $row['ex_empresa'];
                $item->departamento = $row['ex_departamento'];
                $item->sector = $row['ex_sector'];
                $item->cargo = $row['ex_cargo'];
                $item->area = $row['ex_area'];
                $item->fechaInicio = $row['ex_fecha_inicio'];
                $item->fechaFin = $row['ex_fecha_fin'];
                $item->usuario = $row['fk_ex_usuario'];
            }
            return $item;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function agregar($datos){
        try {            
            $query = $this->db->connect()->prepare('INSERT INTO tb_experiencia(ex_empresa, ex_departamento, ex_sector, ex_cargo, ex_area, ex_fecha_inicio, ex_fecha_fin, fk_ex_usuario) VALUES (:empresa,:departamento,:sector,:cargo,:area,:fechaInicio,:fechaFin,:usuario)');
            $query->execute([
                'empresa' => $datos['empresa'],
                'departamento' => $datos['departamento'],
                'sector' => $datos['sector'],
                'cargo' => $datos['cargo'],
                'area' => $datos['area'],
                'fechaInicio' => $datos['fechaInicio'],
                'fechaFin' => $datos['fechaFin'],
                'usuario' => $datos['usuario']
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }

    }

    function editar($datos){
        try {            
            $query = $this->db->connect()->prepare('UPDATE tb_experiencia SET ex_empresa=:empresa,ex_departamento=:departamento,ex_sector=:sector,ex_cargo=:cargo,ex_area=:area,ex_fecha_inicio=:fechaInicio,ex_fecha_fin=:fechaFin WHERE ex_id=:id');
            $query->execute([
                'id' => $datos['id'],
                'empresa' => $datos['empresa'],
                'departamento' => $datos['departamento'],
                'sector' => $datos['sector'],
                'cargo' => $datos['cargo'],
                'area' => $datos['area'],
                'fechaInicio' => $datos['fechaInicio'],
                'fechaFin' => $datos['fechaFin']
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }

    }

    function eliminar($experiencia){
        try{
            $query = $this->db->connect()->prepare('DELETE FROM tb_experiencia WHERE ex_id = :id');
            $query->execute([
                'id' => $experiencia
            ]);
            return true;
        }catch(PDOException $e) 
        {
            echo "Error con el servidor <br>".$e->getMessage();
            return false;
        }
    }

}
