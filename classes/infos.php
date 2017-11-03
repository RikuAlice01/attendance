<?php
	require_once("database.php");
	
	class Infos {
		
		private static $_table="infos";
		
		private $infos;
		
		public function __construct()
		{
			$this->infos=array(
			"i_id"=>null,
			"i_day"=>null,
			"checktime"=>null,
			"o_id"=>null,
			"time"=>null
			);
		}
		
		public function get_infos()
		{
			return $this->infos;
		}
		
		public function set_infos($key,$value)
		{
			$this->infos[$key]=$value;
		}
		public function find_by_id($id)
		{
			global $db;
			$sql="select * from ".self::$_table;
			$sql.=" where i_id=:id"; 
			$sql.=" limit 1;";
			$re=$db->query($sql,array("id"=>$id));
			$resultat=$re->fetch(PDO::FETCH_ASSOC);
			if(empty($resultat))
			{
				$this->infos=array();
			}else
			{
				$this->infos=$resultat;
			}	
		}

		public function find_by_id_stu($id_stu)
		{
			global $db;
			$sql="select * from ".self::$_table;
			$sql.=" where id_stu=:id"; 
			$sql.=" limit 1;";
			$re=$db->query($sql,array("id_stu"=>$id_stu));
			$resultat=$re->fetch(PDO::FETCH_ASSOC);
			if(empty($resultat))
			{
				$this->infos=array();
			}else
			{
				$this->infos=$resultat;
			}	
		}
		public function find_by_id_oid($o_id)
		{
			date_default_timezone_set('Asia/Bangkok');
	        $checktime = date("H:i:s");
	        $day = date("Y-m-d");
			global $db;
			$sql="select * from ".self::$_table;
			$sql.=" where o_id=:o_id"; 
			$sql.=" limit 1;";
			$re=$db->query($sql,array("o_id"=>$o_id));
			$resultat=$re->fetch(PDO::FETCH_ASSOC);
			if(empty($resultat))
			{
				$this->infos=array();
			}else
			{
				$this->infos=$resultat;
			}	
		}
		public function find_by_id_o($o_id)
		{
			date_default_timezone_set('Asia/Bangkok');
	        $checktime = date("H:i:s");
	        $day = date("Y-m-d");
			global $db;
			$sql="select * from ".self::$_table;
			$sql.=" where o_id=:o_id and i_day!=".$day; 
			$sql.=" limit 1;";
			$re=$db->query($sql,array("o_id"=>$o_id));
			$resultat=$re->fetch(PDO::FETCH_ASSOC);
			if(empty($resultat))
			{
				$this->infos=array();
			}else
			{
				$this->infos=$resultat;
			}	
		}


		public function count_all()
		{
			global $db;
			$sql="select count(*) from ".self::$_table.";";
			$re=$db->query($sql);
			$resultat=$re->fetch(PDO::FETCH_ASSOC);
			return array_shift($resultat);
		}

		public function create()
		{
			global $db;
			$sql="insert into ".self::$_table;
			$sql.=" (".implode(",",array_keys($this->infos)).")";
			$sql.=" values(:".implode(", :",array_keys($this->infos)).");";
			$re=$db->query($sql,$this->infos);
			if($db->affected_rows($re)>0)
			{
				$this->find_by_id($db->last_insert_id());
				return true;
			}else
			{
				
				return false;
			}
		}

		public function update()
		{
			global $db;
			$shifted=$this->infos;
			array_shift($shifted);
			$array_key_key=array();
			foreach($shifted as $key => $val)
			{
				$array_key_key[]=$key."=:".$key;
			}
			$sql="update ".self::$_table;
			$sql.=" set ".implode(",",$array_key_key);
			$sql.=" where i_id=:i_id;";
			$re=$db->query($sql,$this->infos);
			if($db->affected_rows($re)>0)
			{
				return true;
			}else
			{
				return false;
			}
		
		}
		public function delete()
		{
			global $db;
			$sql1 ="SET FOREIGN_KEY_CHECKS=0;";
			$db->query($sql1);
			$sql="delete from  ".self::$_table;
			$sql.=" where i_id=:i_id;";
			$re=$db->query($sql,array("i_id"=>$this->infos["i_id"]));
			if($db->affected_rows($re)>0)
			{
				return true;
			}else
			{
				return false;
			}
		}

		public static function tous_les_infos()
		{
	        global $db;
			$sql="select * from infos;";	
		    $list=array();
			$re=$db->query($sql);
			$list=$re->fetchAll(PDO::FETCH_ASSOC);
			return $list;
		}

		public static function tous_infos_Regit($o_id, $limit=10)
		{
	        global $db;		
			$sql="SELECT * FROM infos WHERE o_id=".$o_id."
				ORDER BY i_id desc
				limit ".$limit.";";			
		
		    $list=array();
			$re=$db->query($sql,array("o_id"=>$o_id));
			$list=$re->fetchAll(PDO::FETCH_ASSOC);
			return $list;
		}

        public static function tous_infos_Regit_day($o_id, $day, $limit=10)
        {
            global $db;     
            $sql="SELECT * FROM infos WHERE o_id=:".$o_id."
                ORDER BY i_id desc
                limit ".$limit.";";         
            $list=array();
            $re=$db->query($sql,array("o_id"=>$o_id, "day"=>$day));
            $list=$re->fetchAll(PDO::FETCH_ASSOC);
            return $list;
        
        }
	}


?>