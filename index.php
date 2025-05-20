<?php
require __DIR__ . "/classes/consultationContext.php";

$list = array(
    'ID' => 5,
    'Date' => '2020-01-05',
    'GroupID' => 6,
    'TeacherID' => 4
);
$obj = new consultationContext($list);

// $marks = $obj->select();
// foreach ($marks as $mark) {
//     echo "ID: " . $mark->id . ", Teacher ID: " . 
//     $mark->teacherId . ", Group ID: " . $mark->groupId
//     . ", date: " . $mark->date ."\n";
// }

echo $obj->add();
?>