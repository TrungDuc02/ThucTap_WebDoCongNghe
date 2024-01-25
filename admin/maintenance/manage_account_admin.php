<?php
require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `users` where id = '{$_GET['id']}' ");
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
			<input type="text" name="firstname" id="firstname" class="form-control form-control-sm rounded-0" value="<?php echo isset($firstname) ? $firstname : ''; ?>" />
		</div>
        <div class="form-group">
			<label for="lastname" class="control-label">Tên</label>
			<input type="text" name="lastname" id="lastname" class="form-control form-control-sm rounded-0" value="<?php echo isset($lastname) ? $lastname : ''; ?>" />
		</div>

        <div class="form-group">
			<label for="username" class="control-label">Tên đăng nhập</label>
			<input type="text" name="username" id="username" class="form-control form-control-sm rounded-0" value="<?php echo isset($username) ? $username : ''; ?>" />
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
				url:_base_url_+"classes/Master.php?f=save_sub_category",
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
						location.href = "./?page=maintenance/sub_category";
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