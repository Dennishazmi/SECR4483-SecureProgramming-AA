<?php

require_once 'db_config.php';

$keyword = trim($_GET['keyword'] ?? '');

try{

$stmt = $conn->prepare("
SELECT
id,
name,
illness_history
FROM patient_records
WHERE name LIKE :keyword
");

$stmt->execute([
':keyword'=>"%{$keyword}%"
]);

$patients = $stmt->fetchAll();

if(count($patients)>0){

foreach($patients as $patient){

echo "<div>";

echo "<strong>Result for:</strong> "
.htmlspecialchars($keyword,ENT_QUOTES,'UTF-8');

echo "<br>";

echo "<strong>Patient:</strong> "
.htmlspecialchars($patient['name'],ENT_QUOTES,'UTF-8');

echo "<br>";

echo "<strong>History:</strong> "
.htmlspecialchars($patient['illness_history'],ENT_QUOTES,'UTF-8');

echo "</div><hr>";

}

}else{

echo "No records found.";

}

}catch(PDOException $e){

echo "Query failed.";

}
?>
