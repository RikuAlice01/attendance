<?php
	require_once("database.php");
	class User
	{

	  	private static $_table = "user";
		private $user;

		public function __construct()
		{
			$this->user = array(
				'titlename'=>null,
				"u_id"=>null,
				"u_lastname"=>null,
				"u_firstname"=>null,
				"username"=>null,
				"u_password"=>null,
				"u_verification"=>null,
			);
		}

		public function authenticate($username, $password)
		{
			global $db;

			$sql = "SELECT u_password FROM " . self::$_table;
			$sql .= " WHERE username=:username";
			$sql .= " LIMIT 1;";

			$re = $db->query($sql, array("username"=>$username));
			$resultat = $re->fetch();
			$resultat = $resultat['u_password'];

			if(md5($password)==$resultat)
			{
				$this->find_by_username($username);
				return true;
			}else
			{
				return false;
			}
		}

		public function get_user()
		{
			return $this->user;
		}

		public function set_user($key, $value)
		{
			$this->user[$key] = $value;
		}
		
		public function find_by_id($id)
		{
			global $db;
			$sql = "SELECT * FROM " . self::$_table;
			$sql .= " WHERE u_id=:id";
			$sql .= " LIMIT 1;";
			$re = $db->query($sql, array("id"=>$id));
			$resultat = $re->fetch(PDO::FETCH_ASSOC);
			if(empty($resultat))
			{
				$this->user = array();
			}
			else
			{
				$this->user = $resultat;
			}
		}

		public function find_by_username($username)
		{
			global $db;
			$sql="select * from ".self::$_table;
			$sql.=" where username=:username";
			$sql.=" limit 1;";
			$re=$db->query($sql,array("username"=>$username));
			$resultat=$re->fetch(PDO::FETCH_ASSOC);
			if(empty($resultat)) {
				$this->user=array();
			} else {
				$this->user=$resultat;
			}
		}

		public function count_all()
		{
			global $db;

			$sql = "SELECT COUNT(*) FROM " . self::$_table . ";";

			$re = $db->query($sql);
			$resultat = $re->fetch(PDO::FETCH_ASSOC);

			return array_shift($resultat);
		}


		public function create()
		{
			global $db;

			$sql = "INSERT INTO " . self::$_table;
			$sql .= " (" . implode(",",array_keys($this->user)) . ")";
			$sql .= " values(:".implode(", :",array_keys($this->user)) . ");";

			$re = $db->query($sql, $this->user);

			if($db->affected_rows($re) > 0)
			{
				$this->find_by_id($db->last_insert_id());
				return true;
			}
			else
			{
				return false;
			}

		}

		public function update()
		{
			global $db;
			$shifted = $this->user;
			array_shift($shifted);
			$array_key_key = array();
			foreach($shifted as $key => $val)
			{
				$array_key_key[] = $key . "=:" . $key;
			}
			$sql = "UPDATE " . self::$_table;
			$sql .= " SET ". implode(",", $array_key_key);
			$sql .= " WHERE u_id=:u_id;";
			$re = $db->query($sql, $this->user);
			if($db->affected_rows($re) > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		public static function users()
		{
			global $db;

			$sql = "SELECT *
				    FROM ".self::$_table.";";

		    $list = array();
			$re = $db->query($sql);
			$list = $re->fetchAll(PDO::FETCH_ASSOC);

			return $list;
		}

	}


?>
