<?php
require __DIR__ . "/classes/studentContext.php";
require_once __DIR__ . '/classes/groupContext.php';

$list = array(
    'ID' => 6,
    'Name' => 'Исв-22-1'
);
$obj = new groupContext();

$marks = $obj->select();
foreach ($marks as $mark) {
    echo "ID: " . $mark->id . ", Name: " . 
    $mark->Name ."\n";
}
?>