<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php   
        try {
            $hostname = "127.0.0.1";
            $dbname = "world";
            $username = "admin";
            $pw = "admin123";
            $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
          } catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
          }
          ?>

          <form method="POST">
            <input type="text" name="inputNomPais" id="inputNomPais">
            <input type="submit" value="Enviar País">
          </form>



          <?php

          if (isset($_POST['inputNomPais'])) {
            echo "<ul>";
            $query = $pdo->prepare("SELECT c.name as nombre, co.Language as lengua, co.IsOfficial as ofi, co.Percentage as porcentaje FROM country c inner join countrylanguage co on co.CountryCode = c.Code WHERE c.name LIKE CONCAT('%','".$_POST['inputNomPais']."','%') order by c.name;");
            $query->execute();
            
            //anem agafant les fileres d'amb una amb una
            $row = $query->fetch();
            
            while ( $row ) {
                echo "<li>".$row["nombre"]."</li>";

                echo "<tr>";
                    echo "<td>".$row["nombre"]."</td>";
                    echo "<td>".$row["lengua"]."</td>";
                    echo "<td>".$row["ofi"]."</td>";
                    echo "<td>".$row["porcentaje"]."</td>";
                echo "</tr>";
                $row = $query->fetch();
            }
            echo "</ul>";

            //eliminem els objectes per alliberar memòria 
            unset($pdo); 
            unset($query);
            }

    ?>
</body>
</html>