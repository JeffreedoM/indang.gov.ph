<?php

include '../../../includes/dbh.inc.php';
include '../../../includes/deactivated.inc.php';


if (isset($_POST['create-form'])) {
    $form_content = $_POST['form-content'];
    $form_name = $_POST['form-name'];
    $form_filename = strtolower(str_replace(" ", "-", trim($form_name))) . '.php';

    // Prepare the INSERT statement
    $stmt = $pdo->prepare("INSERT INTO forms (form_name, form_content, barangay_id) VALUES (:formName, :formContent, :barangayId)");

    $data = array(
        'formName' => $form_name,
        'formContent' => $form_content,
        'barangayId' => $barangayId
    );
    // Bind parameters from the associative array
    $stmt->execute($data);

    // Creating a new form
    $forms_base_path = '../forms/forms-base.php';
    if (file_exists($forms_base_path)) {
        $forms_base_content = file_get_contents($forms_base_path);
        $destination_path = dirname($forms_base_path) . '/' . $form_filename;
        file_put_contents($destination_path, $forms_base_content);
        echo "Success on creating a new form";
    } else {
        echo "Error: forms-base.php does not exist.";
    }

    header('Location: ../create-form.php?create=success');
}
