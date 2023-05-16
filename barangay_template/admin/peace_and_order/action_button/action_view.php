<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/deactivated.inc.php';

$id = $_GET['view_id'];

//select incident_table
$sql = "SELECT * FROM incident_table
    WHERE incident_id = :id
";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$list1 = $stmt->fetch(PDO::FETCH_ASSOC);

//selecting incident_complainant
$sql = "SELECT * FROM incident_offender
    LEFT JOIN resident ON incident_offender.resident_id = resident.resident_id
    LEFT JOIN non_resident ON incident_offender.non_resident_id = non_resident.non_resident_id
    LEFT JOIN incident_table ON incident_offender.incident_id = incident_table.incident_id
    WHERE incident_offender.incident_id = $id
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$list2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

//selecting incident_complainant
$sql = "SELECT * FROM incident_complainant
    LEFT JOIN resident ON incident_complainant.resident_id = resident.resident_id
    LEFT JOIN non_resident ON incident_complainant.non_resident_id = non_resident.non_resident_id
    LEFT JOIN incident_table ON incident_complainant.incident_id = incident_table.incident_id
    WHERE incident_complainant.incident_id = $id
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$list3 = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
                                </td>
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
</body>

</html>