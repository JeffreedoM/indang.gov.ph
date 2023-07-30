<?php
include '../../../includes/deactivated.inc.php';
include '../../../includes/session.inc.php';
include './../function.php';

$b_name = $barangay['b_name'];

$id = $_GET['print_id'];

// Selecting report_complaint table with prepared statement
$query = "SELECT * FROM report_complaint WHERE complaint_id = :id AND barangay_id = :barangay_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);

// Execute the query
$stmt->execute();

// Fetch all the results
$results = $stmt->fetchAll();


// Process and display the data
foreach ($results as $row) {
    $blotter_id = $row['blotter_id'];
    $content = $row['content'];
    $para_sa = $row['para_sa'];
    $blg = $row['blg'];
    $date_s = $row['date_s'];
    $date_a = $row['date_a'];
}
if (!empty($date_s)) {
    $sMonth = convertToTagalogMonth($date_s);

    $date_s = new DateTime($date_s);
} else {
    $sMonth = '';
    $date_s = '';
}
if (!empty($date_a)) {
    $aMonth = convertToTagalogMonth($date_a);
    $date_a = new DateTime($date_a);
} else {
    $aMonth = '';

    $date_a = '';
}

// selecting incident_table
$complainant = getIncidentComplainant($pdo, $blotter_id);
$offender = getIncidentOffender($pdo, $blotter_id);

$stmt->execute();
$i_results = $stmt->fetchAll();
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
    <link rel="icon" type="image/x-icon" href="../../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Reports</title>

</head>
<style>
    @media print {

        #printPageButton,
        #backButton {
            display: none;
        }
    }

    .form-container * {
        font-family: "Times New Roman", Times, serif !important;
    }

    .form-container {
        font-size: 14px;
        width: 794px;
        margin: auto;
        /* box-sizing: content-box; */
        height: 1123px;
    }

    .form-container h2 {
        text-align: center;
        margin-top: 1rem;
        font-size: 1rem;
        text-transform: uppercase;
        font-weight: bold;
        margin-left: 26px;
    }

    .header {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        gap: 1rem;
        font-weight: 500;
    }

    .bodyform {
        display: inline;
        margin: 5rem;
    }

    .bodyform .left {
        width: 30%;
        margin-left: 2rem;
        margin-top: 5rem;
        text-align: center;
    }

    .bodyform .right {
        margin-top: 1rem;
        float: right;
        width: 40%;
        text-align: center;
    }

    .label {
        width: 20%;
        margin: 20px;
    }

    .content {
        margin: 2rem;
        margin-right: 3rem;
    }


    .footer_content {
        margin-top: 1rem;
        float: right;
        width: 80%;
    }

    .horizontal-line {
        border-top: 1px solid black;
    }

    .horizontal-line2 {
        border-top: 1px solid black;
        margin: 10px 0;
        margin-top: 1rem;
    }
</style>

<body>
    <main class="main-content">

        <!-- Container -->
        <div class="wrapper">
            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header">
                <h3 class="page-title"></h3>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <!-- Form Template -->
                <!-- Header -->
                <div class="flex justify-between">
                    <button class="py-2 px-4 m-3 bg-yellow-400 rounded-md hover:bg-yellow-500" id="backButton" onClick="window.location.href = '../index.php';"><i class="fa-solid fa-left-long"></i> Back</button>
                    <button class="py-2 px-4 m-3 bg-yellow-400 rounded-md hover:bg-yellow-500" id="printPageButton" onClick="window.print();">Print <i class="fa-solid fa-print"></i></button>
                </div>

                <div class="form-container">

                    <div class="header">
                        <img src="../../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>" alt="Barangay Logo" width="80px">
                        <div>
                            <div>Republika ng Pilipinas</div>
                            <div>Lalawigang Cavite</div>
                            <div>Lungsod/Bayan ng Indang</div>
                            <div>Barangay <?php echo $barangayName ?></div>
                        </div>
                        <img src="../../../../admin/assets/images/<?php echo $municipality['municipality_logo'] ?>" alt="Barangay Logo" width="80px">
                    </div>


                    <h2 class="title">TANGGAPAN NG PUNONG BARANGAY</h2>
                    <h2 class="title">TANGGAPAN NG LUPON TAGAPAMAYAPA</h2>
                    <div class="bodyform">
                        <div class="right">
                            <p style="text-align:left">
                                <?php echo !empty($blg) ? 'Usaping BarangayBlg.<span style="text-decoration:underline">' . $blg . '</span>' :
                                    'Usaping BarangayBlg. __________'
                                ?>
                                <br>
                                <?php echo !empty($blg) ? ' Para sa : <span style="text-decoration:underline">' . $para_sa . '</span>' :
                                    'Para sa :______________________'
                                ?>
                            </p>
                        </div>
                        <div class="left">
                            <p>
                                <?php foreach ($complainant as $row) {
                                    if (!empty($row['resident_id'])) {
                                        echo "$row[firstname] $row[middlename] $row[lastname]";
                                    } else {
                                        echo "$row[non_res_firstname] $row[non_res_lastname]";
                                    }
                                ?>
                            <div class="horizontal-line"></div>
                        <?php
                                }

                        ?>
                        Nagrereklamo
                        <div style="margin: 30px;"> -Laban kay-</div>
                        <?php foreach ($offender as $row) {
                            if (!empty($row['resident_id'])) {
                                echo "$row[firstname] $row[middlename] $row[lastname]";
                            } else {
                                echo "$row[non_res_firstname] $row[non_res_lastname]";
                            }
                        ?>
                            <div class="horizontal-line"></div>
                        <?php
                        }

                        ?>
                        Inirereklamo
                        </p>
                        </div>
                        <div class="content">
                            <h2 style="margin:20px">Reklamo</h2>
                            <span class="pr-4"></span>AKO / KAMI AY NAGREREKLAMO LABAN SA MGA TAONG PINANGALANAN SA
                            ITAAS DAHIL SA PAGLABAG SA AKING/AMING KARAPATAN AT INTERES SA MGA SUMUSUNOD;
                            <!-- <div class="">
                                <hr class="line-name">
                            </div> -->
                            <br>
                            <br>
                            <p style="text-decoration: underline;">
                                <?php echo $content; ?>

                            </p>
                            <?php if (empty($content)) { ?>
                                <div class="horizontal-line2"></div>
                                <div class="horizontal-line2"></div>
                                <div class="horizontal-line2"></div>
                                <div class="horizontal-line2"></div>
                                <div class="horizontal-line2"></div>
                                <div class="horizontal-line2"></div>
                                <div class="horizontal-line2"></div>
                                <div class="horizontal-line2"></div>
                            <?php } ?>

                            <br>
                            DAHIL DITO, AKO/KAMI AY NAKIKIUSAP NA ANG MGA SUMUSUNOD NA LUNAS
                            AY IPAGKALOOB SA AKIN/AMIN NANG SA BATAS AT / SA KATARUNGAN.

                            <div class="footer_content">
                                <?php if (!empty($date_s)) { ?>
                                    GINAGAWA NGAYONG IKA-<span style="text-decoration:underline"><?php echo $date_s->format('d'); ?></span> ARAW NG <span style="text-decoration:underline"><?php echo $sMonth; ?></span>, <?php echo $date_s->format('Y') ?>
                                <?php }
                                if (empty($date_s)) {
                                    echo 'GINAGAWA NGAYONG IKA-_____ARAW NG__________,' . date("Y");
                                }
                                ?>

                                <br>
                                <?php if (!empty($date_a)) { ?>
                                    TINANGGAP AT INIHAIN NGAYONG IKA-<span style="text-decoration:underline"><?php echo $date_a->format('d') ?></span> ARAW NG <span style="text-decoration:underline"><?php echo $sMonth; ?></span>, <?php echo $date_a->format('Y') ?>
                                <?php }
                                if (empty($date_a)) {
                                    echo 'TINANGGAP AT INIHAIN NGAYONG IKAW-____ARAW NG__________,' . date("Y");
                                }
                                ?>
                                <div class="right" style="margin-top:2rem">
                                    <?php foreach ($complainant as $row) {
                                        if (!empty($row['resident_id'])) {
                                            echo "$row[firstname] $row[middlename] $row[lastname]";
                                        } else {
                                            echo "$row[non_res_firstname] $row[non_res_lastname]";
                                        }
                                    ?>

                                    <?php } ?>
                                    <div class="horizontal-line"></div>
                                    NAGREREKLAMO
                                    <br><br>
                                    <?php foreach ($offender as $row) {
                                        if (!empty($row['resident_id'])) {
                                            echo "$row[firstname] $row[middlename] $row[lastname]<br>";
                                        } else {
                                            echo "$row[non_res_firstname] $row[non_res_lastname]<br>";
                                        }
                                    ?>

                                    <?php } ?>
                                    <div class="horizontal-line"></div>
                                    TUMANGGAP NG REKLAMO
                                </div>

                            </div>
                        </div>


                    </div>
                </div>


            </div>
        </div>




    </main>
    <script>
        function printPage() {
            window.print();
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
</body>

</html>