<?php
class Mpag
{
    private $idpag;
    private $nompag;
    private $rutpag;
    private $mospag;
    private $icopag;
    //Menú
    private $idsbm;
    private $nombre;
    private $url;
    private $url2;
    private $idmen;
    public function getIdpag()
    {
        return $this->idpag;
    }
    public function getNompag()
    {
        return $this->nompag;
    }
    public function getRutpag()
    {
        return $this->rutpag;
    }
    public function getMospag()
    {
        return $this->mospag;
    }
    public function getIcopag()
    {
        return $this->icopag;
    }
    public function getIdsbm()
    {
        return $this->idsbm;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function getUrl2()
    {
        return $this->url2;
    }
    public function getIdmen()
    {
        return $this->idmen;
    }
    public function setIdpag($idpag)
    {
        $this->idpag = $idpag;
    }
    public function setNompag($nompag)
    {
        $this->nompag = $nompag;
    }
    public function setRutpag($rutpag)
    {
        $this->rutpag = $rutpag;
    }
    public function setMospag($mospag)
    {
        $this->mospag = $mospag;
    }
    public function setIcopag($icopag)
    {
        $this->icopag = $icopag;
    }
    public function setIdsbm($idsbm)
    {
        $this->idsbm = $idsbm;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function setUrl2($url2)
    {
        $this->url2 = $url2;
    }
    public function setIdmen($idmen)
    {
        $this->idmen = $idmen;
    }
    function getAll()
    {
        $res = NULL;
        $sql = "SELECT idpag, nompag, rutpag, mospag, icopag FROM pagina;";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error. Intentalo mas tarde";
        }
        return $res;
    }
    function getOne($idpag)
    {
        $res = NULL;
        $sql = "SELECT idpag, nompag, rutpag, mospag, icopag FROM pagina WHERE idpag = :idpag";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':idpag', $idpag, PDO::PARAM_INT);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error. Intentalo mas tarde";
        }
        return $res;
    }
    function getMenu($isLoged)
    {
        $res = NULL;
        try {
           
            $sql = "SELECT idmen, nombre, url, ordmen, estmen, url2, submen 
                    FROM menu 
                    WHERE estmen = :status OR estmen IS NULL;";

            $status = $isLoged ? 1 : 0;

            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':status', $status, PDO::PARAM_INT);
            $result->execute();
            $menuItems = $result->fetchAll(PDO::FETCH_ASSOC);

            // Obtener submenús para cada ítem del menú principal
            foreach ($menuItems as &$menuItem) {
                $menuItem['submenus'] = $this->getSubMen($menuItem['idmen']);
            }

            $res = $menuItems;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error. Intentalo mas tarde";
        }
        return $res;
    }


    function getSubMen($idmen)
    {
        $res = NULL;
        $sql = "SELECT s.idsbm, s.nombre, s.url, s.url2, s.idmen 
                FROM submenu AS s 
                INNER JOIN menu AS m ON s.idmen = m.idmen 
                WHERE s.idmen = :idmen;";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':idmen', $idmen, PDO::PARAM_INT);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, "C:/xampp/htdocs/SHOOP/errors/error_log.log");
            echo "Error. Intentalo mas tarde";
        }
        return $res;
    }

    //metodos adicionales para las operaciones de la clase
    function savePag()
    {
        $res = NULL;
        $sql = "INSERT INTO pagina(idpag, nompag, rutpag, mospag, icopag) VALUES (:idpag, :nompag, :rutpag, :mospag, :icopag)";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $idpag = $this->getIdpag();
            $nompag = $this->getNompag();
            $rutpag = $this->getRutpag();
            $mospag = $this->getMospag();
            $icopag = $this->getIcopag();
            $result->bindParam(':idpag', $idpag, PDO::PARAM_INT);
            $result->bindParam(':nompag', $nompag, PDO::PARAM_STR);
            $result->bindParam(':rutpag', $rutpag, PDO::PARAM_STR);
            $result->bindParam(':mospag', $mospag, PDO::PARAM_BOOL);
            $result->bindParam(':icopag', $icopag, PDO::PARAM_STR);
            $res = $result->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error al guardar la página";
        }
        return $res;
    }
    function ediPag()
    {
        //implementar la logica de guardado en la base de datos
        $res = NULL;
        $sql = "UPDATE pagina SET idpag=:idpag, nompag=:nompag, rutpag=:rutpag, mospag=:mospag, icopag=:icopag)";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $idpag = $this->getIdpag();
            $nompag = $this->getNompag();
            $rutpag = $this->getRutpag();
            $mospag = $this->getMospag();
            $icopag = $this->getIcopag();
            $result->bindParam(':idpag', $idpag, PDO::PARAM_INT);
            $result->bindParam(':nompag', $nompag, PDO::PARAM_STR);
            $result->bindParam(':rutpag', $rutpag, PDO::PARAM_STR);
            $result->bindParam(':mospag', $mospag, PDO::PARAM_BOOL);
            $result->bindParam(':icopag', $icopag, PDO::PARAM_STR);
            $res = $result->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error al actualizar la página";
        }
        return $res;
    }
    function delPag()
    {
        //implementar la logica de guardado en la base de datos
        $res = NULL;
        $sql = "DELETE FROM pagina WHERE idpag=:idpag;";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $idpag = $this->getIdpag();
            $result->bindParam(':idpag', $idpag, PDO::PARAM_INT);
            $res = $result->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error al eliminar la página";
        }
        return $res;
    }
}