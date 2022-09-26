<p>En un arxiu PHP es comença escrivint en HTML</p>
 
    <?php

    
    //echo "<p>Aquesta línia l'hem escrita en PHP</p>";
    $s = 10;  //columnas
    $f = 10;  // filas
    /*
    echo "<table border : '2px'>";
        echo "<tr>";
            for ($i=0; $i < $s; $i++) {
                echo "<td>".chr($i+65)."</td>";
            }
        echo "</tr>";
        echo "<tr>";
            for ($i=0; $i < $s; $i++) {
                echo "<td>$i</td>";
            }
        echo "</tr>";
    echo "</table>";

    echo "<p> <br> </p>"; //Salto de línia
    */

    $fragata = [1,4];
    $submarino = [2,3];
    $destructor = [3,2];
    $portaAviones = [4,1];
    $conjuntVaixells = array();
    array_push($conjuntVaixells, $portaAviones, $destructor, $submarino, $fragata);
    //$conjuntVaixells = [[4,1],[3,2],[2,3],[1,4]]

    // [   [[1,1]], [[2,1],[2,2]], [[3,1],[3,2],[3,3]], [[4,1],[4,2],[4,3],[4,4]]   ]  4 frags, 3 subs, 2 destr, 1 porta


    // [ [[]],[[]] ,[[]] ,[[]] ,    [[],[]], [[],[]], [[],[]],     [[],[],[]] , [[],[],[]]      [[],[],[],[]] ]


    $flota = array(); //[]

    //FUNCIÓ QUE RETORNA UN ARRAY AMB UNA POSICIÓ 'X' I UNA POSICIÓ 'Y' ([X,Y]) ALEATORIA QUE NO ES TROBI AL ARRAY DE FLOTA
    function numRandomOutArray($flota,$s,$f){
        $num_valid = false;          
        while ($num_valid === false){
            $num_in_array = false;
            $random1 = rand(1,$s-1);
            $random2 = rand(1,$f-1);
            foreach ($flota as $posicioLlista => $valorVaixell){
                foreach ($valorVaixell as $posicioSubLlista => $posicioVaixell){
                    if (($random1 === $posicioVaixell[0]) && ($random2 === $posicioVaixell[1])){
                        $num_in_array = true;
                    }
                }
            }
            if ($num_in_array == false){
                $num_valid = true;
            }
        }
        return [$random1,$random2];
    }

    function numInArray($flota,$array){
        $num_in_array = false;
        $random1 = $array[0];
        $random2 = $array[1];
        foreach ($flota as $posicioLlista => $valorVaixell){
            foreach ($valorVaixell as $posicioSubLlista => $posicioVaixell){
                if (($random1 === $posicioVaixell[0]) && ($random2 === $posicioVaixell[1])){
                    $num_in_array = true;
                }
            }
        }
        if ($num_in_array == false){
            return false;
        }
        return true;
    }

    function arrayNums1to4Random($array_nums){
        shuffle($array_nums);
        return $array_nums;
    }

    //$conjuntVaixells = [[4,1],[3,2],[2,3],[1,4]]
    foreach ($conjuntVaixells as $index => $valor){
        for ($i = 1; $i <= $valor[1]; $i++){ //for que iterará el numero de barcos necesarios (de fragatas 4, de portaaviones 1...)
            if ($valor[0] === 1){ //$valor[0] tamano del barco, en este caso 1 (fragata)
                $vaixells = array();
                $vaixell = numRandomOutArray($flota,$s,$f); //--> [1,2] posicion [x,y]
                array_push($vaixells,$vaixell); //[[1,2]]  --> 1 barco completo
                array_push($flota,$vaixells); // [[[1,2]],] --->barco completo

            }
            //Caso que sea un barco de tamano superior a 1
            else{
                $vaixells = array();
                //TENGO QUE HACER QUE AQUÍ ITERE EL NUMERO DE VECES COMO POSICIONES TIENE VAIXELLS
                for($num_posicions = 1; $num_posicions <= $valor[0]; $num_posicions++){

                    $num_valid = false;
                    if (( (isset($vaixells) === false) ) || count($vaixells) === 0 || count($vaixells) >= $valor[0]){    //Caso en el que sea la primera posicion a colocar del barco, ya que las importantes son las siguientes
                        while ($num_valid === false){
                            $vaixell = numRandomOutArray($flota,$s,$f);
                            
                            $der_cubierta = false;
                            $abaj_cubierta = false;
                            $izq_cubierta = false;
                            $arr_cubierta = false;
    
                            //si llega aqui significa que tiene un valor que no esta en la lista, falta comprovar que tenga hueco para poner el resto de sus piezas
                            for ($p = 1; $p<$valor[0]; $p++){  //for para que vea si tiene hueco, comprueba que lo tenga tanto arriba como abajo como derecha o izq
                                foreach ($flota as $posicioLlista => $valorVaixell){
                                    foreach ($valorVaixell as $posicioSubLlista => $posicioVaixell){
                                        if (($vaixell[0] + $p === $posicioVaixell[0]) && ($vaixell[1] === $posicioVaixell[1]) && ($vaixell[0] + $p <= $s)){
                                            $der_cubierta = true;
                                        }
                                        elseif (($vaixell[0] === $posicioVaixell[0]) && ($vaixell[1] + $p === $posicioVaixell[1]) && ($vaixell[1] + $p <= $f)){
                                            $abaj_cubierta = true;
                                        }
                                        elseif (($vaixell[0] - $p === $posicioVaixell[0]) && ($vaixell[1] === $posicioVaixell[1]) && ($vaixell[0] - $p >= 1)){
                                            $izq_cubierta = true;
    
                                        }elseif (($vaixell[0] === $posicioVaixell[0]) && ($vaixell[1] - $p === $posicioVaixell[1]) && ($vaixell[1] - $p >= 1)){
                                            $arr_cubierta = true;
                                        }
                                    }
                                }
                            }
                            //comprueba que tenga hueco
                            if ( ($der_cubierta == false) || ($abaj_cubierta == false) || ($izq_cubierta == false) || ($arr_cubierta == false)){ 
                                $num_valid = true;
                            }
                        }
                        array_push($vaixells,$vaixell);
                    }
                    else{ //Cuando el barco mide mas de 0, por lo que se ha escogido la primera posicion
                                                
                        if (count($vaixells) === 1){   //El array solo tiene un barco, solo hay que mirar su anterior y decidir su direccion
                            $der_cubierta = false;
                            $abaj_cubierta = false;
                            $izq_cubierta = false;
                            $arr_cubierta = false;
                            
                            $last_vaixell = $vaixells[count($vaixells)-1]; //coordernadas ultimo barco

                            //lista de fors que comprueba si los siguientes barcos caben
                            for ($z=1; $z<$valor[0]; $z++){
                                $new_vaixell = array();
                                $new_vaixell = [$last_vaixell[0]+$z, $last_vaixell[1]];
                                if (numInArray($flota, $new_vaixell) || $new_vaixell[0] >= $s ) {
                                    $der_cubierta = true;
                                }
                            }

                            for ($z=1; $z<$valor[0]; $z++){
                                $new_vaixell = array();
                                $new_vaixell = [$last_vaixell[0]-$z, $last_vaixell[1]];
                                if (numInArray($flota, $new_vaixell) || $new_vaixell[0] < 1 ) {
                                    $izq_cubierta = true;
                                }
                            }

                            for ($z=1; $z<$valor[0]; $z++){
                                $new_vaixell = array();
                                $new_vaixell = [$last_vaixell[0], $last_vaixell[1]+$z];
                                if (numInArray($flota, $new_vaixell) || $new_vaixell[1] >= $f ) {
                                    $abaj_cubierta = true;
                                }
                            }

                            for ($z=1; $z<$valor[0]; $z++){
                                $new_vaixell = array();
                                $new_vaixell = [$last_vaixell[0], $last_vaixell[1]-$z];
                                if (numInArray($flota, $new_vaixell) || $new_vaixell[1] < 1 ) {
                                    $arr_cubierta = true;
                                }
                            }

                            //                    1               2               3            4
                            $array_probs = array();
                            $array_probs = [$der_cubierta, $izq_cubierta, $abaj_cubierta, $arr_cubierta];
                            $array_probsNum = array();
                            foreach ($array_probs as $indice => $cubierta) {
                                if ($cubierta === false){
                                    array_push($array_probsNum, $indice+1);
                                }
                            }

                            $array_probsNum = arrayNums1to4Random($array_probsNum);


                            if ($array_probsNum[0] == 1){
                                $random1 = $vaixells[count($vaixells)-1][0]+1;
                                $random2 = $vaixells[count($vaixells)-1][1];
                            }
                            elseif ($array_probsNum[0] == 2){
                                $random1 = $vaixells[count($vaixells)-1][0]-1;
                                $random2 = $vaixells[count($vaixells)-1][1];
                            }
                            elseif ($array_probsNum[0] == 3){
                                $random1 = $vaixells[count($vaixells)-1][0];
                                $random2 = $vaixells[count($vaixells)-1][1]+1;
                            }
                            elseif ($array_probsNum[0] == 4){
                                $random1 = $vaixells[count($vaixells)-1][0];
                                $random2 = $vaixells[count($vaixells)-1][1]-1;
                            }

                            $vaixell = array();
                            $vaixell = [$random1,$random2];
                            array_push($vaixells,$vaixell);
                            

                        }
                        else{  //el array posee mas de un barco por lo tanto hay que mirar su direccion para que vaya recto
                            
                            
                            if ($array_probsNum[0] == 1){
                                $random1 = $vaixells[count($vaixells)-1][0]+1;
                                $random2 = $vaixells[count($vaixells)-1][1];
                            }
                            elseif ($array_probsNum[0] == 2){
                                $random1 = $vaixells[count($vaixells)-1][0]-1;
                                $random2 = $vaixells[count($vaixells)-1][1];
                            }
                            elseif ($array_probsNum[0] == 3){
                                $random1 = $vaixells[count($vaixells)-1][0];
                                $random2 = $vaixells[count($vaixells)-1][1]+1;
                            }
                            elseif ($array_probsNum[0] == 4){
                                $random1 = $vaixells[count($vaixells)-1][0];
                                $random2 = $vaixells[count($vaixells)-1][1]-1;
                            }
                            $vaixell = array();
                            $vaixell = [$random1,$random2];
                            array_push($vaixells,$vaixell);


                        }
                
                    }
                }

                array_push($flota,$vaixells); // [ [[1,2]],...] --->barco Completo

            }
        }
    }


    //LECTURA DEL TAULELL

    echo "<table border : '2px'>";

    for ($j=0; $j < $f; $j++){
        echo "<tr>";
        for ($i=0; $i < $s; $i++) {

            if (($j==0) &&  ($i != 0)){
                echo "<td>$i</td>";
            }

            else{

                if ($i==0 && $j!=0){
                    echo "<td>".chr($j+64)."</td>";
                }
                else{
                    $comp = false;

                    //en principio index hay del 0-3 y valores son arrays como por ejemplo destructor
                    foreach ($flota as $index => $valor){
                        foreach($valor as $subindex => $posicio){
                            if ($j === $posicio[0] && $i === $posicio[1]){
                                if (count($valor)===1){
                                    echo "<td> <p style='color:blue'>X</p></td>";
                                    $comp = true;
                                }
                                elseif (count($valor)===2){
                                    echo "<td> <p style='color:green'>X</p></td>";
                                    $comp = true;
                                }
                                elseif (count($valor)===3){
                                    echo "<td> <p style='color:yellow'>X</p></td>";
                                    $comp = true;

                                }
                                elseif (count($valor)===4){
                                    echo "<td> <p style='color:red'>X</p></td>";
                                    $comp = true;
                                }
                            }
                        }
                    }
                    if ($comp == false){
                        echo "<td></td>";
                    }
                }
            }
        }
        echo "</tr>";
    }
    
    echo "</table>";

    ?>

 
<p style="color:red">Aquesta línia torna a ser HTML</p>

