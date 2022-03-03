<?php
require("./config.php");
require("./classes/Controller.php");
session_start();
Controller::handle();
?>