<?php

require_once(__DIR__ . '/../configpdo/Crud.class.php');

class Question extends Crud
{
    protected $table = 'asm_questions';
    protected $pk = 'id';
}
