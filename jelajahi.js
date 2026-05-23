document.addEventListener("DOMContentLoaded", () => {
  const dropdownBtn = document.getElementById("dropdownBtn");
  const dropdownMenu = document.getElementById("dropdownMenu");
  const dropdownItems = document.querySelectorAll(".dropdown-item");
  const searchInput = document.getElementById("search-input");
  const cards = document.querySelectorAll(".card");

  let activeRegion = "semua daerah";

  function filterCards() {
    const keyword = searchInput.value.toLowerCase();

    cards.forEach((card) => {
      const title = card.dataset.title.toLowerCase();
      const region = card.dataset.region.toLowerCase();

      const matchSearch = title.includes(keyword);
      const matchRegion =
        activeRegion === "semua daerah" || region === activeRegion;

      card.style.display = matchSearch && matchRegion ? "block" : "none";
    });
  }

  dropdownBtn.addEventListener("click", () => {
    dropdownMenu.classList.toggle("show");
    dropdownBtn.classList.toggle("active");
  });

  dropdownItems.forEach((item) => {
    item.addEventListener("click", () => {
      const region = item.textContent.trim();
      dropdownBtn.textContent = region;
      activeRegion = region.toLowerCase();
      dropdownMenu.classList.remove("show");
      dropdownBtn.classList.remove("active");

      dropdownItems.forEach((i) => i.classList.remove("selected"));
      item.classList.add("selected");

      filterCards();
    });
  });

  searchInput.addEventListener("input", filterCards);

  document.addEventListener("click", (e) => {
    if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
      dropdownMenu.classList.remove("show");
      dropdownBtn.classList.remove("active");
    }
  });
});