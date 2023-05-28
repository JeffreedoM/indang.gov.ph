<?php
//add nonresident
function addNonResident($fname, $lname, $gender, $bdate, $number, $address)
{
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=bmis", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO non_resident(non_res_firstname, non_res_lastname, non_res_contact, non_res_gender, non_res_birthdate, non_res_address) VALUES(:non_res_firstname, :non_res_lastname, :non_res_contact, :non_res_gender, :non_res_birthdate, :non_res_address)");
        $stmt->bindParam(':non_res_firstname', $fname);
        $stmt->bindParam(':non_res_lastname', $lname);
        $stmt->bindParam(':non_res_gender', $gender);
        $stmt->bindParam(':non_res_birthdate', $bdate);
        $stmt->bindParam(':non_res_contact', $number);
        $stmt->bindParam(':non_res_address', $address);

        $pdo->beginTransaction();
        $stmt->execute();
        $id = $pdo->lastInsertId();
        $pdo->commit();

        return $id;
    } catch (PDOException $e) {
        $pdo->rollback();
        throw $e;
    } finally {
        $pdo = null;
    }
}

//add incident_offender
function addIncidentOffender($offender_type, $id, $incident_id, $description)
{
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=bmis", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($offender_type === 'resident') {
            $stmt1 = $pdo->prepare("INSERT INTO incident_offender(offender_type, resident_id, incident_id, `desc`) VALUES(:offender_type,:resident_id,:incident_id, :desc)");
            $stmt1->bindParam(':offender_type', $offender_type);
            $stmt1->bindParam(':resident_id', $id);
            $stmt1->bindParam(':incident_id', $incident_id);
            $stmt1->bindParam(':desc', $description);

            $pdo->beginTransaction();
            if ($stmt1->execute()) {
                $pdo->commit();
                echo "Data inserted successfully";
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
                echo "Data inserted successfully";
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
function addIncidentComplainant($complainant_type, $id, $incident_id)
{
    try {
        if ($complainant_type == 'resident') {
            $pdo = new PDO("mysql:host=localhost;dbname=bmis", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt2 = $pdo->prepare("INSERT INTO incident_complainant(complainant_type, resident_id, incident_id) VALUES(:complainant_type,:resident_id,:incident_id)");
            $stmt2->bindParam(':complainant_type', $complainant_type);
            $stmt2->bindParam(':resident_id', $id);
            $stmt2->bindParam(':incident_id', $incident_id);

            $pdo->beginTransaction();
            if ($stmt2->execute()) {
                $pdo->commit();
                echo "Data inserted successfully";
            } else {
                $pdo->rollback();
                echo "Error inserting data: " . $stmt2->errorInfo()[2];
            }
        } else {
            $pdo = new PDO("mysql:host=localhost;dbname=bmis", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt2 = $pdo->prepare("INSERT INTO incident_complainant(complainant_type, non_resident_id, incident_id) VALUES(:complainant_type,:non_resident_id,:incident_id)");
            $stmt2->bindParam(':complainant_type', $complainant_type);
            $stmt2->bindParam(':non_resident_id', $id);
            $stmt2->bindParam(':incident_id', $incident_id);

            $pdo->beginTransaction();
            if ($stmt2->execute()) {
                $pdo->commit();
                echo "Data inserted successfully";
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
