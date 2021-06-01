<?php

Class User {
  private $pdo;
  public $msgError = "";

    public function connect($name, $host, $user, $password){
      global $pdo; 
      try 
        {
              $pdo = new PDO("mysql:dbname=" .$name.
              ";host=".$host, $user, $password);
        } catch (PDOException $e){
          global $msgError;
          $msgError = $e ->getMessage();
        }  
    }  
    public function register($userName, $userNick, $userPhone, $userEmail, $userPass)
    {
        global $pdo;
        //verify if the user email is alredy registered 
        $sql = $pdo->prepare("SELECT user_Id FROM users WHERE email = :e");
        $sql->bindValue(":e", $userEmail);
        $sql->execute();
        if($sql->rowCount() > 0)
        {
          //email alredy registered 
          return false; 
        }
        else 
        {
          //if not, register 
          $sql = $pdo->prepare("INSERT INTO users (name, nickName, phone, email, passw) VALUES (:n, :nn, :t, :e, :p)");
          $sql->bindValue(":n", $userName);
          $sql->bindValue(":nn", $userNick);
          $sql->bindValue(":t", $userPhone);
          $sql->bindValue(":e", $userEmail);
          $sql->bindValue(":p", md5($userPass));
          $sql->execute();
          return true;
        }
    }
    public function login($userEmail, $userPass){
        global $pdo;
        //verify if email and password is registered, if yes 
        $sql = $pdo->prepare("SELECT user_Id FROM users WHERE email = :e AND passw = :p");
        $sql->bindValue(":e", $userEmail);
        $sql->bindValue(":p", md5($userPass));
        $sql->execute();
        if($sql->rowCount() > 0)
        {
          //private session
          $data = $sql->fetch();

          session_start();
          $_SESSION['user_Id'] = $data['user_Id'];
          return true;
        }
        else
        {
          // added header para test
          header('Location: index.php');
          return false;
        }
    }

    public function searchProperty($str)
    {
      global $pdo;
      $cmd =  $pdo->prepare(
        "SELECT
        p.address,
        r.title,
        r.textReview
      FROM
        property p, review r
      ON
        p.eircode = r.RAircode WHERE r.RAircode = '$str' ");

      $cmd->execute();
      $data = $cmd->fetchAll(PDO::FETCH_ASSOC);
      return $data;

    }

        //Adding a review
    public function insertReview($user,$rTitle, $rReview, $pAddress, $pEircode)
    {
        global $pdo;
          //adding into two different tables
          $sql1 = $pdo->prepare("INSERT INTO review (user_Id ,title, textReview, RAircode) VALUES (:u,:t, :r, :ra)");
          
          $sql1->bindValue(":u", $user);
          $sql1->bindValue(":t", $rTitle);
          $sql1->bindValue(":r", $rReview);
          $sql1->bindValue(":ra", $pEircode);
          $sql1->execute();

          $sql2 = $pdo->prepare("INSERT INTO property (address, eircode) VALUES (:a, :e)");
          $sql2->bindValue(":a", $pAddress);
          $sql2->bindValue(":e", $pEircode);
          $sql2->execute();
          return true;
        }

    public function searchData($id){
        
        global $pdo;
        $cmd = $pdo->prepare("SELECT * FROM users WHERE user_Id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $data = $cmd->fetch();
        return $data;
        }     

    }

