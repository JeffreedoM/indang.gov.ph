<?php 

    $conn = new mysqli('localhost', 'root', '', 'bmis');

if ($conn->connect_error){
    die('Connection Failed' .$conn->connect_error);
}else{

    $id = $_GET['id'];
    $form_label = $_GET['form_label'];
    $sql = mysqli_query($conn, "SELECT * FROM new_clearance WHERE finance_id=$id");
    $user = mysqli_fetch_assoc($sql);

    $formName = $user['form_request'];
    $formAmount = $user['amount'];
   

    // Calculate total amount
    $totalResult = mysqli_query($conn, "SELECT SUM(amount) AS total FROM new_clearance WHERE form_request='$form_label'");
    $totalRow = mysqli_fetch_assoc($totalResult);
    $formTotal = $totalRow['total'];

    // Calculate total request
    $totalRequestResult = mysqli_query($conn, "SELECT COALESCE(COUNT(*), 0) AS total_request FROM new_clearance WHERE form_request='$form_label'");
    $totalRowRequest = mysqli_fetch_assoc($totalRequestResult);
    $formRequest = $totalRowRequest['total_request'];

    // Display User name
    $formResident1 = array(); // Initialize an empty array
    $formDate1 = array();
    $formStatus1 = array();
    $formPaid1 = array();
    
    $residentName = mysqli_query($conn, "SELECT resident.firstname, resident.middlename, resident.lastname, new_clearance.date_string, new_clearance.status, new_clearance.amount 
    FROM resident JOIN new_clearance ON resident.resident_id = new_clearance.resident_id 
    WHERE form_request='$form_label'");

    while ($resident = mysqli_fetch_assoc($residentName)) {
        $residentFirstName = $resident['firstname'].' '.$resident['middlename'].' '.$resident['lastname'];
        $formResident1[] = $residentFirstName; // Add the resident name to the array
        $formDate1[] = $resident['date_string']; // Add the resident name to the array
        $formStatus1[] = $resident['status']; // Add the resident name to the array
        $formPaid1[] = $resident['amount']; // Add the resident name to the array
    }

    $formResident = implode("<br>", $formResident1);
    $formDate = implode("<br>", $formDate1);
    $formStatus = implode("<br>", $formStatus1);
    $formPaid = implode("<br>", $formPaid1);

    // Form pending count
    $formPending1 = array();
    $statuspending = mysqli_query($conn, "SELECT COALESCE(COUNT(*), 0) AS total_pending 
    FROM resident JOIN new_clearance ON resident.resident_id = new_clearance.resident_id 
    WHERE form_request='$form_label' AND status='Pending'");

    while ($statusgetpending = mysqli_fetch_assoc($statuspending)) {
        $formPending1[] = $statusgetpending['total_pending']; // Add the resident name to the array
    }
    $formPending = implode("<br>", $formPending1);

    // Form pending count
    $formPaid1 = array();
    $statuspaid = mysqli_query($conn, "SELECT COALESCE(COUNT(*), 0) AS total_paid 
    FROM resident JOIN new_clearance ON resident.resident_id = new_clearance.resident_id 
    WHERE form_request='$form_label' AND status='Paid'");

    while ($statusgetpaid = mysqli_fetch_assoc($statuspaid)) {
        $formPaid1[] = $statusgetpaid['total_paid']; // Add the resident name to the array
    }
    $formPaidStatus = implode("<br>", $formPaid1);

    // Form released count
    $formReleased1 = array();
    $statusreleased = mysqli_query($conn, "SELECT COALESCE(COUNT(*), 0) AS total_released 
    FROM resident JOIN new_clearance ON resident.resident_id = new_clearance.resident_id 
    WHERE form_request='$form_label' AND status='Released'");

    while ($statusgetreleased = mysqli_fetch_assoc($statusreleased)) {
        $formReleased1[] = $statusgetreleased['total_released']; // Add the resident name to the array
    }
    $formReleased = implode("<br>", $formReleased1);

    $response = array(
        'formName' => $formName,
        'formAmount' => $formAmount,
        'formTotal' => $formTotal,
        'formRequest' => $formRequest,
        'formResident' => $formResident,
        'formDate' => $formDate,
        'formStatus' => $formStatus,
        'formPaid' => $formPaid,
        'formPending' => $formPending,
        'formPaidStatus' => $formPaidStatus,
        'formReleased' => $formReleased,
    );

    header('Content-Type: application/json');
    echo json_encode($response);
    
}


?>