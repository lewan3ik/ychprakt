<?php
require __DIR__ . "/classes/GroupContext.php";

$list = array(
    'ID' => 11,
    'Name' => 'ИСВ-22-6'
);
$obj = new groupContext($list);

$marks = $obj->select();
foreach ($marks as $mark) {
    echo "ID: " . $mark->id . ", Name: " . 
    $mark->name ."\n";
}

echo $obj->delete(11);
?>