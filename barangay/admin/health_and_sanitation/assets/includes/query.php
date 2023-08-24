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

    /* Insert into resident table */
    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO resident (firstname, middlename, lastname, sex, birthdate, barangay_id)
                           VALUES (:firstname, :middlename, :lastname, :sex, :date_of_birth, :barangay_id)");

    $params = array(
        ':firstname' => $newborn_fname,
        ':middlename' => $newborn_mname,
        ':lastname' => $newborn_lname,
        ':sex' => $newborn_gender,
        ':date_of_birth' => $newborn_date_birth,
        ':barangay_id' => $barangayId
    );
    $stmt->execute($params);

    $resident_id = $pdo->lastInsertId();

    /* Insert newborn to newborn table */
    $stmt = $pdo->prepare("INSERT INTO hns_newborn (resident_id) VALUES (:resident_id)");
    $stmt->bindParam(':resident_id', $resident_id);
    $stmt->execute();


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
    // $newborn_date_added = $_POST['newborn_date_added'];

    $stmt = $pdo->prepare("UPDATE resident
                    JOIN hns_newborn ON resident.resident_id = hns_newborn.resident_id
                       SET firstname = :firstname,
                           middlename = :middlename,
                           lastname = :lastname,
                           sex = :sex,
                           birthdate = :date_of_birth
                           WHERE newborn_id = :newborn_id");

    $params = array(
        ':firstname' => $newborn_fname,
        ':middlename' => $newborn_mname,
        ':lastname' => $newborn_lname,
        ':sex' => $newborn_gender,
        ':date_of_birth' => $newborn_date_birth,
        ':newborn_id' => $newborn_id
    );
    $stmt->execute($params);

    echo "<script>alert('Record Updated!'); window.location.href = '../../newborn.php';</script>";
}
// delete newborn record
if (isset($_POST['submit_delete_newborn'])) {
    $newborn_id = $_POST['newborn_id'];
    $query = "DELETE FROM hns_newborn WHERE newborn_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$newborn_id]);
    echo "<script>alert('Deleted Successfully!'); window.location.href = '../../newborn.php';</script>";
    exit;
}

//PREGNANT QUERIES

// add pregnant record
if (isset($_POST['submit_add_pregnant'])) {
    $id_resident = $_POST['id_resident'];
    $pregnant_num = $_POST['pregnant_num'];
    $pregnant_due = $_POST['pregnant_due'];

    // Prepare the SQL statement for inserting data into the officials table
    $sql = "INSERT INTO pregnant (id_resident, pregnant_num, pregnant_due) 
        VALUES (:id_resident, :pregnant_num, :pregnant_due)";

    // Bind the values to the placeholders in the SQL statement using an array
    $params = array(
        ':id_resident' => $id_resident,
        ':pregnant_num' => $pregnant_num,
        ':pregnant_due' => $pregnant_due,
    );
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header('Location: ../../pregnant.php');
}
// edit pregnant record
if (isset($_POST['submit_edit_pregnant'])) {
    $pregnant_id = $_POST['pregnant_id'];
    $id_resident = $_POST['id_resident'];
    // $pregnant_occupation = $_POST['pregnant_occupation'];
    $pregnant_num = $_POST['pregnant_num'];
    $pregnant_due = $_POST['pregnant_due'];
    $pregnant_status = $_POST['pregnant_status'];

    $query = "UPDATE pregnant SET pregnant_num=?, pregnant_due=?
        WHERE pregnant_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$pregnant_num, $pregnant_due, $pregnant_id]);

    /* update in resident table */
    $query = "UPDATE resident SET civil_status=?
        WHERE resident_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$pregnant_status, $id_resident]);

    echo "<script>alert('Record Updated!'); window.location.href = '../../pregnant.php';</script>";
}
// delete pregnant record
if (isset($_POST['submit_delete_pregnant'])) {
    $pregnant_id = $_POST['pregnant_id'];
    $id_resident = $_POST['id_resident'];
    $query = "DELETE FROM pregnant WHERE pregnant_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$pregnant_id]);
    echo "<script>alert('Deleted Successfully!'); window.location.href = '../../pregnant.php';</script>";
    exit;
}


//DEATH QUERIES
// add death record
if (isset($_POST['submit_add_death'])) {
    $resident_id = $_POST['resident_id'];
    $death_date = $_POST['death_date'];
    $death_cause = $_POST['death_cause'];

    // SET THE IS_ALIVE VALUE IN RESIDENT TO 0 (meaning not alive)
    $sql = "UPDATE resident SET is_alive = 0 WHERE resident_id = :resident_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
    $stmt->execute();


    // INSERT THE RECORD INTO DEATH TABLE
    $sql = "INSERT INTO death (resident_id, death_date, death_cause) 
            VALUES (:resident_id, :death_date, :death_cause)";

    $params = array(
        'resident_id' => $resident_id,
        'death_date' => $death_date,
        'death_cause' => $death_cause
    );

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header('Location: ../../death.php');
    // exit(); // Terminate the script after redirecting

}
// edit death record
if (isset($_POST['submit_edit_death'])) {
    $resident_id = $_POST['resident_id'];
    $death_id = $_POST['death_id'];
    $death_fname = $_POST['death_fname'];
    $death_mname = $_POST['death_mname'];
    $death_lname = $_POST['death_lname'];
    $death_sex = $_POST['death_sex'];
    $death_address = $_POST['death_address'];
    $death_cause = $_POST['death_cause'];
    $death_date = $_POST['death_date'];

    $query = "UPDATE resident SET firstname=?, middlename=?, lastname=?, sex=?, address=? WHERE resident_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$death_fname, $death_mname, $death_lname, $death_sex, $death_address, $resident_id]);

    $query = "UPDATE death SET death_cause=?, death_date=? WHERE death_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$death_cause, $death_date, $death_id]);
    echo "<script>alert('Record Updated!'); window.location.href = '../../death.php';</script>";
}
// delete death record
if (isset($_POST['submit_delete_death'])) {
    $death_id = $_POST['death_id'];
    $resident_id = $_POST['resident_id'];

    $query = "DELETE FROM death WHERE death_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$death_id]);

    $query = "UPDATE resident SET is_alive = 1 WHERE resident_id = :resident_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
    $stmt->execute();

    echo "<script>alert('Deleted Successfully!'); window.location.href = '../../death.php';</script>";
    exit;
}

// add vaccine inventory
if (isset($_POST['submit_add_inventory-vaccine'])) {
    $vaccineName = $_POST['vaccineName'];

    // $vaccineStatus = $_POST['vaccineStatus'];
    $vaccineQuantity = $_POST['vaccineQuantity'];
    $vaccineStatus = ($vaccineQuantity > 0) ? 'Available' : 'Out of Stock';
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
