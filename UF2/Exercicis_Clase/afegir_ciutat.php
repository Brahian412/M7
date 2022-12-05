<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afegir Pais</title>
</head>
<body>
<?php
 		# (1.1) Connectem a MySQL (host,usuari,contrassenya)
 		$conn = mysqli_connect('127.0.0.1','admin','admin123');
 
 		# (1.2) Triem la base de dades amb la que treballarem
 		mysqli_select_db($conn, 'world');
 
 		# (2.1) creem el string de la consulta (query)
 		$consulta = "SELECT * FROM country;";
 
 		# (2.2) enviem la query al SGBD per obtenir el resultat
 		$resultat = mysqli_query($conn, $consulta);
 
 		# (2.3) si no hi ha resultat (0 files o bé hi ha algun error a la sintaxi)
 		#     posem un missatge d'error i acabem (die) l'execució de la pàgina web
 		if (!$resultat) {
     			$message  = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
     			$message .= 'Consulta realitzada: ' . $consulta;
     			die($message);
 		}
 	?>
 
 	<form method="POST">
     <label for="codi_pais">Tria pais:</label>
    <select id="codi_pais" name="codi_pais">
 	<?php
 		# (3.2) Bucle while
 		while( $registre = mysqli_fetch_assoc($resultat) )
 		{
 			# els \t (tabulador) i els \n (salt de línia) son perquè el codi font quedi llegible
   
 			# (3.4) cadascuna de les columnes ha d'anar precedida d'un <td>
 			#	després concatenar el contingut del camp del registre
 			#	i tancar amb un </td>
 			echo "\t\t<option value=".$registre["Code"]." >".$registre["Name"]."</option>\n";

 		}
 	?>
  	<!-- (3.6) tanquem la taula -->
      </select>
        <br>
        <label for="nom_ciutat">Nom de la ciutat:</label>
        <input type="text" id="nom_ciutat" name="nom_ciutat">
        <br>
        <label for="poblacio">Poblacio:</label>
        <input type="number" id="poblacio" name="poblacio">
        <br>
        <input type="submit" value="Afegir_Ciutat">
    </form>

    <a href="index.php">Tornar a l'inici</a>

    <?php
        if (isset($_POST["codi_pais"])) {
            $consulta = "SELECT COUNT(*) as contador FROM city c inner join country co on c.CountryCode = co.Code WHERE co.Code='".$_POST["codi_pais"]."' && c.Name='".$_POST["nom_ciutat"]."';";
            $resultat = mysqli_query($conn, $consulta);
            $potCrear = false;
            while( $registre = mysqli_fetch_assoc($resultat) ){
                if ($registre['contador'] == 0) {
                    $potCrear = true;
            	}

            }
            if ($potCrear) {

                $consulta = "INSERT INTO city (city.Name, city.CountryCode, city.Population) VALUES ('".$_POST["nom_ciutat"]."','".$_POST["codi_pais"]."','".$_POST["poblacio"]."');";
				
                $resultat = mysqli_query($conn, $consulta);
                echo "<div class='missatge'>Ciutat afegida correctament</div>";
            }
            else{
                echo "<div class='missatge'>Aquesta ciutat ja existeix en aquest país</div>";

            }
        }
    ?>

</body>
</html>