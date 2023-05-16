<?php
    include '../../../../includes/dbh.inc.php';

    // VACCINATION QUERIES

    // add vaccine record
    if (isset($_POST['submit_add_vaccine'])) {
        $id_resident = $_POST['id_resident'];
        $vaccine_fname = $_POST['vaccine_fname'];
        $vaccine_dose = $_POST['vaccine_dose'];
        $vaccine_type = $_POST['vaccine_type'];
        $vaccine_date = $_POST['vaccine_date'];
        $vaccine_place = $_POST['vaccine_place'];
    
        // Prepare the SQL statement for inserting data into the officials table
        $sql = "INSERT INTO vaccine (id_resident, vaccine_fname, vaccine_dose, vaccine_type,vaccine_date,vaccine_place) 
        VALUES (:id_resident, :vaccine_fname, :vaccine_dose, :vaccine_type, :vaccine_date, :vaccine_place)";
    
        // Bind the values to the placeholders in the SQL statement using an array
        $params = array(
            ':id_resident' => $id_resident,
            ':vaccine_fname' => $vaccine_fname,
            ':vaccine_dose' => $vaccine_dose,
            ':vaccine_type' => $vaccine_type,
            ':vaccine_date' => $vaccine_date,
            ':vaccine_place' => $vaccine_place);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    
        header('Location: ../../vaccination.php');
    }
    // edit vaccine record
    if (isset($_POST['submit_edit'])) {
        $id_resident = $_POST['id_resident'];
        $vaccine_fname = $_POST['vaccine_fname'];
        $vaccine_dose = $_POST['vaccine_dose'];
        $vaccine_type = $_POST['vaccine_type'];
        $vaccine_date = $_POST['vaccine_date'];
        $vaccine_place = $_POST['vaccine_place'];
      
        $query = "UPDATE vaccine SET vaccine_fname=?, vaccine_dose=?, vaccine_type=?, vaccine_date=?, vaccine_place=?
        WHERE id_resident=?";

        $stmt = $pdo->prepare($query);
        $stmt->execute([$vaccine_fname, $vaccine_dose, $vaccine_type, $vaccine_date, $vaccine_place, $id_resident]);
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
    
        // Prepare the SQL statement for inserting data into the officials table
        $sql = "INSERT INTO newborn (newborn_fname, newborn_mname, newborn_lname,newborn_gender,newborn_date_birth,newborn_date_added) 
        VALUES (:newborn_fname, :newborn_mname, :newborn_lname, :newborn_gender, :newborn_date_birth, :newborn_date_added)";
    
        // Bind the values to the placeholders in the SQL statement using an array
        $params = array(
            ':newborn_fname' => $newborn_fname,
            ':newborn_mname' => $newborn_mname,
            ':newborn_lname' => $newborn_lname,
            ':newborn_gender' => $newborn_gender,
            ':newborn_date_birth' => $newborn_date_birth,
            ':newborn_date_added' => $newborn_date_added);
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

    // add vaccine record
    if (isset($_POST['submit_add_pregnant'])) {
        $id_resident = $_POST['id_resident'];
        $pregnant_fname = $_POST['pregnant_fname'];
        $pregnant_occupation = $_POST['pregnant_occupation'];
        $pregnant_num = $_POST['pregnant_num'];
        $pregnant_status = $_POST['pregnant_status'];
    
        // Prepare the SQL statement for inserting data into the officials table
        $sql = "INSERT INTO pregnant (id_resident, pregnant_fname, pregnant_occupation, pregnant_num,pregnant_status) 
        VALUES (:id_resident, :pregnant_fname, :pregnant_occupation, :pregnant_num, :pregnant_status)";
    
        // Bind the values to the placeholders in the SQL statement using an array
        $params = array(
            ':id_resident' => $id_resident,
            ':pregnant_fname' => $pregnant_fname,
            ':pregnant_occupation' => $pregnant_occupation,
            ':pregnant_num' => $pregnant_num,
            ':pregnant_status' => $pregnant_status);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    
        header('Location: ../../pregnant.php');
    }
    // edit pregnant record
    if (isset($_POST['submit_edit_pregnant'])) {
        $id_resident = $_POST['id_resident'];
        $pregnant_fname = $_POST['pregnant_fname'];
        $pregnant_occupation = $_POST['pregnant_occupation'];
        $pregnant_num = $_POST['pregnant_num'];
        $pregnant_status = $_POST['pregnant_status'];
      
        $query = "UPDATE pregnant SET pregnant_fname=?, pregnant_occupation=?, pregnant_num=?, pregnant_status=? 
        WHERE id_resident=?";

        $stmt = $pdo->prepare($query);
        $stmt->execute([$pregnant_fname, $pregnant_occupation, $pregnant_num, $pregnant_status, $id_resident]);
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
        $death_fname = $_POST['death_fname'];
        $death_cause = $_POST['death_cause'];
        $death_date = $_POST['death_date'];
    
        // Prepare the SQL statement for inserting data into the officials table
        $sql = "INSERT INTO death (id_resident, death_fname, death_cause, death_date) 
        VALUES (:id_resident, :death_fname, :death_cause, :death_date)";
    
        // Bind the values to the placeholders in the SQL statement using an array
        $params = array(
            ':id_resident' => $id_resident,
            ':death_fname' => $death_fname,
            ':death_cause' => $death_cause,
            ':death_date' => $death_date);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    
        header('Location: ../../death.php');
    }
    // edit death record
    if (isset($_POST['submit_edit_death'])) {
        $id_resident = $_POST['id_resident'];
        $death_fname = $_POST['death_fname'];
        $death_cause = $_POST['death_cause'];
        $death_date = $_POST['death_date'];
      
        $query = "UPDATE death SET death_fname=?, death_cause=?, death_date=?
        WHERE id_resident=?";

        $stmt = $pdo->prepare($query);
        $stmt->execute([$death_fname, $death_cause, $death_date, $id_resident]);
        echo "<script>alert('Record Updated!'); window.location.href = '../../death.php';</script>";
    }
    // delete death record
    if (isset($_POST['submit_delete_death'])) {
        $id_resident = $_POST['id_resident'];
        $query = "DELETE FROM death WHERE id_resident=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id_resident]);
        echo "<script>alert('Deleted Successfully!'); window.location.href = '../../death.php';</script>";
        exit;
    }

?>