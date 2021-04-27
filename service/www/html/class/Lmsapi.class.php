<?php

require_once __DIR__ . '/curl.php';
// require_once __DIR__ . '/completion.class.php';
// require_once __DIR__ . '/exorder.class.php';

class Lms
{
    protected $curl;
    // protected $completion;
    // protected $exam;
    protected $domainname;
    protected $restformat;
    protected $tk;
    protected $reset;

    // Set the tree function
    public function __construct($resource = [])
    {
        //   $this->reset = new local_recompletion\task\check_recompletion();
        $this->domainname = $resource['site'];
        $this->restformat = 'json';
        $this->tk = $resource['token'];
        $this->curl = new curl();
        $this->serviceFunction = "";
        $this->url =
        $this->domainname .
        '/webservice/rest/server.php' .
        '?wstoken=' .
        $this->tk .
        '&wsfunction=' . $this->serviceFunction . '&moodlewsrestformat=' .
        $this->restformat;

    }

    //  Add course to lms
    public function addcourse($params)
    {
        $url =
        $this->domainname .
        '/webservice/rest/server.php' .
        '?wstoken=' .
        $this->tk .
        '&wsfunction=enrol_manual_enrol_users&moodlewsrestformat=' .
        $this->restformat .
            '';

        return json_decode($this->curl->post($url, $params), true);
    }

    //  CHECK EXIST COURSE OF USE
    public function existcourse($userid)
    {

        $url =
        $this->domainname .
        '/webservice/rest/server.php' .
        '?wstoken=' .
        $this->tk .
        '&wsfunction=core_enrol_get_users_courses&userid=' .
        $userid .
        '&moodlewsrestformat=' .
        $this->restformat .
            '';

        return json_decode($this->curl->post($url), true);
    }

    //
    public function createuser($params)
    {
        // $this->curl = new curl();

        $url =
        $this->domainname .
        '/webservice/rest/server.php' .
        '?wstoken=' .
        $this->tk .
        '&wsfunction=core_user_create_users&moodlewsrestformat=' .
        $this->restformat .
            '';

        return json_decode($this->curl->post($url, $params), true);
    }

    //
    public function updateUserData($params)
    {
        // $this->curl = new curl();

        $url =
        $this->domainname .
        '/webservice/rest/server.php' .
        '?wstoken=' .
        $this->tk .
        '&wsfunction=core_user_update_users&moodlewsrestformat=' .
        $this->restformat .
            '';

        return json_decode($this->curl->post($url, $params), true);
    }

    /**
     * Need to loop through courses and trigger for eache course
     * Need to query lms id
     */
    //
    // public function resetCourse($data)
    // {
    //     // Inni setup
    //     // $this->curl = new curl();
    //     $this->completion = new Completion();

    //     //Open port request
    //     $ch = curl_init();
    //     curl_setopt(
    //         $ch,
    //         CURLOPT_URL,
    //         'https://visd.in.th/lms/local/recompletion/resetcourse.php'
    //     );
    //     curl_setopt($ch, CURLOPT_POST, 1);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //     //SET CURL DATA
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //     $resp = curl_exec($ch);

    //     $this->completion->updateResetCourse($data['originid'], $data['courseid']);

    //     $decoderesp = json_decode($resp, true);
    //     curl_close($ch);

    //     // Receive server response ...
    //     return $decoderesp;
    // }

    //GET USER LMS ID
    public function getLmsId($username)
    {
        $db = new DB();
        $db->bind('username', $username);
        return $db->single(
            'SELECT id FROM visd_user WHERE username = :username'
        );
    }

    public function getUserGrade($userid, $courseid)
    {
        // $this->curl = new curl();
        $url =
        $this->domainname .
        '/webservice/rest/server.php' .
        '?wstoken=' .
        $this->tk .
        '&wsfunction=gradereport_user_get_grade_items&userid=' .
        $userid .
        '&courseid=' .
        $courseid .
        '&moodlewsrestformat=' .
        $this->restformat;
        return json_decode($this->curl->post($url), true);
    }

    public function getListOfTeacher($courseId)
    {

        $coursecapabilities = ['coursecapabilities' => [
            [
                'courseid' => $courseId,
                'capabilities' => ['moodle/grade:edit'],
            ],
        ],
        ];

        $this->serviceFunction = "core_enrol_get_enrolled_users_with_capability";

        return json_decode($this->curl->post($this->getWebServiceUrl(), $coursecapabilities), true);
        // print_r($params1);
    }

    public function getCourseContent($courseId)
    {

        $options = ['options' => [

            'ids' => [$courseId],

        ],
        ];

        $this->serviceFunction = "core_course_get_courses";

        return json_decode($this->curl->post($this->getWebServiceUrl(), $options), true);
    }

    protected function getWebServiceUrl()
    {
        return $this->domainname .
        '/webservice/rest/server.php' .
        '?wstoken=' .
        $this->tk .
        '&wsfunction=' . $this->serviceFunction . '&moodlewsrestformat=' .
        $this->restformat;
    }

    public function getUserDataByField($fieldName, $userId)
    {
        $options = ['field' => $fieldName,
            'values' => [$userId],
        ];

        $this->serviceFunction = "core_user_get_users_by_field";

        return json_decode($this->curl->post($this->getWebServiceUrl(), $options), true);
    }
}
