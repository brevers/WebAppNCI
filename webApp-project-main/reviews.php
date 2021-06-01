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
    <title>Reviews</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time();?>">
</head>
<body>
    <div class="header"> <!--nav bar -->
    <a href="index.php"><h1 id = "title">RR</h1></a>
    <h1 id = "title">Rental Rate</h1>
    <h3><a href="index.php">Login</a></h3>
    </div> <!--end nav bar -->

    <form method= "POST">
    <div style="background-image: url('IMAGES/gray.jpg');" id="backgrImage">
        <h1>Search Property</h1> <!--Search by Eircode -->
        <input name="search" id="searchBar" type="text" placeholder="Search by Eircode" maxlength="7">
        <input type="submit" name="submit">
    </div>
    </form>
    <?php
        $con = new PDO("mysql:host=localhost;dbname=webApp", 'root',''); //stablish connection to databases

        if(isset($_POST["submit"])){
            $str = $_POST["search"];
            $sth = $con->prepare("SELECT tb_property.address, tb_review.title, tb_review.review FROM 
            tb_property, tb_review WHERE tb_property.review_id = tb_review.review_id AND tb_property.eircode = '$str'");

            $sth->setFetchMode(PDO:: FETCH_OBJ);
            $sth -> execute();


            if($row = $sth ->fetch()){
                ?>
                <h1 class="Re">Your Results:</h1>
                <div class="ResultsForm">
                    <table>
                        <tr>
                            <div class="contAddress">
                                <?php echo $row->address; ?>
                            </div>
                            <div class="contReview">
                                <br><?php echo $row->title; ?></br>
                                <?php echo $row->review; ?>
                            </div>
                        </tr>
                    </table>
                </div>
                <?php
            }
                else{
                    ?><h1 class="Re">Your Results:</h1><div class="Nodata"><?php
                    echo "No data from this property.    Please, log in and add this property to our database.";
                }
        }

                ?>
                </div>

    <div class="MainReviews"> <!--Showing some reviews -->
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
    <div id="footer">&copy;footer</div>
    <!--This will be only visible when user is logged in -->
</body>
</html>