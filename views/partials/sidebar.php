<aside class="sidebar">
    <div class="sidebar-brand">TASKFLOW</div>
    <ul class="sidebar-nav">
        <li><a href="<?= $basePath ?? '' ?>dashboard.php" class="<?= ($activePage ?? '') === 'dashboard' ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="<?= $basePath ?? '' ?>projects/projects.html" class="<?= ($activePage ?? '') === 'projects' ? 'active' : '' ?>">Projects</a></li>
        <li><a href="#" class="<?= ($activePage ?? '') === 'tasks' ? 'active' : '' ?>">Tasks</a></li>
        <li><a href="#" class="<?= ($activePage ?? '') === 'users' ? 'active' : '' ?>">Users</a></li>
    </ul>
</aside>
