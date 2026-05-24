<?php $halaman = basename($_SERVER['PHP_SELF']); ?>
<nav id="navMenu">
    <ul>
        <li><a href="landing.php" class="<?= $halaman === 'landing.php' ? 'active' : '' ?>"
                onclick="closeMenu()">Beranda</a></li>
        <li><a href="jelajahi.php" class="<?= $halaman === 'jelajahi.php' ? 'active' : '' ?>"
                onclick="closeMenu()">Jelajahi</a></li>
        <li><a href="belajar.php" class="<?= $halaman === 'belajar.php' ? 'active' : '' ?>"
                onclick="closeMenu()">Belajar</a></li>
        <li><a href="tentang.php" class="<?= $halaman === 'tentang.php' ? 'active' : '' ?>"
                onclick="closeMenu()">Tentang</a></li>
        <li>
            <a href="kelola.php" onclick="closeMenu()">
                <img src="gmbr_gnrl/usr.png" width="15px" height="15px" />
            </a>
        </li>
    </ul>
</nav>