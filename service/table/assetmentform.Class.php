<?php

require_once(__DIR__ . '/../configpdo/Crud.class.php');

class QuestionForm extends Crud
{
    protected $table = 'asm_assetmentform';
    protected $pk = 'id';


}
