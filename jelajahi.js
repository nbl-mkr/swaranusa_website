document.addEventListener("DOMContentLoaded", () => {
    const dropdownBtn = document.getElementById("dropdownBtn");
    const dropdownMenu = document.getElementById("dropdownMenu");
    const dropdownItems = document.querySelectorAll(".dropdown-item");
    const searchInput = document.getElementById("search-input");

    dropdownBtn.addEventListener("click", () => {
        dropdownMenu.classList.toggle("show");
        dropdownBtn.classList.toggle("active");
    });

    dropdownItems.forEach((item) => {
        item.addEventListener("click", () => {
            const region = item.textContent.trim();
            const search = searchInput.value;
            dropdownMenu.classList.remove("show");
            dropdownBtn.classList.remove("active");

            const params = new URLSearchParams();
            if (region !== "Semua Daerah") params.set("daerah", region);
            if (search) params.set("search", search);
            window.location.href = "jelajahi.php?" + params.toString();
        });
    });

    searchInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            const search = searchInput.value;
            const daerah = dropdownBtn.textContent.trim();
            const params = new URLSearchParams();
            if (daerah !== "Semua Daerah") params.set("daerah", daerah);
            if (search) params.set("search", search);
            window.location.href = "jelajahi.php?" + params.toString();
        }
    });

    document.addEventListener("click", (e) => {
        if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.remove("show");
            dropdownBtn.classList.remove("active");
        }
    });
});