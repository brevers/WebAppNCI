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
    <title>Rental-Rate</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time();?>">
</head>
<body>
    <div class="header">
    <a href="index.php"><h1 id = "title">RR</h1></a>
    <h1 id = "title">Rental Rate</h1>
    </div>
    <div id="body-form">
        <form method="POST">
            <div class="indexOpt">
                <div>
                    <h2>Login</h2>
                    <input type="email" name="userEmail" placeholder="your e-mail">
                    <input type="password" name="userPass"  placeholder="Your password">
                    <input type="submit" value="Login">
                    <a href="register.php">Still not registered?<strong> Sign-up Here!</strong></a>
                </div>
             </div>
        </form>
            <div class="indexOpt">
                <input type="submit" value="See Reviews" onclick= " window.location.href='reviews.php'">
            </div>
    </div>
<?php
    if(isset($_POST['userEmail']))
    {
        $userEmail = addslashes($_POST['userEmail']);
        $userPass = addslashes($_POST['userPass']);

        if(!empty($userEmail) && !empty($userPass))
        {
            $u-> connect("rentalrate", "localhost", "root", "");
            if($u->msgError == "")
            {
                if($u->login($userEmail, $userPass))
                {
                    header ('Location: private_area.php');
                }
                else
                {
                    ?>
                        <div class="msg-error">
                        Email or Password incorrect!
                        </div>
                    <?php
                }
            }
            else
            {
                ?>
                    <div class="msg-error">
                    <?php echo "Error: ".$u->msgError; ?>
                    </div>
                <?php
            }
        }
        else
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
