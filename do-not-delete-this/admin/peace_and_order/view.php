<?php
include '../../includes/dbh.inc.php';
include '../../includes/session.inc.php';
include '../../includes/deactivated.inc.php';

$id = $_GET['view_id'];

$sql = "SELECT i.*, o.*
        FROM incident_table i
        JOIN incident_offender1 o ON o.offender_id = i.offender_id
        WHERE incident_id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$list = $stmt->fetch(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of person involve</title>
</head>
<body>
<form method="post">
<table>
    <tr>
    <th>List of person involve</th>
    </tr>
    <tr>
        <td>Case</td>
        <td>
        <input type="text" name="case" value="<?php echo $list['case_incident'] ?>">
        </td>
    </tr>
    <tr>
        <td>Incident title</td>
        <td>
        <input type="text" name="case" value="<?php echo $list['incident_title'] ?>">
        </td>
    </tr>
    <tr>
        <td>Date of Incident</td>
        <td>
        <input type="date" name="case" value="<?php echo $list['date_incident'] ?>">
        </td>
    </tr>
    <tr>
        <td>Time of Incident</td>
        <td>
        <input type="time" name="case" value="<?php echo $list['time_incident'] ?>">
        </td>
    </tr>

    <tr>
        <td>List</td>
    </tr>
    <tr>
        <td>
        <table>
        <tr>
            <td>Name</td>
            <td>Gender</td>
            <td>Address</td>
            <td>Involve Person type</td>
            <td>Action</td>
        </tr>
        <tr>
            <td><?php echo $list['offender_name'] ?></td>
            <td><?php echo $list['offender_gender'] ?></td>
            <td><?php echo $list['offender_address'] ?></td>
            <td><?php echo $list['offender_address'] ?></td>
            
            <td><button href="edit.php">Edit details</button>
            <br><button href="delete.php">Remove</button>
            </td>
        </tr>
        </table>
        </td>
    </tr>
</table>
<br>
<button><a href="list_incident.php"> Back</a></button>
</form>
</body>
</html>