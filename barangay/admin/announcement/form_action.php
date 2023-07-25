
<?php
include '../../includes/deactivated.inc.php';
include '../../includes/dbh.inc.php';
?>

<?php

if (isset($_POST['submit'])) {
  $category = $_POST['category'];
 
  if($category === 'Resident'){

    try {
      $stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
      $stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
      $stmt->execute();
      $resident = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach($resident as $resident) {
        echo $resident['firstname'] . $resident['contact']; 
      }
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

  }

  elseif($category === 'Senior')
  {
    try {
      $senior = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND age >= 60 ")->fetchAll();
      if (!$senior){
        echo "No senior";
      }
      else{
        foreach($senior as $senior) {
          echo $senior['firstname'] . $senior['contact']; 
        }
      }
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

  }

  elseif($category === 'Barangay_Official'){
    try {
      $officials = $pdo->query("SELECT *
      FROM barangay
      JOIN resident ON barangay.b_id = resident.barangay_id
      JOIN officials ON resident.resident_id = officials.resident_id
      WHERE barangay_id = $barangayId")->fetchAll();
      foreach($officials as $officials) {
        echo $officials['firstname'] ;
      }
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

  }
}
   

   # header('location: index.php');

    ?>


