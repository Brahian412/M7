<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <?php
        if (isset($_SESSION["username"])){
            echo "<h1>User: ".$_SESSION["username"]."</h1>";
        }
        else{
            header("Location: login.php");
        }
 
        try {
            $hostname = "127.0.0.1";
            $dbname = "usuaris";
            $username = "admin";
            $pw = "admin123";
            $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
          } catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }
    ?>
    <h2>Edit Profile</h2>

    <form method="POST">
        <label for="user">Username</label>
        <input type="text" id="user" name="user">
        <br>
        <label for="pass">Password</label>
        <input type="password" id="pass" name="pass">
        <br>
        <label for="mail">Email</label>
        <input type="email" id="mail" name="mail">
        <br>
        <input type="submit" value="Actualitzar dades">
    </form>
    
    <a href="main.php">Torna a Main</a>
    <?php
        if (isset($_POST["user"]) && isset($_POST["pass"]) && isset($_POST["mail"])) {
            $stmt = $pdo ->prepare("UPDATE users SET username=?, pass= sha2(?,256), email=? WHERE username = ?;");            
            $stmt->bindParam(1,htmlspecialchars($_POST["user"])); 
            $stmt->bindParam(2,htmlspecialchars($_POST["pass"])); 
            $stmt->bindParam(3,htmlspecialchars($_POST["mail"])); 
            $stmt->bindParam(4,htmlspecialchars($_SESSION['username'])); 
            $stmt->execute();

            echo"<p>Usuari actualitzat Correctament</p>";
        }   
    ?>
</body>
</html>