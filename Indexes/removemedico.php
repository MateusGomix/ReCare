<?php
$mysql = new mysqli('localhost', 'root', '', 'recare');

$removeMed = $mysql->prepare('DELETE FROM AtendeEm
                                   WHERE ID_Medico = ?');
$removeMed->bind_param('s', $_GET['id']);
$removeMed->execute();

header("Location: indexAdmin.php"); 
exit();

?>