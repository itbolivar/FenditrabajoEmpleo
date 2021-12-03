<?php

require 'models/entity/hojaV.php';

class HojaVidaModel extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function agregarHoja($datos)
    {
        try {
            $query = $this->db->connect()->prepare('INSERT INTO tb_hoja_vida (hv_nombre, hv_apellido, hv_tipo_id, hv_numero_id, hv_fecha, hv_genero, hv_estado_civil, hv_tipo_tel, hv_telefono, hv_departamento, hv_direccion, hv_nacionalidad, hv_titulo, hv_perfil, hv_foto, fk_hv_usuario) VALUES (:nombre,:apellido,:tipoId,:numeroId,:fecha,:genero,:estadoCivil,:tipoTel,:telefono,:departamento,:direccion,:nacionalidad,:titulo,:perfil,:foto,:persona)');
            $query->execute([
                'nombre' => $datos['nombre'],
                'apellido' => $datos['apellido'],
                'tipoId' => $datos['tipoId'],
                'numeroId' => $datos['numeroId'],
                'fecha' => $datos['fecha'],
                'genero' => $datos['genero'],
                'estadoCivil' => $datos['estadoCivil'],
                'tipoTel' => $datos['tipoTel'],
                'telefono' => $datos['telefono'],
                'departamento' => $datos['departamento'],
                'direccion' => $datos['direccion'],
                'nacionalidad' => $datos['nacionalidad'],
                'titulo' => $datos['titulo'],
                'perfil' => $datos['perfil'],
                'foto' => $datos['foto'],
                'persona' => $datos['persona'],
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function modificarHoja($datos)
    {
        try {
            $query = $this->db->connect()->prepare('UPDATE tb_hoja_vida SET hv_nombre=:nombre,hv_apellido=:apellido,hv_tipo_id=:tipoId,hv_numero_id=:numeroId,hv_fecha=:fecha,hv_genero=:genero,hv_estado_civil=:estadoCivil,hv_tipo_tel=:tipoTel,hv_telefono=:telefono,hv_departamento=:departamento,hv_direccion=:direccion,hv_nacionalidad=:nacionalidad,hv_titulo=:titulo,hv_perfil=:perfil,hv_foto=:foto,fk_hv_usuario=:persona WHERE hv_id = :id');
            $query->execute([
                'id' => $datos['id'],
                'nombre' => $datos['nombre'],
                'apellido' => $datos['apellido'],
                'tipoId' => $datos['tipoId'],
                'numeroId' => $datos['numeroId'],
                'fecha' => $datos['fecha'],
                'genero' => $datos['genero'],
                'estadoCivil' => $datos['estadoCivil'],
                'tipoTel' => $datos['tipoTel'],
                'telefono' => $datos['telefono'],
                'departamento' => $datos['departamento'],
                'direccion' => $datos['direccion'],
                'nacionalidad' => $datos['nacionalidad'],
                'titulo' => $datos['titulo'],
                'perfil' => $datos['perfil'],
                'foto' => $datos['foto'],
                'persona' => $datos['persona'],
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function mostrar($persona)
    {
        try {
            $query = $this->db->connect()->prepare('SELECT * FROM tb_hoja_vida WHERE fk_hv_usuario = :persona');
            $query->execute([
                'persona' => $persona
            ]);
            $item = new HojaV();
            if ($query->rowCount()) {
                while ($row = $query->fetch()) {
                    $item->id = $row['hv_id'];
                    $item->nombre = $row['hv_nombre'];
                    $item->apellido = $row['hv_apellido'];
                    $item->tipoId = $row['hv_tipo_id'];
                    $item->numero = $row['hv_numero_id'];
                    $item->fecha = $row['hv_fecha'];
                    $item->genero = $row['hv_genero'];
                    $item->estado = $row['hv_estado_civil'];
                    $item->tipoTel = $row['hv_tipo_tel'];
                    $item->telefono = $row['hv_telefono'];
                    $item->departamento = $row['hv_departamento'];
                    $item->direccion = $row['hv_direccion'];
                    $item->nacionalidad = $row['hv_nacionalidad'];
                    $item->titulo = $row['hv_titulo'];
                    $item->perfil = $row['hv_perfil'];
                    $item->foto = $row['hv_foto'];
                    $item->usuario = $row['fk_hv_usuario'];
                }
            }
            return $item;
        } catch (PDOException $e) {
            echo "error con el servidor";
        }
    }
}
