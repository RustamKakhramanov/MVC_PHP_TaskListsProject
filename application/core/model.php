<?php
class Model
{
   public $DBH;

   public function __construct()
   {
		include "application/database/dbconnect.php";
		$this->DBH = new PDO($dsn, $user, $pass, $opt);
   }

   public function serializeArray($post){
       $array =[];
       foreach ($post as  $key => $value){
           $array[$key] =  htmlspecialchars($value);
       }
       return $array;
	}
	
	public function get_data()
	{
	}
}