

<?php

require_once __DIR__ . '/class/Lmsapi.class.php';

$lms = new Lms();
print_r($lms->getCourseContent(60));