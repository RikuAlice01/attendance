<?php
require_once('panel.php');
?>
    <div class="main">
      <div class="main-inner">
        <div class="container">
          <div class="row">
            <?php if (isset($_GET['id'])) {
              $ou = new Regit();
              $ou->find_by_id($_GET['id']);
              $ou_data = $ou->get_regit();
              $infos=Infos::tous_infos_Regit($ou_data['o_id']);
              ?>
              <div class="span12">
                <div class="widget widget-table action-table">
                  <div class="widget-header"> <i class="icon-th-list"></i>
                    <h3>รายชื่อ - <?php echo escape( $ou_data['titlename'].' '.$ou_data['s_firstname'] . ' ' . $ou_data['s_lastname']); ?></h3>
                  </div>
                  <div class="widget-content">

                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th> วัน</th>
                          <th> เวลาเข้าเรียน</th>
                          <th> คาบเรียน</th>
                          <th class="td-actions"> </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($infos as $info):?>
                          <tr>
                            <?php $id = $info['i_id']; ?>
                            <td><?php echo escape($info["i_day"]); ?></td>
                            <td><?php echo escape($info["checktime"]); ?></td>
                            <td><?php echo escape($info["time"]); ?></td>
                            <td class="td-actions">
                              <a href="#deleteInfo<?php echo $id; ?>" role="button" data-toggle="modal" class="btn btn-danger btn-small">เอาออก <i class="btn-icon-only icon-remove"> </i></a></td>
                              <div id="deleteInfo<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                  <h3 id="myModalLabel">คุณแน่ใจหรือไม่ว่าต้องการลบระเบียนนี้?</h3>
                                </div>
                                <form action="process/delete.php" method="post">
                                  <div class="modal-body pull-left">
                                    <input type="hidden" name="idinfo" value='<?php echo escape($id); ?>'>
                                    <input type="hidden" name="qrcode" value="<?php echo escape($ou_data['qrcode']); ?>" >
                                    <button class="btn btn-danger">เอาออก</button>
                                    <button class="btn" data-dismiss="modal" aria-hidden="true">ยกเลิก</button>
                                  </div>
                                </form>
                              </div>                
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table> 
                      <?php } else {
                        $subjectss=subjects::subjectss();
                        if(empty($subjectss))
                          echo"<center><h2>คุณยังไม่ได้สร้างรายวิชา</h2></center>";

                        ?>
                        <?php foreach ($subjectss as $subjects): 
                        $cid = $subjects["s_id"]; 
                        ?>
                        <div class="span6">
                          <div class="widget widget-table action-table">
                            <div class="widget-header"> <i class="icon-th-list"></i>
                              <h3>วิชา - <a href="management.php?id=<?php echo $cid; ?>">
                                <?php echo escape($subjects['s_number'].' '.$subjects['s_name']); ?></a></h3>
                              </div>
                              <div class="widget-content">
                                <table class="table table-striped table-bordered">
                                  <thead>
                                    <tr>
                                      <th class="td-photos"></th>
                                      <th> เลขประจำตัว </th>
                                      <th> คำนำหน้า </th>
                                      <th> ชื่อ </th>
                                      <th> นามสกุล</th>
                                      <th class="td-actions"> </th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $regit=Regit::liste_regit_subjects($cid); 
                                    foreach ($regit as $Regit):
                                      ?>
                                      <tr>
                                        <td>
                                          <div class="from_user left"> 
                                            <img src="<?php if(empty($Regit["photo"])) {
                                              echo "img/message_avatar.png";
                                            } else {
                                             echo  escape($Regit["photo"]);      
                                           }?>"/>
                                         </div>
                                       </td>
                                       <td><?php echo escape($Regit["id_student"]); ?></td>
                                       <td><?php echo escape($Regit["titlename"]); ?></td>
                                       <td><?php echo escape($Regit["s_firstname"]); ?></td>
                                       <td><?php echo escape($Regit["s_lastname"]); ?></td>
                                       <td class="td-actions"><a href="reports.php?id=<?php echo escape($Regit["o_id"]); ?>" class="btn btn-small btn-info">ข้อมูล<i class="btn-icon-only  icon-arrow-right"> </i></a>
                                        <a href="#deleteregit<?php echo escape($Regit["o_id"]); ?>"role="button" data-toggle="modal" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a>
                                      </td>                       
                                      <div id="deleteregit<?php echo escape($Regit["o_id"]); ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                          <h3 id="myModalLabel">คุณแน่ใจหรือไม่ว่าต้องการลบสมาชิกคนนี้?</h3>
                                        </div>
                                        <form action="process/delete.php" method="post">
                                          <div class="modal-body pull-left"> 

                                            <input type="hidden" name="subjectsid" value="<?php echo escape($cid); ?>">
                                            <input type="hidden" name="regit" value="<?php echo escape($Regit["o_id"]); ?>">  

                                            <button class="btn btn-danger">ลบ</button>
                                            <button class="btn" data-dismiss="modal" aria-hidden="true">ยกเลิก</button>
                                          </div>
                                        </form>
                                      </div>
                                    </td>
                                  </tr>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    <?php endforeach;} ?>
                  </div>
                </div>
              </div>
            </div> 
          </div> 
        </div> 
      </div> 
      <div class="extra">
        <div class="extra-inner">
          <div class="container">
            <div class="row">
            </div>
          </div>
        </div>
      </div>
      <div class="footer">
        <div class="footer-inner">
          <div class="container">
            <div class="row">
              <div class="span12"> จัดทำโดย :: <a href="https://www.facebook.com/OneVRM">นายสิทธิชัย สิริฤทธิกุลชัย </a> :: 2017
              </div>
            </div>
          </div>
        </div>
      </div>
    </body>
    </html>
