<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');

header('Content-Type: application/json; charset=utf-8');

switch ($_SERVER['REQUEST_METHOD']) {
    case "POST":

        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected succesfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        $sql = "INSERT INTO visits (Country, Code, City, Locality, Time) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$data['country'], $data['code'], $data['city'], $data['locality'], $data['time']]);

        break;

    case "GET":

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected succesfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        if (isset($_GET['country'])) {
            $country = $_GET['country'];

            $sql = "SELECT City FROM visits WHERE Country = (?) GROUP BY City";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$country]);

            $city = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($city);
        } else if(isset($_GET['count'])) {
            $city = $_GET['count'];

            $sql = "SELECT count(*) FROM visits WHERE City = (?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$city]);

            $city = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($city);
        } else {
            $sql = "SELECT * FROM visits";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $city = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($city);
        }

        break;
}
