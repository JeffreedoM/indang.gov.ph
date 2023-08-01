<?php
include '../../../../includes/deactivated.inc.php';
include '../../../../includes/session.inc.php';
include './query.php';

$b_name = $barangay['b_name'];

$query = "SELECT * FROM incident_table WHERE barangay_id=$barangayId";
$stmt = $pdo->query($query);
$rows = $stmt->fetchAll();
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
    <link rel="stylesheet" href="../../../../assets/css/main.css" />
    <link rel="icon" type="image/x-icon" href="../../../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Reports</title>

</head>
<style>
    .form-container * {
        font-family: "Times New Roman", Times, serif !important;
    }

    .form-container {
        font-size: 14px;
        width: 794px;
        margin: auto;
        border: 1px solid #ddd;
        padding: 48px 0 48px 20px;
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
        margin-top: 1rem;
    }

    .show {
        color: green;

    }

    .show:hover {
        text-decoration: underline;

    }
</style>

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
                <div style="display:flex;">
                    <button data-modal-target="medium-modal" data-modal-toggle="medium-modal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" type="button">
                        GENERATE
                    </button>
                    <button type="button" style="margin-right: auto;" class="text-gray-900 hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800">
                        <a href="../../index.php">Back</a>
                    </button>
                </div>

                <!-- Form Template -->
                <!-- Header -->
                <div class="form-container">

                    <div class="header">
                        <img src="../../../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>" alt="Barangay Logo" width="80px">
                        <div>
                            <div>Republika ng Pilipinas</div>
                            <div>Lalawigang Cavite</div>
                            <div>Lungsod/Bayan ng Indang</div>
                            <div>Barangay <?php echo $barangayName ?></div>
                        </div>
                        <img src="../../../../../admin/assets/images/<?php echo $municipality['municipality_logo'] ?>" alt="Barangay Logo" width="80px">
                    </div>


                    <h2 class="title">TANGGAPAN NG PUNONG BARANGAY</h2>
                    <h2 class="title">TANGGAPAN NG LUPON TAGAPAMAYAPA</h2>
                    <div class="bodyform">
                        <div class="right">
                            <p>
                                Usaping BarangayBlg. __________
                                <br>
                                Para sa :______________________
                            </p>
                        </div>
                        <div class="left">
                            <p>
                            <div class="horizontal-line"></div>
                            <div class="horizontal-line"></div>
                            Nagrereklamo
                            <div style="margin: 30px;"> -Laban kay-</div>
                            <div class="horizontal-line"></div>
                            <div class="horizontal-line"></div>
                            Inirereklamo
                            </p>
                        </div>
                        <div class="content">
                            <h2 style="margin:20px">Reklamo</h2>
                            <span class="pr-4"></span>AKO / KAMI AY NAGREREKLAMO LABAN SA MGA TAONG PINANGALANAN SA
                            ITAAS DAHIL SA PAGLABAG SA AKING/AMING KARAPATAN AT INTERES SA MGA SUMUSUNOD;
                            <br>
                            <br>
                            <div class="horizontal-line"></div>
                            <div class="horizontal-line"></div>
                            <div class="horizontal-line"></div>
                            <div class="horizontal-line"></div>
                            <div class="horizontal-line"></div>
                            <div class="horizontal-line"></div>
                            <div class="horizontal-line"></div>
                            <div class="horizontal-line"></div>
                            <div class="horizontal-line"></div>
                            <div class="horizontal-line"></div>
                            <div class="horizontal-line"></div>
                            <div class="horizontal-line"></div>
                            <br>
                            DAHIL DITO, AKO/KAMI AY NAKIKIUSAP NA ANG MGA SUMUSUNOD NA LUNAS
                            AY IPAGKALOOB SA AKIN/AMIN NANG SA BATAS AT / SA KATARUNGAN.

                            <div class="footer_content">
                                GINAGAWA NGAYONG IKA-_____ARAW NG__________,<?php echo date("Y") ?>
                                <br>
                                TINANGGAP AT INIHAIN NGAYONG IKAW-_____ARAW NG__________,<?php echo date("Y") ?>

                                <div class="right">
                                    <div class="horizontal-line" style="margin-top:2rem"></div>
                                    NAGREREKLAMO
                                    <br>
                                    <div class="horizontal-line" style="margin-top:2rem"></div>
                                    TUMANGGAP NG REKLAMO
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
                <center><button onClick="window.location.href ='../../pdf/compReport_orig.php';" class="py-2 px-4 m-3 text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">View <i class="fa-solid fa-eye"></i></button></center>


            </div>
        </div>

        <?php include './modal.php'; ?>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.0/datepicker.min.js"></script>
</body>

</html>