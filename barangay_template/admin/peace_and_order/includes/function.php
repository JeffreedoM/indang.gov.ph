<?php
//add nonresident
function addNonResident($pdo, $fname, $lname, $gender, $bdate, $number, $address, $barangayId, $incident_id)
{

    try {

        $stmt = $pdo->prepare("INSERT INTO non_resident(non_res_firstname, non_res_lastname, non_res_contact, non_res_gender, non_res_birthdate, non_res_address, barangay_id, incident_id) VALUES(:non_res_firstname, :non_res_lastname, :non_res_contact, :non_res_gender, :non_res_birthdate, :non_res_address, :b_id, :i_id )");
        $stmt->bindParam(':non_res_firstname', $fname);
        $stmt->bindParam(':non_res_lastname', $lname);
        $stmt->bindParam(':non_res_gender', $gender);
        $stmt->bindParam(':non_res_birthdate', $bdate);
        $stmt->bindParam(':non_res_contact', $number);
        $stmt->bindParam(':non_res_address', $address);
        $stmt->bindParam(':b_id', $barangayId);
        $stmt->bindParam(':i_id', $incident_id);


        $pdo->beginTransaction();
        $stmt->execute();
        $id = $pdo->lastInsertId();
        $pdo->commit();

        return $id;
    } catch (PDOException $e) {
        $pdo->rollback();
        throw $e;
    }
}

//add incident_offender
function addIncidentOffender($pdo, $offender_type, $id, $incident_id, $description)
{
    try {
        if ($offender_type === 'resident') {
            $stmt1 = $pdo->prepare("INSERT INTO incident_offender(offender_type, resident_id, incident_id, `desc`) VALUES(:offender_type,:resident_id,:incident_id, :desc)");
            $stmt1->bindParam(':offender_type', $offender_type);
            $stmt1->bindParam(':resident_id', $id);
            $stmt1->bindParam(':incident_id', $incident_id);
            $stmt1->bindParam(':desc', $description);

            $pdo->beginTransaction();
            if ($stmt1->execute()) {
                $pdo->commit();
                // echo "Data inserted successfully";
            } else {
                $pdo->rollback();
                echo "Error inserting data: " . $stmt1->errorInfo()[2];
            }
        } else {
            $stmt1 = $pdo->prepare("INSERT INTO incident_offender(offender_type, non_resident_id, incident_id, `desc`) VALUES(:offender_type,:non_resident_id,:incident_id, :desc)");
            $stmt1->bindParam(':offender_type', $offender_type);
            $stmt1->bindParam(':non_resident_id', $id);
            $stmt1->bindParam(':incident_id', $incident_id);
            $stmt1->bindParam(':desc', $description);

            $pdo->beginTransaction();
            if ($stmt1->execute()) {
                $pdo->commit();
                // echo "Data inserted successfully";
            } else {
                $pdo->rollback();
                echo "Error inserting data: " . $stmt1->errorInfo()[2];
            }
        }
    } catch (PDOException $e) {
        $pdo->rollback();
        throw $e;
    } finally {
        $pdo = null;
    }
}
function addIncidentComplainant($pdo, $complainant_type, $id, $incident_id)
{
    try {
        if ($complainant_type == 'resident') {

            $stmt2 = $pdo->prepare("INSERT INTO incident_complainant(complainant_type, resident_id, incident_id) VALUES(:complainant_type,:resident_id,:incident_id)");
            $stmt2->bindParam(':complainant_type', $complainant_type);
            $stmt2->bindParam(':resident_id', $id);
            $stmt2->bindParam(':incident_id', $incident_id);

            $pdo->beginTransaction();
            if ($stmt2->execute()) {
                $pdo->commit();
                // echo "Data inserted successfully";
            } else {
                $pdo->rollback();
                echo "Error inserting data: " . $stmt2->errorInfo()[2];
            }
        } else {

            $stmt2 = $pdo->prepare("INSERT INTO incident_complainant(complainant_type, non_resident_id, incident_id) VALUES(:complainant_type,:non_resident_id,:incident_id)");
            $stmt2->bindParam(':complainant_type', $complainant_type);
            $stmt2->bindParam(':non_resident_id', $id);
            $stmt2->bindParam(':incident_id', $incident_id);

            $pdo->beginTransaction();
            if ($stmt2->execute()) {
                $pdo->commit();
                // echo "Data inserted successfully";
            } else {
                $pdo->rollback();
                echo "Error inserting data: " . $stmt2->errorInfo()[2];
            }
        }
    } catch (PDOException $e) {
        $pdo->rollback();
        throw $e;
    } finally {
        $pdo = null;
    }
}

//selecting table incident_complainant
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

//selecting table incident_offender
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
function getComplainantIds($pdo, $id)
{
    $sql = "SELECT * FROM incident_complainant WHERE complainant_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getOffenderIds($pdo, $id)
{
    $sql = "SELECT * FROM incident_offender WHERE offender_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function fetchDetails($pdo, $type, $id)
{
    $stmt = null;
    $details = array();

    if ($type === 'resident') {
        $stmt = $pdo->prepare("SELECT * FROM resident WHERE resident_id = :id");
    } else if ($type === 'non_resident') {
        $stmt = $pdo->prepare("SELECT * FROM non_resident WHERE non_resident_id = :id");
    }

    if ($stmt) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($record) {
            if ($type === 'resident') {
                $details['fname'] = $record['firstname'];
                $details['lname'] = $record['lastname'];
                $details['number'] = $record['contact'];
                $details['gender'] = $record['sex'];
                $details['bdate'] = $record['birthdate'];
                $details['address'] = $record['address'];
            } else if ($type === 'non_resident') {
                $details['fname'] = $record['non_res_firstname'];
                $details['lname'] = $record['non_res_lastname'];
                $details['number'] = $record['non_res_contact'];
                $details['gender'] = $record['non_res_gender'];
                $details['bdate'] = $record['non_res_birthdate'];
                $details['address'] = $record['non_res_address'];
            }
        }
    }

    return $details;
}

function isChecked($value, $case)
{
    if ($case === "criminal") {
        return ($value === $case) ? "checked" : "";
    } else if ($case === "civil") {
        return ($value === $case) ? "checked" : "";
    } else {
        return "checked";
    }
}

function getBrgyOfficials($pdo, $barangayId)
{
    // select the name of brgy officials
    $sql = "SELECT resident.*, officials.position
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
                'middlename' => !empty($list['middlename']) ? (strtoupper($list['middlename'][0])) . '. ' : '',
                'lastname' => $list['lastname'],
                'suffix' => !empty($list['suffix'] != '') ? " ($list[suffix])" : ''
            ];
        } else {
            $officials['captain'] = [
                'firstname' => $list['firstname'],
                'middlename' => !empty($list['middlename']) ? (strtoupper($list['middlename'][0])) . '. ' : '',
                'lastname' => $list['lastname'],
                'suffix' => !empty($list['suffix'] != '') ? " ($list[suffix])" : ''

            ];
        }
    }
    return $officials;
}

function getIncidentsByBarangayId($incident_id, $barangayId, $pdo)
{
    // Assuming $pdo is your PDO connection object

    $sql = "SELECT * FROM incident_table WHERE incident_id = :i_id AND barangay_id = :barangayId";
    $query = $pdo->prepare($sql);
    $query->bindParam(':barangayId', $barangayId);
    $query->bindParam(':i_id', $incident_id);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function getIncidentReports($pdo, $resident_id, $barangayId)
{
    $stmt = $pdo->prepare("
        SELECT *
        FROM incident_offender 
        LEFT JOIN resident ON incident_offender.resident_id = resident.resident_id
        LEFT JOIN incident_table ON incident_offender.incident_id = incident_table.incident_id
        WHERE incident_offender.resident_id = :id AND resident.barangay_id = :barangay_id");

    $stmt->bindParam(':id', $resident_id, PDO::PARAM_INT);
    $stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getStatusText($statusValue)
{
    switch ($statusValue) {
        case "1":
            return "On-going";
        case "2":
            return "Dismiss";
        case "3":
            return "Certified 4a";
        case "4":
            return "Mediated";
        case "5":
            return "Resolved";
        default:
            return "";
    }
}
