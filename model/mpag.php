<?php 
class Mpag{
    private $idpag;
    private $nompag;
    private $rutpag;
    private $mospag;
    private $icopag;
    public function getIdpag(){
        return $this->idpag;
    }
    public function getNompag(){
        return $this->nompag;
    }
    public function getRutpag(){
        return $this->rutpag;
    }
    public function getMospag(){
        return $this->mospag;
    }
    public function getIcopag(){
        return $this->icopag;
    }
    public function setIdpag($idpag){
        $this->idpag = $idpag;
    }
    public function setNompag($nompag){
        $this->nompag = $nompag;
    }
    public function setRutpag($rutpag){
        $this->rutpag = $rutpag;
    }
    public function setMospag($mospag){
        $this->mospag = $mospag;
    }
    public function setIcopag($icopag){
        $this->icopag = $icopag;
    }
    function getAll(){
        $res = NULL;
        $sql = "SELECT idpag, nompag, rutpag, mospag, icopag FROM pagina;";
        try{
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e){
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
        }
        return $res;
    }
    function getOne($idpag){
        $res = NULL;
        $sql = "SELECT idpag, nompag, rutpag, mospag, icopag FROM pagina WHERE idpag = :idpag";
        try{
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':idpag', $idpag, PDO::PARAM_INT);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e){
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
        }
        return $res;
    }
    //metodos adicionales para las operaciones de la clase
    function savePag(){
        //implementar la logica de guardado en la base de datos
        $res = NULL;
        $sql = "INSERT INTO pagina(idpag, nompag, rutpag, mospag, icopag) VALUES (:idpag, :nompag, :rutpag, :mospag, :icopag)";
        try{
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
        } catch(PDOException $e){
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error al guardar la página";
        }
        return $res;
    }
    function ediPag(){
        //implementar la logica de guardado en la base de datos
        $res = NULL;
        $sql = "UPDATE pagina SET idpag=:idpag, nompag=:nompag, rutpag=:rutpag, mospag=:mospag, icopag=:icopag)";
        try{
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
        } catch(PDOException $e){
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error al actualizar la página";
        }
        return $res;
    }
    function delPag(){
        //implementar la logica de guardado en la base de datos
        $res = NULL;
        $sql = "DELETE FROM pagina WHERE idpag=:idpag;";
        try{
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $idpag = $this->getIdpag();
            $result->bindParam(':idpag', $idpag, PDO::PARAM_INT);
            $res = $result->execute();
        } catch(PDOException $e){
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error al eliminar la página";
        }
        return $res;
    }
}