<?php
require_once 'orm.php';
$orm = new ORMSimple('localhost', 'root', 'mysql', 'ormsimple');
$res = $orm->fetchAllData('orm');
foreach ($res as $row) {
    echo $row['text'] . "<br>";
}

echo "Total rows: " . count($res);

?>
<form action="add.php" method="post">
    <input type="text" name="text">
    <button type="submit">add</button>
</form>
<form action="add.php" method="post">
    <input type="text" name="id">
    <button type="submit">del</button>
</form>

