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
            $dbname = "acces_dades";
            $username = "admin";
            $pw = "admin123";
            $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
          } catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
          }
          
          //preparem i executem la consulta
          $query = $pdo->prepare("select i, a FROM prova");
          $query->execute();
          
          //anem agafant les fileres d'amb una amb una
          $row = $query->fetch();
          while ( $row ) {
            echo $row['i']." - " . $row['a']. "<br/>";
            $row = $query->fetch();
          }
        
          //eliminem els objectes per alliberar memòria 
          unset($pdo); 
          unset($query)
    ?>
</body>
</html>