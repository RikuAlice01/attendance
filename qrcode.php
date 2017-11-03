<div>
<?php
require_once('panel.php');
$session = new Session();
if(!$session->is_loggedin())
{
  $session->message("โปรดเข้าสู่ระบบ");
  header('Location: login.php');
}
$ut= new User();
$ut->find_by_id($session->get_user_id());
$ut_data= $ut->get_user();
$ou = new Student();
if(empty($_GET['id'])){
  header('Location: management.php');
}
else { 
  $usercheck= new Subjects();
  $usercheck->check_subject($_GET['id']);

  date_default_timezone_set("Asia/Bangkok");
  $i_day=date("Y-m-d");
  $checktime=date("H:i:s");
  $sub_id=$_GET["id"];
  ?>
  <div id="app">
    <?php
    $getsub = new subjects;
    $num_sub = $getsub->find_by_id_sub_num($sub_id);
    $name_sub = $getsub->find_by_id_sub_name($sub_id);
    $o_id;
    ?>

      <div class="main">
        <div class="main-inner">
          <div class="container">
            <div class="row">
              <div class="span12">
                <table>
                  <td>
                    <div class="span12">
                     <div class="widget-content-b">
                       <center>
                         <video id="qrcode"></video>
                       </center>
                     </div>
                   </div>
                 </td>   
                 <td>
                  <div class="span12">
                   <div class="widget-content-a" id="postlist">
                    <h3>Date</h3>
                    <?php 
                    echo $i_day."<br>";
                    echo " <div id='txt'>Time </div>";
                    echo "วิชา : ".$num_sub." ".$name_sub."<br>";
                    ?>
                    ระยะเวลาคาบเรียน : 
                    <select id="time" name="time">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                    </select>
                    <section class="cameras">
                      <h3>Cameras</h3>
                      <ul>
                        <li v-if="cameras.length === 0" class="empty">No cameras found</li>
                        <li v-for="camera in cameras">
                          <span v-if="camera.id == activeCameraId" :title="formatName(camera.name)" class="active">{{ formatName(camera.name) }}</span>
                          <span v-if="camera.id != activeCameraId" :title="formatName(camera.name)">
                            <a @click.stop="selectCamera(camera)">{{ formatName(camera.name) }}</a>
                          </span>
                        </li>
                      </ul>
                    </section>
                    <section class="scans">
                      <h3>Scans</h3>
                      <ul v-if="scans.length === 0">
                        <li class="empty">ยังไม่มีรายการ</li>
                      </ul>
                      <transition-group name="scans" tag="ul">
                        <li v-for="scan in scans" :key="scan.date" :title="scan.content">{{ scan.content }}</li>
                      </transition-group>
                    </section>
                  </div>
                </div>
              </div>
            </td>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="extra">
    <div class="extra-inner">
      <div class="container">
        <div class="row">
          <?php } ?>
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
</div>
</div>
<script>
  var subid = <?php echo json_encode($sub_id); ?>; 
  var app = new Vue({
    el: '#app',
    data: {
      scanner: null,
      activeCameraId: null,
      cameras: [],
      scans: []
    },
    mounted: function () {
      var self = this;
      self.scanner = new Instascan.Scanner({ video: document.getElementById('qrcode'), mirror: false,refractoryPeriod: 5000, scanPeriod: 1 });
      self.scanner.addListener('scan', function (content, image) {
        var qrcode = content;
        var time = document.getElementById("time").value; 
        $.ajax({
         url: 'process/qrs.php',
         type: 'POST',
         data: {qrcode:qrcode,subid:subid,time:time},
         success: function (response) {
          if(response)
           self.scans.unshift({ date: +(Date.now()), content: response});
       }
     });
      });
      Instascan.Camera.getCameras().then(function (cameras) {
        self.cameras = cameras;
        if (cameras.length > 0) {
          self.activeCameraId = cameras[0].id;
          self.scanner.start(cameras[0]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });
    },
    methods: {
      formatName: function (name) {
        return name || '(unknown)';
      },
      selectCamera: function (camera) {
        this.activeCameraId = camera.id;
        this.scanner.start(camera);
      }
    }
  });
</script>
</body>
</html>
