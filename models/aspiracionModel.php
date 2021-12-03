 <?php

    require 'models/entity/oferta.php';
    require 'models/entity/persona.php';
    require 'models/entity/personaAsp.php';

    class AspiracionModel extends Model
    {

        function __construct()
        {
            parent::__construct();
        }

        function aplicarOferta($datos)
        {
            try {

                $query = $this->db->connect()->prepare('SELECT * FROM tb_aspiracion WHERE fk_as_usuario = :usuario AND fk_as_oferta = :oferta');
                $query->execute([
                    'usuario' => $datos['usuario'],
                    'oferta' => $datos['oferta']
                ]);

                if (!$query->rowCount()) {

                    $query = $this->db->connect()->prepare('INSERT INTO tb_aspiracion(fk_as_usuario, fk_as_oferta, as_fecha_aspiracion, as_estado) VALUES (:usuario,:oferta,:fecha,1)');
                    $query->execute([
                        'usuario' => $datos['usuario'],
                        'oferta' => $datos['oferta'],
                        'fecha' => $datos['fecha']
                    ]);
                }
                return true;
            } catch (PDOException $e) {
                echo "Error con el servidor <br>".$e->getMessage();
            }
        }

        function eliminar($datos)
        {
            try {
                $query = $this->db->connect()->prepare('DELETE FROM tb_aspiracion WHERE fk_as_usuario = :usuario AND fk_as_oferta = :oferta');
                $query->execute([
                    'usuario' => $datos['usuario'],
                    'oferta' => $datos['oferta']
                ]);
                return true;
            } catch (PDOException $e) {
                echo "Error con el servidor <br>".$e->getMessage();
            }
        }

        function seleccionar($id)
        {
            try {
                $query = $this->db->connect()->prepare('UPDATE tb_aspiracion SET as_estado = 2 WHERE as_id = :id');
                $query->execute([
                    'id' => $id
                ]);
                return true;
            } catch (PDOException $e) {
                echo "Error con el servidor <br>".$e->getMessage();
            }
        }

        function listar($usuario)
        {
            try {
                $items = [];
                $query = $this->db->connect()->prepare('SELECT o.*,a.* FROM tb_aspiracion a INNER JOIN tb_oferta o ON o.of_id = a.fk_as_oferta WHERE a.fk_as_usuario = :usuario ORDER BY a.as_estado');
                $query->execute([
                    'usuario' => $usuario
                ]);
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
                    $item->empresa = $row['fk_of_empresa'];
                    if ($row['as_estado'] == 1) {
                        $item->estado = 'En proceso';
                    } elseif ($row['as_estado'] == 2) {
                        $item->estado = 'Seleccionado';
                    } else {
                        $item->estado = 'No seleccionado';
                    }
                    array_push($items, $item);
                }
                return $items;
            } catch (PDOException $e) {
                echo "Error con el servidor <br>".$e->getMessage();
            }
        }

        function personasOfeta($datos)
        {
            try {
                $items = [];
                $query = $this->db->connect()->prepare('SELECT u.*,a.* FROM tb_aspiracion a INNER JOIN tb_usuario u ON u.us_id = a.fk_as_usuario WHERE a.fk_as_oferta = :id LIMIT :limPagina,15');
                $query->execute([
                    'id' => $datos['idOfe'],
                    'limPagina' => $datos['limPagina']
                ]);
                while ($row = $query->fetch()) {
                    $item = new PersonaAsp();
                    $item->id = $row['as_id'];
                    $item->nombres = $row['us_nombres'];
                    $item->apellidos = $row['us_apellidos'];
                    $item->idUser = $row['us_id'];
                    if ($row['as_estado'] == 1) {
                        $item->estado = 'En proceso';
                    } elseif ($row['as_estado'] == 2) {
                        $item->estado = 'Seleccionado';
                    }
                    array_push($items, $item);
                }
                return $items;
            } catch (PDOException $e) {
                echo "Error con el servidor <br>".$e->getMessage();
            }
        }

        function numPaginasPersonas($id)
        {
            try {
                $query = $this->db->connect()->prepare('SELECT COUNT(*) FROM tb_aspiracion WHERE fk_as_oferta = :id ');
                $query->execute(['id' => $id]);

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
    }
