<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/deactivated.inc.php';
include_once '../function.php';


if (isset($_GET['up_comp_id'])) {
    //selecting incident_complainant
    $cid = $_GET['up_comp_id'];

    //selecting resident_id/non_resident_id
    $result = getComplainantIds($pdo, $cid);
    $resident_id = $result['resident_id'];
    $non_resident_id = $result['non_resident_id'];


    //fetching the resident/non_resident table
    if (isset($resident_id)) {

        $sql = "
        SELECT * FROM resident
        WHERE resident_id = $resident_id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($lists as $list) {
            $fname = $list['non_res_firstname'];
            $lname = $list['non_res_lastname'];
            $number = $list['non_res_contact'];
            $gender = $list['non_res_gender'];
            $bdate = $list['non_res_birthdate'];
            $address = $list['non_res_address'];
        }
    } else {
        $sql = "
        SELECT * FROM non_resident
        WHERE non_resident_id = $non_resident_id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $lists = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($lists as $list) {
            $fname = $list['non_res_firstname'];
            $lname = $list['non_res_lastname'];
            $number = $list['non_res_contact'];
            $gender = $list['non_res_gender'];
            $bdate = $list['non_res_birthdate'];
            $address = $list['non_res_address'];
        }
    }
} else {
    //selecting incident_offender
    $oid = $_GET['up_off_id'];

    //selecting resident_id/non_resident_id
    $result = getOffenderIds($pdo, $oid);
    $resident_id = $result['resident_id'];
    $non_resident_id = $result['non_resident_id'];



    if (isset($id['resident_id'])) {

        $sql = "
        SELECT * FROM resident
        WHERE resident_id = $resident_id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $sql = "
        SELECT * FROM non_resident
        WHERE non_resident_id = $non_resident_id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $lists = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($lists as $list) {
            $fname = $list['non_res_firstname'];
            $lname = $list['non_res_lastname'];
            $number = $list['non_res_contact'];
            $gender = $list['non_res_gender'];
            $bdate = $list['non_res_birthdate'];
            $address = $list['non_res_address'];
        }
    }
}


// Update the complainant_id
if (isset($_POST['add_comp'])) {

    //insert to incident_reporting_person db
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $number = $_POST['number'];
    $bdate = $_POST['bdate'];
    $address = $_POST['address'];

    // Prepare the query with placeholders for the parameters
    if (isset($id[0])) {
        $res = $id[0];

        $stmt = $conn->prepare("UPDATE  SET address = :address WHERE name = :name");
        $stmt->bindParam(':desc', $desc, PDO::PARAM_STR);

        // Bind the parameters to the placeholders in the query
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':name', $name);

        // Execute the query
        $stmt->execute();
    } else {
        $non_res = $id[1];
        $sql = "
        UPDATE non_resident SET non_res_firstname = :non_res_firstname, non_res_lastname = :non_res_lastname, non_res_contact = :non_res_contact, 
        non_res_gender = :non_res_gender, non_res_birthdate = :non_res_birthdate, non_res_address = :non_res_address, WHERE non_resident_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':non_res_firstname', $fname, PDO::PARAM_STR);
        $stmt->bindParam(':non_res_lastname', $lname, PDO::PARAM_STR);
        $stmt->bindParam(':non_res_contact', $number, PDO::PARAM_STR);
        $stmt->bindParam(':non_res_gender', $gender, PDO::PARAM_STR);
        $stmt->bindParam(':non_res_birthdate', $bdate, PDO::PARAM_STR);
        $stmt->bindParam(':non_res_address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':id', $non_res, PDO::PARAM_INT);
        $stmt->execute();
    }
}

if (isset($_POST['add_off'])) {
    $offender_type = $_POST['offender_type'];
    $incident_id = $_GET['add_id'];

    //insert to incident_reporting_person db
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $number = $_POST['number'];
    $bdate = $_POST['bdate'];
    $address = $_POST['address'];
    $desc = $_POST['desc'];

    $id = addNonResident($fname, $lname, $gender, $bdate, $number, $address);
    addIncidentOffender($offender_type, $id, $incident_id, $desc);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>

    <div>
        <select name="select_type" id="select_type">
            <option value="complainant">Complainant</option>
            <option value="offender">Offender</option>
        </select>

    </div>
    <!-- Reporting person/Complainant -->
    <form method="POST" id="complainant">
        <table*>

            <h3>Reporting person/Complainant</h3>
            <br>

            <!-- Name -->
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="fname" value="<?php echo $fname; ?>" id="floating_first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="lname" value="<?php echo $lname; ?>" id="floating_last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
                </div>
            </div>

            <!-- Number -->

            <div class="relative z-0 w-full mb-6 group">
                <input type="tel" pattern="[0-9]{4}[0-9]{3}[0-9]{4}" name="number" value="<?php echo $number; ?>" id="floating_phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone number</label>
            </div>

            <!-- Gender -->
            <div>
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                <select name="gender" id="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Your Gender</option>
                    <option value="male" <?php if ($gender == "male") {
                                                echo "selected";
                                            } ?>>Male</option>
                    <option value="female" <?php if ($gender == "female") {
                                                echo "selected";
                                            } ?>>Female</option>
                </select>
            </div>

            <!--Birthdate -->
            <div>
                <label for="">Birthdate <span class="required-input">*</span></label>
                <div>
                    <input type="date" name="bdate" value="<?php echo $bdate; ?>" id="res_bdate" placeholder="Birthdate" onblur="getAge()" required>
                </div>
            </div>
            <!--Address -->
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="address" value="<?php echo $address; ?>" id="floating_address" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_address" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    Address</label>
            </div>
            <!-- Description -->
            <div>
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                <br>
                <textarea name="desc" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a comment..."></textarea>
            </div>
            <br>
            <button type="submit" name="add_comp">Submit</button>
            </table>

    </form>

    <button><a href="../list_incident.php">Back</a></button>
    <script src="./../assets/js/add-newperson.js"></script>

</body>

</html>