<?php
include '../../../../includes/deactivated.inc.php';
include '../../../../includes/session.inc.php';
include '../../../../includes/dbh.inc.php';
include '../../function.php';

$officials = getBrgyOfficials($pdo, $barangayId);
$household = getR_familyCount($pdo, $barangayId);
$cap =  !empty($officials['captain']) ? $officials['captain']['firstname'] . ' ' . strtoupper($officials['captain']['middlename'][0]) . '. ' . $officials['captain']['lastname'] : '';

//count all resident
$totalPop = getResidentCount($pdo, $barangayId);

if (isset($_POST['submit'])) {
    try {
        $mcuName = $_POST['mcuName'];
        $mquarter = $_POST['quarter'];
        $myear = $_POST['year'];
        $cce = $_POST['cce'];

        $total_comp = $_POST['total_comp'];
        $com_ave = $_POST['com_ave'];
        $mrf_brgy = $_POST['mrf_brngy'];
        $mrf_fclty = $_POST['mrf_fclty'];

        //radio yes or no
        // Retrieve the answers from the form
        $answer1 = $_POST['rdbtn'] == '1' ? 1 : 0;
        $answer2 = $_POST['rdbtn1'] == '1' ? 1 : 0;
        $answer3 = $_POST['rdbtn2'] == '1' ? 1 : 0;
        $answer4 = $_POST['rdbtn3'] == '1' ? 1 : 0;
        // and so on for the other answers...

        // Combine the answers into a binary number
        $checks = $answer1 | ($answer2 << 1) | ($answer3 << 2) | ($answer4 << 3);

        // arrays
        $key_array = $_POST['k'];
        $legal_array = $_POST['l'];
        $reason_array = $_POST['r'];
        $next_array = $_POST['n'];



        $stmt = $pdo->prepare("INSERT INTO report_cleanup (mcu_name,mcu_quarter,mcu_year, total_compliant, com_ave,mrf_brngy, mrf_fclty, commChairman, checks, barangay_id)VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute([$mcuName,  $mquarter, $myear, $total_comp, $com_ave, $mrf_brgy, $mrf_fclty, $cce, $checks, $barangayId]);

        $id = $pdo->lastInsertId();
        for ($i = 0; $i < 4; $i++) {
            if (($key_array[$i] or $legal_array[$i] or $reason_array[$i] or $next_array[$i]) === '') {
                continue;
            }
            $key = $key_array[$i];
            $legal = $legal_array[$i];
            $reason = $reason_array[$i];
            $next = $next_array[$i];

            $stmt = $pdo->prepare("INSERT INTO report_cleanup_nstep (key_legal, legal_consq, reason_low, next_step, mcu_id)VALUES (?,?,?,?,?)");
            $stmt->execute([$key, $legal, $reason, $next, $id]);
        }
        header('Location: ../../index.php');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
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
    <!-- //bootstrap for calendar -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../../assets/css/main.css" />
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link rel="stylesheet" href="../../assets/css/reset.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">

    <!-- css for data table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

    <!-- css -->
    <style>
        .brgy_n {
            position: absolute;
            bottom: 0;
            font-size: 14px;
            color: gray;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 10px;
            margin-left: 20px;
        }

        .tablePadding th {
            padding-left: 25px;
            padding-right: 25px;
        }

        .genInfo {
            font-size: 16px;
        }

        .genInfo th {
            padding-left: 10px;
        }

        h4 {
            text-decoration: underline;
        }
    </style>

    <link rel="icon" type="image/x-icon" href="../../../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Reports</title>
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
            <div class="page-body">
                <form action="" method="POST">
                    <!-- back -->
                    <button type="button" class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800">
                        <a href="../../index.php">Back</a>
                    </button>
                    <div>
                        <!-- report format -->
                        <div class="head" style="align-content :center; border-bottom:none;">
                            <p>MONTHLY CLEAN UP, REHABILITATION AND PRESERVATION PROJECT</p>
                            Quarter:
                            <select name="quarter" id="quarter" style="height: 35px; margin-top: .3rem; " required>
                                <option name="quarter" value="" disabled selected>Select quarter</option>
                                <option value="1st">1st</option>
                                <option value="2nd">2nd</option>
                                <option value="3rd">3rd</option>
                                <option value="4th">4th</option>
                            </select>
                            Quarter Year:
                            <input type="text" class="form-control" name="year" id="datepicker" placeholder="Year" style="height: 35px; margin-top: .3rem;  " required />
                            <h2 class="swm">SOLID WASTE MANAGEMENT</h2>
                            <br>

                        </div>
                        <div class="body" style="text-align:left">
                            <input type="hidden" name="mcuName" value="Monthly Clean-up">

                            <h4>GENERAL INFORMATION</h4>
                            <table class="genInfo">
                                <tr>
                                    <td>Name of Barangay: </td>
                                    <th><?php echo $barangay['b_name']; ?></th>
                                </tr>
                                <tr>
                                    <td>Provincial Location:</td>
                                    <th><?php echo $barangay['b_address']; ?> </th>
                                </tr>
                                <tr>
                                    <td>Regional Location:</td>
                                    <th>IV-A (CALABARZON)</th>
                                </tr>
                                <tr>
                                    <td>No. of Households:</td>
                                    <th><?php echo $household; ?> </th>
                                </tr>
                                <tr>
                                    <td>Total Population:</td>
                                    <th><?php echo $totalPop; ?> </th>
                                </tr>
                            </table>
                            <br>
                            <h4>MANDATORY SEGREGATION OF WASTE AT SOURCE</h4>
                            <br>
                            <h5>12. Determine the compliance rate of Barangay.</h5>
                            <p>3.1 Total number of households: </p>
                            <p>3.2 Total number of compliant households: <span><input type="number" name="total_comp"></span></p>
                            <p>3.3 Computed average (use formula below): <span><input type="number" name="com_ave"></span></p>
                            <br>

                            <h5>13. Based on the computed average, is the Barangay compliant?</h5>
                            <p>If average is 70% or higher, tick "YES"</p>
                            <p>If average is 69% or lower, tick "NO"</p>
                            <input type="radio" name="rdbtn" value="1" style="padding:10px">YES
                            <input type="radio" name="rdbtn" value="0" style="padding:10px">NO
                            <p>(Barangay much reach a minimum rate of 70% to be considered as compliant)</p>
                            <br>
                            <br>
                            <h4>FUNCTIONAL MATERIALS RECOVERY FACILITY</h4>
                            <br>
                            <h5>14. Determine the compliance rate of the Barangay.</h5>
                            <table>
                                <tbody>
                                    <!-- MRF -->
                                    <tr>
                                        <th rowspan="1" style="padding-left:2%; color:white; text-align:left; background-color:SteelBlue">Is there an existing MRF servicing the Barangay, whether individual, cluster or municipal? (50%)</th>
                                        <th style="background-color:LightSteelBlue; padding:10px 10px 0 10px">
                                            <input type="number" name="mrf_brngy" id="num1">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th rowspan="1" style="padding-left:2%;color:white; text-align:left; background-color:SteelBlue">Does the existing MRF with an operational solid waste transfer station or sorting station, drop-off center, a composting facility and a recycling facility? (50%)</th>
                                        <th style="background-color:LightSteelBlue; padding:10px 10px 0 10px">
                                            <input type="number" name="mrf_fclty" id="num2">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th rowspan="1" style="padding-left:2%;color:white; text-align:left;  background-color:SteelBlue">TOTAL</th>
                                        <th style="background-color:LightSteelBlue; padding:10px 10px 0 10px ">
                                            <input type="number" id="result" disabled>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <h5>15. Based on the total, is the LGU compliant?</h5>
                            <p>If score is 100%, tick "YES"</p>
                            <p>Otherwise, tick "NO"</p>
                            <input type="radio" name="rdbtn1" value="1" style="padding:10px">YES
                            <input type="radio" name="rdbtn1" value="0" style="padding:10px">NO
                            <br>
                            <h4 style="margin-top: 50px">NO LITTERING AND RELATED ORDINANCE</h4>
                            <br>
                            <h5>16. The Barangay has NO LITTERING ordinance</h5>
                            <input type="radio" name="rdbtn2" value="1" style="padding:10px">YES
                            <input type="radio" name="rdbtn2" value="0" style="padding:10px">NO
                            <br>
                            <br>
                            <h5>17. If "YES", is the ordinance strictly implemented? (conduct a random ocular inspection)</h5>
                            <input type="radio" name="rdbtn3" value="1" style="padding:10px">YES
                            <input type="radio" name="rdbtn3" value="0" style="padding:10px">NO
                            <br>
                            <br>

                            <!-- next steps -->
                            <h4>NEXT STEPS</h4>
                            <table style="background-color:SteelBlue;">
                                <thead style="font-size: large; text-align:center">
                                    <tr>
                                        <th>KEY LEGAL PROVISION</th>
                                        <th>LEGAL CONSEQUENCES</th>
                                        <th>REASON FOR LOW-COMPLIANCE</th>
                                        <th>NEXT STEPS</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center;" class="tablePadding">
                                    <tr>
                                        <th><input type="text" name="k[]"></th>
                                        <th><input type="text" name="l[]"></th>
                                        <th><input type="text" name="r[]"></th>
                                        <th><input type="text" name="n[]"></th>
                                    </tr>
                                    <tr>
                                        <th><input type="text" name="k[]"></th>
                                        <th><input type="text" name="l[]"></th>
                                        <th><input type="text" name="r[]"></th>
                                        <th><input type="text" name="n[]"></th>
                                    </tr>
                                    <tr>
                                        <th><input type="text" name="k[]"></th>
                                        <th><input type="text" name="l[]"></th>
                                        <th><input type="text" name="r[]"></th>
                                        <th><input type="text" name="n[]"></th>
                                    </tr>
                                    <tr>
                                        <th><input type="text" name="k[]"></th>
                                        <th><input type="text" name="l[]"></th>
                                        <th><input type="text" name="r[]"></th>
                                        <th><input type="text" name="n[]"></th>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <div class="accby">
                                <h4>ACCOMPLISHED BY:</h4>
                                <input type="text" name="cce" required>
                                <br>
                                <label for="cce">Committee Chairman on Environment</label>
                            </div>
                            <br>
                            <div>
                                <h4>CERTIFIED TRUE AND CORRECT:</h4>
                                <div class="input-wrapper">
                                    <p><strong><?php echo $cap; ?></strong></p>
                                    <br>
                                    <span class="brgy_n">Barangay Captain</span>
                                </div>
                            </div>


                            <div class="fieldBtn">
                                <button class="btn btn-secondary" style="margin-right: .3rem;">
                                    <a href="../../index.php">Back</a>
                                </button>
                                <button type="submit" name="submit" class="btn btn-primary">Save</button>
                            </div>




                        </div>
                </form>

            </div>

        </div>






    </main>

    <script src="../../../../assets/js/sidebar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <!-- js for jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- js for data table -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

    <!-- date picker -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    <!-- validate inputs -->
    <script src="./../../assets/js/validate_input.js"></script>
    <!-- calculate two inputs -->
    <script src="../../assets/js/calculate.js"></script>
    <!-- select year -->
    <script>
        $("#datepicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
    </script>
</body>

</html>