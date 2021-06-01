<?php
  require_once 'CLASS/connection.php';
  $u = new User;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time();?>">
</head>
<body>
    <div class="header">
    <a href="index.php"><h1 id = "title">RR</h1></a>
    <h1 id = "title">Rental Rate</h1>
    </div>
    <div id="body-form">
        <form method="POST">
            <h2>Register</h2>
            <input type="text" name="userName" placeholder="Name" maxlength="30">
            <input type="text" name="userNick" placeholder="Nickname"maxlength="20">
            <input type="text" name="userPhone" placeholder="Phone" maxlength="20">
            <input type="email" name="userEmail"  placeholder="your e-mail"maxlength="40">
            <input type="password" name="userPass" placeholder="Your password" maxlength="15">
            <input type="password" name="confPass" placeholder="Confirm password" maxlength="15">
            <input type="submit" value="Sign-up">
        </form>
    </div>
<?php
  //VERIFY IF USER CLICK IN THE BUTTON
  if(isset($_POST['userName']))
  {
      $userName = addslashes($_POST['userName']);
      $userNick = addslashes($_POST['userNick']);
      $userPhone = addslashes($_POST['userPhone']);
      $userEmail = addslashes($_POST['userEmail']);
      $userPass = addslashes($_POST['userPass']);
      $confPass = addslashes($_POST['confPass']);
      //check if the user has filled out the form
      if(!empty($userName) && !empty($userNick) && !empty($userPhone) && !empty($userEmail) && !empty($userPass) && !empty($confPass))
      {
        $u-> connect("rentalrate", "localhost", "root", "");
        if($u->msgError == "") // check if is everything ok
        {
            if($userPass == $confPass)
            {
                if($u->register($userName, $userNick, $userPhone, $userEmail, $userPass))
                {
                  ?>
                    <div id="msg-success">
                      Successfully registered!
                    </div>
                  <?php
                } else
                {
                ?>
                    <div class="msg-error">
                      Email alredy registered!
                    </div>
                <?php
                }
            }
              else
              {
                ?>
                    <div class="msg-error">
                      Password and Confirme Password do not match!
                    </div>
                <?php
              }
        }else
        {
        ?>
          <div class="msg-error">
            <?php echo "Error: ".$u->msgError; ?>
          </div>
        <?php
        }

      } else
      {
        ?>
          <div class="msg-error">
            Fill all the fields!
          </div>
        <?php
      }
  }
?>
<div id="footer">&copy;footer</div>
</body>
</html>