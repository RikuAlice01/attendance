<?php
require_once('panel.php');
?>
    <div class="main">
      <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span6">
              <div class="widget widget-nopad">
                <div class="widget-header"> <i class="icon-list-alt"></i>
                  <h3> สมาชิก</h3>
                </div>
                <div class="widget-content">
                  <div class="widget big-stats-container">
                    <div class="widget-content">                  
                      <h6>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <i class="icon-user-md"></i>&nbsp;รายวิชา&nbsp;&nbsp; &nbsp; 
                        <i class="icon-group"></i>&nbsp;สมาชิก&nbsp;&nbsp; &nbsp;  
                      </h6>
                      <div id="big_stats" class="cf">
                        <div class="stat"> <i class="icon-user-md"></i><h3><span>
                          <?php 
                          $ch = new subjects();
                          echo $ch->count_all();
                          ?></span></h3> </div>
                          <div class="stat"> <i class="icon-group"></i><h3><span>
                            <?php 
                            $ou = new regit();
                            echo $ou->count_all();
                            ?></span></h3> </div>
                          </div>
                        </div>  
                      </div>
                    </div>
                  </div>
                </div>
                <div class="span6">
                  <div class="widget">
                    <div class="widget-header"> <i class="icon-bookmark"></i>
                      <h3>เมนูลัด</h3>
                    </div>
                    <div class="widget-content">
                      <br>
                      <div class="shortcuts"> 
                        <a href="change.php" class="shortcut">
                          <i class="shortcut-icon icon-list-alt"></i>
                          <span class="shortcut-label">เปลี่ยนรหัส</span> </a> 
                          <a href="process/logout.php" class="shortcut">
                            <i class="shortcut-icon icon-list-alt"></i>
                            <span class="shortcut-label">ออกจากระบบ</span> </a>
                            <br>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="span12">
                      <div class="widget widget-table action-table">
                        <div class="widget-header"> <i class="icon-th-list"></i>
                          <?php 
                          if (empty($_GET['id'])) { 
                            ?>
                            <h3>รายวิชาของฉัน </h3>
                            <a href="#myModal" role="button" class="btn btn-info" data-toggle="modal">เพิ่มรายวิชา</a>
                          </div>
                          <div class="widget-content">

                           <table class="table table-striped table-bordered">
                             <thead>
                               <tr>
                                <th class="td-photos"></th>
                                <th><center>  ชื่อวิชา </center> </th>
                                <th class="td-actions"> </th>
                                <th class="td-actions"> </th>
                              </tr>
                            </thead>
                            <tbody>
                             <?php foreach($subjectss as $subjects):?>
                               <tr>
                                <?php $id = $subjects["s_id"]; ?>
                                <td>
                                  <div class="from_user left"> 
                                    <img src="<?php if(empty($regit["photo"]))
                                    {
                                      echo "img/message_avatar0.png";
                                    }
                                    ?>"/>
                                  </div>
                                </td>
                                <td> <center> <?php echo escape($subjects["s_number"]); ?>
                                  <?php echo escape($subjects["s_name"]); ?> </center></td>
                                  <td class="td-actions">
                                    <a href="qrcode.php?id=<?php echo escape($id); ?>" class="btn btn-small btn-invert"><i class="btn-icon-only  icon-group"> เช็คชื่อ</i></a>
                                  </td>
                                  <td class="td-actions">
                                    <a href="management.php?id=<?php echo escape($id); ?>" class="btn btn-small btn-invert"><i class="btn-icon-only  icon-group"> รายชื่อสมาชิก</i></a>
                                    <a href="#deletesubjects<?php echo $id; ?>" role="button" data-toggle="modal" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a>
                                    <div id="deletesubjects<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">คุณแน่ใจหรือไม่ว่าต้องการลบผู้นำคนนี้?</h3>
                                      </div>
                                      <form action="process/delete.php" method="post">
                                        <div class="modal-body pull-left">    
                                         <input type="hidden" name="idsubjects" value='<?php echo escape($id); ?>'>                      
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
                       <br />
                       <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          <h3 id="myModalLabel">การเพิ่มรายวิชาใหม่</h3>
                        </div>
                        <form action="process/add.php" method="post" enctype="multipart/form-data">
                          <div class="modal-body">
                            <div class="form-group">
                              <input name="s_number" type="text" class="form-control" required placeholder="รหัสวิชา">
                            </div>
                            <div class="form-group">
                              <input name="s_name" type="text" class="form-control" required placeholder="ชื่อวิชา">
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-primary">เพิ่ม</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">ยกเลิก</button>
                          </div>
                        </form>
                      </div>
                      <?php 
                    } else {
                     $regit=regit::liste_regit_subjects($_GET['id']);
                     ?>
                     <h3>รายชื่อสมาชิก</h3>
                     <a href="#myModal" role="button" class="btn btn-info" data-toggle="modal">เพิ่มสมาชิก</a>
                   </div>
                   <div class="widget-content">
                     <table class="table table-striped table-bordered">
                       <thead>
                         <tr>
                          <th class="td-photos"></th>
                          <th> เลขประจำตัว </th>
                          <th> คำนำหน้า </th>
                          <th> ชื่อ </th>
                          <th> นามสกุล </th>
                          <th class="td-actions"> </th>
                        </tr>
                      </thead>
                      <tbody>
                       <?php foreach($regit as $regit):?>
                         <tr>
                          <?php $oid = $regit["o_id"]; ?>
                          <td>
                            <div class="from_user left"> 
                              <img src="<?php if(empty($regit["photo"]))
                              {
                                echo "img/message_avatar.png";
                              }else
                              {
                               echo  escape($regit["photo"]);      
                             }
                             ?>"/>
                           </div>
                         </td>
                         <td><?php echo escape($regit["id_student"]); ?></td>
                         <td><?php echo escape($regit["titlename"]); ?></td>
                         <td><?php echo escape($regit["s_firstname"]); ?></td>
                         <td><?php echo escape($regit["s_lastname"]); ?></td>
                         <td class="td-actions"><a href="reports.php?id=<?php echo escape($oid); ?>" class="btn btn-small btn-invert"><i class="btn-icon-only icon-time"> ข้อมูล</i></a>
                          <a href="#deleteregit<?php echo $oid; ?>"role="button" data-toggle="modal" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a></td>
                          <div id="deleteregit<?php echo $oid; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                           <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">คุณแน่ใจหรือไม่ว่าต้องการลบสมาชิกคนนี้?</h3>
                          </div>
                          <form action="process/delete.php" method="post">
                            <div class="modal-body pull-left"> 
                              <input type="hidden" name="o_id" value="<?php echo escape($oid); ?>">
                             <input type="hidden" name="subjectsid" value="<?php echo escape($_GET['id']); ?>">
                             <input type="hidden" name="idregit" value="<?php echo escape($oid); ?>">  
                             <button class="btn btn-danger">ลบ</button>
                             <button class="btn" data-dismiss="modal" aria-hidden="true">ยกเลิก</button>
                           </div>
                         </form>
                       </div>
                     </tr>
                   <?php endforeach; ?>
                 </tbody>
               </table>	              
             </div>
             <br />
             <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">การเพิ่มสมาชิก</h3>
              </div>
              <form method="post" action="process/add.php" enctype="multipart/form-data">
                <div class="modal-body">
                  <?php $Student=Student::get_list_student(); ?>
                  <div class="widget-content">
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th class="td-photos"></th>
                          <th> เลขประจำตัว </th>
                          <th> คำนำหน้า </th>
                          <th> ชื่อ </th>
                          <th> นามสกุล </th>
                          <th class="td-actions"> </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($Student as $Student):?>
                          <tr>
                            <?php $id_stu = $Student["id_stu"]; ?>
                            <td>
                              <div class="from_user left"> 
                                <img src="<?php if(empty($Student["photo"]))
                                {
                                  echo "img/message_avatar.png";
                                }else
                                {
                                 echo  escape($Student["photo"]);      
                               }
                               ?>"/>
                             </div>
                           </td>
                           <td><?php echo escape($Student["id_student"]); ?></td>
                           <td><?php echo escape($Student["titlename"]); ?></td>
                           <td><?php echo escape($Student["s_firstname"]); ?></td>
                           <td><?php echo escape($Student["s_lastname"]); ?></td>
                           <td class="td-actions">
                            <form action="process/add.php" method="post" enctype="multipart/form-data">
                              <input name="sid" type="hidden" value=<?php echo escape($id_stu); ?> class="form-control">
                              <input name="id" type="hidden" value=<?php echo escape($_GET['id']); ?> class="form-control">  
                              <button class="button btn btn-primary btn-large">เพิ่มเข้ารายวิชา</button>
                            </form>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>  
                </div>
              </div> 
            </div>
          </form>
        </div>
        <?php } ?>
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
<script src="js/jquery-1.7.2.min.js"></script> 
<script src="js/excanvas.min.js"></script> 
<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script> 
</body>
</html>
