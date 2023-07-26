<?php
function getBrgyOfficials($pdo, $barangayId)
{
    // select the name of brgy officials
    $sql = "SELECT resident.firstname, resident.lastname, officials.position
            FROM resident
            INNER JOIN officials ON resident.resident_id = officials.resident_id
            WHERE barangay_id = $barangayId AND officials.position IN ('Barangay Secretary', 'Barangay Captain')";

    $stmt = $pdo->query($sql);
    $brgy_off = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // display the secretary and captain
    $officials = [];
    foreach ($brgy_off as $list) {
        if ($list['position'] == 'Barangay Secretary') {
            $officials['secretary'] = [
                'firstname' => $list['firstname'],
                'lastname' => $list['lastname']
            ];
        } else {
            $officials['captain'] = [
                'firstname' => $list['firstname'],
                'lastname' => $list['lastname']
            ];
        }
    }
    return $officials;
}

//getting last and first day month
function getLastDayOfMonth($year, $month)
{
    $lastDay = date("F t, Y", strtotime($year . "-" . $month . "-01"));
    return $lastDay;
}
function getFirstDayOfMonth($year, $month)
{
    $firstDay = date("F 1, Y", strtotime($year . "-" . $month . "-01"));
    return $firstDay;
}



//Count all resident
function getResidentCount($pdo, $barangayId)
{
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM resident WHERE barangay_id = $barangayId");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

//Count all family
function getR_familyCount($pdo, $barangayId)
{


    $stmt = $pdo->prepare("SELECT COUNT(DISTINCT f.family_id) as count FROM resident_family f
    LEFT JOIN resident r ON r.family_id = f.family_id
    WHERE r.barangay_id = $barangayId");

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}
