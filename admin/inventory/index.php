<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Danh sách hàng tồn kho</h3>
		<div class="card-tools">
			<a href="?page=inventory/manage_inventory" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Tạo mới</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-strip">
				<colgroup>
				<col width="5%">
					<col width="35%">

					<col width="4%">
					<col width="6%">
			
					<col width="8%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Tên sản phẩm</th>
						<th>Giá</th>
						<th>Số lượng</th>
						<th>Hành động</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT i.*,p.name as product,b.name as bname from `inventory` i inner join `products` p on p.id = i.product_id inner join brands b on p.brand_id = b.id order by unix_timestamp(i.date_created) desc ");
						while($row = $qry->fetch_assoc()):
						$sold = $conn->query("SELECT SUM(ol.quantity) as sold FROM order_list ol inner join orders o on o.id = ol.order_id where ol.product_id='{$row['id']}' and o.`status` != 4 ");
						$sold = $sold->num_rows > 0 ? $sold->fetch_assoc()['sold'] : 0;
						$avail = $row['quantity'] - $sold;
						foreach($row as $k=> $v){
							$row[$k] = trim(stripslashes($v));
						}
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td>
								<b><?php echo $row['product'] ?></b> <br>
								<small><b>Thương hiệu:</b> <?php echo $row['bname'] ?></small>
							</td>
							<td class="text-right"><?php echo number_format($row['price']) ?></td>
							<td class="text-right"><?php echo $avail ?></td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Hoạt động
				                    <span class="sr-only">Chuyển đổi thả xuống</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item" href="?page=inventory/manage_inventory&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Sửa </a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Xóa</a>
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
			_conf("Bạn có chắc chắn xóa khoảng không quảng cáo này vĩnh viễn không?","delete_inventory",[$(this).attr('data-id')])
		})
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [4] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	function delete_inventory($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_inventory",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("đã xảy ra lỗi.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("đã xảy ra lỗi.",'error');
					end_loader();
				}
			}
		})
	}
</script>