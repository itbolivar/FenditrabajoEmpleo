<?php

require 'models/entity/empresa.php';

class EmpresaModel extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function loginEmpresa($datos)
    {
        try {
            $query = $this->db->connect()->prepare('SELECT * FROM tb_empresa WHERE em_correo = :email AND em_contrasena = :pass');
            $query->execute(['email' => $datos['email'], 'pass' => $datos['password']]);
            if ($query->rowCount()) {
                while ($row = $query->fetch()) {
                    $resultado = [
                        'idEmp' =>  $row['em_id'],
                        'estado' => $row['em_estado']
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

    function nuevaEmpresa($datos)
    {
        try {
            $query = $this->db->connect()->prepare('SELECT * FROM tb_empresa WHERE em_correo = :email ');
            $query->execute([
                'email' => $datos['email']
            ]);
            if ($query->rowCount()) {
                return false;
            }

            $query = $this->db->connect()->prepare('INSERT INTO tb_empresa(em_nombre, em_descripcion, em_nit, em_isotipo, em_correo_con, em_departamento, em_ciudad, em_direccion, em_estado, em_nombre_e, em_apellido_e, em_cargo_e, em_correo_e, em_telefono_e, em_correo, em_contrasena) VALUES (:nombre,:descripcion,:nit,:logo,:correoCon,:departamento,:ciudad,:direccion,:estado,:nombreE,:apellidoE,:cargoE,:correoE,:telefonoE,:email,:pass)');
            $query->execute([
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'],
                'nit' => $datos['nit'],
                'logo' => $datos['logo'],
                'correoCon' => $datos['correoCon'],
                'departamento' => $datos['departamento'],
                'ciudad' => $datos['ciudad'],
                'direccion' => $datos['direccion'],
                'estado' => 1,
                'nombreE' => $datos['nombreE'],
                'apellidoE' => $datos['apellidoE'],
                'cargoE' => $datos['cargoE'],
                'correoE' => $datos['correoE'],
                'telefonoE' => $datos['telefonoE'],
                'email' => $datos['email'],
                'pass' => $datos['password']
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function editarEmpresa($datos)
    {
        try {
            $query = $this->db->connect()->prepare('UPDATE `tb_empresa` SET em_nombre=:nombre,em_descripcion=:descripcion,em_nit=:nit,em_isotipo=:logo,em_correo_con=:correoCon,em_departamento=:departamento,em_ciudad=:ciudad,em_direccion=:direccion,em_nombre_e=:nombreE,em_apellido_e=:apellidoE,em_cargo_e=:cargoE,em_correo_e=:correoE,em_telefono_e=:telefonoE WHERE em_id = :id');
            $query->execute([
                'id' => $datos['id'],
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'],
                'nit' => $datos['nit'],
                'logo' => $datos['logo'],
                'correoCon' => $datos['correoCon'],
                'departamento' => $datos['departamento'],
                'ciudad' => $datos['ciudad'],
                'direccion' => $datos['direccion'],
                'nombreE' => $datos['nombreE'],
                'apellidoE' => $datos['apellidoE'],
                'cargoE' => $datos['cargoE'],
                'correoE' => $datos['correoE'],
                'telefonoE' => $datos['telefonoE']
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function informacionEmpresa($idEmp)
    {
        try {
            $query = $this->db->connect()->prepare('SELECT * FROM tb_empresa WHERE em_id = :id');
            $query->execute(['id' => $idEmp]);
            $item = new Empresa();
            while ($row = $query->fetch()) {
                $item->id = $row['em_id'];
                $item->nombre = $row['em_nombre'];
                $item->descripcion = $row['em_descripcion'];
                $item->nit = $row['em_nit'];
                $item->isotipo = $row['em_isotipo'];
                $item->correoCon = $row['em_correo_con'];
                $item->departamento = $row['em_departamento'];
                $item->ciudad = $row['em_ciudad'];
                $item->direccion = $row['em_direccion'];
                $item->estado = $row['em_estado'];
                $item->nombreE = $row['em_nombre_e'];
                $item->apellidoE = $row['em_apellido_e'];
                $item->cargoE = $row['em_cargo_e'];
                $item->correoE = $row['em_correo_e'];
                $item->telefonoE = $row['em_telefono_e'];
                $item->correo = $row['em_correo'];
                $item->contrasena = $row['em_contrasena'];
            }
            return $item;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function listarEmpresas($datos)
    {
        try {
            $sql = "SELECT * FROM tb_empresa WHERE" . "(em_nombre LIKE " . "'%" . $datos['nombre'] . "%') OR " . "(em_nombre_e LIKE " . "'%" . $datos['nombre'] . "%') OR " . "(em_apellido_e LIKE " . "'%" . $datos['nombre'] . "%') LIMIT " . $datos['limPagina'] . ",15";
            $query = $this->db->connect()->prepare($sql);
            $query->execute();
            $items = [];
            while ($row = $query->fetch()) {
                $item = new Empresa();
                $item->id = $row['em_id'];
                $item->nombre = $row['em_nombre'];
                $item->descripcion = $row['em_descripcion'];
                $item->nit = $row['em_nit'];
                $item->isotipo = $row['em_isotipo'];
                $item->correoCon = $row['em_correo_con'];
                $item->departamento = $row['em_departamento'];
                $item->ciudad = $row['em_ciudad'];
                $item->direccion = $row['em_direccion'];
                $item->estado = $row['em_estado'];
                $item->nombreE = $row['em_nombre_e'];
                $item->apellidoE = $row['em_apellido_e'];
                $item->cargoE = $row['em_cargo_e'];
                $item->correoE = $row['em_correo_e'];
                $item->telefonoE = $row['em_telefono_e'];
                $item->correo = $row['em_correo'];
                $item->contrasena = $row['em_contrasena'];
                array_push($items, $item);
            }
            return $items;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }


    function numPaginasEmpresa()
    {
        try {
            $query = $this->db->connect()->prepare('SELECT COUNT(*) FROM tb_empresa');
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
            $query = $this->db->connect()->prepare('DELETE FROM tb_empresa WHERE em_id =:id');
            $query->execute([
                'id' => $id
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function cambiarEstado($datos)
    {
        try {
            $query = $this->db->connect()->prepare('UPDATE `tb_empresa` SET em_estado=:estado WHERE em_id = :id');
            $query->execute([
                'id' => $datos['id'],
                'estado' => $datos['estado']
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }

    function cambiarContrasena($datos)
    {
        try {
            $query = $this->db->connect()->prepare('UPDATE tb_empresa SET em_contrasena=:pass WHERE em_correo=:correo');
            $query->execute([
                'pass' => $datos['pass'],
                'correo' => $datos['correo']
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error con el servidor <br>".$e->getMessage();
        }
    }
}
