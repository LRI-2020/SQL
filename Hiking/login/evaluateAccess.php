<?php
function canAccess(){
    session_start();
    return (isset($_SESSION['password'])&&isset($_SESSION['password']));
}