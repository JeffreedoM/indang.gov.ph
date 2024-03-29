<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/deactivated.inc.php';


// ADD FINANCE
if (isset($_POST['submit_finance'])) {

    $id_resident = $_POST['id_resident'];
    // $finance_amount = $_POST['finance_amount'];
    $finance_purpose = $_POST['finance_purpose'];
    $form_request = $_POST['form_request'];
    $status = $_POST['status'];
    $barangay_id = $_POST['brgyID'];

    $sql = "SELECT amount FROM forms WHERE form_name = :form_name AND barangay_id = :barangay_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':form_name', $form_request, PDO::PARAM_STR);
    $stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
    $stmt->execute();

    $form = $stmt->fetch(PDO::FETCH_ASSOC);
    $finance_amount = $form['amount'];

    // date
    date_default_timezone_set('Asia/Manila');
    $currentDateTime = new DateTime();
    $formattedDateTime = $currentDateTime->format('F j, Y g:i A');

    $date_finance = date('Y-m-d');

    // if ($form_request == '') {
    //     $form_request_insert = $_POST['form_request_others'];
    // } else {
    //     $form_request_insert = $_POST['form_request'];
    // }

    $sql = "INSERT INTO new_clearance (resident_id, barangay_id, form_request, amount, purpose, date_string, finance_date, status) 
        VALUES (:resident_id, :barangay_id, :form_request, :amount, :purpose, :date_string, :finance_date, :status)";

    $params = array(
        ':resident_id' => $id_resident,
        ':barangay_id' => $barangay_id,
        ':form_request' => $form_request,
        ':amount' => $finance_amount,
        ':purpose' => $finance_purpose,
        ':date_string' => $formattedDateTime,
        ':finance_date' => $date_finance,
        ':status' => $status
    );
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $id = $pdo->lastInsertId();

    // Select created forms from the database
    $stmt = $pdo->prepare("SELECT * FROM forms WHERE barangay_id = :barangayId");
    $stmt->bindParam(':barangayId', $barangayId);
    $stmt->execute();
    $forms = $stmt->fetchAll();


    switch ($form_request) {
        case 'Barangay Business Clearance':
            $form = 'business-clearance';
            break;
        case 'Barangay Clearance':
            $form = 'barangay-clearance';
            break;
        case 'Certificate of Good Moral Character':
            $form = 'cert_goodMoral';
            break;
        case 'Certificate of Indigency':
            $form = 'cert_indigency';
            break;
        case 'Certificate of Residency':
            $form = 'cert_residency';
            break;
        default:
            foreach ($forms as $form) {
                if ($form_request === $form['form_name']) {
                    $form = strtolower(str_replace(" ", "-", trim($form['form_name'])));
                    break;
                }
            }
            break;
    }

    header("Location: ../forms/$form.php?id=$id");
}

// EDIT FINANCE
if (isset($_POST['submit_edit_finance'])) {
    $id_resident = $_POST['id_resident'];
    $form_request = $_POST['form_request'];
    $finance_date = $_POST['finance_date'];
    $status = $_POST['status'];
    $amount = $_POST['amount'];
    $finance_purpose = $_POST['purpose'];
    // date
    date_default_timezone_set('Asia/Manila');
    $currentTime = date('g:i A');
    $financeDateTime = date('F j, Y', strtotime($finance_date)) . ' ' . $currentTime;

    $query = "UPDATE new_clearance SET form_request=?, finance_date=?, status=?, amount=?, purpose=?, date_string=?
        WHERE clearance_id=?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$form_request, $finance_date, $status, $amount, $finance_purpose, $financeDateTime, $id_resident]);
    echo "<script>alert('Record Updated!'); window.location.href = '../index.php';</script>";
}

if (isset($_POST['submit_delete_finance'])) {
    $id_resident = $_POST['id_resident'];
    $query = "DELETE FROM new_clearance WHERE clearance_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_resident]);
    echo "<script>alert('Deleted Successfully!'); window.location.href = '../index.php';</script>";
    exit;
}
