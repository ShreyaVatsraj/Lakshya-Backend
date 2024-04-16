<?php

require("../includes/init.php");
require(pathOf('admin/includes/auth.php'));

$id = $_REQUEST['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    header('Content-Type: application/json');

    $name = $_POST['name'];
    $pnumber = $_POST['pnumber'];
    $gender = $_POST['gender'];

    $query = "UPDATE `Students` SET `FullName` = ?,`PhoneNumber` = ?,`Gender` = ? WHERE `Id` = ?";
    $params = [$name,$password,$pnumber,$gender, $id];
    execute($query, $params);

    header('Content-Type: application/json');
    echo json_encode(["status" => true, "message" => "Student edited successfully."]);

    exit();
}

$title = "Edit Student";
$student = selectOne("SELECT * FROM `Students` WHERE `Id` = ?", [$id]);

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
                        <h1>Edit Student</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= urlOf('admin/') ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= urlOf('admin/students') ?>">Students</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form onsubmit="return editStudent(<?= $id ?>);">
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Student Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter Student Name" value="<?= $student['FullName'] ?>" autofocus required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Phone Number</label>
                                    <input type="text" class="form-control" id="pnumber" placeholder="Enter Phone Number" value="<?= $student['PhoneNumber'] ?>" autofocus required />
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender" value="<?= $student['Gender'] ?>">
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button id="btn-submit" type="submit" class="btn btn-success">
                            <span id="btn-submit-text">Save</span>
                            <span id="btn-submit-text-saved" style="display: none">Saved!</span>
                            <div id="btn-submit-spinner" class="spinner-border spinner-border-sm" role="status" style="display: none">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
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
<script src="<?= urlOf('admin/js/students.js') ?>"></script>
<?php
require(pathOf('admin/includes/footer-part2.php'));
?>