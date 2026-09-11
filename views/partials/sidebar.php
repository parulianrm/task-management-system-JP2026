<aside class="sidebar">
    <div class="sidebar-brand">TASKFLOW</div>
    <ul class="sidebar-nav">
        <li><a href="/dashboard" class="<?= ($activePage ?? '') === 'dashboard' ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="/projects" class="<?= ($activePage ?? '') === 'projects' ? 'active' : '' ?>">Projects</a></li>
        <li><a href="/tasks" class="<?= ($activePage ?? '') === 'tasks' ? 'active' : '' ?>">Tasks</a></li>
        <li><a href="/users" class="<?= ($activePage ?? '') === 'users' ? 'active' : '' ?>">Users</a></li>
    </ul>
</aside>
