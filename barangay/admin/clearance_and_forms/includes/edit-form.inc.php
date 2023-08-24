<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/deactivated.inc.php';

if (isset($_POST['update-form'])) {
    $form_id = $_POST['form_id']; // Assuming you're passing the form ID through the POST request
    $form_content = $_POST['form-content'];
    $form_name = $_POST['form-name'];

    $form_filename = strtolower(str_replace(" ", "-", trim($form_name))) . '.php';

    // Prepare the UPDATE statement
    $stmt = $pdo->prepare("UPDATE forms SET form_name = :formName, form_content = :formContent WHERE form_id = :formId");

    $data = array(
        'formId' => $form_id,
        'formName' => $form_name,
        'formContent' => $form_content
    );
    // Bind parameters from the associative array
    $stmt->execute($data);

    // Update successful
    echo "Success on updating the form";

    // Rename the form file
    $old_form_filename = strtolower(str_replace(" ", "-", trim($_POST['old-form-name']))) . '.php'; // Assuming you're passing the old form name through the POST request
    $new_form_path = '../forms/' . $form_filename;

    $old_form_path = '../forms/' . $old_form_filename;

    echo $old_form_filename;
    if (file_exists($old_form_path)) {
        if (rename($old_form_path, $new_form_path)) {
            echo "Success on renaming the form file";
        } else {
            echo "Error renaming the form file.";
        }
    } else {
        echo "Error: Old form file does not exist.";
    }

    header('Location: ../edit-form.php?id=' . $form_id . '&update=success');
}

if (isset($_POST['change-amount'])) {
    $amount = $_POST['amount'];
    $form_id = $_POST['form_id'];

    $sql = "UPDATE forms SET amount = :amount WHERE form_id = :form_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
    $stmt->bindParam(':form_id', $form_id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: ../form-list.php');
}
