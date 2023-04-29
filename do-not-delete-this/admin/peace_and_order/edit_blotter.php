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

<form method="post" id="view">
    <button><a href="../list_incident.php"> Back</a></button>
    <table>
        <tr>
            <th>List of person involve</th>
        </tr>
        <tr>
            <td>Case</td>
            <td>
                <input type="text" name="case" value="<?php echo $list1['case_incident']; ?>">
            </td>
        </tr>
        <tr>
            <td>Incident title</td>
            <td>
                <input type="text" name="case" value="<?php echo $list1['incident_title']; ?>">
            </td>
        </tr>
        <tr>
            <td>Date of Incident</td>
            <td>
                <input type="date" name="case" value="<?php echo $list1['date_incident']; ?>">
            </td>
        </tr>
        <tr>
            <td>Time of Incident</td>
            <td>
                <input type="time" name="case" value="<?php echo $list1['time_incident']; ?>">
            </td>
        </tr>

        <tr>
            <td>List</td>
        </tr>
        <tr>
            <table>
                <tr>
                    <td>Name</td>
                    <td>Gender</td>
                    <td>Address</td>
                    <td>Involve Person type</td>
                    <td>Action</td>
                </tr>
                <?php
                foreach ($list2 as $list) {
                    if ($list['offender_type'] == "resident") {
                ?>
                        <tr>
                            <td><?php echo $list['firstname'] . " " . $list['lastname']; ?></td>
                            <td><?php echo $list['sex']; ?></td>
                            <td><?php echo $list['address']; ?></td>
                            <td><?php echo "Offender"; ?></td>
                            <td>
                                <button><a href="edit_person.php?up_off_id=<?php echo $list['offender_id']; ?>">
                                        Edit details</a></button>
                                <br>
                                <button onclick="delete_person()"> <a href="delete_person.php? view_id=<?php echo $id; ?>&del_off_id=<?php echo $list['offender_id']; ?>">
                                        Remove</a></button>
                            </td>offender
                        </tr>
                    <?php
                    } else {
                    ?>
                        <tr>
                            <td><?php echo $list['non_res_firstname'] . " " . $list['non_res_lastname']; ?></td>
                            <td><?php echo $list['non_res_gender']; ?></td>
                            <td><?php echo $list['non_res_address']; ?></td>
                            <td><?php echo "Offender" ?></td>

                            <td>
                                <button><a href="edit_person.php?up_off_id=<?php echo $list['offender_id']; ?>">
                                        Edit details</a></button>
                                <br>
                                <button onclick="delete_person()"> <a href="delete_person.php? view_id=<?php echo $id; ?>&del_off_id=<?php echo $list['offender_id']; ?>">
                                        Remove</a></button>
                            </td>
                        </tr>
                <?php

                    }
                }
                ?>
                <?php
                foreach ($list3 as $list) {
                    if ($list['complainant_type'] == "resident") {
                ?>
                        <tr>
                            <td><?php echo $list['non_firstname'] . " " . $list['lastname']; ?></td>
                            <td><?php echo $list['sex']; ?></td>
                            <td><?php echo $list['address']; ?></td>
                            <td><?php echo "Complainant"; ?></td>

                            <td>
                                <button><a href="edit_person.php?up_comp_id=<?php echo $list['complainant_id']; ?>">
                                        Edit details</a></button>
                                <br>
                                <button onclick="delete_person()"> <a href="delete_person.php? view_id=<?php echo $id; ?>&del_comp_id=<?php echo $list['complainant_id']; ?>">
                                        Remove</a></button>
                            </td>
                        </tr>
                    <?php
                    } else {
                    ?><tr>
                            <td><?php echo $list['non_res_firstname'] . " " . $list['non_res_lastname']; ?></td>
                            <td><?php echo $list['non_res_gender']; ?></td>
                            <td><?php echo $list['non_res_address']; ?></td>
                            <td><?php echo "Complainant" ?></td>

                            <td>
                                <button><a href="edit_person.php?up_comp_id=<?php echo $list['complainant_id']; ?>">
                                        Edit details</a></button>
                                <br>
                                <button onclick="return confirm('are you sure?')"> <a href="delete_person.php? view_id=<?php echo $id; ?>&del_comp_id=<?php echo $list['complainant_id']; ?>">
                                        Remove</a></button>
                            </td>
                        </tr>
                <?php

                    }
                }
                ?>
        </tr>
    </table>
    </tr>
    </table>
    <br>
</form>
<script src="./../assets/js/action_view.js"></script>