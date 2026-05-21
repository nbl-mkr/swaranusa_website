// Burger
function toggleMenu() {
  const nav = document.getElementById("navMenu");
  const hamburger = document.querySelector(".hamburger");
  nav.classList.toggle("active");
  hamburger.classList.toggle("active");
}

function closeMenu() {
  const nav = document.getElementById("navMenu");
  const hamburger = document.querySelector(".hamburger");
  nav.classList.remove("active");
  hamburger.classList.remove("active");
}

// Nutup
document.addEventListener("click", function (event) {
  const nav = document.getElementById("navMenu");
  const hamburger = document.querySelector(".hamburger");
  const isClickInsideNav = nav.contains(event.target);
  const isClickOnHamburger = hamburger.contains(event.target);

  if (
    !isClickInsideNav &&
    !isClickOnHamburger &&
    nav.classList.contains("active")
  ) {
    closeMenu();
  }
});

function setActivePage() {
  const currentPage = window.location.pathname.split("/").pop() || "index.html";

  const navLinks = document.querySelectorAll("nav ul li a");

  navLinks.forEach((link) => {
    link.classList.remove("active");

    const linkHref = link.getAttribute("href");

    if (linkHref === currentPage) {
      link.classList.add("active");
    }

    if (currentPage === "" && linkHref === "index.html") {
      link.classList.add("active");
    }
  });

  updateUnderline();
}

// Garis navbar
function updateUnderline() {
  const activeLink = document.querySelector("nav ul li a.active");
  const navUl = document.querySelector("nav ul");

  if (!activeLink || !navUl) return;

  const linkRect = activeLink.getBoundingClientRect();
  const navRect = navUl.getBoundingClientRect();

  const left = linkRect.left - navRect.left;
  const width = linkRect.width;

  navUl.style.setProperty("--underline-left", `${left}px`);
  navUl.style.setProperty("--underline-width", `${width}px`);
}

// Ganti garis di halaman lain
document.querySelectorAll("nav ul li a").forEach((link) => {
  link.addEventListener("click", function () {
    document
      .querySelectorAll("nav ul li a")
      .forEach((a) => a.classList.remove("active"));

    this.classList.add("active");
    updateUnderline();
  });
});

document.addEventListener("DOMContentLoaded", function () {
  setActivePage();

  window.addEventListener("resize", updateUnderline);
});

window.addEventListener("popstate", setActivePage);

// ===== FUNGSI UNTUK CEK STATUS LOGIN =====
function checkLoginStatus() {
  // Cek apakah user sudah login (ambil dari localStorage)
  const isLoggedIn = localStorage.getItem("isLoggedIn") === "true";
  return isLoggedIn;
}

// ===== FUNGSI UNTUK UPDATE LINK PROFIL =====
function updateProfileLink() {
  const profileLink = document.querySelector(
    'nav ul li a[href*="register.html"], nav ul li a[href*="profil.html"]'
  );

  if (!profileLink) return;

  if (checkLoginStatus()) {
    // Jika sudah login, arahkan ke profil
    profileLink.setAttribute("href", "profil.html");
  } else {
    // Jika belum login, arahkan ke register
    profileLink.setAttribute("href", "register.html");
  }
}

// ===== FUNGSI UNTUK HANDLE KLIK PROFIL =====
function handleProfileClick(event) {
  const profileLink = event.currentTarget;

  if (checkLoginStatus()) {
    // Jika sudah login, biarkan navigasi ke profil
    return true;
  } else {
    // Jika belum login, redirect ke register
    event.preventDefault();
    window.location.href = "register.html";
  }
}

// ===== FUNGSI LOGIN (untuk simulasi) =====
function login(username) {
  localStorage.setItem("isLoggedIn", "true");
  localStorage.setItem("username", username);
  updateProfileLink();
  console.log("User logged in:", username);
}

// ===== FUNGSI LOGOUT (untuk simulasi) =====
function logout() {
  localStorage.removeItem("isLoggedIn");
  localStorage.removeItem("username");
  updateProfileLink();
  window.location.href = "index.html";
  console.log("User logged out");
}

// Jalankan saat halaman dimuat
document.addEventListener("DOMContentLoaded", function () {
  setActivePage();
  updateProfileLink(); // Update link profil sesuai status login

  // Tambahkan event listener untuk link profil
  const profileLink = document.querySelector(
    'nav ul li a[href*="register.html"], nav ul li a[href*="profil.html"]'
  );
  if (profileLink) {
    profileLink.addEventListener("click", handleProfileClick);
  }

  // Update posisi garis saat window di-resize
  window.addEventListener("resize", updateUnderline);
});

// Jalankan saat navigasi (untuk SPA atau penggunaan history API)
window.addEventListener("popstate", setActivePage);
