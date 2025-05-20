<?php
header('Content-Type: application/json');

try {
        $students = [
        [
            'ID' => 11,
            'FIO' => 'Гилев Алексей',
            'Group' => 'ИСВ-22-1',
            'date' => '2026-01-20'
        ]
    ];

    echo json_encode($students);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['error' => 'Failed to fetch students']);
}
?>
