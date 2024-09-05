<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("config.php");

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected succesfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$sql = "SELECT Country FROM visits GROUP BY Country";

$stmt = $conn->prepare($sql);
$stmt->execute();
$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT Code FROM visits GROUP BY Code";

$stmt = $conn->prepare($sql);
$stmt->execute();
$codes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT count(*) FROM visits GROUP BY Country";

$stmt = $conn->prepare($sql);
$stmt->execute();
$counts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT count(*) FROM visits WHERE HOUR(`Time`) BETWEEN '6:00:00' AND '15:00:00'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$time1 = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT count(*) FROM visits WHERE HOUR(`Time`) BETWEEN '15:00:00' AND '21:00:00'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$time2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT count(*) FROM visits WHERE HOUR(`Time`) BETWEEN '21:00:00' AND '24:00:00'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$time3 = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT count(*) FROM visits WHERE HOUR(`Time`) BETWEEN '00:00:00' AND '06:00:00'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$time4 = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Portal visits</title>
</head>
<nav class="navbar navbar-dark bg-dark" aria-label="navbar">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample10" aria-controls="navbarsExample10" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample10">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
            </ul>    
        </div>
    </div>
</nav>

<body class="bg-dark text-dark bg-opacity-10">
    <div class="container text-center">
        <div>
            <h4>Visits</h4>
            <table class="table">
                <thead>
                    <th>Country</th>
                    <th>Flag</th>
                    <th>Number of visits</th>
                </thead>
                <tbody>
                    <?php
                    if (count($countries) != 0) {
                        $i = 0;
                        foreach ($countries as $country) {
                            $imagelink = 'https://www.geonames.org/flags/x/' . strtolower($codes[$i]['Code']) . '.gif';
                            $altcode = $codes[$i]['Code'];
                            echo "<tr>
                                        <td><button class='btn countryButton' id='countryButton'>".$country['Country']."</button></td>
                                        <td><img src=$imagelink alt=$altcode border=1 height=30 width=50></img></td>
                                        <td>{$counts[$i]['count(*)']}</td>
                                    </tr>";
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div>
            <h4>Time info</h4>
            <table class="table">
                <thead>
                    <th>Time range</th>
                    <th>Number of visits</th>
                </thead>
                <tbody>
                    <tr>
                        <td>6:00-15:00</td>
                        <?php
                        echo " <td>{$time1[0]['count(*)']}</td>";
                        ?>
                    </tr>
                    <tr>
                        <td>15:00-21:00</td>
                        <?php
                        echo " <td>{$time2[0]['count(*)']}</td>";
                        ?>
                    </tr>
                    <tr>
                        <td>21:00-24:00</td>
                        <?php
                        echo " <td>{$time3[0]['count(*)']}</td>";
                        ?>
                    </tr>
                    <tr>
                        <td>24:00-6:00</td>
                        <?php
                        echo " <td>{$time4[0]['count(*)']}</td>";
                        ?>
                    </tr>


                </tbody>
            </table>
        </div>
    </div>
    <div id="newLayer" class="newLayer"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2MeRgRdBzfHem-vpeT196rvW3fwZyNWc&callback=initMap&libraries=places&v=weekly" async></script>
    <script src="js/visits.js"></script>

</body>

</html>