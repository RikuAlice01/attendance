<?php
include("panel.php");
?>			
<div class="main">
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="widget widget-table action-table">
						<div class="widget-header"> <i class="icon-th-list"></i>
							<h3 >เปลี่ยนรหัสผ่าน</h3>
						</div>
					</div>
				</div> 
				<div class="widget-content">
					<form role="form" action="process/change.php" autocomplete="off" method="post">
						<div class="form-group">
							<label>รหัสเดิม</label>
							<input type="password" class="form-control" autocomplete="off" name="oldpassword" autofocus>
							<label>รหัสใหม่</label>
							<input type="password" class="form-control"  autocomplete="off" name="newpassword" autofocus>
							<label>รหัสใหม่อีกครั้ง</label>
							<input type="password" class="form-control"  autocomplete="off" name="renewpassword" autofocus>
						</div>
						<button type="submit" class="btn btn-primary">ยืนยัน</button>
						<button type="reset" class="btn btn-default">ยกเลิก</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
