<?php
class Mpro
{
    public $idpro;
    public $nompro;
    public $precio;
    public $descripcion;
    public $estado;
    public $imgpro;

    // Getters
    public function getIdpro()
    {
        return $this->idpro;
    }

    public function getNompro()
    {
        return $this->nompro;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getImgpro()
    {
        return $this->imgpro;
    }

    // Setters
    public function setIdpro($idpro)
    {
        $this->idpro = $idpro;
    }

    public function setNompro($nompro)
    {
        $this->nompro = $nompro;
    }

    public function setPrecio($precio)
    {
        if ($precio < 0) {
            throw new Exception("El precio no puede ser negativo.");
        }
        $this->precio = $precio;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setEstado($estado)
    {
        $estadosValidos = ['activo', 'inactivo'];
        if (!in_array($estado, $estadosValidos)) {
            throw new Exception("Estado no válido.");
        }
        $this->estado = $estado;
    }

    public function setImgpro($imgpro)
    {
        $this->imgpro = $imgpro;
    }
    public function getOnePrd(){
        $res = "";
        $sql = "SELECT idpro, nompro, precio, cantidad, tipro, valorunitario, descripcion, imgpro, provpro, prousu, feccreat, fecupdate, enofer, fechiniofer, fechfinofer, estado, pordescu, idval FROM producto WHERE idpro = 3;
";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener productos. Intentalo mas tarde";
        }
    }
    public function getInfPar()
    {
        $res = "";
        $sql = "SELECT p.idpro, p.nompro, p.estado, p.tipro, p.valorunitario, p.pordescu, i.imgpro,p.valorunitario - (p.valorunitario * (p.pordescu / 100)) AS valor_con_descuento FROM producto AS p LEFT JOIN imagen AS i ON p.idpro = i.idpro WHERE p.estado = 'activo' GROUP BY p.idpro;
";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener productos. Intentalo mas tarde";
        }
        return $res;
    }
}