const rows = document.querySelectorAll('tr');
const medicineNameInput = document.querySelector('#medicine_name');
const medicineIdInput = document.querySelector('#medicine_id');


rows.forEach(row => {
    row.addEventListener('click', () => {
        // get the id of the clicked resident
        const medicineId = row.getAttribute('id');
        // putting the id in the hidden input
        medicineIdInput.value = medicineId;

        // getting the right resident name of the clicked resident
        const medicine_name = document.querySelector(`#${CSS.escape(medicineId)} td:nth-child(2)`).textContent;
        // putting the resident name in the input name 
        medicineNameInput.value = medicine_name;

        //close the popup
        closePopup();

    });
});
