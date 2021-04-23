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

    $sql = 'SELECT *,SUM(score=1) as n1,SUM(score=2) as n2,SUM(score=3) as n3,SUM(score=4) as n4,SUM(score=5) as n5, count(*) as total
    FROM (SELECT a.transection_id,b.assetmentform_id,a.score,c.question_text,c.question_type
        FROM asm_rating as a INNER JOIN asm_transection as b on a.transection_id = b.id
            INNER JOIN asm_questions as c on a.question_id = c.id ) newtable
        WHERE assetmentform_id = 6
    GROUP by score,question_text
    ORDER BY `newtable`.`question_text` DESC';

    $queryData = $DB->query($sql);
    $tempArray = ['questions' => []];
    $count = 0;
    $countRating = count($queryData);
    $totalArray = [

    ];

    foreach ($queryData as $value) {
        $indexOfArray = array_search($questionText, array_column($tempArray['questions'], 'question_text'));

        // echo array_sum(array_column($queryData, 'question_text'));
        $questionText = $value['question_text'];

        $test = array_filter($queryData, function ($var) use ($questionText) {
            return ($var['question_text'] == $questionText);
        });

        $test1 = array_reduce($test, function ($acc, $item) {

            return $acc + $item['total'];
        });

        if (count($tempArray) == 0) {
            array_push($tempArray['questions'],
                ['question_text' => $value['question_text'],
                    'question_type' => $value['question_type'],
                    'totalscore' =>
                    [
                        ['score' => 1, 'total' => 0, 'avg' => 0],
                        ['score' => 2, 'total' => 0, 'avg' => 0],
                        ['score' => 3, 'total' => 0, 'avg' => 0],
                        ['score' => 4, 'total' => 0, 'avg' => 0],
                        ['score' => 5, 'total' => 0, 'avg' => 0],
                    ],
                ]
            );

            array_push($totalArray, ['question_text' => $questionText
                , 'sum' => $value['total']]);

            $indexOfTotalScoreArray = array_search($value['score'], array_column($tempArray['questions'][$indexOfArray]['totalscore'], 'score'));
            $tempArray['questions'][$indexOfArray]['totalscore'][$indexOfTotalScoreArray]['total'] = $value['total'];
            $tempArray['questions'][$indexOfArray]['totalscore'][$indexOfTotalScoreArray]['avg'] = round($value['total'] * 100 / $test1, 2);

        } else {

            $currentArray = array_filter($tempArray['questions'], function ($var) use ($questionText) {
                return ($var['question_text'] == $questionText);
            });

            if (count($currentArray) < 1) {

                array_push($tempArray['questions'],
                    ['question_text' => $questionText, 'question_type' => $value['question_type'], 'totalscore' =>
                        [
                            ['score' => 1, 'total' => 0, 'avg' => 0],
                            ['score' => 2, 'total' => 0, 'avg' => 0],
                            ['score' => 3, 'total' => 0, 'avg' => 0],
                            ['score' => 4, 'total' => 0, 'avg' => 0],
                            ['score' => 5, 'total' => 0, 'avg' => 0],
                        ],
                    ]
                );
                array_push($totalArray, ['question_text' => $questionText
                    , 'sum' => $value['total']]);
                $indexOfArray = array_search($questionText, array_column($tempArray['questions'], 'question_text'));
                $indexOfTotalScoreArray = array_search($value['score'], array_column($tempArray['questions'][$indexOfArray]['totalscore'], 'score'));
                $indexOfArrayTest = array_search($questionText, array_column($tempArray['questions'], 'question_text'));

                $tempArray['questions'][$indexOfArray]['totalscore'][$indexOfTotalScoreArray]['total'] = $value['total'];
                $tempArray['questions'][$indexOfArray]['totalscore'][$indexOfTotalScoreArray]['avg'] = round($value['total'] * 100 / $test1, 2);
                // $totalArray[$indexOfArrayTest]['sum'] = $totalArray[$indexOfArrayTest]['sum'] + $value['total'];

            } else {
                $indexOfArray = array_search($questionText, array_column($tempArray['questions'], 'question_text'));
                $indexOfTotalScoreArray = array_search($value['score'], array_column($tempArray['questions'][$indexOfArray]['totalscore'], 'score'));
                $indexOfArrayTest = array_search($questionText, array_column($totalArray, 'question_text'));

                $tempArray['questions'][$indexOfArray]['totalscore'][$indexOfTotalScoreArray]['total'] = $value['total'];
                $totalArray[$indexOfArrayTest]['sum'] = $totalArray[$indexOfArrayTest]['sum'] + $value['total'];

                $tempArray['questions'][$indexOfArray]['totalscore'][$indexOfTotalScoreArray]['avg'] = round($value['total'] * 100 / $test1, 2);

            }

        }
        // print_r($totalArray);

    }
    $tempArray['comments'] = getAllAsessmentComments(6);

    $data = json_encode($tempArray, JSON_UNESCAPED_UNICODE);

    echo $data;

} catch (\Throwable $th) {
    //throw $th;
}

function getAllAsessmentComments($assesmentId)
{
    global $DB;
    $DB->bind('assessmentid', $assesmentId);
    $sql = 'SELECT comment_message,a.created_at,a.id as comment_id FROM (asm_comment as a INNER JOIN asm_transection as b on a.transection_id = b.id INNER JOIN
    asm_assetmentform as c on c.id = b.assetmentform_id) where c.id = :assessmentid';
    return $DB->query($sql);
}
