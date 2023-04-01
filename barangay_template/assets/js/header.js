const dropdownBtn = document.querySelector('.admin__name')
const dropdown = document.querySelector('.admin__name-dropdown')

/* dropdownBtn.addEventListener('click', dropdownToggle)

function dropdownToggle() {
    dropdown.classList.toggle('show');
} */

document.addEventListener("click", (event) => {
    if (dropdownBtn.contains(event.target)) {
        dropdown.classList.toggle('show');
    } else {
        dropdown.classList.remove('show');
    }
});