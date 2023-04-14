<?php
include '../../includes/dbh.inc.php';
include '../../includes/session.inc.php';
include '../../includes/deactivated.inc.php';

$id = $_GET['update_id'];
$sql = "SELECT i.*, o.*, p.*
FROM incident_table i
        JOIN incident_offender1 o ON o.offender_id = i.offender_id
        JOIN incident_reporting_person p ON p.person_id = i.person_id
        WHERE incident_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();


if ($sql) {
    $list = $stmt->fetch(PDO::FETCH_ASSOC);
    $p_id = $list['person_id'];
    $o_id = $list['offender_id'];
    //insert to incident_reporting_person db
    $complainant_name = $list['name'];
    $complainant_gender = $list['gender'];
    $complainant_number = $list['phone_number'];
    $complainant_address = $list['address'];

    //insert to incident_offender db
    $offender_gender = $list['offender_gender'];
    $offender_name = $list['offender_name'];
    $offender_address = $list['offender_address'];
    $description = $list['description'];

    //insert to incident_table db
    $case_incident = $list['case_incident'];
    $i_title = $list['incident_title'];
    $i_date = $list['date_incident'];
    $i_time = $list['time_incident'];
    $location = $list['location'];
    $narrative = $list['narrative'];
}


if (isset($_POST['submit'])) {

    $resident_type = $_POST['resident_type'];
    $comp_type = $_POST['comp_type'];

    //insert to incident_reporting_person db
    $complainant_name = $_POST['c_name'];
    $complainant_gender = $_POST['c_gender'];
    $complainant_number = $_POST['c_number'];
    $complainant_address = $_POST['c_address'];

    //insert to incident_offender db
    $offender_name = $_POST['o_name'];
    $offender_gender = $_POST['o_gender'];
    $offender_number = $_POST['o_number'];
    $offender_address = $_POST['o_address'];
    $description = $_POST['desc'];

    //insert to incident_table db
    $case_incident = $_POST['i_case'];
    $i_title = $_POST['i_title'];
    $i_date = $_POST['i_date'];
    $i_time = $_POST['i_time'];
    $location = $_POST['i_location'];
    $narrative = $_POST['narrative'];

    //update incident_table
    $sql = "UPDATE incident_table SET case_incident = :case_incident, incident_title = :i_title, date_incident = :i_date, 
    time_incident = :i_time, location = :location, narrative = :narrative WHERE incident_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':case_incident', $case_incident, PDO::PARAM_STR);
    $stmt->bindParam(':i_title', $i_title, PDO::PARAM_STR);
    $stmt->bindParam(':i_date', $i_date, PDO::PARAM_STR);
    $stmt->bindParam(':i_time', $i_time, PDO::PARAM_STR);
    $stmt->bindParam(':location', $location, PDO::PARAM_STR);
    $stmt->bindParam(':narrative', $narrative, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();





    if ($stmt) {
        // Get the last inserted ID
        $incident_id = $pdo->lastInsertId();

        echo $incident_id;

        // Update data in the second table, using the last inserted ID as a foreign key
        $sql1 = "UPDATE incident_offender1 SET offender_name=:offender_name, offender_gender=:offender_gender, 
            offender_address=:offender_address, description=:description WHERE offender_id=:o_id";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->bindParam(':offender_name', $offender_name, PDO::PARAM_STR);
        $stmt1->bindParam(':offender_gender', $offender_gender, PDO::PARAM_STR);
        $stmt1->bindParam(':offender_address', $offender_address, PDO::PARAM_STR);
        $stmt1->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt1->bindParam(':o_id', $o_id, PDO::PARAM_INT);
        $stmt1->execute();

        $sql2 = "UPDATE incident_reporting_person SET name=:complainant_name, gender=:complainant_gender,
            phone_number=:complainant_number, address=:complainant_address WHERE person_id=:p_id";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(':complainant_name', $complainant_name, PDO::PARAM_STR);
        $stmt2->bindParam(':complainant_gender', $complainant_gender, PDO::PARAM_STR);
        $stmt2->bindParam(':complainant_number', $complainant_number, PDO::PARAM_STR);
        $stmt2->bindParam(':complainant_address', $complainant_address, PDO::PARAM_STR);
        $stmt2->bindParam(':p_id', $p_id, PDO::PARAM_INT);
        $stmt2->execute();

        if ($stmt1 && $stmt2) {
            echo "Data updated successfully";
        } else {
            echo "Error updating data: " . $pdo->errorInfo()[2];
        }
    } else {
        die("Error executing query: " . $pdo->errorInfo()[2]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
</head>
<form method="POST">

    <body>
        <table>
            <tr>
                <th colspan="3">Edit Records</th>
            </tr>
            <tr>
                <td>
                    <h3>Reporting person/Complainant</h3>
                    <select name="comp_type">
                        <option value="1">Complaint</option>
                        <option value="2">Incident</option>
                    </select>

                </td>
            </tr>
            <tr>
                <td>
                    <select name="resident_type">
                        <option value="resident">Resident</option>
                        <option value="not resident">Non-Resident</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Name: </td>
                <td><input type="text" name="c_name" value="<?php echo $complainant_name; ?>"></td>
                <td><select name="c_gender" id="">
                        <option>Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Phone Number: </td>
                <td><input type="number" name="c_number" value="<?php echo $complainant_number; ?>">
                </td>
            </tr>
            <tr>
                <td>Birthday: </td>
                <td><input type="date" name="c_bday">
                </td>
            </tr>
            <td>Address: </td>
            <td><input type="text" name="c_address" value="<?php echo $complainant_address; ?>">
            </td>
            </tr>
            <!-- offender -->
            <tr>
                <td>
                    <h3>Offender type</h3>
                    <select name="o_res">
                        <option value="resident">Resident</option>
                        <option value="n_resident">Non-Resident</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Name: </td>
                <td><input type="text" name="o_name" value="<?php echo $offender_name; ?>"></td>
                <td><select name="o_gender" id="gender">
                        <option>Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Phone Number: </td>
                <td><input type="number" name="o_number" value="<?php echo $offender_number; ?>" required>
                </td>
            </tr>
            <tr>
                <td>Birthday: </td>
                <td><input type="date" name="o_bday">
                </td>
            </tr>
            <td>Address: </td>
            <td><input type="text" name="o_address" value="<?php echo $offender_address; ?>" required>
            </td>
            </tr>
            <tr>
                <td>Description:</td>
                <td>
                    <textarea name="desc" value="<?php echo $description; ?>" required>
            </textarea>
                </td>
            </tr>
            <tr>
                <td>

                    <input type="radio" id="c1" name="i_case" value="criminal">
                    <label for="c1">Criminal</label>
                    <input type="radio" id="c2" name="i_case" value="civil">
                    <label for="c2">Civil</label>
                    <input type="radio" id="c0" name="i_case" value="others">
                    <label for="c0">Others</label>
                </td>
            </tr>
            <tr>
                <td>Incident Title</td>
                <td>
                    <input type="text" name="i_title" value="<?php echo $i_title; ?>" required>
                </td>
            </tr>
            <tr>
                <td>Date of Incident</td>
                <td>
                    <input type="date" name="i_date" value="<?php echo $i_date; ?>" required>
                </td>
            </tr>
            <tr>
                <td>Time of Incident</td>
                <td>
                    <input type="time" name="i_time" value="<?php echo $i_time; ?>" required>
                </td>
            </tr>
            <tr>
                <td>Location of incident</td>
                <td>
                    <input type="text" name="i_location" value="<?php echo $location; ?>" required>
                </td>
            </tr>
            <tr>
                <td>Narrative</td>
                <td>
                    <textarea name="narrative" value="<?php echo $narrative; ?>" required>
                </textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <button name="submit">Submit</button>
                    <br>
                    <br>
                    <button><a href="list_incident.php">Back</a></button>
                </td>
            </tr>

        </table>

    </body>
</form>

</html>