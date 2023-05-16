const burgerMenu = document.querySelector('.burger-menu');
const burgerMenu2 = document.querySelector('.burger-menu2');
const sideBar = document.querySelector('.sidebar');
const mainContent = document.querySelector('.main-content');

burgerMenu.addEventListener('click', () => {
    sideBar.classList.toggle('close');
    mainContent.classList.toggle('close');
    subMenu.classList.remove('dropdown')
    arrowDownIcon.style.transform = ""
})

burgerMenu2.addEventListener('click', () => {
    sideBar.classList.toggle('mobile');
})

window.onresize = function (event) {
    const mediaQuery = window.matchMedia('(max-width: 768px)')
    // Check if the media query is true
    if (mediaQuery.matches) {
        sideBar.classList.remove('close');
    } else {
        mainContent.classList.remove('close');
    }
};