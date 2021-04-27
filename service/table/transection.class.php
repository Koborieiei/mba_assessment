<?php


require_once(__DIR__ . '/../configpdo/Crud.class.php');


class Transection extends Crud
{
    protected $table = 'asm_transection';
    protected $pk = 'id';
}
