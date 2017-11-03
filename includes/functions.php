<?php 

function escape($var) {
	return htmlEntities($var, ENT_QUOTES);
}

function getDuree($heured, $heuref) {
    if (!is_null($heuref)) {
        $hr = strtotime($heuref) - strtotime($heured);
        date_default_timezone_set('Asia/Bangkok');
        $hr = date("H:i:s", $hr);
    } else {
            $hr = ' -- ';
    }
    return $hr;
}

function getDureeInfo($iid) {
    $in = new Infos();
    $in->find_by_id($iid);
    $in_data=$in->get_infos();
    date_default_timezone_set('Asia/Bangkok');
    return getDuree($in_data['heure_start'],$in_data['heure_end']);
}

function sum_the_time($time1, $time2) {
  $times = array($time1, $time2);
  $seconds = 0;
  foreach ($times as $time)
  {
    list($hour,$minute,$second) = explode(':', $time);
    $seconds += $hour*3600;
    $seconds += $minute*60;
    $seconds += $second;
  }
  $hours = floor($seconds/3600);
  $seconds -= $hours*3600;
  $minutes  = floor($seconds/60);
  $seconds -= $minutes*60;
  return "{$hours}:{$minutes}:{$seconds}";
}

function dureeDay($oid, $day) {
    $ou = new Student();
    $ou->find_by_id($oid);
    $ou_data=$ou->get_student();
    $infos=Infos::tous_infos_student_day($oid,$day);
    $duree = '00:00:00';
    foreach ($infos as $info) {
        date_default_timezone_set('Asia/Bangkok');
        if (!is_null($info['heure_end'])) {
            $durinfo = getDureeInfo($info['i_id']);
            $duree = sum_the_time($duree, $durinfo);
        }
    }
    date_default_timezone_set('Asia/Bangkok');
    return $duree;
}
