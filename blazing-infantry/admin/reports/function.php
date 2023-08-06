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

function convertToTagalogMonth($date)
{
    // English to Tagalog month mapping
    $months = array(
        'January'   => 'Enero',
        'February'  => 'Pebrero',
        'March'     => 'Marso',
        'April'     => 'Abril',
        'May'       => 'Mayo',
        'June'      => 'Hunyo',
        'July'      => 'Hulyo',
        'August'    => 'Agosto',
        'September' => 'Setyembre',
        'October'   => 'Oktubre',
        'November'  => 'Nobyembre',
        'December'  => 'Disyembre',
    );

    // Create a DateTime object from the date string
    $dateTime = new DateTime($date);

    // Extract the month in English
    $monthEnglish = $dateTime->format('F');

    // Convert the English month to Tagalog using the array
    $tagalogMonth = $months[$monthEnglish];

    return $tagalogMonth;
}

function getIncidentComplainant($pdo, $id)
{
    $sql = "
    SELECT *
    FROM incident_complainant 
    LEFT JOIN resident ON incident_complainant.resident_id = resident.resident_id
    LEFT JOIN non_resident ON incident_complainant.non_resident_id = non_resident.non_resident_id
    LEFT JOIN incident_table ON incident_complainant.incident_id = incident_table.incident_id
    WHERE incident_complainant.incident_id = :id

    ORDER BY complainant_id ASC
    ";
    $query = $pdo->prepare($sql);
    $query->execute(['id' => $id]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function getIncidentOffender($pdo, $id)
{
    $sql = "
    SELECT *
    FROM incident_offender 
    LEFT JOIN resident ON incident_offender.resident_id = resident.resident_id
    LEFT JOIN non_resident ON incident_offender.non_resident_id = non_resident.non_resident_id
    LEFT JOIN incident_table ON incident_offender.incident_id = incident_table.incident_id
    WHERE incident_offender.incident_id = :id
    ";
    $query = $pdo->prepare($sql);
    $query->execute(['id' => $id]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
