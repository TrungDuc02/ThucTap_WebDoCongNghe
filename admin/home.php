<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<h1>Chào Mừng đến <?php echo $_settings->info('name') ?></h1>
<hr>
<div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-maroon elevation-1"><i class="bi bi-laptop"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Số lượng sản phẩm</span>
                <span class="info-box-number">
                  <?php 
                    $inv = $conn->query("SELECT sum(quantity) as total FROM inventory ")->fetch_assoc()['total'];
                    $sales = $conn->query("SELECT sum(quantity) as total FROM order_list where order_id in (SELECT order_id FROM sales) ")->fetch_assoc()['total'];
                    echo number_format($inv - $sales);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-purple elevation-1"><i class="bi bi-hourglass-split"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Đơn hàng chờ xử lý</span>  <!-----Pending Orders------->
                <span class="info-box-number">
                  <?php 
                    $pending = $conn->query("SELECT COUNT(*) as total FROM `orders` where status = '0' ")->fetch_assoc()['total'];
                    echo number_format($pending);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-pink elevation-1"><i class="bi bi-cart-check"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Tổng số đơn hàng đã bán</span>  <!-----Pending Orders------->
                <span class="info-box-number">
                <?php 
                  $orders_sold = $conn->query("SELECT COUNT(*) as total FROM `orders` WHERE status = 3")->fetch_assoc()['total'];
                     echo number_format($orders_sold);
                    ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-black elevation-1"><i class="fa fa-address-card"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Tổng số tài khoản khách hàng</span>  <!-----Pending Orders------->
                <span class="info-box-number">
                <?php 
                 $total_customers = $conn->query("SELECT COUNT(*) as total FROM `clients`")->fetch_assoc()['total'];
                  echo number_format($total_customers);
                    ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-gray  elevation-1"><i class="fa fa-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Tổng số sản phẩm</span>  <!-----Pending Orders------->
                <span class="info-box-number">
                <?php 
                $total_products = $conn->query("SELECT COUNT(*) as total FROM `products`")->fetch_assoc()['total'];
                  echo number_format($total_products);
                    ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-blue elevation-1"><i class="bi bi-bag-plus-fill"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Số lượng sản phẩm nhập hôm nay</span>  <!-----Pending Orders------->
                <span class="info-box-number">
                <?php 
                 $current_date = date('Y-m-d'); // Lấy ngày hiện tại
                   $total_new_products = $conn->query("SELECT SUM(quantity) as total FROM `inventory` WHERE DATE(date_created) = '{$current_date}'")->fetch_assoc()['total'];
                     echo number_format($total_new_products);
                      ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-yellow elevation-1"><i class="bi bi-truck"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Đơn hàng đã bán hôm nay</span>  <!-----Pending Orders------->
                <span class="info-box-number">
                <?php 
                  $orders_sold = $conn->query("SELECT COUNT(*) as total FROM `orders` WHERE date(date_created) = CURDATE() AND paid = 1")->fetch_assoc()['total'];
                   echo number_format($orders_sold);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="bi bi-cash-coin"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Tổng doanh số hôm nay</span>
                <span class="info-box-number">
                <?php 
                $current_date = date('Y-m-d'); // Lấy ngày hiện tại
               $sales = $conn->query("SELECT SUM(amount) as total FROM `orders` WHERE DATE(date_created) = '{$current_date}' AND paid = 1")->fetch_assoc()['total'];
                echo number_format($sales);
                ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>



          
    <!----- end ----->
        </div>






        
<div class="container">
  <?php 
    $files = array();
      $fopen = scandir(base_app.'uploads/banner');
      foreach($fopen as $fname){
        if(in_array($fname,array('.','..')))
          continue;
        $files[]= validate_image('uploads/banner/'.$fname);
      }
  ?>
  <div id="tourCarousel"  class="carousel slide" data-ride="carousel" data-interval="3000">
      <div class="carousel-inner h-100">
          <?php foreach($files as $k => $img): ?>
          <div class="carousel-item  h-100 <?php echo $k == 0? 'active': '' ?>">
              <img class="d-block w-100  h-100" style="object-fit:contain" src="<?php echo $img ?>" alt="">
          </div>
          <?php endforeach; ?>
      </div>
      <a class="carousel-control-prev" href="#tourCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#tourCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
      </a>
  </div>
</div>
