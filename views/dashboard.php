<?php
$pageTitle = 'Dashboard - TaskFlow';
$activePage = 'dashboard';
$basePath = '';
require __DIR__ . '/partials/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/partials/sidebar.php'; ?>

    <div class="app-main">
        <?php require __DIR__ . '/partials/topbar.php'; ?>

        <main class="dashboard-container">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Projects</h3>
                    <div class="number">12</div>
                </div>
                <div class="stat-card">
                    <h3>Active Tasks</h3>
                    <div class="number">28</div>
                </div>
                <div class="stat-card">
                    <h3>Completed Tasks</h3>
                    <div class="number">104</div>
                </div>
            </div>

            <div class="dashboard-content">
                <section class="content-card">
                    <h2>Recent Projects</h2>
                    <ul class="item-list">
                        <li><span>E-Commerce Mobile App</span><span class="badge badge-progress">In Progress</span></li>
                        <li><span>HRIS Internal System</span><span class="badge badge-pending">Pending</span></li>
                        <li><span>Payment Gateway Integration</span><span class="badge badge-progress">In Progress</span></li>
                    </ul>
                </section>

                <section class="content-card">
                    <h2>Tasks Due Soon</h2>
                    <ul class="item-list">
                        <li><span>Fix Auth API</span><span class="badge badge-urgent">Besok</span></li>
                        <li><span>Design ERD Diagram</span><span class="badge badge-urgent">Hari Ini</span></li>
                        <li><span>Midtrans Integration</span><span class="badge badge-pending">10 Sep</span></li>
                    </ul>
                </section>
            </div>
        </main>
    </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
