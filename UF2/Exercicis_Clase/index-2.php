<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ciutats</title>
    <style>
 		body{
 		}
 		table,td {
 			border: 1px solid black;
 			border-spacing: 0px;
 		}
 	</style>
</head>
<body>
    <?php
        $conn = mysqli_connect('localhost','admin','admin123');
        mysqli_select_db($conn, 'world');
        $consulta = "SELECT c.Name as alias, co.Name as nombre FROM city c inner join country co on c.CountryCode = co.Code WHERE CountryCode = '$_POST[countryCode]';";
        $resultat = mysqli_query($conn, $consulta);
        if (!$resultat) {
            $message  = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
            $message .= 'Consulta realitzada: ' . $consulta;
            die($message);
        }
    ?>
    <table>
 	<thead><td colspan="4" align="center" bgcolor="cyan">Llistat de ciutats</td></thead>

	 <?php
 		# (3.2) Bucle while
 		while( $registre = mysqli_fetch_assoc($resultat) )
 		{
			echo "\t<tr>\n";
			echo "\t\t<td>".$registre["alias"]."</td>\n";
            echo "\t\t<td>".$registre["nombre"]."</td>\n";
			echo "\t</tr>\n";
 		}
 	?>
    </table>
</body>
</html>