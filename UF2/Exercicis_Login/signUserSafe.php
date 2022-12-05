<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
</head>
<body>
    <?php   
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

    <a href="createUsers.php">Sign In</a>
    <h1>Log in</h1>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <br>
        <label for="password">Password: </label>
        <input type="password" id="password" name="password">
        <br>
        <input type="submit">
    </form>

    <?php
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $stmt = $pdo ->prepare("SELECT * FROM users WHERE username = ? AND pass =  sha2(?,256);");            
            $stmt->bindParam(1,htmlspecialchars($_POST['username']));
            $stmt->bindParam(2,htmlspecialchars($_POST['password']));
            $stmt->execute();
            $row = $stmt->fetch();
            if ($row){
                echo "<p>Benvingut '".$row["username"]."'</p>";
            }
            else{
                echo "<p>Nom o contrasenya Incorrectes</p>";
            }
        }   
    ?>
</body>
</html>