<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$conn = new PDO($dsn, $username, $password);

$country = filter_input(INPUT_GET, 'country', FILTER_SANITIZE_STRING);
$lookup  = filter_input(INPUT_GET, 'lookup', FILTER_SANITIZE_STRING);

if ($lookup === 'cities') {
    // CITY LOOKUP
    $stmt = $conn->prepare(
        "SELECT cities.name, cities.district, cities.population
         FROM cities
         JOIN countries ON cities.country_code = countries.code
         WHERE countries.name LIKE :country"
    );

    $like_country = "%" . $country . "%";
    $stmt->bindParam(':country', $like_country, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output cities table
    echo "<table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>District</th>
                    <th>Population</th>
                </tr>
            </thead>
            <tbody>";

    foreach ($results as $row) {
        echo "<tr>
                <td>" . htmlentities($row['name']) . "</td>
                <td>" . htmlentities($row['district']) . "</td>
                <td>" . htmlentities($row['population']) . "</td>
              </tr>";
    }

    echo "</tbody></table>";

} else {
    // COUNTRY LOOKUP
    if ($country) {
        $stmt = $conn->prepare(
            "SELECT name, continent, independence_year, head_of_state
             FROM countries
             WHERE name LIKE :country"
        );

        $like_country = "%" . $country . "%";
        $stmt->bindParam(':country', $like_country, PDO::PARAM_STR);
        $stmt->execute();

    } else {
        // If country is empty -> return ALL countries
        $stmt = $conn->query(
            "SELECT name, continent, independence_year, head_of_state
             FROM countries"
        );
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output countries table
    echo "<table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Continent</th>
                    <th>Independence Year</th>
                    <th>Head of State</th>
                </tr>
            </thead>
            <tbody>";

    foreach ($results as $row) {
        echo "<tr>
                <td>" . htmlentities($row['name']) . "</td>
                <td>" . htmlentities($row['continent']) . "</td>
                <td>" . htmlentities($row['independence_year']) . "</td>
                <td>" . htmlentities($row['head_of_state']) . "</td>
              </tr>";
    }

    echo "</tbody></table>";
}
?>
