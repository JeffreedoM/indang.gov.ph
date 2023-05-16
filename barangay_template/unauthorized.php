<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../admin/assets/css/main.css" />
    <title>Unauthorized Access</title>

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
            padding: 0 1rem;
        }

        .deactivate-message {
            text-align: center;
        }

        .deactivate-message h1 {
            font-size: clamp(3rem, 3rem + 5vw, 8rem);
            letter-spacing: 10px;
        }

        button {
            margin-top: 1rem;
            background: blue;
            border: none;
            border-radius: 1.5rem;
        }
        button a {
            color: white;
            text-transform: uppercase;
            font-weight: 900;
            padding: 12px 20px;
            display: block;
        }
    </style>
</head>



<body>
    <div class="deactivate-message">
        <h1>OOPS!</h1>
        <p>Access Denied. You do not have sufficient privileges to access this page.</p>
        <button>
            <a href="./admin/dashboard/">Go to dashboard</a>
        </button>
    </div>
</body>

</html>