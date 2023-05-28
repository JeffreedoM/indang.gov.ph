<?php
//Getting residents from the database
$stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$residents = $stmt->fetchAll(PDO::FETCH_ASSOC);
$o_residents = $residents;

if (isset($_POST['submit'])) {
    //
    $offender_type = $_POST['o_res'];
    $complainant_type = $_POST['c_res'];
    $blotter_type = $_POST['blotter_type'];

    // for Resident id
    $offender_id = $_POST['offender_id'];
    $complainant_id = $_POST['complainant_id'];


    //insert to incident_reporting_person db
    $complainant_fname = $_POST['c_fname'];
    $complainant_lname = $_POST['c_lname'];
    $complainant_gender = $_POST['c_gender'];
    $complainant_bdate = $_POST['c_bdate'];
    $complainant_number = $_POST['c_number'];
    $complainant_address = $_POST['c_address'];

    //insert to incident_offender db
    $offender_fname = $_POST['o_fname'];
    $offender_lname = $_POST['o_lname'];
    $offender_gender = $_POST['o_gender'];
    $offender_bdate = $_POST['o_bdate'];
    $offender_number = $_POST['o_number'];
    $offender_address = $_POST['o_address'];
    $description = $_POST['desc'];

    //insert to incident_table db
    if ($_POST['i_case'] == 'more') {
        $case_incident = $_POST['case_more'];
    } else {
        $case_incident = $_POST['i_case'];
    }

    $i_title = $_POST['i_title'];
    $i_date = $_POST['i_date'];
    $i_time = $_POST['i_time'];
    $location = $_POST['i_location'];
    $status = 1;
    $narrative = $_POST['narrative'];

    $stmt3 = $pdo->prepare("INSERT INTO incident_table(case_incident, incident_title, date_incident, time_incident, location,status, narrative, blotterType_id, barangay_id) VALUES(:case_incident,:i_title,:i_date,:i_time,:location,:status,:narrative,:blotterType_id, :b_id)");
    $stmt3->bindParam(':case_incident', $case_incident);
    $stmt3->bindParam(':i_title', $i_title);
    $stmt3->bindParam(':i_date', $i_date);
    $stmt3->bindParam(':i_time', $i_time);
    $stmt3->bindParam(':location', $location);
    $stmt3->bindParam(':status', $status);
    $stmt3->bindParam(':narrative', $narrative);
    $stmt3->bindParam(':blotterType_id', $blotter_type);
    $stmt3->bindParam(':b_id', $barangayId);

    // Execute the third query and get the inserted ID
    $pdo->beginTransaction();
    $stmt3->execute();
    $incident_id = $pdo->lastInsertId();
    $pdo->commit();


    //complainant insert data
    if ($complainant_type === 'resident') {
        // Prepare the first query


        // Prepare the complainant query
        $stmt = $pdo->prepare("INSERT INTO incident_complainant(complainant_type, resident_id, incident_id) VALUES(:complainant_type,:resident_id,:incident_id)");
        $stmt->bindParam(':complainant_type', $complainant_type);
        $stmt->bindParam(':resident_id', $complainant_id);
        $stmt->bindParam(':incident_id', $incident_id);

        // Execute the second query and get the inserted ID
        $pdo->beginTransaction();
        $stmt->execute();
        $pdo->commit();
    } else {
        //Prepare non-resident query
        $stmt = $pdo->prepare("INSERT INTO non_resident(non_res_firstname, non_res_lastname, non_res_contact, non_res_gender, non_res_birthdate, non_res_address,barangay_id,incident_id) VALUES(:non_res_firstname, :non_res_lastname, :non_res_contact, :non_res_gender, :non_res_birthdate, :non_res_address, :b_id, :i_id)");
        $stmt->bindParam(':non_res_firstname', $complainant_fname);
        $stmt->bindParam(':non_res_lastname', $complainant_lname);
        $stmt->bindParam(':non_res_gender', $complainant_gender);
        $stmt->bindParam(':non_res_birthdate', $complainant_bdate);
        $stmt->bindParam(':non_res_contact', $complainant_number);
        $stmt->bindParam(':non_res_address', $complainant_address);
        $stmt->bindParam(':b_id', $barangayId);
        $stmt->bindParam(':i_id', $incident_id);
        // Execute the second query and get the inserted ID
        $pdo->beginTransaction();
        $stmt->execute();
        $non_resident_id = $pdo->lastInsertId();
        $pdo->commit();

        // Prepare the complainant query
        $stmt = $pdo->prepare("INSERT INTO incident_complainant(complainant_type, non_resident_id, incident_id) VALUES(:complainant_type,:non_resident_id,:incident_id)");
        $stmt->bindParam(':complainant_type', $complainant_type);
        $stmt->bindParam(':non_resident_id', $non_resident_id);
        $stmt->bindParam(':incident_id', $incident_id);

        // Execute the second query and get the inserted ID
        $pdo->beginTransaction();
        $stmt->execute();
        $pdo->commit();
    }


    //offender insert data
    if ($offender_type === 'resident') {
        // Prepare the first query
        $stmt = $pdo->prepare("INSERT INTO incident_offender(offender_type, resident_id, incident_id, `desc`) VALUES(:offender_type,:resident_id,:incident_id, :desc)");
        $stmt->bindParam(':offender_type', $offender_type);
        $stmt->bindParam(':resident_id', $offender_id);
        $stmt->bindParam(':incident_id', $incident_id);
        $stmt->bindParam(':desc', $description);

        // Execute the first query and get the inserted ID
        $pdo->beginTransaction();
        $stmt->execute();
        $pdo->commit();
    } else {
        //Prepare non-resident query
        $stmt = $pdo->prepare("INSERT INTO non_resident(non_res_firstname, non_res_lastname, non_res_gender, non_res_contact, non_res_birthdate, non_res_address, barangay_id, incident_id) VALUES(:non_res_firstname, :non_res_lastname, :non_res_gender, :non_res_contact, :non_res_birthdate, :non_res_address, :b_id, :i_id)");
        $stmt->bindParam(':non_res_firstname', $offender_fname);
        $stmt->bindParam(':non_res_lastname', $offender_lname);
        $stmt->bindParam(':non_res_gender', $offender_gender);
        $stmt->bindParam(':non_res_contact', $offender_number);
        $stmt->bindParam(':non_res_birthdate', $offender_bdate);
        $stmt->bindParam(':non_res_address', $offender_address);
        $stmt->bindParam(':b_id', $barangayId);
        $stmt->bindParam(':i_id', $incident_id);

        $pdo->beginTransaction();
        $stmt->execute();
        $non_resident_id = $pdo->lastInsertId();
        $pdo->commit();

        // Prepare the complainant query
        $stmt = $pdo->prepare("INSERT INTO incident_offender(offender_type, non_resident_id, incident_id, `desc`) VALUES(:offender_type,:non_resident_id,:incident_id, :desc)");
        $stmt->bindParam(':offender_type', $offender_type);
        $stmt->bindParam(':non_resident_id', $non_resident_id);
        $stmt->bindParam(':incident_id', $incident_id);
        $stmt->bindParam(':desc', $description);

        // Execute the first query and get the inserted ID
        $pdo->beginTransaction();
        $stmt->execute();
        $pdo->commit();
    }
}
