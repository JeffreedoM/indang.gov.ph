/*-------------------------------------------------------------------*/
/* Pop=up for adding resident in resident profiling */

let popup = document.querySelector('.popup')
let modalBg = document.querySelector('.modal-bg')

function openPopup() {
    popup.classList.add('open-popup')
    modalBg.classList.add('modal-bg-active')
    let modalContentHeight = document.getElementById('modal-container').clientHeight;
    document.getElementsByClassName('modal-bg')[0].style.minHeight = modalContentHeight + 100 + 'px';
}
function closePopup() {
    popup.classList.remove('open-popup')
    modalBg.classList.remove('modal-bg-active')
    modalBg.style.minHeight = '0';
}