<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "codicipostali";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $method = $_SERVER["REQUEST_METHOD"];
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode('/', $uri);

    // Read postal codes of codicipostali
    if ($method == "GET") {
        $urlParts = explode('/', $_SERVER['REQUEST_URI']);
        $lastPart = end($urlParts);
    
        if ($lastPart == 'api_comuni_tpsi' || $lastPart == '') {
            // If the last part is 'api_comuni_tpsi' or empty, get all records
            $sql = "SELECT * FROM codicipostali";
        } elseif (is_numeric($lastPart)) {
            // If the last part is numeric, assume it's a cap
            $sql = "SELECT * FROM codicipostali WHERE cap=$lastPart";
        } else {
            // Otherwise, assume it's a comune
            $lastPart = mysqli_real_escape_string($conn, $lastPart);
            $sql = "SELECT * FROM codicipostali WHERE comune='$lastPart'";
        }
    
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $rows = array();
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        } else {
            echo json_encode(array("code" => 404, "message" => "No results found"));
        }
    }
    
    // Add postal code of a municipality
    if ($method == "POST") {
        $urlParts = explode('/', $_SERVER['REQUEST_URI']);
        $lastPart = end($urlParts);
    
        if ($lastPart == 'add') {
            // If the last part is 'add', add a new record
            $data = json_decode(file_get_contents('php://input'), true);
            if (is_array($data) && isset($data["cap"]) && isset($data["comune"])) {
                $cap = mysqli_real_escape_string($conn, $data["cap"]);
                $comune = mysqli_real_escape_string($conn, $data["comune"]);
    
                $sql = "INSERT INTO codicipostali (cap, comune) VALUES ('$cap', '$comune')";
                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("code" => 200, "message" => "Municipality added successfully"));
                } else {
                    echo json_encode(array("code" => 500, "message" => "Error adding municipality: " . $conn->error));
                }
            } else {
                echo json_encode(array("code" => 400, "message" => "Invalid data"));
            }
        } else {
            echo json_encode(array("code" => 400, "message" => "Invalid URL"));
        }
    }

    // Update postal code of a municipality
    if ($method == "PUT") {
        $urlParts = explode('/', $_SERVER['REQUEST_URI']);
        $lastPart = end($urlParts);
    
        if (is_numeric($lastPart)) {
            // If the last part is numeric, assume it's a cap
            $data = json_decode(file_get_contents('php://input'), true);
            if (is_array($data) && isset($data["comune"])) {
                $municipalityName = mysqli_real_escape_string($conn, $data["comune"]);
    
                $sql = "UPDATE codicipostali SET comune='$municipalityName' WHERE cap=$lastPart";
                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("code" => 200, "message" => "Municipality updated successfully"));
                } else {
                    echo json_encode(array("code" => 500, "message" => "Error updating municipality: " . $conn->error));
                }
            } else {
                echo json_encode(array("code" => 400, "message" => "Invalid data"));
            }
        } else {
            echo json_encode(array("code" => 400, "message" => "Invalid cap"));
        }
    }

    // Delete postal code of a municipality
    if ($method == "DELETE") {
        $urlParts = explode('/', $_SERVER['REQUEST_URI']);
        $lastPart = end($urlParts);
    
        if (is_numeric($lastPart)) {
            // If the last part is numeric, assume it's a cap
            $sql = "DELETE FROM codicipostali WHERE cap=$lastPart";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(array("code" => 200, "message" => "Municipality deleted successfully"));
            } else {
                echo json_encode(array("code" => 500, "message" => "Error deleting municipality: " . $conn->error));
            }
        } else {
            echo json_encode(array("code" => 400, "message" => "Invalid cap"));
        }
    }

    $conn->close();
?>