<?php

require 'models/entity/oferta.php';

class OfertaModel extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function agregarOferta($datos)
    {
        try {
            $query = $this->db->connect()->prepare('INSERT INTO tb_oferta( of_nombre, of_descripcion, of_fecha_publicacion, of_fecha_final, of_departamento, of_municipio, of_salario, of_tipo_jornada,of_estado, fk_of_empresa) VALUES (:nombre,:descripcion,:fecha,:fechaFin,:departamento,:municipio,:salario,:jornada,:estado,:empresa)');
            $query->execute([
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'],
                'fecha' => $datos['fecha'],
                'fechaFin' => $datos['fechaFin'],
                'departamento' => $datos['departamento'],
                'municipio' => $datos['municipio'],
                'salario' => $datos['salario'],
                'jornada' => $datos['jornada'],
                'estado' => $datos['estado'],
                'empresa' => $datos['empresa']
            ]);

            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function editar($datos)
    {
        try {
            $query = $this->db->connect()->prepare('UPDATE tb_oferta SET of_nombre=:nombre, of_descripcion=:descripcion, of_departamento=:departamento, of_municipio=:municipio, of_salario=:salario, of_tipo_jornada=:jornada WHERE of_id = :id');
            $query->execute([
                'id' => $datos['id'],
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'],
                'departamento' => $datos['departamento'],
                'municipio' => $datos['municipio'],
                'salario' => $datos['salario'],
                'jornada' => $datos['jornada']
            ]);

            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function buscarOfertas($datos)
    {
        $items = [];
        try {

            $sql = 'WHERE ';
            if ($datos['nombre'] != '') {
                $sql .= "(of_nombre LIKE " . "'%" . $datos['nombre'] . "%')";
            }
            if ($datos['departamento'] != '') {
                if ($sql != 'WHERE ') {
                    $sql .= " AND (of_departamento = '" . $datos['departamento'] . "')";
                } else {
                    $sql .= " (of_departamento = '" . $datos['departamento'] . "')";
                }
            }
            if ($datos['salario'] != 00000) {
                if ($sql != 'WHERE ') {
                    $sql .= " AND (of_salario > " . $datos['salario'] . ")";
                } else {
                    $sql .= " (of_salario > " . $datos['salario'] . ")";
                }
            }
            if ($datos['jornada']) {
                if ($sql != 'WHERE ') {
                    $sql .= " AND (of_tipo_jornada = '" . $datos['jornada'] . "')";
                } else {
                    $sql .= " (of_tipo_jornada = '" . $datos['jornada'] . "')";
                }
            }
            if ($sql == 'WHERE ') {
                $sql = $sql . "of_estado > 0 ORDER BY of_fecha_publicacion DESC LIMIT " . $datos['limPagina'] . ", 15";
            } else {
                $sql = $sql . "AND (of_estado > 0) ORDER BY of_fecha_publicacion DESC LIMIT " . $datos['limPagina'] . ", 15";
            }
            $valor = "SELECT * FROM tb_oferta " . $sql;
            $query = $this->db->connect()->query($valor);
            while ($row = $query->fetch()) {
                $item = new Oferta();
                $item->id = $row['of_id'];
                $item->nombre = $row['of_nombre'];
                $item->descripcion = $row['of_descripcion'];
                $item->fechaInicial = $row['of_fecha_publicacion'];
                $item->fechaFinal = $row['of_fecha_final'];
                $item->departamento = $row['of_departamento'];
                $item->municipio = $row['of_municipio'];
                $item->salario = $row['of_salario'];
                $item->jornada = $row['of_tipo_jornada'];
                $item->estado = $row['of_estado'];
                $query2 = $this->db->connect()->prepare('SELECT * FROM tb_empresa WHERE em_id = :id');
                $query2->execute(['id' => $row['fk_of_empresa']]);
                while ($row2 = $query2->fetch()) {
                    $item->empresa = $row2['em_isotipo'];
                }
                array_push($items, $item);
            }

            return $items;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function numPaginasOfertas()
    {
        try {
            $query = $this->db->connect()->prepare('SELECT COUNT(*) FROM tb_oferta WHERE of_estado > 0');
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


    function ofertaId($id)
    {
        try {
            $query = $this->db->connect()->prepare('SELECT * FROM tb_oferta WHERE of_id = :id');
            $query->execute([
                'id' => $id
            ]);

            $item = new Oferta();
            while ($row = $query->fetch()) {
                $item->id = $row['of_id'];
                $item->nombre = $row['of_nombre'];
                $item->descripcion = $row['of_descripcion'];
                $item->fechaInicial = $row['of_fecha_publicacion'];
                $item->fechaFinal = $row['of_fecha_final'];
                $item->departamento = $row['of_departamento'];
                $item->municipio = $row['of_municipio'];
                $item->salario = $row['of_salario'];
                $item->jornada = $row['of_tipo_jornada'];
                $query2 = $this->db->connect()->prepare('SELECT * FROM tb_empresa WHERE em_id = :id');
                $query2->execute(['id' => $row['fk_of_empresa']]);
                while ($row2 = $query2->fetch()) {
                    $item->empresa = $row2['em_isotipo'];
                }
            }

            return $item;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function ofertasEmpresa($datos)
    {
        try {
            $query = $this->db->connect()->prepare('SELECT * FROM tb_oferta WHERE fk_of_empresa = :id AND of_estado > 0 ORDER BY of_estado,of_fecha_publicacion DESC LIMIT :limPagina,15');
            $query->execute([
                'id' => $datos['idEmp'],
                'limPagina' => $datos['limPagina']
            ]);
            $items = [];
            while ($row = $query->fetch()) {
                $item = new Oferta();
                $item->id = $row['of_id'];
                $item->nombre = $row['of_nombre'];
                $item->descripcion = $row['of_descripcion'];
                $item->fechaInicial = $row['of_fecha_publicacion'];
                $item->fechaFinal = $row['of_fecha_final'];
                $item->departamento = $row['of_departamento'];
                $item->municipio = $row['of_municipio'];
                $item->salario = $row['of_salario'];
                $item->jornada = $row['of_tipo_jornada'];
                $item->estado = $row['of_estado'];
                $query2 = $this->db->connect()->prepare('SELECT * FROM tb_aspiracion WHERE fk_as_oferta = :id');
                $query2->execute(['id' => $row['of_id']]);
                $cont = 0;
                while ($row2 = $query2->fetch()) {
                    $cont++;
                }
                $item->empresa = $cont;
                array_push($items, $item);
            }
            return $items;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function numPaginasEmpresa($idEmp)
    {
        try {
            $query = $this->db->connect()->prepare('SELECT COUNT(*) FROM tb_oferta WHERE fk_of_empresa = :id AND of_estado > 0 ');
            $query->execute(['id' => $idEmp]);

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

    function archivarOferta($id)
    {
        try {
            $query = $this->db->connect()->prepare('UPDATE tb_aspiracion SET as_estado = 3 WHERE (fk_as_oferta = :id) AND (as_estado = 1)');
            $query->execute(['id' => $id]);

            $query2 = $this->db->connect()->prepare('UPDATE tb_oferta SET of_estado = -1 WHERE of_id = :id');
            $query2->execute(['id' => $id]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }
}
