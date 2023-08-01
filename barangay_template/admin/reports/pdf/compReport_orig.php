<?php
include '../../../includes/deactivated.inc.php';
include '../../../includes/session.inc.php';

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
    <link rel="stylesheet" href="../assets/css/forms.css" />
    <link rel="icon" type="image/x-icon" href="../../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Reports</title>
</head>

<body>

    <!-- Form Template -->
    <!-- Header -->
    <div class="flex justify-between">
        <button class="py-2 px-4 m-3 bg-yellow-400 rounded-md hover:bg-yellow-500" id="backButton" onClick="window.location.href = '../action/5/create.php';"><i class="fa-solid fa-left-long"></i> Back</button>
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
                <p>
                    Usaping BarangayBlg. __________
                    <br>
                    Para sa :______________________
                </p>
            </div>
            <div class="left">
                <p>
                <div class="horizontal-line2"></div>
                <div class="horizontal-line2"></div>
                Nagrereklamo
                <div style="margin: 30px;"> -Laban kay-</div>
                <div class="horizontal-line2"></div>
                <div class="horizontal-line2"></div>
                Inirereklamo
                </p>
            </div>
            <div class="content">
                <h2 style="margin:20px">Reklamo</h2>
                <span class="pr-4"></span>AKO / KAMI AY NAGREREKLAMO LABAN SA MGA TAONG PINANGALANAN SA
                ITAAS DAHIL SA PAGLABAG SA AKING/AMING KARAPATAN AT INTERES SA MGA SUMUSUNOD;
                <br>
                <br>
                <div class="horizontal-line2"></div>
                <div class="horizontal-line2"></div>
                <div class="horizontal-line2"></div>
                <div class="horizontal-line2"></div>
                <div class="horizontal-line2"></div>
                <div class="horizontal-line2"></div>
                <div class="horizontal-line2"></div>
                <div class="horizontal-line2"></div>
                <div class="horizontal-line2"></div>
                <div class="horizontal-line2"></div>
                <div class="horizontal-line2"></div>
                <div class="horizontal-line2"></div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
</body>

</html>