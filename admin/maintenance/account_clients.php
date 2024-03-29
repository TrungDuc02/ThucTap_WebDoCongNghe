<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Danh sách tài khoản</h3> <br>
        <a href="?page=maintenance/account_admin" class="listaccountadmin">Danh sách tài khoản quản lý</a>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Tạo mới</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">  <!---# --->
					<col width="13%"> <!---Ngày tạo--->
					<col width="8%">   <!---Họ --->
					<col width="8%">   <!---Tên --->
					<col width="8%">   <!---gioi tinh --->
					<col width="10%">   <!---Liên hệ--->
                    <col width="15%">   <!---email --->
                    <col width="10%">   <!---pass--->
                    <col width="13%">   <!---địa chỉ--->
					<col width="10%">   <!---hành động --->
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Ngày tạo</th>
						<th>Họ</th>
						<th>Tên</th>
						<th>Giới tính</th>
						<th>Liên hệ</th>
                        <th>Email</th>
                        <th>Mật khẩu  <span style="color: red;">( đã mã hóa ) *</span></th>
                        <th>Địa chỉ</th>
						<th>Hành động</th>
					</tr>
				</thead>
				<tbody>

                <?php 
    $i = 1;
    $qry = $conn->query("SELECT * FROM `clients` ORDER BY UNIX_TIMESTAMP(date_created) DESC");
    while($row = $qry->fetch_assoc()):
        $password = md5($row['password']); // Lưu mật khẩu đã mã hóa từ MD5 vào biến tạm thời
        $row['password'] = $password; // Gán mật khẩu đã mã hóa vào cột password
?>
    <tr>
        <td class="text-center"><?php echo $i++; ?></td>
        <td><?php echo date("H:i d-m-Y", strtotime($row['date_created'])) ?></td>
        <td><?php echo $row['firstname'] ?></td>
        <td><?php echo $row['lastname'] ?></td>
		<td><?php echo $row['gender'] ?></td>
        <td><?php echo $row['contact'] ?></td>
        <td><?php echo $row['email'] ?></td>
        <td><?php echo $password ?></td> <!-- Hiển thị mật khẩu đã được giải mã từ MD5 -->
        <td><?php echo $row['default_delivery_address'] ?></td>
        
        <!-- Các cột khác của bảng clients, nếu có -->
        <td align="center">
            <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                Hoạt động
                <span class="sr-only">Chuyển đổi thả xuống</span>
            </button>
            <div class="dropdown-menu" role="menu">
                <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
                    <span class="fa fa-edit text-primary"></span> Sửa
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
                    <span class="fa fa-trash text-danger"></span> Xóa
                </a>
            </div>
        </td>
    </tr>
<?php endwhile; ?>

				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Bạn có chắc chắn xóa người dùng này vĩnh viễn không?","delete_account_clients",[$(this).attr('data-id')])
		})
		$('#create_new').click(function(){
			uni_modal("<i class='fa fa-plus'></i> Thêm tài khoản mới","maintenance/manage_account_clients.php")
		})
		$('.edit_data').click(function(){
			uni_modal("<i class='fa fa-edit'></i> Cập nhật tài khoản khách hàng","maintenance/manage_account_clients.php?id="+$(this).attr('data-id'))
		})
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [4,5] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	function delete_account_clients($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_account_clients",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("Đã xảy ra lỗi.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("Đã xảy ra lỗi.",'error');
					end_loader();
				}
			}
		})
	}
</script>