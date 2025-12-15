
<hr> determinar si un número no es primo y, además, si precede a otro que sí es primo. <hr/>

<?php
 
function calcularPrimo($numero){

	$numeroDivisibles = [];

	for ($i=1; $i <= $numero; $i++) { 

		if ($numero% $i == 0) {
			$numeroDivisibles[] = $i;
		}
		
	}
	if (count($numeroDivisibles)==2) {
		echo "el " . $numero . " es un numero primo";
		echo "<br>";
	} else {
		echo "el " . $numero . " no es un numero primo";
		echo "<br>";
	}

	echo "el numero que precede al  ". $numero .", el cual es ". $numero+1 .",".  calcularSiguientePrimo($numero+1) ;
	
}

function calcularSiguientePrimo($numero){

	$numeroDivisibles = [];

	for ($i=1; $i <= $numero; $i++) { 

		if ($numero% $i == 0) {
			$numeroDivisibles[] = $i;
		}
		
	}
	if (count($numeroDivisibles)==2) {
		return " es primo";
	} else {
		return " no es primo";
	}	
}

 calcularPrimo(2);