<?php $halaman = basename($_SERVER['PHP_SELF']); ?>
<nav class="sidebar-menu">
    <div class="<?= $halaman === 'dashboard.php' ? 'active' : '' ?>">
        <img src="assets/logo_dashboard.png" alt="Logo Dashboard" />
        <a href="dashboard.php">Dashboard</a>
    </div>

    <div class="sidebar-dropdown <?= in_array($halaman, ['konten.php']) ? 'active' : '' ?>"
        onclick="toggleSidebar('konten')">
        <img src="assets/logo_analisis.png" alt="Logo Konten" />
        <span>Konten</span>
        <span class="arrow" id="arrow-konten">▾</span>
    </div>
    <div class="sidebar-submenu" id="submenu-konten">
        <a href="konten.php?tab=jelajahi"
            class="<?= ($halaman === 'konten.php' && ($_GET['tab'] ?? '') === 'jelajahi') ? 'active' : '' ?>">Jelajahi</a>
        <a href="konten.php?tab=belajar"
            class="<?= ($halaman === 'konten.php' && ($_GET['tab'] ?? '') === 'belajar') ? 'active' : '' ?>">Belajar</a>
    </div>

    <div class="sidebar-dropdown <?= in_array($halaman, ['histori.php']) ? 'active' : '' ?>"
        onclick="toggleSidebar('histori')">
        <img src="assets/logo_histori.png" alt="Logo Histori" />
        <span>Histori</span>
        <span class="arrow" id="arrow-histori">▾</span>
    </div>
    <div class="sidebar-submenu" id="submenu-histori">
        <a href="histori.php?tab=jelajahi"
            class="<?= ($halaman === 'histori.php' && ($_GET['tab'] ?? '') === 'jelajahi') ? 'active' : '' ?>">Jelajahi</a>
        <a href="histori.php?tab=belajar"
            class="<?= ($halaman === 'histori.php' && ($_GET['tab'] ?? '') === 'belajar') ? 'active' : '' ?>">Belajar</a>
    </div>

    <div class="<?= $halaman === 'kelola.php' ? 'active' : '' ?>">
        <img src="assets/logo_kelola.png" alt="Logo Kelola" width="15px" height="15px" />
        <a href="kelola.php">Kelola Akun</a>
    </div>
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</nav>

<script>
    function toggleSidebar(menu) {
        const submenu = document.getElementById('submenu-' + menu);
        const arrow = document.getElementById('arrow-' + menu);
        const isOpen = submenu.classList.contains('open');

        document.querySelectorAll('.sidebar-submenu').forEach(el => el.classList.remove('open'));
        document.querySelectorAll('.arrow').forEach(el => el.classList.remove('rotated'));

        if (!isOpen) {
            submenu.classList.add('open');
            arrow.classList.add('rotated');
        }
    }

    const halaman = '<?= $halaman ?>';

    if (halaman === 'konten.php') {
        document.getElementById('submenu-konten').classList.add('open');
        document.getElementById('arrow-konten').classList.add('rotated');
    }
    if (halaman === 'histori.php') {
        document.getElementById('submenu-histori').classList.add('open');
        document.getElementById('arrow-histori').classList.add('rotated');
    }
</script>