<!DOCTYPE html>
<html>
<head>
	<title>Consultas</title>
</head>
<body>
	<?php
		// Conexión a la base de datos
		$servername = "sql10.freesqldatabase.com";
		$username = "sql10606056";
		$password = "am7njyLbMT";
		$dbname = "sql10606056";

		$conn = mysqli_connect($servername, $username, $password, $dbname);

		if (!$conn) {
			die("Conexión fallida: " . mysqli_connect_error());
		}

		// Consulta para obtener los partidos jugados y ganados por cada jugador
		$sql = "SELECT j.nombre, 
               COUNT(pj.id_partido) AS partidos_jugados, 
               COUNT(CASE WHEN p.equipo_local = pj.id_equipo AND p.goles_local > p.goles_visitante 
                          OR p.equipo_visitante = pj.id_equipo AND p.goles_visitante > p.goles_local 
                          THEN pj.id_partido END) AS partidos_ganados
                FROM jugadores j
                JOIN partido_jugador pj ON j.id_jugador = pj.id_jugador
                JOIN partidos p ON p.id_partido = pj.id_partido
                GROUP BY j.nombre";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
			echo "<table>";
			echo "<tr><th>Nombre</th><th>Partidos jugados</th><th>Partidos ganados</th></tr>";

			while ($row = mysqli_fetch_assoc($result)) {
				echo "<tr>";
				echo "<td>" . $row["nombre"] . "</td>";
				echo "<td>" . $row["partidos_jugados"] . "</td>";
				echo "<td>" . $row["partidos_ganados"] . "</td>";
				echo "</tr>";
			}

			echo "</table>";
		} else {
			echo "No se encontraron resultados";
		}

		mysqli_close($conn);
	?>
</body>
</html>
