<?php
$id = $_GET['id']; // id of the resident in the current profile
// Selecting the residents data including resident_family
$sql = "SELECT resident.*, resident_family.*
        FROM resident
        INNER JOIN resident_family ON resident.family_id = resident_family.family_id
        WHERE resident.resident_id = :resident_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':resident_id', $id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch();

if (isset($result['mother_id'])) {
    // the resident already has a mother set
    $mother_exists = true;
    $motherId = $result['mother_id'];
    $mother = $pdo->query("SELECT * FROM resident WHERE resident_id='$motherId'")->fetch();
    $mother_fullname = "$mother[firstname] $mother[middlename] $mother[lastname] $mother[suffix]";
} else {
    // the resident has no mother set
    $mother_exists = false;
}

if (isset($result['father_id'])) {
    // the resident already has a father set
    $father_exists = true;
    $fatherId = $result['father_id'];
    $father = $pdo->query("SELECT * FROM resident WHERE resident_id='$fatherId'")->fetch();
    $father_fullname = "$father[firstname] $father[middlename] $father[lastname] $father[suffix]";
} else {
    // the resident has no father set
    $father_exists = false;
}

//Getting Female residents from the database
$stmt = $pdo->prepare("SELECT * FROM resident WHERE sex = 'Female' AND barangay_id = :barangay_id AND resident_id != :resident_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->bindParam(':resident_id', $id, PDO::PARAM_INT);
$stmt->execute();
$femaleResidents = $stmt->fetchAll();
//Getting Male residents from the database
$stmt = $pdo->prepare("SELECT * FROM resident WHERE sex = 'Male' AND barangay_id = :barangay_id AND resident_id != :resident_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->bindParam(':resident_id', $id, PDO::PARAM_INT);
$stmt->execute();
$maleResidents = $stmt->fetchAll();
