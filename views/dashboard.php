<?php
$pageTitle = 'Dashboard - TaskFlow';
$activePage = 'dashboard';
require __DIR__ . '/partials/header.php';

$statusBadge = [
    'To Do' => 'badge-status-todo',
    'In Progress' => 'badge-status-progress',
    'Done' => 'badge-status-done',
];
?>

<div class="app-layout">
    <?php require __DIR__ . '/partials/sidebar.php'; ?>

    <div class="app-main">
        <?php require __DIR__ . '/partials/topbar.php'; ?>

        <main class="dashboard-container">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Dashboard</h1>
                    <p class="page-subtitle">
                        <?= $_SESSION['role'] === 'Admin'
                            ? 'Ringkasan seluruh project & task di sistem'
                            : 'Ringkasan task yang ditugaskan ke Anda' ?>
                    </p>
                </div>
            </div>

            <div class="stats-grid">
                <?php if ($_SESSION['role'] === 'Admin'): ?>
                    <div class="stat-card">
                        <h3>Project Aktif</h3>
                        <div class="number"><?= $activeProjects ?></div>
                        <p class="stat-desc">Project berstatus Active saat ini</p>
                    </div>
                <?php endif; ?>
                <div class="stat-card">
                    <h3>Belum Dikerjakan</h3>
                    <div class="number"><?= $tasksByStatus['To Do'] ?></div>
                    <p class="stat-desc">Task berstatus To Do</p>
                </div>
                <div class="stat-card">
                    <h3>Sedang Dikerjakan</h3>
                    <div class="number"><?= $tasksByStatus['In Progress'] ?></div>
                    <p class="stat-desc">Task berstatus In Progress</p>
                </div>
                <div class="stat-card">
                    <h3>Selesai</h3>
                    <div class="number"><?= $tasksByStatus['Done'] ?></div>
                    <p class="stat-desc">Task berstatus Done</p>
                </div>
                <div class="stat-card">
                    <h3>Terlambat</h3>
                    <div class="number"><?= $overdueCount ?></div>
                    <p class="stat-desc">Due date lewat &amp; belum selesai</p>
                </div>
            </div>


            <div class="dashboard-content">
                <section class="content-card">
                    <h2><?= $_SESSION['role'] === 'Admin' ? '5 Task Due Terdekat' : '5 Task Saya yang Due Terdekat' ?>
                    </h2>
                    <ul class="item-list">
                        <?php if (empty($upcomingTasks)): ?>
                            <li>Tidak ada task yang mendekati due date.</li>
                        <?php else: ?>
                            <?php foreach ($upcomingTasks as $task): ?>
                                <li>
                                    <span><?= htmlspecialchars($task['title']) ?> &mdash;
                                        <?= htmlspecialchars($task['project_name']) ?></span>
                                    <span
                                        class="badge <?= $statusBadge[$task['status']] ?>"><?= date('d M Y', strtotime($task['due_date'])) ?></span>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </section>
            </div>
        </main>
    </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>