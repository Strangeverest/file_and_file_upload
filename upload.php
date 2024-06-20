<?php
require_once(__DIR__ . '/Controller.php');

$controller =  new Controller;
$controller->uploadFile($_FILES);
