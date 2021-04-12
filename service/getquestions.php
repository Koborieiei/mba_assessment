<?php
require_once '../configpdo/db.class.php';
require_once __DIR__ . '/class/Lmsapi.class.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header(
    'Access-Control-Allow-Headers: Authorization, Content-Type,Accept, Origin'
);

try {

    if (!isset($_GET['courseid']) || !isset($_GET['uid'])) {
        throw new Exception('Invalid Parameters', 404);
    }

    $db = new DB();
    $lms = new Lms();
    $courseId = $_GET['courseid'];
    $userid = $_GET['uid'];

    // if (hasTransection($userid)) {
    //     throw new Exception('You have evaluated already', 208);
    // }

    // echo hasTransection($userid);
    $assetmentId = getAssesmentId($courseId);
    $questions = createAsessmentForm($assetmentId);

    echo json_encode($questions, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (Exception $e) {
    echo json_encode([
        "message" => $e->getMessage(),
        "code" => $e->getCode(),
    ], JSON_PRETTY_PRINT);
}

function getQuestions($assetmentId)
{
    global $db;
    $db->bind('assetmentid', $assetmentId);
    return $db->query('SELECT * FROM asm_questions WHERE assetmentform_id = :assetmentid');
}

function getAssesmentId($courseid)
{
    global $db;
    $db->bind('courseid', $courseid);
    return $db->single("SELECT id FROM asm_assetmentform where course_id = :courseid");
}

function createAsessmentForm($assetmentId)
{


    global $courseId;
    global $lms;
    global $userid;

    $assesmentArray = [
        "assetmentid" => 3,
        'course_shortname' => $lms->getCourseContent($courseId)[0]['shortname'],
        "questions" => [],
        "teacher_list" => getTeacherName($courseId),
    ];
    $questions = getQuestions(3);

    foreach ($questions as $question) {
        if ($question['question_type'] == 2) {
            $newObject = [
                "id" => $question['id'],
                "question" => $question['question_text'],
                "items" => [
                    ["value" => '1', "label" => "ใช่", "disabled" => false],
                    ["value" => '2', "label" => "ไม่ใช่", "disabled" => false],
                ],
            ];
        } else {
            $newObject = [
                "id" => $question['id'],
                "question" => $question['question_text'],
                "items" => [
                    ["value" => '1', "label" => "น้อย", "disabled" => false],
                    ["value" => '2', "label" => "น้อยมาก", "disabled" => false],
                    ["value" => '3', "label" => "ปานกลาง", "disabled" => false],
                    ["value" => '4', "label" => "มาก", "disabled" => false],
                    ["value" => '5', "label" => "มากที่สุด", "disabled" => false],
                ],
            ];
        }
        array_push($assesmentArray['questions'], $newObject);
    }
    return $assesmentArray;
}

function getTeacherName($courseId)
{
    global $lms;
    $buckOfTeacherList = $lms->getListOfTeacher($courseId);
    $teacherLists = [];
    foreach ($buckOfTeacherList[0]['users'] as $value) {
        array_push($teacherLists, [$value['id'], $value['firstname'], $value['lastname']]);
    }
    return $teacherLists;
}

function hasTransection($userid)
{
    global $db;
    $db->bind('userid', $userid);
    $queryResponse = $db->single('SELECT COUNT(ID) FROM asm_transection WHERE user_id = :userid');
    return $queryResponse > 0;
}
