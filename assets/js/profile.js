const toggle = document.getElementById("toggle-financeiro");
const submenu = document.getElementById("submenu-financeiro");
const arrow = document.getElementById("arrow");

toggle.addEventListener("click", function (e) {
  e.preventDefault();
  submenu.classList.toggle("hidden");
  arrow.textContent = submenu.classList.contains("hidden") ? "▼" : "▲";
});
