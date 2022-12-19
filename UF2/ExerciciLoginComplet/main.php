<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
   
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
    <ul>
        <li>
            <a href="profile.php">Profile</a>
        </li>
        <?php
            $stmt = $pdo ->prepare("SELECT u.role as rol FROM users u where username = ?");            
            $stmt->bindParam(1,htmlspecialchars($_SESSION["username"])); 
            $stmt->execute();
            $row = $stmt->fetch();
            if ($row["rol"] === "admin"){
                echo"<li><a href='admin_users.php'>Admin Users</a></li>";
            }
        ?>
        <li>
            <a href="logout.php">Log out</a>
        </li>
    </ul>
</body>
</html>