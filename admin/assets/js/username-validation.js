$(document).ready(function () {
  $(".username-check").keyup(function (e) {
    let username = $(".username-check").val();

    $.ajax({
      type: "POST",
      url: "includes/add-brgy.inc.php",
      data: {
        check_username: 1,
        username: username,
      },
      success: function (response) {
        // alert(response);
        $(".username-exists").html(response);
      },
      error: function () {},
    });
  });
});
