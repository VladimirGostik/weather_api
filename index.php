<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="utf-8">
    <title>Portal</title>
    <link rel="shortcut icon" href="#">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<nav class="navbar navbar-dark bg-dark" aria-label="navbar">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample10" aria-controls="navbarsExample10" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample10">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="visits.php">Visit info</a>
                </li>
            </ul>    
        </div>
    </div>
</nav>
<body class=" bg-dark bg-opacity-10">
    <br>
    <div class="container text-center p-3 mb-2 bg-dark text-white bg-opacity-90">
        <div id="googleMap" class="googleMap">
        </div>
        <div>
            <form class="form" action="index.php" method="post">
                <div class="input-group mb-3">
                    <input name="address" id="pac-input" type="text" class="form-control controls" placeholder="Current address" required>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="date" class="form-label">Arrival Date:</label>
                        <input id="arrival_date" type="date" name="date" class="form-control controls" required>
                    </div>
                    <div class="col">
                        <label for="departure_date" class="form-label">Departure Date:</label>
                        <input id="departure_date" type="date" name="departure_date" class="form-control controls" required>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="input-group mb-3">
                        <input id="btn" type="button" name="submit" class="btn btn-outline-light" value="Submit">
                    </div>
                </div>

            </form>
            <div id="weather">
                <div><b>Sky condition:</b></div>
                <div id="sky"></div><br>
                <div><b>Temperature:</b></div>
                <div id="temp"></div><br>
                <div><b>Wind speed:</b></div>
                <div id="wind"></div><br>
            </div>
            <div id="info" >
                <div><b>GPS location: </b></div>
                <div id="location"></div><br>
                <div><b>Priemerná teplota:</b></div>
                <div id="average_temp"></div><br>
                <div><b>Country: </b></div>
                    <div id="country">
                        <span id="country_flag"></span>
                    </div><br>
                <div><b>Capital city: </b></div>
                <div id="capital"></div><br>
                <div id="city"></div>
                <div><b>Peňažná mena:</b></div>
                <div id="currency">
                    <span id="currency_code"></span> (
                    <span id="currency_conversion"></span> € )
                </div>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2MeRgRdBzfHem-vpeT196rvW3fwZyNWc&callback=initMap&libraries=places&v=weekly" async></script>
</body>

</html>