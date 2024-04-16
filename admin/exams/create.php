<?php

require "../includes/init.php";
require pathOf('admin/includes/auth.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    header('Content-Type: application/json');

    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $dateTime = "$date $time";
    $subject = $_POST['subject'];

    $query = "INSERT INTO `Exams` SET `Name` = ?, `Description` = ?, `DateTime` = ?, `SubjectId` = ?";
    $params = [$name, $description, $dateTime, $subject];

    execute($query, $params);

    $examId = lastInsertId();
    $titles = $_POST['title'];
    $option1s = $_POST['option1'];
    $option2s = $_POST['option2'];
    $option3s = $_POST['option3'];
    $option4s = $_POST['option4'];
    $correctOptionNumbers = $_POST['correctOptionNumber'];

    for ($i = 0; $i < count($titles); $i++) {
        $query = "INSERT INTO `Questions` SET `Title` = ?, `Option1` = ?, `Option2` = ?, `Option3` = ?,`Option4` = ?, `CorrectOptionNumber` = ?, `ExamId` = ?";
        $params = [$titles[$i], $option1s[$i], $option2s[$i], $option3s[$i], $option4s[$i], $correctOptionNumbers[$i], $examId];

        execute($query, $params);
    }

    header('Content-Type: application/json');
    echo json_encode(["status" => true, "message" => "Exam created successfully."]);

    exit();
}

$subject = select("SELECT * FROM `subjects`");
$title = "Create New Exam";

require pathOf('admin/includes/header.php');
require pathOf('admin/includes/nav.php');
require pathOf('admin/includes/sidebar.php');

?>
<div class="content-wrapper">
    <div class="container px-5">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create New Exam</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?=urlOf('admin/exams/index.php')?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?=urlOf('admin/exams')?>">Exams</a></li>
                            <li class="breadcrumb-item active">Create New</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form onsubmit="return false;">
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <label for="subjects">Subject Name</label>
                                    <select name="subjects" id="subject">
                                        <?php foreach ($subject as $s) {?>
                                            <option value="<?=$s["Id"]?>"><?=$s["Name"]?>
                                            </option>
                                        <?php }?>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Exam Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter Exam Name" autofocus required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="description">Exam Description</label>
                                    <textarea class="form-control" id="description" placeholder="Enter Exam Description" rows="5" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="date">Exam Date</label>
                                <label for="time">& Time</label>
                                <div class="form-group input-group">
                                    <input type="date" class="form-control" id="date" placeholder="Select Exam Date" value="<?=(new DateTime())->format('Y-m-d')?>" required />
                                    <input type="time" class="form-control" id="time" placeholder="Select Exam Time" value="<?=(new DateTime())->format('h:i:s')?>" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-info" onclick="createQuestionDiv();">Add Question</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="questions"></div>
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <div class="card-footer">
                            <button id="btn-submit" type="button" class="btn btn-success" onclick="createExam()">
                                <span id="btn-submit-text">Create</span>
                                <span id="btn-submit-text-saved" style="display: none">Created!</span>
                                <div id="btn-submit-spinner" class="spinner-border spinner-border-sm" role="status" style="display: none">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
<?php
require pathOf('admin/includes/footer-part1.php');
require pathOf('admin/includes/scripts.php');
?>
<script src="<?=urlOf('admin/js/exams.js')?>"></script>
<?php
require pathOf('admin/includes/footer-part2.php');
?>