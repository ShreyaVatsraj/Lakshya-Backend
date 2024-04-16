<?php

require("../includes/init.php");
require(pathOf('admin/includes/auth.php'));

$id = $_REQUEST['id'];
$examAttempts = selectOne("SELECT COUNT(*) AS `Count` FROM `answers` WHERE `ExamId` = ?", [$id]);
$examAttemptCount = $examAttempts['Count'];

if ($examAttemptCount > 0) {
    echo "<script>alert('Cannot edit/delete this exam!');window.location.href = '" . urlOf('admin/exams') . "';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    header('Content-Type: application/json');

    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $dateTime = "$date $time";
    $subject = $_POST['subject'];

    $query = "UPDATE `Exams` SET `Name` = ?, `Description` = ?, `DateTime` = ?,`SubjectId` = ? WHERE `Id` = ?";
    $params = [$name, $description, $dateTime, $durationInMinutes,$subject,$id];
    
    execute($query, $params);
    execute("DELETE FROM `Questions` WHERE `ExamId` = ?", [$id]);

    $titles = $_POST['title'];
    $option1s = $_POST['option1'];
    $option2s = $_POST['option2'];
    $option3s = $_POST['option3'];
    $option4s = $_POST['option4'];
    $correctOptionNumbers = $_POST['correctOptionNumber'];

    for ($i = 0; $i < count($titles); $i++)
    {
        $query = "INSERT INTO `Questions` SET `Title` = ?, `Option1` = ?, `Option2` = ?, `Option3` = ?,`Option4` = ?, `CorrectOptionNumber` = ?, `ExamId` = ?";
        $params = [$titles[$i], $option1s[$i], $option2s[$i], $option3s[$i], $option4s[$i], $correctOptionNumbers[$i], $id];

        execute($query, $params);
    }

    header('Content-Type: application/json');
    echo json_encode(["status" => true, "message" => "Exam edited successfully."]);

    exit();
}

$subject = select("SELECT * FROM `subjects`");
$title = "Edit Exam";
$exam = selectOne("SELECT * FROM `Exams` WHERE `Id` = ?", [$id]);
$questions = select("SELECT * FROM `Questions` WHERE `ExamId` = ?", [$id]);

require(pathOf('admin/includes/header.php'));
require(pathOf('admin/includes/nav.php'));
require(pathOf('admin/includes/sidebar.php'));

?>
<div class="content-wrapper">
    <div class="container px-5">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Exam</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= urlOf('admin/') ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= urlOf('admin/exams') ?>">Exams</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form>
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                 <label for="subject">Subject Name</label>
                                    <select name="subject" id="subject">
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
                                    <input type="text" class="form-control" id="name" placeholder="Enter Exam Name" value="<?= $exam['Name'] ?>" autofocus required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="description">Exam Description</label>
                                    <textarea class="form-control" id="description" placeholder="Enter Exam Description" rows="5" required><?= $exam['Description'] ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="date">Exam Date</label>
                                <label for="time">& Time</label>
                                <div class="form-group input-group">    
                                    <input type="date" class="form-control" id="date" placeholder="Select Exam Date" value="<?= (new DateTime($exam['DateTime']))->format('Y-m-d') ?>" required />
                                    <input type="time" class="form-control" id="time" placeholder="Select Exam Time" value="<?= (new DateTime($exam['DateTime']))->format('h:i:s') ?>" required />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="questions">
                    <?php for ($i = 0; $i < count($questions); $i++) : ?>
                        <div class="card card-outline card-info single-question" id="question-<?= $i + 1 ?>">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="title">Question <?= $i + 1 ?></label>
                                            <input type="text" value="<?= $questions[$i]['Title'] ?>" class="form-control title" id="title" placeholder="Enter question" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="option1">Option 1</label>
                                            <input value="<?= $questions[$i]['Option1'] ?>" class="form-control option1" id="option1" placeholder="Option 1" required></input>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="option2">Option 2</label>
                                            <input value="<?= $questions[$i]['Option2'] ?>" type="text" class="form-control option2" id="option2" placeholder="Option 2" required />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="option3">Option 3</label>
                                            <input value="<?= $questions[$i]['Option3'] ?>" type="text" class="form-control option3" id="option3" placeholder="Option 3" required />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="option4">Option 4</label>
                                            <input value="<?= $questions[$i]['Option4'] ?>" type="text" class="form-control option4" id="option4" placeholder="Option 4" required />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="correctOptionNumber">Correct Option Number</label>
                                            <select id="correctOptionNumber" class="custom-select correctOptionNumber">
                                                <option <?= $questions[$i]['CorrectOptionNumber'] == 1 ? 'selected': '' ?> value="1">1</option>
                                                <option <?= $questions[$i]['CorrectOptionNumber'] == 2 ? 'selected': '' ?> value="2">2</option>
                                                <option <?= $questions[$i]['CorrectOptionNumber'] == 3 ? 'selected': '' ?> value="3">3</option>
                                                <option <?= $questions[$i]['CorrectOptionNumber'] == 4 ? 'selected': '' ?> value="4">4</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col d-flex align-items-end">
                                        <button type="button" class="btn btn-danger" onclick="removeQuestion(<?= $i + 1 ?>)">X</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <div class="card-footer">
                            <button id="btn-submit" type="button" class="btn btn-success" onclick="return editExam(<?= $id ?>);">
                                <span id="btn-submit-text">Save</span>
                                <span id="btn-submit-text-saved" style="display: none">Saved!</span>
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
require(pathOf('admin/includes/footer-part1.php'));
require(pathOf('admin/includes/scripts.php'));
?>
<script src="<?= urlOf('admin/js/exams.js') ?>"></script>
<?php
require(pathOf('admin/includes/footer-part2.php'));
?>