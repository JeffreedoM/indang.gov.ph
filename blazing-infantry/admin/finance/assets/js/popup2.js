/*-------------------------------------------------------------------*/
/* Pop=up for adding resident in resident profiling */

let popup = document.querySelector('.popup2')
let modalBg = document.querySelector('.modal-bg2')

function openPopup2() {
    popup.classList.add('open-popup2')
    modalBg.classList.add('modal-bg-active2')
    let modalContentHeight = document.getElementById('modal-container').clientHeight;
    document.getElementsByClassName('modal-bg2')[0].style.minHeight = modalContentHeight + 100 + 'px';
}
function closePopup() {
    popup.classList.remove('open-popup2')
    modalBg.classList.remove('modal-bg-active2')
    modalBg.style.minHeight = '0';
}