<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">TASKFLOW</div>
    <ul class="sidebar-nav">
        <li><a href="/dashboard" class="<?= ($activePage ?? '') === 'dashboard' ? 'active' : '' ?>"><img src="/images/dashboard.png" class="sidebar-icon" alt="" />Dashboard</a></li>
        <li><a href="/projects" class="<?= ($activePage ?? '') === 'projects' ? 'active' : '' ?>"><img src="/images/layers.png" class="sidebar-icon" alt="" />Projects</a></li>
        <li><a href="/tasks" class="<?= ($activePage ?? '') === 'tasks' ? 'active' : '' ?>"><img src="/images/clipboard.png" class="sidebar-icon" alt="" />Tasks</a></li>
        <?php if ($_SESSION['role'] === 'Admin'): ?>
            <li><a href="/users" class="<?= ($activePage ?? '') === 'users' ? 'active' : '' ?>"><img src="/images/group.png" class="sidebar-icon" alt="" />Users</a></li>
        <?php endif; ?>
    </ul>
</aside>

<div class="sidebar-backdrop" id="sidebar-backdrop"></div>