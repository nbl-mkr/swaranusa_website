<?php $halaman = basename($_SERVER['PHP_SELF']); ?>
<nav class="sidebar-menu">
    <div class="<?= $halaman === 'histori_user.php' ? 'active' : '' ?>">
        <img src="../assets/logo_histori.png" alt="Logo Histori" />
        <a href="histori_user.php">Histori</a>
    </div>
    <div class="<?= $halaman === 'kelola_user.php' ? 'active' : '' ?>">
        <img src="../assets/logo_kelola.png" alt="Logo Kelola" width="15px" height="15px" />
        <a href="kelola_user.php">Kelola Akun</a>
    </div>
    <div class="logout">
        <a href="../logout.php">Logout</a>
    </div>
</nav>