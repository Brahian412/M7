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
    <a href="signUser.php">Log in</a>
    <h1>Sign in</h1>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <br>
        <label for="password">Password: </label>
        <input type="password" id="password" name="password">
        <br>
        <label for="confirmPassword">Confirm Password: </label>
        <input type="password" id="confirmPassword" name="confirmPassword">
        <br>
        <input type="submit">
    </form>

    <?php
        if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["confirmPassword"])) {

            if ($_POST["confirmPassword"] === $_POST["password"]) {
                $query = $pdo->prepare("INSERT INTO users (username,pass) VALUES (?, sha2(? ,256) );");

                $query -> bindParam(1,htmlspecialchars($_POST['username']));
                $query->bindParam(2,htmlspecialchars($_POST['password']));
                $query->execute();
                echo "<p>Usuari Creat</p>";

            }

            else {
                echo "<p>Les contrasenyes no coincideixen</p>";
            }
            
        }
        else{
            echo "<p>Omple tots els Camps</p>";
        }
    ?>

</body>
</html>