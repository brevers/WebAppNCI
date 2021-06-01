<?php 
    //calling the file connection.php
    require_once 'CLASS/connection.php';
    //Start session logged user
    session_start();
    if(!isset($_SESSION['user_Id']))
    {
      header("Location: index.php");
      exit;
    }else {
      $u = new User;
      //stablish connection to databases
      $u-> connect("rentalrate", "localhost", "root", "");

          
      $information = $u->searchData($_SESSION['user_Id']);

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews-private</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time();?>">
</head>
<body>

    <div class="header">
    <a href="index.php"><h1 id = "title">RR</h1></a>
    <h1 id = "title">Rental Rate</h1>
    <h3><?php echo $information['name'];?><a href="logout.php">Log out</a></h3>
    </div>

    <div id="privateArea">
    <form method= "POST">
    
        <h1>Search Property</h1>
        <input name="search" id="searchBar" type="text" placeholder="Search by Eircode" maxlength="7">
        <input type="submit" name="submit">
    </form>
    </div>
    <?php
        if(isset($_POST["submit"])){

          $str = $_POST["search"];  
          $search = $u->searchProperty($str);
        
          if(count($search) > 0)
          {
            foreach($search as $r)
            { ?>
              <div class="ResultsForm">
                <table>
                  <tr>
                     <div class="contAddress">
                        <?php echo $r['address']; ?>
                      </div>
                      <div class="contReview">
                        <br>
                        <?php echo $r['title']; ?> 
                        </br>
                        <?php echo $r ['textReview']; ?>
                      </div>
                  </tr>
               </table>
             </div>
             <?php 
            } 
          } else
          { ?>
            <h1 class="Re">Your Results:</h1>
            <div class="Nodata"> 
              <?php
                echo "No data from this property.    Please, log in and add this property to our database.";
         ?> </div>  
    <?php } 
    
          }?>
               
          

    <div class="MainReviews">
        <h1>Other Reviews</h1>
        <div class="ReviewContainer">
            <div class="Reviews"><img src="IMAGES/home1.jpg" alt="profile picture1" class="pik"><div class="text"><h4>Wilton PI, Dublin2</h4><p>After living there with my 
                girlfriend for a year we were experiencing serious problems in our lungs due to the mould problem in the house. It is damp and our experience with 
                the landlord was not great. Even though the furniture was undamaged and we took care of the apartment during our stay, he never gave us our deposit back. 
                The location is great, it is a quiet area in a nice neighbourhood with great neigbours.<br> I would give it a 5.3 out of 10 overall </p></div>
            </div>
            <div class="Reviews"><div class="text"><h4>15 New St Gardens, Dublin8</h4><p>I have been very happy throughout my stay in this house, but when we left the 
                landlord took advantage of us. He kicked us out because he wanted to sell the house and the only thing he did was put the rent higher for the
                 next tenants. The only physical problem with that house is that it needs a heating upgrade. <br>I give it an 8 out of 10 </p></div><img src="IMAGES/home2.jpg" alt="profile picture2" class="pik">
            </div>
        </div>
    </div>

    <!--This will be only visible when user is logged in -->
    <div id="ContainerReview">
      <div class="Private">
        <h2>Leave a review of your rental</h2>
        <div class="form2">
          <form method="POST">
            <div class=FName>
              <input type="text" id="fname" name="fname" placeholder="Title" maxlength="30" required>
              <input type="text" id="address" name="address" placeholder="Home Address" required>
              <input type="text" id="eircode" name="eircode" placeholder="Eircode" maxlength="7" required>
            </div>
            <textarea placeholder="Write your review here..." id="TArea" name="textA" rows="5" cols="50" required>
            </textarea>
            <div class="check" required>
              <input type="checkbox" id="acceptP" name="acceptP" value="none" required>
              <label for="acceptP"> I have read and accept the privacy policy</label>
            </div>
              <input type="submit" name="submit1" value="Send Review"> 
          </form>
        </div>
      </div>
        <img src="IMAGES/DublinP.jpg" alt="Dublin logo" class="pictureDublin">
    </div>

    <?php
      // $con = new PDO("mysql:host=localhost;dbname=webApp", 'root',''); //stablish connection to databases
        if(isset($_POST['submit1'])){

          $rTitle = addslashes($_POST['fname']);
          $rReview = addslashes($_POST['textA']);
          $pAddress = addslashes($_POST['address']);
          $pEircode = addslashes($_POST['eircode']);

        if(!empty($rTitle) && !empty($pAddress) && !empty($pEircode) && !empty($rReview)){
          $u-> connect("rentalrate", "localhost", "root", "");
          $user['user_Id'] = $_SESSION['user_Id'];
          echo $user['user_Id'];
          

            if($u-> insertReview($user['user_Id'],$rTitle, $rReview, $pAddress, $pEircode)){
              ?>
                <div id="msg-success">
                  Thank you for your Review!
                </div>
              <?php
            } else{
              ?>
                <div class="msg-error">
                  Something went wrong!
                </div>
              <?php
                  }
        } else{
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