<?php
function getBrgyOfficials($pdo)
{
    // select the name of brgy officials
    $sql = "SELECT resident.firstname, resident.lastname, officials.position
            FROM resident
            INNER JOIN officials ON resident.resident_id = officials.resident_id
            WHERE officials.position IN ('Barangay Secretary', 'Barangay Captain')";

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
