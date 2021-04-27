

<?php
require_once __DIR__ . '/../config.php';

try {
    if (!isloggedin()) {
        throw new Exception('You are not logged in', 404);
    }
    require_login();

    echo json_encode([
        'message' => "Successful",
        'code' => 200,
        'userid' => $USER->id,
    ]);

    // print_r($CFG);

} catch (Exception $e) {
    echo json_encode([
        'message' => $e->getMessage(),
        'code' => $e->getCode(),
    ]);
}
