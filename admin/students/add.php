<?php

require("../includes/init.php");
require(pathOf('admin/includes/auth.php'));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    header('Content-Type: application/json');

    $username = $_POST['username'];
    $password = $_POST['password'];
    $PasswordHash = password_hash($password, PASSWORD_DEFAULT);
      
    
    $query = "INSERT INTO `Users` SET `Username` = ?,`PasswordHash` = ?,`UserType` = ?";
    $params = [$username,$PasswordHash,"student"];
    execute($query, $params);

    $userId = lastInsertId();
    $name = $_POST['name'];
    $pnumber = $_POST['pnumber'];
    $gender = $_POST['gender'];

    $query = "INSERT INTO `Students` SET `FullName` = ?,`PhoneNumber` = ?,`Gender` = ?,`UserId` = ?";
    $params = [$name,$pnumber,$gender,$userId];
    execute($query, $params);

    header('Content-Type: application/json');
    echo json_encode(["status" => true, "message" => "Student added successfully."]);

    exit();
}

$title = "Add New Student";

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
                        <h1>Add New Student</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= urlOf('admin/') ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= urlOf('admin/students') ?>">Students</a></li>
                            <li class="breadcrumb-item active">Add New</li>
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
                                <div class="form-group">
                                    <label for="name">Username</label>
                                    <input type="text" class="form-control" id="username" placeholder="Enter Username" autofocus required />
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Password</label>
                                    <input type="text" class="form-control" id="password" placeholder="Enter Password" autofocus required />
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter Student Name" autofocus required />
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="pnumber">Phone Number</label>
                                    <input type="text" class="form-control" id="pnumber" placeholder="Enter Phone Number" autofocus required />
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender">
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select><br>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <button id="btn-submit" type="button" class="btn btn-success" onclick="addStudent()">
                            <span id="btn-submit-text">Add</span>
                            <span id="btn-submit-text-saved" style="display: none">added!</span>
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