<html>
    <head>
    </head>

    <body>
        <h1>Botiga</h1>
    <form method="post">

        <?php
            $files = file('botiga.txt');
            foreach ($files as $key => $value) {
                echo "<input type='checkbox' name='input".$key."'><label>".$value."</label><br>";
            }
        ?>
        <br>
        <input type="submit">
    </form>
    </body>

</html>