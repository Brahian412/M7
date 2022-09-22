<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Login</title>
</head>
<body>
    <h1 id="response"></h1>
    <?php
        $users = [["aleix","kebab"],["Brahian","123"]];
        
        $username = $_POST["user"];
        $password = $_POST["pass"];

        $exists = false;
        $exists_user = false;
        foreach ($users as $id => $user) {
            if (($user[0] === $username) && ($user[1] === $password)){
                $exists = true;
            }
            elseif (($user[0] === $username) && ($user[1] !== $password)) {
                $exists_user = true;
            }
        }

        if ($exists){
            echo "<script> document.getElementById('response').innerHTML = 'Benvingut ".$username."';</script>";
        }
        elseif ($exists_user) {
            echo "<script> document.getElementById('response').innerHTML = 'Error, wrong password' ;</script>";
        }
        else{
            echo "<script> document.getElementById('response').innerHTML = 'Error, unkwnown username or password' ;</script>";
        }
    ?>
</body>
</html>