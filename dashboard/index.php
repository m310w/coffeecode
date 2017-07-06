<?php
session_start();
if(isset($_SESSION['id_usuario']))
{
    header("location: main/index.php");
}
else
{
    header("location: main/login.php");
}
?>