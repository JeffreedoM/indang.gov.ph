const dropdownBtn = document.querySelector(".dropdown-btn");
const dropdown = document.querySelector(".dropdown");

/* dropdownBtn.addEventListener('click', dropdownToggle)

function dropdownToggle() {
    dropdown.classList.toggle('show');
} */

document.addEventListener("click", (event) => {
  if (dropdownBtn.contains(event.target)) {
    dropdown.classList.toggle("show");
  } else {
    dropdown.classList.remove("show");
  }
});
