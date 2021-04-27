<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header(
    'Access-Control-Allow-Headers: Authorization, Content-Type,Accept, Origin'
);
require_once __DIR__ . '/../configpdo/db.class.php';
require_once __DIR__ . '/class/Lmsapi.class.php';

try {

    if (!isset($_GET['courseid']) || !isset($_GET['uid']) || !isset($_GET['site'])) {
        throw new Exception('Invalid Parameters', 404);
    }
    $courseId = $_GET['courseid'];
    $userid = $_GET['uid'];
    $site = html_entity_decode($_GET['site']);

    $db = new DB();

    $siteAccessData = getSiteServiceToken($site);
    // print_r($siteAccessData);

    if (!$siteAccessData['token']) {
        throw new Exception('This site has not found', 505);
    }

    if (hasTransection($userid, $courseId, $siteAccessData['site_id'])) {
        throw new Exception('You have evaluated already', 208);
    }

    $lms = new Lms($siteAccessData);

    if (!hasAssesmentForm($courseId)) {
        insertAssessmentForm($courseId);
    }

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

    $assesmentArray = [
        "assetmentid" => $assetmentId,
        'course_shortname' => $lms->getCourseContent($courseId)[0]['shortname'],
        "questions" => [],
        "teacher_list" => getTeacherName($courseId),
        'code' => 200,
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

function hasTransection($userid, $courseId, $siteId)
{
    global $db;
    // $db->bind('userid', $userid);
    $db->bindMore(['userid' => $userid, 'courseid' => $courseId, 'siteId' => $siteId]);
    $queryResponse = $db->single('SELECT COUNT(a.ID) FROM asm_transection as a INNER JOIN asm_assetmentform as b on a.assetmentform_id = b.id WHERE user_id = :userid AND b.course_id = :courseid AND b.site_id = :siteId');
    return $queryResponse > 0;
}

function hasAssesmentForm($courseId)
{
    global $db;
    $db->bind('courseid', $courseId);
    $queryResponse = $db->single('SELECT COUNT(ID) FROM asm_assetmentform WHERE course_id = :courseid');
    return $queryResponse > 0;
}

function insertAssessmentForm($courseId)
{
    global $db;
    global $lms;
    global $siteAccessData;

    try {
        $buckOfTeacherList = $lms->getListOfTeacher($courseId);

        foreach ($buckOfTeacherList[0]['users'] as $value) {
            $db->bindMore(
                [
                    'course_id' => $courseId,
                    'teacher_id' => $value['id'],
                    'site_id' => $siteAccessData['site_id'],
                ]
            );
            $sqlCommande = 'INSERT INTO asm_assetmentform (course_id,question_id,teacher_id,user_created,term_id,is_visible,site_id) VALUES (:course_id,"1,2,5,6,7",:teacher_id,11,1,1,:site_id)';
            $queryResponse = $db->query($sqlCommande);

            if (!$queryResponse) {
                throw new Exception('Failed to connect', 505);
            }
        }
    } catch (Exception $e) {
        echo json_encode([
            "message" => $e->getMessage(),
            "code" => $e->getCode(),
        ], JSON_PRETTY_PRINT);
    }
}

function getSiteServiceToken($site)
{
    global $db;
    $db->bind('site', $site);
    $sqlCommande = 'SELECT site_token,id FROM asm_site WHERE site_name = :site';
    $data = $db->query($sqlCommande);
    return ['site' => $site, 'token' => $data[0]['site_token'], 'site_id' => $data[0]['id']];
}
