// Set up an event listener for when the user submits the form
$('#myForm').submit(function (event) {
    event.preventDefault(); // Prevent the form from submitting normally

    // Get the value of the position field from the form
    var position = $('#position').val();

    // Make an AJAX request to the server to check if the position is already occupied
    $.ajax({
        url: 'includes/add-officials.inc.php',
        method: 'POST',
        data: { position: position },
        dataType: 'json',
        success: function (response) {
            if (response.occupied) {
                // If the position is occupied, display an error message
                $('#positionError').text('This position is already occupied.');
            } else {
                // If the position is available, submit the form
                $('#myForm').off('submit').submit();
            }
        },
        error: function () {
            // If there was an error with the AJAX request, display an error message
            $('#positionError').text('There was an error checking if this position is available. Please try again later.');
        }
    });
});
