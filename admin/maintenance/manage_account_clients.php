<?php
require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `clients` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="container-fluid">
	<form action="" id="category-form">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
		
		<div class="form-group">
			<label for="firstname" class="control-label">Họ</label>
			<input type="text" name="firstname" id="cliefirstnaments" class="form-control form-control-sm rounded-0" value="<?php echo isset($firstname) ? $firstname : ''; ?>" />
		</div>
        <div class="form-group">
			<label for="lastname" class="control-label">Tên</label>
			<input type="text" name="lastname" id="lastname" class="form-control form-control-sm rounded-0" value="<?php echo isset($lastname) ? $lastname : ''; ?>" />
		</div>
        <div class="form-group">
			<label for="contact" class="control-label">Số điện thoại</label>
			<input type="text" name="contact" id="contact" class="form-control form-control-sm rounded-0" value="<?php echo isset($contact) ? $contact : ''; ?>" />
		</div>
		<div class="form-group">
    <label for="" class="control-label">Giới tính</label>
    <select name="gender" id="" class="custom-select select">
        <option <?php echo (isset($gender) && $gender == 'Nam') ? 'selected' : ''; ?>>Nam</option>
        <option <?php echo (isset($gender) && $gender == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
    </select>
</div>
        <div class="form-group">
			<label for="default_delivery_address" class="control-label">Địa chỉ</label>
			<input type="text" name="default_delivery_address" id="default_delivery_address" class="form-control form-control-sm rounded-0" value="<?php echo isset($default_delivery_address) ? $default_delivery_address : ''; ?>" />
		</div>
        <div class="form-group">
			<label for="email" class="control-label">Tên đăng nhập <span style="color: red;"> *</span></label>
			<input type="text" name="email" id="email" placeholder="Nhập Email..." class="form-control form-control-sm rounded-0" value="<?php echo isset($email) ? $email : ''; ?>" />
		</div>
        <div class="form-group">
			<label for="password" class="control-label">Mật khẩu <span style="color: red;"> *</span></label>
			<input type="text" name="password"placeholder="Nhập password..." id="password" class="form-control form-control-sm rounded-0" value="<?php echo isset($password) ? $password : ''; ?>" />
		</div>
		
	</form>
</div>
<script>
  
	$(document).ready(function(){
		$('#category-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_account_clients",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("Tính năng đang bảo trì ! Vui lòng quay lại sau ",'warning');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = "./?page=maintenance/account_clients";
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader()
                    }else{
						alert_toast("Đã xảy ra lỗi",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

	})
</script>