<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "root", "projet_web2023");

// Récupération des créneaux horaires de cours depuis la base de données
$sql = "SELECT jour FROM creneaucours";

// $result = mysqli_query($conn, $sql);

$result = $conn->query($sql);

// Création d'un tableau pour stocker les créneaux horaires de cours par jour de la semaine
$cours = array(
    "Lundi" => array(),
    "Mardi" => array(),
    "Mercredi" => array(),
    "Jeudi" => array(),
    "Vendredi" => array()
);

// Parcours des résultats de la requête SQL et stockage des créneaux horaires de cours dans le tableau
while ($row = mysqli_fetch_assoc($result)) {
    $jour = $row['jour'];
    $heure_debut = $row['heuredebut'];
    $heure_fin = $row['heurefin'];
    $cours = $row['matiere'];
    $cours[$jour][$heure_fin . " - " . $heure_debut] = $cours;
}



// Affichage de la grille du calendrier
echo '<div class="calendrier">';
echo '<table>';
echo '<thead>';
echo '<tr>';
echo '<th></th>';
echo '<th>Lundi</th>';
echo '<th>Mardi</th>';
echo '<th>Mercredi</th>';
echo '<th>Jeudi</th>';
echo '<th>Vendredi</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

for($heure = 8; $heure < 19; $heure++) {
	echo '<tr>';
        echo '<th>' . $heure . 'h00</th>';

        for($jour = 1; $jour <= 5; $jour++) {
            echo '<td>';

            // Recherche du créneau correspondant à l'heure et au jour actuels
            $creneau = null;
            foreach($creneaux as $c) {
                if($c['heure'] == $heure && $c['jour'] == $jour) {
                    $creneau = $c;
                    break;
                }
            }

            // Affichage du créneau s'il existe
            if($creneau) {
                echo '<div class="creneau">';
                echo '<h4>' . $creneau['matiere'] . '</h4>';
                echo '<p>' . $creneau['enseignant'] . '</p>';
                echo '<p>' . $creneau['salle'] . '</p>';
                echo '<p>' . $creneau['filiere'] . '</p>';
                echo '</div>';
            }

            echo '</td>';
        }

	echo '</tr>';
	echo '<tr>';
	echo '<th>' . $heure . 'h15</th>';

	for($jour = 1; $jour <= 5; $jour++) {
		echo '<td></td>';
	}

	echo '</tr>';
	echo '<tr>';
	echo '<th>' . $heure . 'h30</th>';

	// for($jour = 1; $jour <= 5; $jour++) {
    foreach ($cours as $jour => $creneaux) {
		echo "<td rowspan=\"" . count($creneaux) . "\">" . $jour . "</td>";
	}

	echo '</tr>';
	echo '<tr>';
	echo '<th>' . $heure . 'h45</th>';

	// for($jour = 1; $jour <= 5; $jour++) {
            $i = 0;
            foreach ($creneaux as $heure_debut => $cours) {
                echo "<td>" . $heure_debut . "</td><td>" . $cours . "</td></tr>";
                $i++;
            }
	// }

	echo '</tr>';
}

echo '</tbody>';
echo '</table>';
echo '</div>';
?>
