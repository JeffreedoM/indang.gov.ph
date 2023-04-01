$(document).ready(function () {
    $('.barangay-check').keyup(function (e) {

        let brgyName = $('.barangay-check').val();

        $.ajax({
            type: "POST",
            url: "includes/add-brgy.inc.php",
            data: {
                "check_submit_btn": 1,
                "brgy-name": brgyName,
            },
            success: function (response) {
                // alert(response);
                $('.barangay-exists').html(response);
            },
            error: function () {
            }
        });
    });
});

