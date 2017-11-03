<?php
	
    require_once "regit.php";
	require_once("database.php");

	class student
	{

	  	private static $_table = "students";
		private $student;
		

		public function __construct()
		{
			$this->student = array(
				"id_stu"=>null,
				"id_student"=>null,
				"titlename"=>null,
				"s_firstname"=>null,
				"s_lastname"=>null,
				"qrcode"=>null
			);
		}

		public function get_student()
		{
			return $this->student;
		}

		public function set_student($key, $value)
		{
			$this->student[$key] = $value;
		}

		public function find_by_id_student($id_student,$sub_id)
		{
			global $db;
			$sql = "SELECT id_stu FROM students ";
			$sql .= " WHERE id_student='$id_student'"; 
			$sql .= " LIMIT 1;";

			$re = $db->query($sql, array($id_student=>$id_student));
			$resultat = $re->fetch(PDO::FETCH_ASSOC);
			if(empty($resultat))
			{	
				//$this->student = array();
			}
			else
			{

		    $ov = new Regit();
		    $register_data = array(
		    	'u_id' =>  $_SESSION["user_id"],
		        'sub_id' =>  $sub_id,
		        'id_student' =>  $resultat['id_stu']
		    );

		    foreach ($register_data as $key => $value) {
		        $ov->set_regit($key,$value);
		    }
		    $ov->created();
			}	
		}

		public function find_by_id($id)
		{
			global $db;

			$sql = "SELECT * FROM " . self::$_table;
			$sql .= " WHERE id_stu=:id"; 
			$sql .= " LIMIT 1;";
			$re = $db->query($sql, array("id"=>$id));
			$resultat = $re->fetch(PDO::FETCH_ASSOC);

			if(empty($resultat))
			{
				$this->student = array();
			}
			else
			{
				$this->student = $resultat;
			}	
		}

				public function find_by_qrcode($qr)
				{
					global $db;

					$sql = "SELECT * FROM " . self::$_table;
					$sql .= " WHERE qrcode=:qrcode"; 
					$sql .= " LIMIT 1;";

					$re = $db->query($sql, array("qrcode"=>$qr));
					$resultat = $re->fetch(PDO::FETCH_ASSOC);

					if(empty($resultat))
					{
						$this->student = array();
						return false;
					}
					else
					{
						$this->student = $resultat;
						return true;
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

		public function create()
		{
			global $db;
			$sql = "INSERT INTO " . self::$_table;
			$sql .= " (" . implode(",",array_keys($this->student)) . ")";
			$sql .= " values(:".implode(", :",array_keys($this->student)) . ");";
			$re = $db->query($sql, $this->student);
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

		public function delete()
		{
			global $db;
			$sql = "DELETE FROM " . self::$_table;
			$sql .= " WHERE o_id=:o_id;";			
			$re = $db->query($sql, array("o_id"=>$this->student["o_id"]));
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

			$shifted = $this->student;
			array_shift($shifted);
			$array_key_key = array();

			foreach($shifted as $key => $val)
			{
				$array_key_key[] = $key . "=:" . $key;
			}
			
			$sql = "UPDATE " . self::$_table;
			$sql .= " SET ". implode(",", $array_key_key);
			$sql .= " WHERE o_id=:o_id;";
			
			$re = $db->query($sql, $this->student);

			if($db->affected_rows($re) > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		public function attache($id_stu)
		{
			global $db;
			$sql="insert 
				into student
				values(:id_stu,:o_id) ";
				$re=$db->query($sql,array("id_stu"=>$id_stu,"o_id"=>$this->student["o_id"]));
				if($db->affected_rows($re)>0)
				{
					return true;
				}else
				{
					
					return false;
				}	
		}

		public static function students()
		{
			global $db;

			$sql = "SELECT *
				    FROM ".self::$_table.";";	
		   
		    $list = array();
			$re = $db->query($sql);
			$list = $re->fetchAll(PDO::FETCH_ASSOC);
			
			return $list;
		}

		public static function liste_students_subjects($id_stu,$offset=0,$limit=10)
	{
	
        global $db;
		$sql="select 
			  id_stu,id_student,titlename, s_firstname,s_lastname
			  from students
			  where id_stu=:id_stu
			  limit  ".$offset.",".$limit.";";	
	   
	    $list=array();
		$re=$db->query($sql,array("id_stu"=>$id_stu));
		$list=$re->fetchAll(PDO::FETCH_ASSOC);
		return $list;
	}

	public static function get_list_student($offset=0,$limit=10)
	{
        global $db;
		$sql="select 
			  id_stu,id_student,titlename, s_firstname,s_lastname,qrcode
			  from students
			  limit  ".$offset.",".$limit.";";	
	    $list=array();
		$re=$db->query($sql,array("id_stu"=>$id_stu));
		$list=$re->fetchAll(PDO::FETCH_ASSOC);
		return $list;
	
	}

		public static function get_list_student_gen($offset=0,$limit=10)
	{
        global $db;
		$sql="select 
			  students.*
			  from students,regit
			   WHERE regit.u_id=".$_SESSION["user_id"]." and regit.id_student = students.id_stu
			  limit  ".$offset.",".$limit.";";	
	    $list=array();
		$re=$db->query($sql,array("id_stu"=>$id_stu));
		$list=$re->fetchAll(PDO::FETCH_ASSOC);
		return $list;
	
	}
		
	}


?>