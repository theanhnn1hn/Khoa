<?php
/**
 * Admin Layout Template
 * File: app/views/admin/layout.php
 */
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Admin Panel'; ?> - Luxury Head Spa</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Admin CSS -->
    <link href="/assets/css/admin.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <?php include_once 'partials/sidebar.php'; ?>
        
        <div class="main-content">
            <!-- Top Navbar -->
            <?php include_once 'partials/header.php'; ?>
            
            <main class="content-wrapper">
                <!-- Flash Messages -->
                <?php flash(); ?>
                
                <!-- Page Content -->
                <?php echo $content; ?>
            </main>
            
            <!-- Footer -->
            <?php include_once 'partials/footer.php'; ?>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Custom Admin JS -->
    <script src="/assets/js/admin.js"></script>
</body>
</html>
