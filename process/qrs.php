<?php
require_once('../classes/session.php');
require_once('../classes/user.php');
require_once('../classes/infos.php');
require_once('../classes/subjects.php');
require_once('../classes/regit.php');
require_once('../classes/Student.php');
require_once('../includes/functions.php');
if (isset($_POST['qrcode'])&&isset($_POST['subid'])&&isset($_POST['time'])) {
    checkIn($_POST['qrcode'],$_POST['subid'],$_POST['time']);
}
function checkIn($qrcode,$subid,$time)
{
    date_default_timezone_set('Asia/Bangkok');
    $checktime = date("H:i:s");
    $day = date("Y-m-d");
    $valid =false;
    $ou = new student();
    if($ou->find_by_qrcode($qrcode)) {
      $ou_data = $ou->get_student();

      $ov = new regit();
      if(!$ov->find_by_idregit_stu($ou_data['id_stu'],$_POST['subid'])) {
        $ov_data = $ov->get_regit();
        if($ov_data['o_id']==NULL){
            echo False;
            exit();
        }else{

            $ox = new infos();
            if($ox->find_by_id_o($ov_data['o_id'])) { 

            }else{

              $infos = Infos::tous_infos_Regit($ov_data['o_id'], 1);
              if (!empty($infos)) {
                foreach ($infos as $info) {
                    $in = new Infos();
                    $b = strtotime($checktime);
                    if ($day != $info['i_day']) {
                        $info_data = array(
                            "i_day"=>$day,
                            "checktime"=>$checktime,      
                            "o_id"=>$ov_data['o_id'],
                            "sub_id"=>$_POST['subid'],
                            "time"=>$time
                        );
                        foreach ($info_data as $key => $value) {
                            $in->set_infos($key,$value);
                        }
                        $in->create();
                        $valid = true;
                    }
                }
            }
            else { 
                echo $info['i_day'];
                $in = new Infos();
                $info_data = array(
                    "i_day"=>$day,
                    "checktime"=>$checktime,      
                    "o_id"=>$ov_data['o_id'],
                    "sub_id"=>$_POST['subid'],
                    "time"=>$time
                );
                foreach ($info_data as $key => $value) {
                    $in->set_infos($key,$value);
                }
                $in->create();
                $valid = true;
            }
            if ($valid) {
              echo "เช็ค ";
              echo $ou_data['id_student']."สำเร็จ"; 
          }
      }
  }
}
}
}
?>
