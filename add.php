<?php
require_once 'orm.php';
$orm = new ORMSimple('localhost', 'root', 'mysql', 'ormsimple');

if($_POST['id']) {
    $orm->deleteData('orm', [
        'id'=> $_POST['id'],
    ]);
    header('Location: index.php');
}