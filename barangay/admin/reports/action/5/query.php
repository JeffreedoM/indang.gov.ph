<?php

if (isset($_POST['submit'])) {
    $blotter_id = $_POST['blotter'];
    $content = !empty($_POST['content']) ? $_POST['content'] : '';
    $date_s = !empty($_POST['date_s']) ? $_POST['date_s'] : '';
    $date_a = !empty($_POST['date_a']) ? $_POST['date_a'] : '';
    $para_sa = !empty($_POST['para_sa']) ? $_POST['para_sa'] : '';
    $blg = !empty($_POST['blg']) ? $_POST['blg'] : '';
    $query = "INSERT INTO report_complaint (blotter_id, content, para_sa, blg, date_s, date_a, barangay_id) VALUES (:blotter_id, :content, :para_sa, :blg, :date_s, :date_a, :barangay_id)";
    // Prepare the statement
    $stmt = $pdo->prepare($query);
    // print($date_a);
    // print($date_s);
    // exit;
    // Bind parameters
    $stmt->bindParam(':blotter_id', $blotter_id);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':para_sa', $para_sa);
    $stmt->bindParam(':blg', $blg);
    $stmt->bindParam(':date_s', $date_s);
    $stmt->bindParam(':date_a', $date_a);
    $stmt->bindParam(':barangay_id', $barangayId);

    // Execute the query
    $stmt->execute();

    // Check if the query was successful
    if ($stmt->rowCount() > 0) {
        $lastInsertedId = $pdo->lastInsertId();
        header("Location: ../../pdf/compReport.php?print_id=$lastInsertedId");
        exit;
    } else {
        echo "No rows were inserted.";
    }
}
