<?php
require __DIR__ . "/classes/studentContext.php";
require_once __DIR__ . '/classes/groupContext.php';

$list = array(
    'ID' => 12,
    'Name' => 'Исв-22-2'
);
$obj = new groupContext($list);

$marks = $obj->select();
foreach ($marks as $mark) {
    echo "ID: " . $mark->ID . ", Name: " . 
    $mark->Name ."\n";
}

echo $obj->delete(12);
?>