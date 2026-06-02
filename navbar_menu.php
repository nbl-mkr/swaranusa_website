<nav id="navMenu">
    <ul>
        <li><a href="index.php" onclick="closeMenu()">Beranda</a></li>
        <li><a href="jelajahi.php" onclick="closeMenu()">Jelajahi</a></li>
        <li><a href="belajar.php" onclick="closeMenu()">Belajar</a></li>
        <li><a href="tentang.php" onclick="closeMenu()">Tentang</a></li>
        <li class="user-menu">
            <img src="assets/user.png" width="15px" height="15px" class="user-icon" onclick="toggleDropdown(event)" />
            <div class="user-dropdown" id="userDropdown">
                <a href="logout.php" onclick="closeMenu()">Logout</a>
            </div>
        </li>
    </ul>
</nav>