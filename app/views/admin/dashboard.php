<?php
/**
 * Admin Dashboard View
 * File: app/views/admin/dashboard.php
 */
$content = ob_start();
?>
<div class="dashboard">
    <div class="row">
        <!-- Statistics Cards -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Đặt lịch hôm nay</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $todayBookings; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tổng dịch vụ</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalServices; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-spa fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Bài viết</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalPosts; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-blog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Đánh giá chờ duyệt</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $pendingTestimonials; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Bookings -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Đặt lịch gần đây</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th>Dịch vụ</th>
                                    <th>Ngày giờ</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentBookings as $booking): ?>
                                <tr>
                                    <td><?php echo $booking['name']; ?></td>
                                    <td><?php echo $booking['service_name']; ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($booking['date'] . ' ' . $booking['time'])); ?></td>
                                    <td>
                                        <span class="badge bg-<?php 
                                            echo $booking['status'] === 'confirmed' ? 'success' : 
                                                 ($booking['status'] === 'pending' ? 'warning' : 'secondary'); 
                                        ?>">
                                            <?php echo $booking['status'] === 'confirmed' ? 'Đã xác nhận' : 
                                                  ($booking['status'] === 'pending' ? 'Chờ xác nhận' : 'Đã hoàn thành'); ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Testimonials -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Đánh giá mới</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th>Dịch vụ</th>
                                    <th>Đánh giá</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentTestimonials as $testimonial): ?>
                                <tr>
                                    <td><?php echo $testimonial['name']; ?></td>
                                    <td><?php echo $testimonial['service_name'] ?? 'N/A'; ?></td>
                                    <td>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?php echo $i <= $testimonial['rating'] ? 'text-warning' : 'text-secondary'; ?>"></i>
                                        <?php endfor; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo $testimonial['status'] === 'approved' ? 'success' : 'warning'; ?>">
                                            <?php echo $testimonial['status'] === 'approved' ? 'Đã duyệt' : 'Chờ duyệt'; ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include_once 'layout.php';
?>
