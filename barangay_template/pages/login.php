<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./assets/css/main.css" />
  <title>Login</title>
</head>

<body class="login-body">

  <div class="login">

    <div class="login__desc">
      <p class="login__p1">Hello! let's get started</p>
      <p class="login__p2">Sign in to continue.</p>
    </div>

    <!-- login -->
    <form action="login.php" method="POST" class="login__form">
      <div>
        <input type="text" name="username" id="username" placeholder="Username" required>
      </div>
      <div>
        <input type="password" name="password" id="password" placeholder="Password" required>
      </div>
      <button type="submit" name="submit">SIGN IN</button>
    </form>
    <div class="create-account">
      <span>Don't have an account?</span>
      <a href="signup.php">Create</a>
    </div>


  </div>

</body>

</html>