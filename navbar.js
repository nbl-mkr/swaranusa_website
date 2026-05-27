function toggleDropdown(event) {
    event.stopPropagation();
    const dropdown = document.getElementById("userDropdown");
    dropdown.classList.toggle("open");
}

document.addEventListener("click", function () {
    const dropdown = document.getElementById("userDropdown");
    if (dropdown) dropdown.classList.remove("open");
});