<?php
$userName = $_SESSION['user_name'] ?? '';
$userEmail = $_SESSION['user_email'] ?? '';
$userRole = $_SESSION['role'] ?? '';
$avatarInitial = $userName !== '' ? strtoupper(substr($userName, 0, 1)) : '?';
$roleBadgeClass = $userRole === 'Admin' ? 'badge-role-admin' : 'badge-role-member';
?>
<header class="app-topbar">
    <details class="nav-user-menu">
        <summary class="nav-user-summary">
            <span class="nav-avatar"><?= $avatarInitial ?></span>
            <span class="nav-user-name"><?= htmlspecialchars($userName) ?></span>
            <span class="nav-caret">▾</span>
        </summary>
        <div class="nav-user-dropdown">
            <div class="nav-user-dropdown-header">
                <span class="nav-avatar"><?= $avatarInitial ?></span>
                <div class="nav-user-dropdown-info">
                    <div class="nav-user-name"><?= htmlspecialchars($userName) ?></div>
                    <div class="nav-user-email"><?= htmlspecialchars($userEmail) ?></div>
                    <span class="badge <?= $roleBadgeClass ?>"><?= htmlspecialchars($userRole) ?></span>
                </div>
            </div>
            <hr class="nav-user-dropdown-separator" />
            <a href="/logout" class="nav-dropdown-item nav-dropdown-item-danger">↩ Logout</a>
        </div>
    </details>
</header>