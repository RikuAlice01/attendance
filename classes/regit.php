<?php

require_once("database.php");

class regit
{

	private static $_table = "regit";
	private $regit;
	

	public function __construct()
	{
		$this->regit = array(
			"o_id"=>null,
			"sub_id"=>null,
			"u_id"=>null,
			"id_student"=>null
		);
	}

	public function get_regit()
	{
		return $this->regit;
	}


	public function set_regit($key, $value)
	{
		$this->regit[$key] = $value;
	}

	public function find_by_idregit($o_id)
	{
		global $db;

		$sql = "SELECT * FROM " . self::$_table;
		$sql .= " WHERE o_id=:o_id"; 
		$sql .= " LIMIT 1;";
		$re = $db->query($sql, array("o_id"=>$o_id));
		$resultat = $re->fetch(PDO::FETCH_ASSOC);
		if(empty($resultat))
		{
			$this->regit = array();
		}
		else
		{
			$this->regit = $resultat;
		}	
	}

	public function find_by_idregit_stu($id_student,$sub_id)
	{
		global $db;
		$sql = "SELECT * FROM " . self::$_table;
		$sql .= " WHERE id_student=:id_student and sub_id=".$sub_id; 
		$sql .= " LIMIT 1;";

		$re = $db->query($sql, array("id_student"=>$id_student));
		
		$resultat = $re->fetch(PDO::FETCH_ASSOC);

		if(empty($resultat))
		{
			$this->regit = array();
		}
		else
		{
			$this->regit = $resultat;
		}	
	}

	public function find_by_id($o_id)
	{
		global $db;

		$sql = "SELECT * FROM " . self::$_table.",students";
		$sql .= " WHERE ".self::$_table.".o_id=:o_id and regit.id_student=students.id_stu"; 
		$sql .= " LIMIT 1;";

		$re = $db->query($sql, array("o_id"=>$o_id));
		$resultat = $re->fetch(PDO::FETCH_ASSOC);

		if(empty($resultat))
		{
			$this->regit = array();
		}
		else
		{
			$this->regit = $resultat;
		}	
	}

	public function count_all()
	{
		global $db;

		$sql = "SELECT COUNT(DISTINCT id_student) FROM " . self::$_table;
		$sql .= " WHERE u_id=".$_SESSION["user_id"].";";
		$re = $db->query($sql);
		$resultat = $re->fetch(PDO::FETCH_ASSOC);
		return array_shift($resultat);
	}

	public function created()
	{
		global $db;
		$sql = "INSERT INTO " . self::$_table;
		$sql .= " (" . implode(",",array_keys($this->regit)) . ")";
		$sql .= " values(:".implode(", :",array_keys($this->regit)) . ");";
		$re = $db->query($sql, $this->regit);
		if($db->affected_rows($re) > 0)
		{
			$this->find_by_idregit($db->last_insert_id());
			return true;
		}
		else
		{
			echo "False<br>";
			return false;
		}
		
	}

	public function delete()
	{
		global $db;
		$sql = "DELETE FROM " . self::$_table;
		$sql .= " WHERE o_id=:o_id and u_id=".$_SESSION["user_id"].";";			
		$re = $db->query($sql, array("o_id"=>$this->regit["o_id"]));
		if($db->affected_rows($re) > 0)
		{
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

		$shifted = $this->regit;
		array_shift($shifted);
		$array_key_key = array();

		foreach($shifted as $key => $val)
		{
			$array_key_key[] = $key . "=:" . $key;
		}
		
		$sql = "UPDATE " . self::$_table;
		$sql .= " SET ". implode(",", $array_key_key);
		$sql .= " WHERE o_id=:o_id;";
		
		$re = $db->query($sql, $this->regit);

		if($db->affected_rows($re) > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function attache($o_id)
	{
		global $db;
		$sql="insert 
		into regit
		values(:o_id,:o_id) ";
		$re=$db->query($sql,array("o_id"=>$o_id,"o_id"=>$this->regit["o_id"]));
		if($db->affected_rows($re)>0)
		{
			return true;
		}else
		{
			
			return false;
		}	
	}

	public static function regit()
	{
		global $db;

		$sql = "SELECT *
		FROM ".self::$_table.";";	
		
		$list = array();
		$re = $db->query($sql);
		$list = $re->fetchAll(PDO::FETCH_ASSOC);
		
		return $list;
	}

	public static function liste_regit_subjects($id,$offset=0,$limit=10)
	{	
		global $db;
		$sql="select 
		regit.o_id,students.id_student,students.titlename,students.s_firstname,students.s_lastname
		from regit,students,subjects
		where regit.sub_id=".$id." and subjects.u_id=".$_SESSION["user_id"]." and regit.id_student=students.id_stu
		GROUP BY regit.o_id
		limit  ".$offset.",".$limit.";";	
		
		$list=array();
		$re=$db->query($sql,array("o_id"=>$o_id));
		$list=$re->fetchAll(PDO::FETCH_ASSOC);
		return $list;
		
	}
	
}


?>