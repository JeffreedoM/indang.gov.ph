<?php
include '../../../../includes/deactivated.inc.php';
include '../../../../includes/session.inc.php';
include '../../../../includes/dbh.inc.php';
include '../../function.php';

$b_name = $barangay['b_name'];

$officials = getBrgyOfficials($pdo, $barangayId);




if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $nonComp_name_array = $_POST['name_Ncomp'];
    $absent_array = $_POST['absent_Ncomp'];
    $tardy_array = $_POST['tardy_Ncomp'];
    $station_array = $_POST['station'];
    $pos_array = $_POST['pos'];
    $n_name = $_POST['n_name'];
    $quarter = $_POST['quarter'];

    //insert in report_personnel_list
    $stmt = $pdo->prepare("INSERT INTO report_personnel_list (pam_title, n_name,`quarter`, barangay_id ) VALUES (:title, :n_name,:quarter, :b_id)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':n_name', $n_name);
    $stmt->bindParam(':quarter', $quarter);
    $stmt->bindParam(':b_id', $barangayId);
    if ($stmt->execute()) {
        $id = $pdo->lastInsertId();

        //loop for insert multiple in tables
        for ($i = 0; $i < count($nonComp_name_array); $i++) {
            if ($nonComp_name_array[$i] === '') {
                continue;
            }
            $nonComp_name = $nonComp_name_array[$i];
            $absent = $absent_array[$i];
            $tardy = $tardy_array[$i];
            $station = $station_array[$i];
            $pos = $pos_array[$i];
            $stmt = $pdo->prepare("INSERT INTO report_personnel (nonComp_name, nonComp_absent, nonComp_tardy,station,position,pam_id) VALUES (?,?,?,?,?,?)");
            $stmt->execute([$nonComp_name, $absent, $tardy, $station, $pos, $id]);
        }

        // echo "<script>window.location.href='../../pdf/pam_pdf.php?view_id=$id';</script>";
        header('location: ../../index.php');
    } else {
        echo 'Error record data: ' . $pdo->errorInfo()[2];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../../../assets/css/main.css" />
</head>
<!-- css for data table -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<!-- script for add row -->
<link rel="icon" type="image/x-icon" href="../../../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
<title>Admin Panel | Reports</title>
<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    input {
        border: none;
        text-align: center;
    }

    table {
        width: 100%;
        margin-bottom: 10px;
    }

    table input {
        width: 100%;
        height: 50px;
    }


    #bname {
        width: 100%;
    }

    .pre {
        text-align: left;
        margin-top: 40px;
        margin-bottom: 50px;
    }

    label {
        color: #1f2937;
        font-weight: bold;
        width: 150px;
    }

    .input-wrapper {
        position: relative;
        margin-bottom: 10px;
    }

    .brgy_n {
        position: absolute;
        bottom: 0;
        font-size: 12px;
        color: gray;
        margin-left: 50px;
    }

    hr {
        border: none;
        border-top: 1px solid black;
        margin: 10px 0;
    }

    h1 {
        font-size: large;
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;

    }
</style>
</head>

<body>


    <?php
    include '../../../../partials/nav_sidebar.php';
    ?>
    <main class="main-content">
        <?php
        include '../../../../partials/nav_header.php';
        ?>

        <!-- Container -->
        <div class="wrapper">
            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header">
                <h3 class="page-title">Reports</h3>
            </div>

            <!-- Page body -->
            <div class="page-body" style="overflow-x:scroll">
                <form id="pam" action="" method="POST" onsubmit="return validateInputs()">
                    <button type="button" class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800">
                        <a href="../../index.php">Back</a></button>
                    <div>
                        <h1>
                            PERSONNEL ATTENDANCE MONITORING
                            <br>Attendance Monitoring Form 1A<br>
                            For The
                            <select name="quarter" id="" required>
                                <option value="" selected disabled>Select</option>
                                <option value="1st">1st</option>
                                <option value="2nd">2nd</option>
                                <option value="3rd">3rd</option>
                                <option value="4th">4th</option>
                            </select>
                            Quarter
                        </h1>
                    </div>
                    <div>
                        <!-- add row button -->
                        <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-1 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700" onclick="addRow()"> Insert Row</button>
                    </div>
                    <table class="row-border hover" id="report-table">
                        <thead>
                            <tr>
                                <th>
                                    LGU Province, City,Municipality, Barangay (1)
                                </th>
                                <th>Name of Non-Compliant Personnel(2)</th>
                                <th colspan="2" style="text-align:center">Nature of Non-Compliance(3)</th>
                                <th>Station</th>
                                <th>Position/Designation</th>
                            </tr>

                            <tr>
                                <td></td>
                                <td></td>
                                <td style="text-align:center">Habitual Absenteeism</td>
                                <td style="text-align:center">Habitual Tardiness</td>
                                <td></td>
                                <td></td>

                            </tr>
                        </thead>
                        <tbody>

                            <div id="addrow">
                                <input type="hidden" id="pam_id" value="<?php echo $id; ?>">
                                <input type="hidden" name="title" value="Personal Attendance Monitoring">
                                <tr>
                                    <td style="text-align:center">
                                        <?php echo $b_name; ?>
                                    </td>
                                    <td>
                                        <input type="text" name="name_Ncomp[]" value="" required>
                                    </td>
                                    <td>
                                        <input type="number" name="absent_Ncomp[]" value="" required>
                                    </td>
                                    <td>
                                        <input type="number" name="tardy_Ncomp[]" value="" required>
                                    </td>
                                    <td>
                                        <input type="text" name="station[]" value="" required>
                                    </td>
                                    <td>
                                        <input type="text" name="pos[]" value="" required>
                                    </td>
                                </tr>

                            </div>

                        </tbody>

                    </table>


                    <!-- prepared -->
                    <div class="pre">
                        <div>
                            <label for="p_name">Prepared By:</label>
                        </div>
                        <div class="input-wrapper">
                            <input type="text" name="p_name" value="<?php echo $officials['secretary']['firstname'] . ' ' . $officials['secretary']['lastname']; ?>" disabled>
                            <br>
                            <span class="brgy_n">Barangay Secretary</span>
                        </div>
                        <div>
                            <label for="s_name">Submitted By:</label>

                        </div>
                        <div class="input-wrapper">
                            <input type="text" name="s_name" value="<?php echo !empty($officials['captain']) ? $officials['captain']['firstname'] . ' ' . $officials['captain']['lastname'] : ''; ?>" disabled>
                            <br>
                            <span class="brgy_n">Barangay Captain</span>
                        </div>
                        <div>
                            <label for="n_name">Noted By:</label>
                        </div>
                        <div class="input-wrapper">
                            <input type="text" name="n_name" placeholder="Enter Mayor's name..." required>
                            <br><br>
                            <span class="brgy_n">Municipal Mayor</span>
                        </div>
                    </div>
                    <div class="save_btn">
                        <button name="submit" class=" text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                            Save</button>
                    </div>
                </form>

            </div>
        </div>


    </main>

    <script src="../../../../assets/js/sidebar.js"></script>
    <script src="./../../assets/js/submit_message.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <!-- js for jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- js for data table -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

    <!-- js form -->
    <!-- <script src="./../../assets/js/validate_input.js"></script> -->

    <script>
        // JavaScript function to add rows dynamically
        function addRow() {
            // Get the table
            var table = document.getElementById("report-table");
            // Get the current number of rows
            var rowCount = table.rows.length;
            // Add a new row
            var row = table.insertRow(rowCount);
            // Add cells to the row
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            // Add inputs to the cells

            cell1.innerHTML = '<input type="text" id="bname" value="<?php echo $b_name; ?>" disabled>';
            cell2.innerHTML += '<input type="text" name="name_Ncomp[]" value="">';
            cell3.innerHTML += '<input type="number" name="absent_Ncomp[]" value="">';
            cell4.innerHTML += '<input type="number" name="tardy_Ncomp[]" value="">';
            cell5.innerHTML += '<input type="text" name="station[]" value="">';
            cell6.innerHTML += '<input type="text" name="pos[]" value="">';

        }
    </script>
    </form>
</body>

</html>