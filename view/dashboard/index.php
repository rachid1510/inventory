<?php
$dsn = 'mysql:dbname=test;host=127.0.0.1';
$user = 'root';
$password = '';
try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}
//$sql="SELECT i.*,v.imei,c.name,CONCAT( p.first_name,' ', p.last_name) AS personnal_name FROM installations i,costumers c,vehicles v,personals p WHERE  i.vehicle_id=v.id  and i.personal_id=p.id and v.costumer_id=c.id";

$sql= "SELECT playerid, score FROM score ORDER BY playerid";
$pre = $pdo->prepare($sql);
$data = array();
$result = array();
$pre->execute();
$result = $pre->fetchAll();
echo json_encode($result);
