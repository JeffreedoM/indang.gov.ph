<?php
include '../../../../includes/dbh.inc.php';
include '../../../../includes/deactivated.inc.php';

// VACCINATION QUERIES

// add vaccine record
if (isset($_POST['submit_add_vaccine'])) {

    $vaccine_batch = $_POST['vaccine_batch'];

    // Prepare the SQL statement for selecting the resident
    $sql_get = "SELECT * FROM vaccine_inventory WHERE vaccineInventoryID = :vaccine_batch";
    $stmt = $pdo->prepare($sql_get);
    $stmt->bindParam(':vaccine_batch', $vaccine_batch);
    $stmt->execute();

    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($record) {

        $vaccineQuantityOrig = $record['vaccineQuantity'];
        if ($vaccineQuantityOrig == 0) {
            echo "<script>alert('Out of Stock'); window.location.href = '../../vaccination-inventory.php';</script>";
        } else {
            $vaccineQuantity = $record['vaccineQuantity'] - 1;
            $sql_update = "UPDATE vaccine_inventory SET vaccineQuantity = :vaccineQuantity
                WHERE vaccineInventoryID = :vaccine_batch";

            $stmt = $pdo->prepare($sql_update);
            $stmt->bindParam(':vaccineQuantity', $vaccineQuantity);
            $stmt->bindParam(':vaccine_batch', $vaccine_batch);
            $stmt->execute();

            $id_resident = $_POST['id_resident'];
            $vaccine_dose = $_POST['vaccine_dose'];
            $vaccine_date = $_POST['vaccine_date'];
            $vaccine_place = $_POST['vaccine_place'];

            // Prepare the SQL statement for inserting data into the officials table
            $sql = "INSERT INTO vaccine (id_resident, vaccine_dose, vaccineInvID,vaccine_date,vaccine_place) 
                VALUES (:id_resident, :vaccine_dose, :vaccineInvID, :vaccine_date, :vaccine_place)";

            // Bind the values to the placeholders in the SQL statement using an array
            $params = array(
                ':id_resident' => $id_resident,
                ':vaccine_dose' => $vaccine_dose,
                ':vaccineInvID' => $vaccine_batch,
                ':vaccine_date' => $vaccine_date,
                ':vaccine_place' => $vaccine_place
            );
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
        }
    }
    echo "<script>alert('Record Added!'); window.location.href = '../../vaccination.php';</script>";
}
// edit vaccine record
if (isset($_POST['submit_edit'])) {
    $id_resident = $_POST['id_resident'];
    $vaccine_dose = $_POST['vaccine_dose'];
    $vaccine_date = $_POST['vaccine_date'];
    $vaccine_place = $_POST['vaccine_place'];

    $query = "UPDATE vaccine SET vaccine_dose=?, vaccine_date=?, vaccine_place=?
        WHERE id_resident=?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$vaccine_dose, $vaccine_date, $vaccine_place, $id_resident]);
    echo "<script>alert('Record Updated!'); window.location.href = '../../vaccination.php';</script>";
}
// delete vaccine record
if (isset($_POST['submit_delete'])) {
    $id_resident = $_POST['id_resident'];
    $query = "DELETE FROM vaccine WHERE id_resident=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_resident]);
    echo "<script>alert('Deleted Successfully!'); window.location.href = '../../vaccination.php';</script>";
    exit;
}


// NEWBORN QUERIES

// add newborn record
if (isset($_POST['submit_add_newborn'])) {
    $newborn_fname = $_POST['newborn_fname'];
    $newborn_mname = $_POST['newborn_mname'];
    $newborn_lname = $_POST['newborn_lname'];
    $newborn_gender = $_POST['newborn_gender'];
    $newborn_date_birth = $_POST['newborn_date_birth'];
    $newborn_date_added = date('Y-m-d');
    $newborn_brgyID = $_POST['barangayID'];

    // Prepare the SQL statement for inserting data into the officials table
    $sql = "INSERT INTO newborn (newborn_fname, newborn_mname, newborn_lname,newborn_gender,newborn_date_birth,newborn_date_added,newborn_brgyID) 
        VALUES (:newborn_fname, :newborn_mname, :newborn_lname, :newborn_gender, :newborn_date_birth, :newborn_date_added,:newborn_brgyID)";

    // Bind the values to the placeholders in the SQL statement using an array
    $params = array(
        ':newborn_fname' => $newborn_fname,
        ':newborn_mname' => $newborn_mname,
        ':newborn_lname' => $newborn_lname,
        ':newborn_gender' => $newborn_gender,
        ':newborn_date_birth' => $newborn_date_birth,
        ':newborn_date_added' => $newborn_date_added,
        ':newborn_brgyID' => $newborn_brgyID
    );
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header('Location: ../../newborn.php');
}
// edit newborn record
if (isset($_POST['submit_edit_newborn'])) {
    $newborn_id = $_POST['newborn_id'];
    $newborn_fname = $_POST['newborn_fname'];
    $newborn_mname = $_POST['newborn_mname'];
    $newborn_lname = $_POST['newborn_lname'];
    $newborn_gender = $_POST['newborn_gender'];
    $newborn_date_birth = $_POST['newborn_date_birth'];
    $newborn_date_added = $_POST['newborn_date_added'];

    $query = "UPDATE newborn SET newborn_fname=?, newborn_mname=?, newborn_lname=?, newborn_gender=?, newborn_date_birth=?, newborn_date_added=? 
        WHERE newborn_id=?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$newborn_fname, $newborn_mname, $newborn_lname, $newborn_gender, $newborn_date_birth, $newborn_date_added, $newborn_id]);
    echo "<script>alert('Record Updated!'); window.location.href = '../../newborn.php';</script>";
}
// delete newborn record
if (isset($_POST['submit_delete_newborn'])) {
    $newborn_id = $_POST['newborn_id'];
    $query = "DELETE FROM newborn WHERE newborn_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$newborn_id]);
    echo "<script>alert('Deleted Successfully!'); window.location.href = '../../newborn.php';</script>";
    exit;
}

//PREGNANT QUERIES

// add pregnant record
if (isset($_POST['submit_add_pregnant'])) {
    $id_resident = $_POST['id_resident'];
    $pregnant_occupation = $_POST['pregnant_occupation'];
    $pregnant_num = $_POST['pregnant_num'];
    $pregnant_status = $_POST['pregnant_status'];

    // Prepare the SQL statement for inserting data into the officials table
    $sql = "INSERT INTO pregnant (id_resident, pregnant_occupation, pregnant_num,pregnant_status) 
        VALUES (:id_resident, :pregnant_occupation, :pregnant_num, :pregnant_status)";

    // Bind the values to the placeholders in the SQL statement using an array
    $params = array(
        ':id_resident' => $id_resident,
        ':pregnant_occupation' => $pregnant_occupation,
        ':pregnant_num' => $pregnant_num,
        ':pregnant_status' => $pregnant_status
    );
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header('Location: ../../pregnant.php');
}
// edit pregnant record
if (isset($_POST['submit_edit_pregnant'])) {
    $id_resident = $_POST['id_resident'];
    $pregnant_occupation = $_POST['pregnant_occupation'];
    $pregnant_num = $_POST['pregnant_num'];
    $pregnant_status = $_POST['pregnant_status'];

    $query = "UPDATE pregnant SET pregnant_occupation=?, pregnant_num=?, pregnant_status=? 
        WHERE id_resident=?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$pregnant_occupation, $pregnant_num, $pregnant_status, $id_resident]);
    echo "<script>alert('Record Updated!'); window.location.href = '../../pregnant.php';</script>";
}
// delete vaccine record
if (isset($_POST['submit_delete_pregnant'])) {
    $id_resident = $_POST['id_resident'];
    $query = "DELETE FROM pregnant WHERE id_resident=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_resident]);
    echo "<script>alert('Deleted Successfully!'); window.location.href = '../../pregnant.php';</script>";
    exit;
}


//DEATH QUERIES
// add death record
if (isset($_POST['submit_add_death'])) {
    $id_resident = $_POST['id_resident'];
    $death_cause = $_POST['death_cause'];
    $death_date = $_POST['death_date'];

    // Prepare the SQL statement for selecting the resident
    $sql = "SELECT * FROM resident WHERE resident_id = :id_resident";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_resident', $id_resident);
    $stmt->execute();

    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($record) {
        $firstname = $record['firstname'];
        $lastname = $record['lastname'];
        $middlename = $record['middlename'];
        $suffix = $record['suffix'];
        $sex = $record['sex'];
        $birthdate = $record['birthdate'];
        $age = $record['age'];
        $civil_status = $record['civil_status'];
        $contact = $record['contact'];
        $contact_type = $record['contact_type'];
        $height = $record['height'];
        $weight = $record['weight'];
        $religion = $record['religion'];
        $occupation_status = $record['occupation_status'];
        $occupation = $record['occupation'];
        $address = $record['address'];
        $image = $record['image'];

        // Prepare the SQL statement for inserting data into the death table
        $sql = "INSERT INTO death (barangay_id, resident_id, firstname, lastname, middlename, suffix, sex, birthdate,
                    age, civil_status, contact, contact_type, height, weight, religion, occupation_status, occupation,
                    address, image, death_cause, death_date) 
                    VALUES (:barangay_id, :resident_id, :firstname, :lastname, :middlename, :suffix, :sex, :birthdate,
                    :age, :civil_status, :contact, :contact_type, :height, :weight, :religion, :occupation_status, :occupation,
                    :address, :image, :death_cause, :death_date)";

        // Bind the values to the placeholders in the SQL statement using an array
        $params = array(
            ':barangay_id' => $barangayId,
            ':resident_id' => $id_resident,
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':middlename' => $middlename,
            ':suffix' => $suffix,
            ':sex' => $sex,
            ':birthdate' => $birthdate,
            ':age' => $age,
            ':civil_status' => $civil_status,
            ':contact' => $contact,
            ':contact_type' => $contact_type,
            ':height' => $height,
            ':weight' => $weight,
            ':religion' => $religion,
            ':occupation_status' => $occupation_status,
            ':occupation' => $occupation,
            ':address' => $address,
            ':image' => $image,
            ':death_cause' => $death_cause,
            ':death_date' => $death_date
        );

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        // // Check referencing foreign key
        // $sql2 = "SELECT COUNT(*) FROM officials WHERE resident_id = :resident_id";
        // $stmt2 = $pdo->prepare($sql2);
        // $stmt2->bindParam(':resident_id', $id_resident);
        // $stmt2->execute();

        // $count = $stmt2->fetchColumn();

        // if ($count > 0) {
        //     // Delete the related records in the referencing table first
        //     $sql3 = "DELETE FROM officials WHERE resident_id = :resident_id";
        //     $stmt3 = $pdo->prepare($sql3);
        //     $stmt3->bindParam(':resident_id', $id_resident);
        //     $stmt3->execute();
        // }

        if ($sql) {
            // Delete the primary record
            $sql4 = "DELETE FROM resident WHERE resident_id = :resident_id";
            $stmt4 = $pdo->prepare($sql4);
            $stmt4->bindParam(':resident_id', $id_resident);
            $stmt4->execute();

            echo 'nakarating dito';
        }

        // header('Location: ../../death.php');
        exit(); // Terminate the script after redirecting
    }
}
// edit death record
if (isset($_POST['submit_edit_death'])) {
    $id_resident = $_POST['death_id'];
    $death_fname = $_POST['death_fname'];
    $death_mname = $_POST['death_mname'];
    $death_lname = $_POST['death_lname'];
    $death_sex = $_POST['death_sex'];
    $death_address = $_POST['death_address'];
    $death_cause = $_POST['death_cause'];
    $death_date = $_POST['death_date'];

    $query = "UPDATE death SET firstname=?, middlename=?, lastname=?, sex=?, address=?, death_cause=?, death_date=?
        WHERE death_id=?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$death_fname, $death_mname, $death_lname, $death_sex, $death_address, $death_cause, $death_date, $id_resident]);
    echo "<script>alert('Record Updated!'); window.location.href = '../../death.php';</script>";
}
// delete death record
if (isset($_POST['submit_delete_death'])) {
    $id_resident = $_POST['death_id'];
    $query = "DELETE FROM death WHERE death_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_resident]);
    echo "<script>alert('Deleted Successfully!'); window.location.href = '../../death.php';</script>";
    exit;
}

// add vaccine inventory
if (isset($_POST['submit_add_inventory-vaccine'])) {
    $vaccineName = $_POST['vaccineName'];
    $vaccineStatus = $_POST['vaccineStatus'];
    $vaccineQuantity = $_POST['vaccineQuantity'];
    $vaccineExpDate = $_POST['vaccineExpDate'];
    $vaccineDescrip = $_POST['vaccineDescrip'];
    $vaccineBrgyID = $_POST['brgy_id'];

    // Prepare the SQL statement for inserting data into the officials table
    $sql = "INSERT INTO vaccine_inventory (vaccineName, vaccineStatus, vaccineQuantity,vaccineExpDate, vaccineDescrip, vaccineBrgyID) 
        VALUES (:vaccineName, :vaccineStatus, :vaccineQuantity, :vaccineExpDate, :vaccineDescrip, :vaccineBrgyID)";

    // Bind the values to the placeholders in the SQL statement using an array
    $params = array(
        ':vaccineName' => $vaccineName,
        ':vaccineStatus' => $vaccineStatus,
        ':vaccineQuantity' => $vaccineQuantity,
        ':vaccineExpDate' => $vaccineExpDate,
        ':vaccineDescrip' => $vaccineDescrip,
        ':vaccineBrgyID' => $vaccineBrgyID
    );
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header('Location: ../../vaccination-inventory.php');
}
// edit vaccine inventory
if (isset($_POST['submit_edit-inventory'])) {
    $vaccineInventoryID = $_POST['vaccineInventoryID'];
    $vaccineName = $_POST['vaccineName'];
    $vaccineQuantity = $_POST['vaccineQuantity'];
    $vaccineExpDate = $_POST['vaccineExpDate'];
    $vaccineStatus = $_POST['vaccineStatus'];
    $vaccineDescrip = $_POST['vaccineDescrip'];

    $query = "UPDATE vaccine_inventory SET vaccineName=?, vaccineQuantity=?, vaccineExpDate=?, vaccineStatus=?, vaccineDescrip=?
        WHERE vaccineInventoryID=?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$vaccineName, $vaccineQuantity, $vaccineExpDate, $vaccineStatus, $vaccineDescrip, $vaccineInventoryID]);
    echo "<script>alert('Record Updated!'); window.location.href = '../../vaccination-inventory.php';</script>";
}
if (isset($_POST['submit_delete-inventory'])) {
    $vaccineInventoryID = $_POST['vaccineInventoryID'];
    $query = "DELETE FROM vaccine_inventory WHERE vaccineInventoryID=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$vaccineInventoryID]);
    echo "<script>alert('Deleted Successfully!'); window.location.href = '../../vaccination-inventory.php';</script>";
    exit;
}
