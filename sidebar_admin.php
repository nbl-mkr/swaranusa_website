<?php $halaman = basename($_SERVER['PHP_SELF']); ?>
<nav class="sidebar-menu">
    <div class="<?= $halaman === 'dashboard.php' ? 'active' : '' ?>">
        <img src="assets/logo_dashboard.png" alt="Logo Dashboard" />
        <a href="dashboard.php">Dashboard</a>
    </div>
    <div class="<?= $halaman === 'analisis.php' ? 'active' : '' ?>">
        <img src="assets/logo_analisis.png" alt="Logo Analisis" />
        <a href="analisis.php">Analisis</a>
    </div>
    <div class="<?= $halaman === 'histori.php' ? 'active' : '' ?>">
        <img src="assets/logo_histori.png" alt="Logo Histori" />
        <a href="histori.php">Histori</a>
    </div>
    <div class="<?= $halaman === 'kelola.php' ? 'active' : '' ?>">
        <img src="assets/logo_kelola.png" alt="Logo Kelola" width="15px" height="15px" />
        <a href="kelola.php">Kelola Akun</a>
    </div>
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</nav>