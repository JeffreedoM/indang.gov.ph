<?php
$incident_id = $_GET['print_id'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .text-center {
            text-align: center;
        }

        .pull-right {
            float: right;
        }

        .pull-left {
            float: left;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .heading {
            margin-top: 50px;
            width: 100%;
        }

        .heading span {
            display: block;
            width: 100%;
        }

        .heading-logo .left-img {
            width: 100px;
            height: 100px;
            position: absolute;
            left: 90px;
            top: 15px;
        }

        .heading-logo .right-img {
            width: 100px;
            height: 100px;
            position: absolute;
            right: 90px;
            top: 15px;
        }

        .heading h2 {
            margin: 60px 0px;
            letter-spacing: 2px;
        }

        .incident-primary-info span {
            font-size: 16px;
            line-height: 24px;
            font-weight: bold;
        }

        .narative p {
            font-size: 18px;
            line-height: 22px;
            text-indent: 40px;
        }

        .doc-signatures {
            margin-top: 50px;
        }

        .doc-signatures span {
            width: 180px;
            display: block;
            line-height: 24px;
            border-top: 1px solid;
        }

        .barangay-cap-sign {
            margin-left: 300px;
        }

        .barangay-cap-sign span {
            border-bottom: 0px !important;
        }
    </style>
</head>

<body>
    <div class=\"heading-logo\">
        <img class=\"left-img\" src=\"assets/images/calumpang.png\">
        <img class=\"right-img\" src=\"assets/images/indang.png\">
    </div>
    <div class=\"heading text-center\">
        <span>Republic of the Philippines</span>
        <span class=\"text-uppercase\">Case Incident Report</span>
        <i>Indang Cavite</i>
        <h2>CERTIFICATE</h2>
    </div>
    <div class=\"incident-print-body\">
        <div class=\"incident-primary-info\">
            <span class=\"text-uppercase\">FOR RECORD :</span> $incident_title <br>
            <span class=\"\">Entry No.</span> $case_no <br>
            <span class=\"\">Location :</span> $location <br>
            <span>Date/Time Reported :</span> $date_reported <br>
        </div>

        <hr>
        <table>
            <tr>
                <td colspan=\"2\">
                    <h3>Reporting Person</h3>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Name :</label>
                </td>
                <td>
                    $name
                </td>
            </tr>
            <tr>
                <td>
                    <label>Gender :</label>
                </td>
                <td>
                    $gender
                </td>
            </tr>
            <tr>
                <td>
                    <label>Phone Number :</label>
                </td>
                <td>
                    N/A
                </td>
            </tr>
            <tr>
                <td>
                    <label>Address :</label>
                </td>
                <td>
                    $address
                </td>
            </tr>
        </table>
        <hr>
        <table>
            <tr>
                <td colspan=\"2\">
                    <h3>Offender</h3>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Name :</label>
                </td>
                <td>
                    $offender_name
                </td>
            </tr>
            <tr>
                <td>
                    <label>Gender :</label>
                </td>
                <td>
                    $offender_gender
                </td>
            </tr>
            <tr>
                <td>
                    <label>Address :</label>
                </td>
                <td>
                    $offender_address
                </td>
            </tr>
            <tr>
                <td>
                    <label>Description :</label>
                </td>
                <td>
                    $description
                </td>
            </tr>
        </table>
        <hr>
        <div class=\"narative\">
            <h3 class=\"text-uppercase\">Narrative :</h3>
            <p>$narrative</p>
        </div>
        <div class=\"doc-signatures\">
            <table>
                <tr>
                    <td>
                        <div class=\"text-center prepared-by\">
                            $sec
                            <span>Prepared By</span>
                        </div>
                    </td>
                    <td>

                        <div class=\"text-center barangay-cap-sign\">
                            $captain
                            <span> Barangay Captain</span>
                        </div>
                    </td>
                </tr>


        </div>
    </div>

    <table>
        <tr>
            <td colspan=\"2\">
                <h3>Reporting Person</h3>
            </td>
        </tr>
        <tr>
            <td>
                <label>Name :</label>
            </td>
            <td>
                $name
            </td>
        </tr>
        <tr>
            <td>
                <label>Gender :</label>
            </td>
            <td>
                $gender
            </td>
        </tr>
        <tr>
            <td>
                <label>Phone Number :</label>
            </td>
            <td>
                N/A
            </td>
        </tr>
        <tr>
            <td>
                <label>Address :</label>
            </td>
            <td>
                $address
            </td>
        </tr>
    </table>
</body>

</html>