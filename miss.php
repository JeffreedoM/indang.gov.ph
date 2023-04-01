<?php
include './admin/includes/dbh.inc.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./admin/assets/css/main.css" />
    <title>I miss u</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #8DA9B4;
            padding: 0 1rem;
            /* color: #6259A7; */
            /* background: url(./admin//assets/images/deactivated.png); */
        }

        .deactivate-message {
            text-align: center;
            color: white;
            text-shadow: -5px 5px #7999A4;
        }

        .deactivate-message h1 {
            font-size: clamp(1rem, 1rem + 4vw, 4rem);
        }
    </style>
</head>

<body>
    <div class="deactivate-message">
        <h1>Miss ko na kayo guys huhu :( </h1>
        <p>Let's meet up?</p>
    </div>
</body>

</html>