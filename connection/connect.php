<?php

$conn = new mysqli('localhost', 'root', '', 'portfolio');
if($conn -> connect_error) {
    die('Connection Faild' . $conn -> connect_error);
}
?>