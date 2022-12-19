<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Users</title>
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

<form method='POST'>
    <table border='1px'>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <?php
                $stmt = $pdo ->prepare("SELECT * FROM users;");            
                $stmt->execute();
                $row = $stmt->fetch();
                $count = 0;
                while($row){
                    echo "<tr>
                            <td><input type='number' name='id_".$count."' value='".$row["id"]."' disabled></td>
                            <td><input type='text' name='username_".$count."' value='".$row["username"]."'</td>
                            <td><input type='text' name='email_".$count."' value='".$row["email"]."'</td>
                            <td><input type='text' name='role_".$count."'  value='".$row["role"]."'</td>
                        </tr>";
                    $row = $stmt->fetch();
                    $count++;
                }
        ?>
    </table>
    <input type='submit' value='Guardar'>
</form>

<?php
    for ($i=0; $i < $count; $i++) { 
        $stmt = $pdo ->prepare("UPDATE users u SET username=?, email=?, u.role=? WHERE id = ?;");  
        $stmt->bindParam(1,htmlspecialchars($_POST["username_".$i])); 
        $stmt->bindParam(3,htmlspecialchars($_POST["email_".$i])); 
        $stmt->bindParam(2,htmlspecialchars($_POST["role_".$i])); 
        $stmt->bindParam(4,htmlspecialchars($_POST["id_".$i])); 
        $stmt->execute();
        }
?>
</body>
</html>