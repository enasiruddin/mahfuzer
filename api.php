<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$filename = 'switches.json';

// Initialize switch states if the file doesn't exist
if (!file_exists($filename)) {
    $initialStates = json_encode([0, 0, 0, 0]);
    file_put_contents($filename, $initialStates);
}

// Read the current switch states
$switches = json_decode(file_get_contents($filename), true);

// Handle GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($switches);
    exit;
}

// Handle POST request for individual switch update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Validate input
    if (isset($data['switch_number']) && isset($data['state'])) {
        $switch_number = $data['switch_number'];
        $state = $data['state'];

        // Update the specific switch state
        if ($switch_number >= 0 && $switch_number < count($switches)) {
            $switches[$switch_number] = $state;
            file_put_contents($filename, json_encode($switches));
            echo json_encode(['message' => 'Switch state updated successfully']);
            exit;
        } else {
            echo json_encode(['error' => 'Invalid switch number']);
            http_response_code(400);
            exit;
        }
    } else {
        echo json_encode(['error' => 'Invalid input']);
        http_response_code(400);
        exit;
    }
}
?>
