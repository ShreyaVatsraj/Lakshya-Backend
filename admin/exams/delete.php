<?php

require("../includes/init.php");
require(pathOf('admin/includes/auth.php'));

$id = $_GET['id'];
$examAttempts = selectOne("SELECT COUNT(*) AS `Count` FROM `answers` WHERE `ExamId` = ?", [$id]);
$examAttemptCount = $examAttempts['Count'];

if ($examAttemptCount > 0) {
    echo "<script>alert('Cannot edit/delete this exam!');window.location.href = '" . urlOf('admin/exams') . "';</script>";
    exit();
}

execute("DELETE FROM `Questions` WHERE `ExamId` = ?", [$id]);
execute("DELETE FROM `Exams` WHERE `Id` = ?", [$id]);
header('Location: ' . urlOf('admin/exams'));
