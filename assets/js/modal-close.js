document.querySelectorAll(".open-modal").forEach(button => {
    button.addEventListener("click", () => {
      const modalId = button.getAttribute("data-modal");
      const modal = document.getElementById(modalId);
      if (modal) {
        modal.classList.remove("hidden");
      }
    });
});

document.querySelectorAll(".close-modal, .nao-btn button").forEach(button => {
    button.addEventListener("click", (e) => {
      e.preventDefault(); 
      const modal = e.target.closest(".modal-overlay");
      if (modal) {
        modal.classList.add("hidden");
      }
    });
});

window.addEventListener("click", (e) => {
    if (e.target.classList.contains("modal-overlay")) {
      e.target.classList.add("hidden");
    }
});