<?php
include '../../../includes/deactivated.inc.php';
include '../../../includes/session.inc.php';

$id = $_GET['id'];
$sql = "SELECT * FROM new_clearance c JOIN resident r ON r.resident_id = c.resident_id WHERE c.clearance_id = :clearance_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':clearance_id', $id, PDO::PARAM_INT);
$stmt->execute();
$clearance = $stmt->fetch(PDO::FETCH_ASSOC);

// Select created forms from the database
$stmt = $pdo->prepare("SELECT * FROM forms WHERE form_name = :form_request AND barangay_id = :barangayId");
$stmt->bindParam(':barangayId', $barangayId);
$stmt->bindParam(':form_request', $clearance['form_request']);
$stmt->execute();
$form = $stmt->fetch();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/forms.css">
    <link rel="icon" type="image/x-icon" href="../../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title><?php echo "$clearance[lastname] $clearance[form_request]" ?></title>

</head>

<body>
    <!-- Form Template -->
    <!-- Header -->
    <?php include_once 'template.php' ?>
    <div class="right">
        <?php echo $form['form_content'] ?>
    </div>
    </div>

    <script src="../assets/js/dates.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
</body>

</html>