<style>
    #uni_modal .modal-content>.modal-footer,#uni_modal .modal-content>.modal-header{
        display:none;
    }
</style>
<div class="container-fluid">
    
    <div class="row">
    <h3 class="float-right">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </h3>
        <div class="col-lg-12">
            <h3 class="text-center">ĐĂNG NHẬP TÀI KHOẢN</h3>
            <hr>
            <form action="" id="login-form">
                <div class="form-group">
                    <label for="" class="control-label">Tài Khoản</label>
                    <input type="email" class="form-control form" name="email" placeholder="Nhập email..." required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Mật Khẩu</label>
                    <input type="password" class="form-control form" name="password" placeholder="Nhập password..." required>
                </div>
                <div class="form-group d-flex justify-content-between">
                <span style="display: inline-block; font-size: 15px;">Khách hàng mới?</span>
                <span style="display: inline-block; margin-right: 105px;">   
                <a href="javascript:void()" id="create_account" style="text-decoration: none;">Tạo tài khoản</a></span>

                    <button class="btn btn-primary btn-flat" style="font-size: 16px;">Đăng nhập</button>

                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#create_account').click(function(){
            uni_modal("","registration.php","mid-large")
        })
        $('#login-form').submit(function(e){
            e.preventDefault();
            start_loader()
            if($('.err-msg').length > 0)
                $('.err-msg').remove();
            $.ajax({
                url:_base_url_+"classes/Login.php?f=login_user",
                method:"POST",
                data:$(this).serialize(),
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("đã xảy ra lỗi",'error')
                    end_loader()
                },
                success:function(resp){
                    if(typeof resp == 'object' && resp.status == 'success'){
                        alert_toast("Đăng nhập thành công",'success')
                        setTimeout(function(){
                            location.reload()
                        },2000)
                    }else if(resp.status == 'incorrect'){
                        var _err_el = $('<div>')
                            _err_el.css("text-align", "center");
                            _err_el.addClass("alert alert-danger err-msg").text("Thông tin đăng nhập không hợp lệ.")
                        $('#login-form').prepend(_err_el)
                        end_loader()
                        
                    }else{
                        console.log(resp)
                        alert_toast("đã xảy ra lỗi",'error')
                        end_loader()
                    }
                }
            })
        })
    })

</script>