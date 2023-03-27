<?php 
session_start();
$bdd = new BDD("mysql","localhost","ruvalor_employé","root","");
class BDD {
    private static $dbtype = '';
    private static $dbhost = '';
    private static $dbname = '';
    private static $dbuser = '';
    private static $dbpasswd = '';
    private static $dsn = '';
    public static $pdo = null;
   
    
    public function __construct( $dbtype, $dbhost, $dbname, $dbuser, $dbpasswd) {
        self::$dbtype = $dbtype;
        self::$dbhost = $dbhost;
        
        self::$dbname = $dbname;
        self::$dbuser = $dbuser;
        self::$dbpasswd = $dbpasswd;
        
        // Set DSN
        self::$dsn = self::$dbtype . ":host=" . self::$dbhost . ";dbname=" . self::$dbname;
    }
    
    // Database connection
    private function pdo() {
        if (self::$pdo == null) {
            self::$pdo = new PDO(self::$dsn, self::$dbuser, self::$dbpasswd);
        }
    }   
/*
    public function SEARCH($table_name) {
        $sql='select * from employe';
                    $params=[];
                    if(isset($_POST['search'])){
                        $sql.=' where (EMP_NOM like :filter or EMP_PRENOM like :filter or EMP_SECU like :filter)';
                        $params[':filter']="%".addcslashes($_POST['search'],'_')."%";
                    };
                    $resultats=$connect->prepare($sql);
                    $resultats->execute($params);
    }
*/
    //INSERT
    public function INSERT($table_name, $data, $begin_transaction = true) {
        $this->pdo();
        $keys = implode(", ", array_keys( $data));
        $values = ':'.implode(", :", array_keys( $data));

        $sql = <<< _EOS_
        INSERT INTO $table_name ($keys) VALUES ($values);
_EOS_;
        try {
            if($begin_transaction)
                self::$pdo->beginTransaction();
            self::$pdo->prepare($sql)->execute($data) or print_r(self::$pdo->errorInfo());
            self::$pdo->commit();
        }   
        catch(PDOException $e) {
            if (self::$pdo->inTransaction())
                self::$pdo->rollBack();
            throw new UnexpectedValueException( 'Exception : ', $e->getMessage());
        }
        
    }
    
    //SELECT ALL (0 || WHERE ID)
    public function SELECTALL($table_name, $id = null) {
        
        $this->pdo();

        if ($id == null) {
            $sql = <<< _EOS_
            SELECT *
            FROM $table_name;
_EOS_;
            $data = array();
        } 
        else {
            $sql = <<< _EOS_
            SELECT *
	        FROM $table_name
	        WHERE id = :id;
_EOS_;
            $data = array(':id' => $id);
        }
        try {
            $pst = self::$pdo->prepare($sql);
            $pst->execute($data);
        }
        catch(PDOException $e) {
            throw new UnexpectedValueException('Exception : ', $e->getMessage());
        }
        return $pst->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function SELECT($table_name, $option, $parametre){
        $this->pdo();
        
        $sql = <<<_EOS_
        SELECT *
        FROM $table_name
        WHERE $option = :parametre;
_EOS_;
        try{
            $pst = self::$pdo->prepare($sql);
            $pst->execute(["parametre"=>$parametre]);
        }
        catch(PDOException $e) {
            throw new UnexpectedValueException('Exception : ', $e->getMessage());
        }
        return $pst->fetchAll();
    }
    
    
    public function SELECTLIM($table_name){
        $this->pdo();
        
        $sql = <<<_EOS_
        SELECT *
        FROM $table_name
        ORDER BY msid DESC
        LIMIT 1;
_EOS_;
        try{
            $pst = self::$pdo->prepare($sql);
            $pst->execute();
        }
        catch(PDOException $e) {
            throw new UnexpectedValueException('Exception : ', $e->getMessage());
        }
        return $pst->fetchAll();
    }
    
    public function UPDATE($table_name, $data, $id, $begin_transaction  = true) {

        $this->pdo();
        $set = [];
        foreach (array_keys($data) as $key) {
            $set[] = "$key = :$key";
        }
        $keys_values = implode( ', ', $set);
        $sql = <<< _EOS_
        UPDATE $table_name
	    SET $keys_values
	    WHERE id = :id;
_EOS_;
        $data['id'] = $id;
        try {
            if ($begin_transaction)
                self::$pdo->beginTransaction();
            self::$pdo->prepare( $sql)->execute( $data);
        }
        catch(PDOException $e) {
            if (self::$pdo->beginTransaction())
                self::$pdo->rollBack();
            throw new UnexpectedValueException( 'Exception : ', $e->getMessage());
        }
    }
    
    public function DELETE( $table_name, $id, $begin_transaction = true) {
        
        $this->pdo();
        $sql = <<< _EOS_
        DELETE
	    FROM $table_name
	    WHERE msid = :msid
        LIMIT 1;
_EOS_;
        try {
            if($begin_transaction){
                $pst = self::$pdo->prepare($sql);
                $pst->execute(["id"=>$id]);
            }
        }
        catch( \PDOException $e) {
            if (self::$pdo->inTransaction())
                self::$pdo->rollBack();
            throw new UnexpectedValueException('Exception : ', $e->getMessage());
        }
    }
    
    public function __destruct() {
        self::$pdo = null;
    }
    
    public function imgPlusRecent(){
    $this->pdo();
    $sql = <<<_EOS_
    SELECT *
    FROM images
    ORDER BY id DESC
    LIMIT 1;
_EOS_;
    try {
        $pst = self::$pdo->prepare($sql);
            $pst->execute();
    }
    catch(PDOException $e) {
        throw new UnexpectedValueException('Exception : ', $e->getMessage());
    }
    $res=$pst->fetchAll(PDO::FETCH_ASSOC);
    return $res[0]['image'];
    }
   
    public function getLastInsertId(){
        return self::$pdo->lastInsertId();
    }
}

?>