<?php

    $connect = mysqli_connect('localhost', 'root', '', 'Authentication');

    if (!$connect) {
        die('Error connect to DataBase');
    }