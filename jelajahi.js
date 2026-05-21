document.addEventListener("DOMContentLoaded", () => {
  const dropdownBtn = document.getElementById("dropdownBtn");
  const dropdownMenu = document.getElementById("dropdownMenu");
  const dropdownItems = document.querySelectorAll(".dropdown-item");

  dropdownBtn.addEventListener("click", () => {
    dropdownMenu.classList.toggle("show");
    dropdownBtn.classList.toggle("active");
  });

  dropdownItems.forEach((item) => {
    item.addEventListener("click", () => {
      const region = item.textContent;
      dropdownBtn.textContent = region;
      dropdownMenu.classList.remove("show");
      dropdownBtn.classList.remove("active");

      dropdownItems.forEach((i) => i.classList.remove("selected"));
      item.classList.add("selected");
    });
  });

  document.addEventListener("click", (e) => {
    if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
      dropdownMenu.classList.remove("show");
      dropdownBtn.classList.remove("active");
    }
  });
});
