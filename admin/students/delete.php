<?php

require("../includes/init.php");
require(pathOf('admin/includes/auth.php'));

execute("DELETE FROM `Students` WHERE `Id` = ?", [$_GET['id']]);
header('Location: ' . urlOf('admin/students'));
