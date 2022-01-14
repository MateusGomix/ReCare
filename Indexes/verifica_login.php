<?php
    if(!$_SESSION['nome']) {
        header('Location: ../login.html');
        exit();
    }
?>