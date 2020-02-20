<?php

require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Classes/DB.php');

class DebitDetails{
	private $id;
	private $user_id;
	private $bank_num;
	private $account_code;

	public function __construct($user_id, $bank_num, $account_code){
		$this->user_id = $user_id;
		$this->bank_num = $bank_num;
		$this->account_code = $account_code;
    }

    /*Save the current instance to the DB*/
    public function save(){
    	$conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("INSERT INTO debit_details(user_id, bank_num, account_code) VALUES (?, ?, ?)");

        $stmt->execute(array($this->user_id, $this->bank_num, $this->account_code));
    }

    /*Return all debit details of a user*/
    public static function GetDebitDetailsByUserId($id){
    	$conn = DB::getInstance()->getConnection();

		$stmt = $conn->prepare("SELECT * FROM debit_details WHERE user_id = ?");

        $stmt->execute(array($id));

        $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $details = array();

        foreach ($queryResult as $row) {
            $d = new DebitDetails(
                $row['user_id'], 
                $row['bank_num'], 
                $row['account_code']
            );

            $d->setId($row['id']);

            array_push($details, $d);
        }

        return $details;
    }

    public static function InsertDebitDetails($user_id, $bank_num, $account_code){
    	$conn = DB::getInstance()->getConnection();

        $stmt = $conn->prepare("INSERT INTO debit_details(user_id, bank_num, account_code) VALUES (?, ?, ?)");

        $stmt->execute(array($user_id, $bank_num, $account_code));
    }

    /*Getters and setters*/
    public function getId(){
    	return $this->id;
    }

    public function getUserId(){
    	return $this->user_id;
    }

    public function getBankNum(){
    	return $this->bank_num;
    }

    public function getAccountCode(){
    	return $this->account_code;
    }
	
    public function setId($id){
    	$this->id = $id;
    }

	public function setBankNum($bank_num){
		$this->bank_num = $bank_num;
	}
	
	public function setAccountCode($account_code){
		$this->account_code = $account_code;
	}
}