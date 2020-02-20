<?php

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Classes/DB.php');

class SystemConfig{
	private $id;
	private $charge_rate;

	public function __construct($charge_rate){
		$this->charge_rate = $charge_rate;
    }

    /*Insert current instance*/
    public function save(){
    	$conn = DB::getInstance()->getConnection();

        $query = "INSERT INTO system_config(charge_rate) VALUES (?)";

        $stmt = $conn->prepare($query);

        $stmt->execute(array($this->charge_rate));
    }

    /*Returns an array of system configs*/
    public static function GetAllSystemConfigs(){
    	$conn = DB::getInstance()->getConnection();

        $query = "SELECT * FROM system_config";

        $stmt = $conn->prepare($query);

        $stmt->execute();

        $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $configs = array();

        foreach ($queryResult as $row) {
            $c = new SystemConfig(
                $row['charge_rate']
            );

            $c->setId($row['id']);

            array_push($configs, $c);
        }

        return $configs;
    }

    /*Returns a single system config*/
    public static function GetSystemConfigById($id){
    	$conn = DB::getInstance()->getConnection();

        $query = "SELECT * FROM system_config WHERE system_config.id = ?";

        $stmt = $conn->prepare($query);

        $stmt->execute(array($id));

        $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);

        $config = new SystemConfig($queryResult['charge_rate']);

        $config->setId($queryResult['id']);

        return $config;
    }

    /*Static insert*/
    public static function InsertSystemConfig($charge_rate){
    	$conn = DB::getInstance()->getConnection();

        $query = "INSERT INTO system_config(charge_rate) VALUES (?)";

        $stmt = $conn->prepare($query);

        $stmt->execute(array($charge_rate));
    }

    public function getId(){
    	return $this->id;
    }

    public function getChargeRate(){
    	return $this->charge_rate;
    }
	
    public function setId($id){
    	$this->id= $id;
    }

	public function setChargeRate($charge_rate){
		$this->charge_rate = $charge_rate;
	}
}