<?php
	require_once("database.php");
	class subjects
	{
	  	private static $_table = "subjects";
		private $subjects;

		public function __construct()
		{
			$this->subjects = array(
				"s_id"=>null,
				"s_number"=>null,
				"s_name"=>null,
				"u_id"=>null
			);
		}
		
		public function get_subjects()
		{
			return $this->subjects;
		}

		public function set_subjects($key, $value)
		{
			$this->subjects[$key] = $value;
		}

		public function check_subject($id)
		{ 
			global $db;
			$sql = "SELECT * FROM " . self::$_table;
			$sql .= " WHERE s_id=".$id." and u_id=".$_SESSION["user_id"]; 
			$sql .= " LIMIT 1;";
			$re = $db->query($sql, array("id"=>$id));
			$resultat = $re->fetch(PDO::FETCH_ASSOC);

			if(empty($resultat))
			{
				header('Location: management.php');
			}
			else
			{

			}	
		}

		public function find_by_id($id)
		{    
			global $db;
			$sql = "SELECT * FROM " . self::$_table;
			$sql .= " WHERE s_id=:id"; 
			$sql .= " LIMIT 1;";

			$re = $db->query($sql, array("id"=>$id));
			$resultat = $re->fetch(PDO::FETCH_ASSOC);

			if(empty($resultat))
			{
				$this->subjects = array();
			}
			else
			{
				$this->subjects = $resultat;
			}	
		}

		public function find_by_id_sub_name($id)
		{    
			global $db;
			$sql = "SELECT * FROM " . self::$_table;
			$sql .= " WHERE s_id=:id"; 
			$sql .= " LIMIT 1;";

			$re = $db->query($sql, array("id"=>$id));
			$resultat = $re->fetch(PDO::FETCH_ASSOC);

			if(empty($resultat))
			{
				return false;
			}
			else
			{
 				return $resultat["s_name"];
			}	
		}

		public function find_by_id_sub_num($id)
		{    
			global $db;
			$sql = "SELECT * FROM " . self::$_table;
			$sql .= " WHERE s_id=:id"; 
			$sql .= " LIMIT 1;";

			$re = $db->query($sql, array("id"=>$id));
			$resultat = $re->fetch(PDO::FETCH_ASSOC);

			if(empty($resultat))
			{
				return false;
			}
			else
			{
 				return $resultat["s_number"];
			}	
		}

		public function count_all()
		{
			global $db;

			$sql = "SELECT COUNT(*) FROM " . self::$_table;
			$sql .= " WHERE u_id=".$_SESSION["user_id"];
			$re = $db->query($sql);
			$resultat = $re->fetch(PDO::FETCH_ASSOC);
			
			return array_shift($resultat);
		}

		public function create()
		{
			global $db;

			$sql = "INSERT INTO " . self::$_table;
			$sql .= " (" . implode(",",array_keys($this->subjects)) . ")";
			$sql .= " values(:".implode(", :",array_keys($this->subjects)) . ");";

			$re = $db->query($sql, $this->subjects);
			if($db->affected_rows($re) > 0)
			{
				$this->find_by_id($db->last_insert_id());
				return true;
			}
			else
			{
				echo "False<br>";
				exit();
				return false;
			}
		
		}

		public function update()
		{
			global $db;

			$shifted = $this->subjects;
			array_shift($shifted);
			$array_key_key = array();

			foreach($shifted as $key => $val)
			{
				$array_key_key[] = $key . "=:" . $key;
			}
			
			$sql = "UPDATE " . self::$_table;
			$sql .= " SET ". implode(",", $array_key_key);
			$sql .= " WHERE s_id=:s_id;";
			
			$re = $db->query($sql, $this->subjects);

			if($db->affected_rows($re) > 0)
			{
				return true;
			}
			else
			{

				return false;
			}
		}
		
		public function delete()
		{
			global $db;
			$sql = "DELETE FROM " . self::$_table;
			$sql .= " WHERE s_id=:s_id and u_id=".$_SESSION["user_id"].";";			
			$re = $db->query($sql, array("s_id"=>$this->subjects["s_id"]));
			if($db->affected_rows($re) > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
				    	
		public static function subjectss()
		{
			session_start();
			global $db;
			$sql = "SELECT * FROM " . self::$_table;
			$sql .= " WHERE u_id=".$_SESSION["user_id"];
		    $list = array();
			$re = $db->query($sql);
			$list = $re->fetchAll(PDO::FETCH_ASSOC);
			return $list;
		}
		
	}


?>