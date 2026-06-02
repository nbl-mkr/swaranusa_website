<?php $halaman = basename($_SERVER['PHP_SELF']); ?>
<nav id="navMenu">
    <ul>
        <li><a href="/belajar_html/swaranusa_website/index.php" class="<?= $halaman === 'index.php' ? 'active' : '' ?>"
                onclick="closeMenu()">Beranda</a></li>
        <li><a href="/belajar_html/swaranusa_website/jelajahi.php"
                class="<?= $halaman === 'jelajahi.php' ? 'active' : '' ?>" onclick="closeMenu()">Jelajahi</a></li>
        <li><a href="/belajar_html/swaranusa_website/belajar.php"
                class="<?= $halaman === 'belajar.php' ? 'active' : '' ?>" onclick="closeMenu()">Belajar</a></li>
        <li><a href="/belajar_html/swaranusa_website/tentang.php"
                class="<?= $halaman === 'tentang.php' ? 'active' : '' ?>" onclick="closeMenu()">Tentang</a></li>
        <li class="user-menu">
            <?php if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"] === true): ?>
                <img src="/belajar_html/swaranusa_website/gmbr_gnrl/usr.png" width="15px" height="15px" class="user-icon"
                    onclick="toggleDropdown(event)" />
                <div class="user-dropdown" id="userDropdown">
                    <?php if ($_SESSION["role"] === "admin"): ?>
                        <a href="/belajar_html/swaranusa_website/histori.php" onclick="closeMenu()">Histori</a>
                        <a href="/belajar_html/swaranusa_website/kelola.php" onclick="closeMenu()">Kelola Akun</a>
                    <?php else: ?>
                        <a href="/belajar_html/swaranusa_website/menu_user/histori_user.php" onclick="closeMenu()">Histori</a>
                        <a href="/belajar_html/swaranusa_website/menu_user/kelola_user.php" onclick="closeMenu()">Kelola
                            Akun</a>
                    <?php endif; ?>
                    <a href="/belajar_html/swaranusa_website/logout.php" onclick="closeMenu()">Logout</a>
                </div>
            <?php else: ?>
                <a href="/belajar_html/swaranusa_website/login.php" onclick="closeMenu()">
                    <img src="/belajar_html/swaranusa_website/gmbr_gnrl/usr.png" width="15px" height="15px" />
                </a>
            <?php endif; ?>
        </li>
    </ul>
</nav>