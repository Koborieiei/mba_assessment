<?

// namespace assessment;

require_once '../configpdo/db.class.php';
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header(
    'Access-Control-Allow-Headers: Authorization, Content-Type,Accept, Origin'
);

$db = new DB();
print_r($questionIdArray);

$jsonData = json_decode(file_get_contents('php://input'), true);
print_r($jsonData);

try {
    storeTransaction();
    storeQuestionRating();
} catch (\Throwable $th) {
    //throw $th;
}

function storeQuestionRating()
{
// $questionIdArray = json_decode($_POST['questionid'],true);

    global $db;
    global $jsonData;
    $transectionId = getTransectionId();
    unset($jsonData['questions']['selectedteacher']);
    foreach ($jsonData['questions'] as $key => $value) {
        // if ($key === "textbox" && $value !== " ") {
        switch ($key) {
            case 'textbox':
                $db->bind('msg', $value);
                $query = $db->query("INSERT INTO asm_comment (comment_message,transection_id) VALUES (:msg,$transectionId)");
                break;
            default:
                $query = $db->query("INSERT INTO asm_rating (transection_id,question_id,score) VALUES($transectionId,$key,$value)");
                break;
        }

    }

}

function storeComment()
{
// foreach($questionIdArray as $value) {
    //     $query = $db->query("INSERT INTO asm_rating (user_id,question_id,score) VALUES(1,$value,4)");
    // }
    global $db;
    $transactionId = getTransectionId();
    $db - query("INSERT INTO asm_comment (comment_message,transection_id) VALUES ($textboxMessage, $transactionId)");
}

function storeTransaction()
{
    global $db;
    // $userId = 1;

    global $jsonData;
    $userId = $jsonData['u_id'];
    $assessmentId = $jsonData['assessment_id'];
    $teacherId = $jsonData['questions']['selectedteacher'];

    $db->bindMore(
        [
            'userId' => $userId,
            'assessmentId' => $assessmentId,
            'teacherId' => $teacherId,
        ]
    );
    $db->query("INSERT INTO asm_transection (assetmentform_id,user_id,teacher_id) VALUES (:assessmentId,:userId ,:teacherId)");
}

function getCommentId()
{
    // return $db->single('SELECT ');
}

function getTransectionId()
{
    global $db;
    global $jsonData;
    $userId = $jsonData['u_id'];

    $db->bind('userId', $userId);
    return $db->single('SELECT id FROM asm_transection WHERE user_id = :userId');
}
