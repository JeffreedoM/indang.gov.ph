const rows = document.querySelectorAll('tr');
const complainantIdInput = document.querySelector('.complainant_id');
const complainantFNameInput = document.querySelector('#complainant_fname');
const complainantLNameInput = document.querySelector('#complainant_lname');
const contactInput = document.querySelector('#contact');
const genderInput = document.querySelector('#gender');
const bdateInput = document.querySelector('#bdate');
const addrInput = document.querySelector('#address');

rows.forEach(row => {
    row.addEventListener('click', () => {
        // get the id of the clicked resident
        const selectedId = row.getAttribute('id');

        // putting the selected id of female or male residents in the hidden input
        complainantIdInput.value = selectedId;

        const complainant_fname = document.querySelector(`#${CSS.escape(selectedId)} td:nth-child(2)`).textContent;
        const complainant_lname = document.querySelector(`#${CSS.escape(selectedId)} td:nth-child(3)`).textContent;
        const contact = document.querySelector(`#${CSS.escape(selectedId)} td:nth-child(4)`).textContent;
        const gender = document.querySelector(`#${CSS.escape(selectedId)} td:nth-child(5)`).textContent;
        const bdate = document.querySelector(`#${CSS.escape(selectedId)} td:nth-child(6)`).textContent;
        const address = document.querySelector(`#${CSS.escape(selectedId)} td:nth-child(7)`).textContent;
        // putting the values in the input name
        complainantFNameInput.value = complainant_fname;
        complainantLNameInput.value = complainant_lname;
        contactInput.value = contact;
        genderInput.value = gender;
        bdateInput.value = bdate;
        addrInput.value = address;


    });
});




