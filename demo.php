<?php
include 'db_connection.php';
//Open database connection
$conn = OpenCon();
//Query database for patient info - Exercise 2&3
$sql = "SELECT pn, last, first, insurance.iname, DATE_FORMAT(from_date,'%m-%d-%Y') as from_date, DATE_FORMAT(to_date, '%m-%d-%Y') as to_date FROM patient 
        LEFT JOIN insurance ON patient._id=insurance.patient_id ORDER BY from_date ASC, last ASC";
$result = $conn->query($sql);
//Display info as requested
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo " " . $row["pn"]. "," . $row["last"]. "," . $row["first"]. "," . $row["iname"] . "," . $row["from_date"] . "," . $row["to_date"] . "<br>";
    }
  } else {
    echo "0 results";
}
$result = $conn->query($sql);
$letters = [];
$countLetters = 0;
//Loop through results, split values, count letters, append to indexed array
while($row = $result->fetch_assoc()) {
    $text = $row["first"].= $row["last"];
    $text = str_replace(' ', '', $text );
    $arrLetters = str_split($text);
    $countLetters += count($arrLetters);
 
    foreach($arrLetters as $letter){
        if(isset($letters[$letter])){
            $letters[$letter] += 1;
        } else {
            $letters[$letter] = 1;  
        }
    }
}
//Display created array values
$totalLetters = 0;
foreach($letters as $letter => $total){
  echo $letter."  ".$total."  ".round(($total/$countLetters*100),2)."%<br />";
  $totalLetters += $total;
}
echo $totalLetters;
$conn->close();

// Object-oriented PHP - Exercise 4
//$conn = OpenCon();
//Interface definition
//interface „PatientRecord“ {
//  public function getPatientId($PatientId);
//  $PatientId=mysql_query("SELECT _id FROM insurance");
//    $result = array();
//  while ($record = mysql_fetch_array($PatientId)) {
//    $result[] = $record;
//}
//return $result;
//}
//
//  public function getPatientNumber($PatientNumber);
//}
//
//class Patient implements „PatientRecord“ {
//  public $PatientId;
//  public function getPatientId($PatientId)
//    $this -> Patientid = $PatientId;
//  >
?>