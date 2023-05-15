const rows = document.querySelectorAll('tr');
const selectedIdInput = document.querySelectorAll('.selected_id');

rows.forEach(row => {
    row.addEventListener('click', () => {
        // get the id of the clicked resident
        const selectedId = row.getAttribute('id');

        // putting the selected id of female or male residents in the hidden input
        selectedIdInput.forEach(input => {
            input.value = selectedId;
        })

        console.log(selectedIdInput.value);

    });
});
