<?php

require 'models/entity/persona.php';

class PersonaModel extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function loginPersona($datos)
    {
        try {
            $query = $this->db->connect()->prepare('SELECT * FROM tb_usuario WHERE us_correo = :email AND us_contrasena = :pass');
            $query->execute(['email' => $datos['email'], 'pass' => $datos['password']]);
            if ($query->rowCount()) {
                while ($row = $query->fetch()) {
                    $resultado = [
                        'idUser' =>  $row['us_id'],
                        'rol' => $row['us_rol']
                    ];
                    return $resultado;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function nuevaPersona($datos)
    {
        try {

            $query = $this->db->connect()->prepare('SELECT * FROM tb_usuario WHERE us_correo = :email ');
            $query->execute([
                'email' => $datos['email']
            ]);
            if ($query->rowCount()) {
                return false;
            }
            $query = $this->db->connect()->prepare('INSERT INTO tb_usuario ( us_nombres, us_apellidos, us_correo,us_contrasena, us_rol, us_ip, us_navegador, us_fecha) VALUES (:nombre,:apellido,:email,:pass,:rol,:ip,:navegador,:fecha)');
            $query->execute([
                'nombre' => $datos['nombre'],
                'apellido' => $datos['apellido'],
                'email' => $datos['email'],
                'pass' => $datos['password'],
                'rol' => 1,
                'ip' => $datos['ip'],
                'navegador' => $datos['navegador'],
                'fecha' => $datos['fecha']
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function informacionPersona($usuario)
    {
        try {
            $query = $this->db->connect()->prepare('SELECT * FROM tb_hoja_vida WHERE fk_hv_usuario = :usuario ');
            $query->execute([
                'usuario' => $usuario
            ]);
            if ($query->rowCount()) {
                $query = $this->db->connect()->prepare('SELECT u.us_nombres, u.us_apellidos,u.us_correo, h.hv_titulo, h.hv_departamento, h.hv_foto FROM tb_hoja_vida h INNER JOIN tb_usuario u  ON u.us_id = h.fk_hv_usuario WHERE h.fk_hv_usuario = :usuario');
                $query->execute(['usuario' => $usuario]);

                while ($row = $query->fetch()) {
                    $resultado = [
                        'nombre' =>  $row['us_nombres'],
                        'apellido' => $row['us_apellidos'],
                        'email' => $row['us_correo'],
                        'titulo' => $row['hv_titulo'],
                        'departamento' => $row['hv_departamento'],
                        'foto' => $row['hv_foto']
                    ];
                    return $resultado;
                }
            } else {
                $query = $this->db->connect()->prepare('SELECT * FROM tb_usuario WHERE us_id = :usuario');
                $query->execute(['usuario' => $usuario]);

                while ($row = $query->fetch()) {
                    $resultado = [
                        'nombre' =>  $row['us_nombres'],
                        'apellido' => $row['us_apellidos'],
                        'email' => $row['us_correo'],
                        'titulo' => "",
                        'departamento' => "",
                        'foto' => ""
                    ];
                    return $resultado;
                }
            }
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function listarUsuarios($datos)
    {
        try {
            $sql = "SELECT * FROM tb_usuario WHERE" . "(us_nombres LIKE " . "'%" . $datos['nombre'] . "%') OR " . "(us_apellidos LIKE " . "'%" . $datos['nombre'] . "%')  LIMIT " . $datos['limPagina'] . ",15";
            $query = $this->db->connect()->prepare($sql);
            $query->execute([]);
            $items = [];
            while ($row = $query->fetch()) {
                $item = new Persona();
                $item->id = $row['us_id'];
                $item->nombres = $row['us_nombres'];
                $item->apellidos = $row['us_apellidos'];
                $item->correo = $row['us_apellidos'];
                $item->rol = $row['us_apellidos'];
                array_push($items, $item);
            }
            return $items;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function numPaginasPersona()
    {
        try {
            $query = $this->db->connect()->prepare('SELECT COUNT(*) FROM tb_usuario');
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

    function eliminar($id)
    {
        try {
            $query = $this->db->connect()->prepare('DELETE FROM tb_usuario WHERE us_id =:id');
            $query->execute([
                'id' => $id
            ]);
            return true;
        } catch (PDOException $e) {
            echo "error con el servidor";
        }
    }

    function cambiarContrasena($datos)
    {
        try {
            $query = $this->db->connect()->prepare('UPDATE tb_usuario SET us_contrasena=:pass WHERE us_correo=:correo');
            $query->execute([
                'correo' => $datos['correo'],
                'pass' => $datos['pass']
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function modificarPersona($datos)
    {
        try {
            $query = $this->db->connect()->prepare('UPDATE tb_usuario SET us_nombres=:nombres, us_apellidos=:apellidos WHERE us_id=:id');
            $query->execute([
                'nombres' => $datos['nombres'],
                'apellidos' => $datos['apellidos'],
                'id' => $datos['id']
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

}
