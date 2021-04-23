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
    $DB = new DB();
    $LMS = new Lms();

    if (!$DB) {
        throw new Exception('NOT FOUND', 505);
    }
    // echo ';test';
    $sql = 'SELECT assesment_id, course_id,teacher_id, SUM(score=1) AS n1, SUM(score=2) AS n2,SUM(score=3) AS n3,SUM(score=4) AS n4,SUM(score=5) AS n5, COUNT(*) AS total
    FROM  (SELECT B.id,A.teacher_id,d.score,d.question_id,c.question_text,A.course_id,A.id as assesment_id FROM asm_assetmentform AS A INNER JOIN asm_transection AS B ON A.ID = B.assetmentform_id INNER JOIN asm_rating as d ON d.transection_id = B.ID INNER JOIN asm_questions as c ON d.question_id = c.id ORDER BY `teacher_id` ASC) newtable
    GROUP BY teacher_id';
    $data = json_encode($DB->query($sql), JSON_UNESCAPED_UNICODE);
    $queryData = $DB->query($sql);

    $tempArray = [];
    $numberOfArray = count($tempArray);
    $count = 0;

    foreach ($queryData as $value) {
        $courseShortName = getCourseShortName($value['course_id']);
        $allComments = getAllAsessmentComments($value['assesment_id']);
        $teacherName = getUserName($value['teacher_id']);
        if (count($tempArray) == 0) {
            array_push($tempArray, ['course_id' => intval($value['course_id']),
                'assesment_id' => $value['assesment_id'],
                'course_shortname' => $courseShortName,
                'comments' => $allComments,
                'teacher' => [
                    ['id' => intval($value['teacher_id']), 'name' => $teacherName, 'totalscore' =>
                        [
                            ['score' => 1, 'total' => $value['n1'], 'avg' => $value['n1'] * 100 / $value['total']],
                            ['score' => 2, 'total' => $value['n2'], 'avg' => $value['n2'] * 100 / $value['total']],
                            ['score' => 3, 'total' => $value['n3'], 'avg' => $value['n3'] * 100 / $value['total']],
                            ['score' => 4, 'total' => $value['n4'], 'avg' => $value['n4'] * 100 / $value['total']],
                            ['score' => 5, 'total' => $value['n5'], 'avg' => $value['n5'] * 100 / $value['total']],
                        ],
                    ],

                ],

            ]);
        } else {
            $currentArray = array_filter($tempArray[$count], function ($value1, $key) {
                global $value;
                return $key == 'course_id' && $value1 == $value['course_id'];
            }, ARRAY_FILTER_USE_BOTH);

            if (count($currentArray) < 1) {
                array_push($tempArray, ['course_id' => $value['course_id'],
                    'course_shortname' => $courseShortName,
                    'assesment_id' => $value['assesment_id'],
                    'comments' => $allComments,
                    'teacher' => [
                        ['id' => intval($value['teacher_id']), 'fullname' => $teacherName, 'totalscore' =>
                            [
                                ['score' => 1, 'total' => $value['n1'], 'avg' => $value['n1'] * 100 / $value['total']],
                                ['score' => 2, 'total' => $value['n2'], 'avg' => $value['n2'] * 100 / $value['total']],
                                ['score' => 3, 'total' => $value['n3'], 'avg' => $value['n3'] * 100 / $value['total']],
                                ['score' => 4, 'total' => $value['n4'], 'avg' => $value['n4'] * 100 / $value['total']],
                                ['score' => 5, 'total' => $value['n5'], 'avg' => $value['n5'] * 100 / $value['total']],
                            ],
                        ],
                    ],

                ]);

            } else if (count(array_filter($tempArray[$count]['teacher'][$count], function ($value1, $key) {
                global $value;
                return $key == 'name' && $value1 == $value['teacher_id'];
            }, ARRAY_FILTER_USE_BOTH)) < 1) {

                array_push($tempArray[$count]['teacher'],
                    ['id' => intval($value['teacher_id']), 'fullname' => $teacherName, 'totalscore' =>
                        [
                            ['score' => 1, 'total' => $value['n1'], 'avg' => $value['n1'] * 100 / $value['total']],
                            ['score' => 2, 'total' => $value['n2'], 'avg' => $value['n2'] * 100 / $value['total']],
                            ['score' => 3, 'total' => $value['n3'], 'avg' => $value['n3'] * 100 / $value['total']],
                            ['score' => 4, 'total' => $value['n4'], 'avg' => $value['n4'] * 100 / $value['total']],
                            ['score' => 5, 'total' => $value['n5'], 'avg' => $value['n5'] * 100 / $value['total']],
                        ],

                    ]);
            }

        }

        // $count++;
    }

    $data = json_encode($tempArray, JSON_UNESCAPED_UNICODE);

    echo $data;
} catch (Exception $e) {
    echo $e->getMessage();
}

function getCourseShortName($courseId)
{
    global $LMS;
    return $LMS->getCourseContent($courseId)[0]['shortname'];
}

function getAllAsessmentComments($assesmentId)
{
    global $DB;
    $DB->bind('assessmentid', $assesmentId);
    $sql = 'SELECT comment_message,a.created_at,a.id as comment_id FROM (asm_comment as a INNER JOIN asm_transection as b on a.transection_id = b.id INNER JOIN
    asm_assetmentform as c on c.id = b.assetmentform_id) where c.id = :assessmentid';
    return $DB->query($sql);
}

function getUserName($userId)
{
    global $LMS;
    $responseData = $LMS->getUserDataByField('id', $userId);
    // print_r($responseData);
    return $responseData[0]['firstname'] . ' ' . $responseData[0]['lastname'];
}

function getUniqueKeyWithValue($array, $key)
{
    $tempArray = [];
    $count = 0;
    $keyArray = [];

    foreach ($array as $val) {
        if (!in_array($val[$key], $keyArray)) {
            array_push($keyArray, $val[$key]);
            array_push($tempArray, $val);
        }
        $count++;
    }

    return $tempArray;
}
