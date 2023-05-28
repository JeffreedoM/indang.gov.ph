<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/deactivated.inc.php';
include_once '../includes/function.php';

$oid = $_GET['up_off_id'];

//selecting resident
$stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$o_residents = $stmt->fetchAll();

$incident_id = $_SESSION['incident_id'];
// selecting resident_id/non_resident_id
$result = getOffenderIds($pdo, $oid);
$resident_id = $result['resident_id'];
$non_resident_id = $result['non_resident_id'];
//for description
$desc = $result['desc'];
if ($result['offender_type'] == 'resident') {
    $stmt = $pdo->prepare("SELECT * FROM resident WHERE resident_id = :resident_id");
    $stmt->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
    $stmt->execute();
    $lists = $stmt->fetchAll();
    foreach ($lists as $list) {
        $fname = $list['firstname'];
        $lname = $list['lastname'];
        $number = $list['contact'];
        $gender = $list['sex'];
        $bdate = $list['birthdate'];
        $address = $list['address'];
    }
} else {
    $stmt = $pdo->prepare("SELECT * FROM non_resident WHERE non_resident_id = :id");
    $stmt->bindParam(':id', $non_resident_id, PDO::PARAM_INT);
    $stmt->execute();
    $lists = $stmt->fetchAll();
    foreach ($lists as $list) {
        $fname = $list['non_res_firstname'];
        $lname = $list['non_res_lastname'];
        $number = $list['non_res_contact'];
        $gender = $list['non_res_gender'];
        $bdate = $list['non_res_birthdate'];
        $address = $list['non_res_address'];
    }
}




if (isset($_POST['add_comp'])) {
    if (empty($_POST['offender_id'])) {
        $id = $resident_id;
    } else {
        $id = $_POST['offender_id'];
    }



    $off_type = $_POST['offender_type'];

    //insert to incident_reporting_person db
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $number = $_POST['number'];
    $bdate = $_POST['bdate'];
    $address = $_POST['address'];
    $desc = $_POST['desc'];

    // Prepare the query with placeholders for the parameters
    if ($off_type === 'resident') {
        $sql = "UPDATE incident_offender SET resident_id = :newid,offender_type = :o_type, non_resident_id = null, `desc` = :desc WHERE offender_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $oid, PDO::PARAM_INT);
        $stmt->bindParam(':newid', $id, PDO::PARAM_INT);
        $stmt->bindParam(':o_type', $off_type, PDO::PARAM_STR);
        $stmt->bindParam(':desc', $desc, PDO::PARAM_STR);
    } else {
        if ($result['non_resident_id'] === null) {
            $non_resident_id = addNonResident($fname, $lname, $gender, $bdate, $number, $address);
        } else {
            $sql = "UPDATE non_resident SET non_res_firstname = :non_res_firstname, non_res_lastname = :non_res_lastname, non_res_contact = :non_res_contact, 
            non_res_gender = :non_res_gender, non_res_birthdate = :non_res_birthdate, non_res_address = :non_res_address WHERE non_resident_id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':non_res_firstname', $fname, PDO::PARAM_STR);
            $stmt->bindParam(':non_res_lastname', $lname, PDO::PARAM_STR);
            $stmt->bindParam(':non_res_contact', $number, PDO::PARAM_STR);
            $stmt->bindParam(':non_res_gender', $gender, PDO::PARAM_STR);
            $stmt->bindParam(':non_res_birthdate', $bdate, PDO::PARAM_STR);
            $stmt->bindParam(':non_res_address', $address, PDO::PARAM_STR);

            $stmt->bindParam(':id', $non_resident_id, PDO::PARAM_INT);
            $stmt->execute();
        }
        $sql = "UPDATE incident_offender SET offender_type = :o_type, resident_id = null, non_resident_id = :nid, `desc` = :desc WHERE offender_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $oid, PDO::PARAM_INT);
        $stmt->bindParam(':nid', $non_resident_id, PDO::PARAM_INT);
        $stmt->bindParam(':o_type', $off_type, PDO::PARAM_STR);
        $stmt->bindParam(':desc', $desc, PDO::PARAM_STR);
    }

    if ($stmt->execute()) {
        header("location: action_view.php?view_id=$incident_id");
    } else {
        echo "Error updating data: " . $stmt->errorInfo()[2];
    }
}
?>

<!DOCTYPE html>
<html lang="en">


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/datepicker.min.js"></script>
    <link rel="stylesheet" href="../../../assets/css/main.css" />

    <!-- Specific module styling -->
    <link rel="stylesheet" href="./../assets/css/styles.css">

    <!-- <link rel="stylesheet" href="../../assets/css/bs-overwrite.css" /> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <style>
        table {
            width: 900px;
            margin-bottom: 10px;
        }

        .list_involve td {
            text-align: center;
        }

        th {
            margin-bottom: 20px;
        }

        input {
            width: 250px;
            margin-bottom: .5rem;
            border-radius: 5px;
            padding: 10px;
        }

        .action_btn button {
            width: 90px;

        }

        hr {
            border: none;
            border-top: 5px solid #ccc;
        }

        .hidden-cell {
            display: none;
        }
    </style>

    <title>Admin Panel</title>
</head>

<body>
    <?php
    include '../../../partials/nav_sidebar.php';
    ?>

    <main class="main-content">
        <?php
        include '../../../partials/nav_header.php';
        ?>

        <!-- Container -->
        <div class="wrapper incident">
            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header">
                <h3 class="page-title">Peace and Order</h3>
            </div>

            <!-- Page body -->
            <div class="page-body" style="overflow-x:auto; min-height: 60vh;">


                <button class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800">
                    <a href="action_view.php?view_id=<?php echo $incident_id; ?>">Back</a></button>

                <br>
                <h1 style="text-align:center; font-size: 20px;"><b>Edit Involve Person</b></h1>
                <br>
                <!-- Reporting person/Complainant -->
                <form method="POST" id="offender">
                    <table*>
                        <h3><strong>Offender</strong></h3>
                        <br>
                        <div class="mb-4">
                            <select onchange="showInput2()" id="res_type2" name="offender_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="resident" <?php if ($result['offender_type'] == 'resident') {
                                                                echo 'selected';
                                                            } ?>>Resident</option>
                                <option value="not resident" <?php if ($result['offender_type'] == 'not resident') {
                                                                    echo 'selected';
                                                                } ?>>Non-Resident</option>
                            </select>
                        </div>
                        <div id="o_input">
                            <!-- list of resident offender -->
                            <?php include '../includes/resident_off.php'; ?>
                            <!-- Name -->
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full mb-6 group">
                                    <input type="hidden" name="offender_id" class="offender_id">
                                    <input type="text" name="fname" value="<?php echo $fname; ?>" id="o_fname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                    <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                                </div>
                                <div class="relative z-0 w-full mb-6 group">
                                    <input type="text" name="lname" value="<?php echo $lname; ?>" id="o_lname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                    <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
                                </div>
                            </div>

                            <!-- Number -->

                            <div class="relative z-0 w-full mb-6 group">
                                <input type="tel" pattern="[0-9]{4}[0-9]{3}[0-9]{4}" name="number" value="<?php echo $number; ?>" id="o_contact" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone number</label>
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                                <select name="gender" id="o_gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Your Gender</option>
                                    <option value="Male" <?php if ($gender == "Male") {
                                                                echo "selected";
                                                            } ?>>Male</option>
                                    <option value="Female" <?php if ($gender == "Female") {
                                                                echo "selected";
                                                            } ?>>Female</option>
                                </select>
                            </div>

                            <!--Birthdate -->
                            <div style="margin-top: 1rem;">
                                <label for="">Birthdate <span class="required-input">*</span></label>
                                <div>
                                    <input type="date" name="bdate" id="o_bdate" value="<?php echo $bdate; ?>" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                </div>
                            </div>
                            <!--Address -->
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="address" value="<?php echo $address; ?>" id="o_address" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                <label for="floating_address" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Address</label>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea name="desc" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a comment..." required><?php echo $desc; ?></textarea>
                            </div>
                        </div>
                        <br>
                        <button type="submit" name="add_comp" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit</button>
                        </table>

                </form>


            </div>

    </main>
    <script src="../../../assets/js/sidebar.js"></script>
    <script src="./../assets/js/add-incident.js"></script>
    <script src="./../assets/js/remote_modals.js"></script>
    <script src="./assets/js/required.js"></script>
    <script src="./../assets/js/select-resident.js"></script>
    <script src="./../assets/js/disabled_input2.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#residents-table').DataTable();
        });
        $(document).ready(function() {
            $('#o_residents-table').DataTable();
        });

        //Selecting resident
        function validateForm() {
            const input = document.getElementById("resident_name").value;
            if (input == "") {
                alert("Select resident");
                return false;
            }
        }
    </script>

</body>

</html>