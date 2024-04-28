const section = document.querySelector("section"),
  overlay = document.querySelector(".overlay"),
  showBtn = document.querySelector(".show-modal"),
  closeBtn = document.querySelector(".close-btn");

showBtn.addEventListener("click", () => section.classList.add("active"));

overlay.addEventListener("click", () =>
  section.classList.remove("active")
);

closeBtn.addEventListener("click", () =>
  section.classList.remove("active")
);

// document.querySelector('.sidebar-toggle').addEventListener('click', function() {
// document.querySelector('.show-modal').classList.toggle('responsive');
// });