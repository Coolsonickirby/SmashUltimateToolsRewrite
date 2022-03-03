<?php
require("./config.php");
require("./classes/ApiController.php");
session_start();
ApiController::handle();
?>