<?php

include 'includes/session.inc.php';

include 'includes/add-brgy.inc.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="./assets/css/main.css" />
    <link rel="stylesheet" href="./assets/css/bs-overwrite.css" />
    <title>Admin Panel | Indang, Cavite</title>
</head>


<!-- to overwrite default bootstrap styling -->
<style>
    .barangay-logo {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .barangay-logo img {
        border-radius: 50%;
        width: 100px;
        height: 100px;
    }

    .barangay-name {
        margin: 0;
        font-weight: bold;
        letter-spacing: 2px;
        line-height: normal;
    }

    .page-title {
        font-size: 1.17em;
        font-weight: bold;
    }

    .logo-img {
        padding-top: 0 !important;
    }

    p {
        margin: 0;
    }

    ol,
    ul {
        padding-left: 0;
    }
</style>

<body>
    <?php
    include './partials/nav_sidebar.php';
    ?>

    <main class="main-content">
        <?php
        include './partials/nav_header.php';
        ?>

        <!-- Add Barangay -->
        <div class="wrapper">
            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header">
                <h3 class="page-title">Adding of Barangay</h3>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <form action="" method="POST" class="add-brgy__form" enctype="multipart/form-data">
                    <div>
                        <label for="">Barangay Name <span class="required-input">*</span></label>
                        <input type="text" name="brgy-name" class="barangay-check" placeholder="Barangay Name" id="brgy-name" required>
                        <small class="barangay-exists" style="color: red;"></small>
                    </div>
                    <div class="barangay-logo">
                        <div>
                            <img src="./assets/images/uploads/barangay-logos/logo-default.jpg" alt="" id="logo-img">
                        </div>
                        <div style="width: 100%;">
                            <label for="">Barangay Logo <span class="required-input">*</span></label>
                            <input type="file" name="image" id="image-input" accept="image/jpeg, image/png" required onchange="show(this)">
                        </div>

                    </div>
                    <div id="address-container">
                        <label for="">Complete Address <span class="required-input">*</span></label>
                        <div>
                            <input type="text" name="brgy-address" placeholder="Address" required>
                            <div>Indang, Cavite</div>
                        </div>

                    </div>

                    <h2 class="form-title">Barangay Admin's Information</h2>
                    <p class="add-resident__desc">This will be the administrator of the barangay's system.
                    </p>

                    <div class="form-group">
                        <!-- First Name -->
                        <div>
                            <label for="">First name <span class="required-input">*</span></label>
                            <input type="text" name="firstname" placeholder="Firstname" required>
                        </div>
                        <!-- Middle Name -->
                        <div>
                            <label for="">Middle name</label>
                            <input type="text" name="middlename" placeholder="Middle name">
                        </div>
                        <!-- Last Name -->
                        <div>
                            <label for="">Last name <span class="required-input">*</span></label>
                            <input type="text" name="lastname" placeholder="Last name" required>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <div>
                            <label for="">Set Default <strong>Username</strong> for Barangay Admin <span class="required-input">*</span></label>
                            <input type="text" name="username" placeholder="Username" required>
                        </div>
                        <div>
                            <label for="">Set Default <strong>Password</strong> for Barangay Admin <span class="required-input">*</span></label>
                            <div id="password-container">
                                <input type="password" name="password" placeholder="Password" id="password" required>
                                <span id="show-pass"><i class="fa-solid fa-eye"></i></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="submit" id="submit">Add Barangay</button>
                </form>
            </div>

        </div>


        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Barangay added successfully!</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="refreshPage()"></button>
                    </div>
                    <div class="modal-body">
                        You can print the necessary information of the Barangay.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" id="print" onclick="printPage('print.php')"><i class="fa-solid fa-print"></i>
                            <span style="margin-left: 5px;"></span> Print</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="refreshPage()">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </main>



    <script>
        /* show / hide password ============================================= */
        pass = document.getElementById('password')
        showPass = document.getElementById('show-pass')
        showPass.addEventListener('click', () => {
            // console.log('clicked')
            // console.log(pass.type)
            if (pass.type === 'password') {
                // console.log('passowrd')
                pass.type = 'text';
                showPass.innerHTML = `<i class="fa-solid fa-eye-slash"></i>`;
            } else {
                pass.type = 'password';
                showPass.innerHTML = `<i class="fa-solid fa-eye"></i>`;
            }
        })


        /* For file uupload validation ====================================== */
        function show(input) {
            debugger;
            var validExtensions = ['jpg', 'png', 'jpeg']; //array of valid extensions
            var fileName = input.files[0].name;
            var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
            const fileSize = input.files[0].size / 1024 / 1024; // in MiB
            if ($.inArray(fileNameExt, validExtensions) == -1) {
                input.type = ''
                input.type = 'file'
                $('#logo-img').attr('src', "");
                alert("Only these file types are accepted : " + validExtensions.join(', '));
            } else if (fileSize > 2) {
                alert('File size exceeds 5 MiB');
                $('#logo-img').attr('src', "./assets/images/uploads/barangay-logos/logo-default.jpg");
                $('#image-input').val(''); //for clearing with Jquery
            } else {
                if (input.files && input.files[0]) {
                    var filerdr = new FileReader();
                    filerdr.onload = function(e) {
                        $('#logo-img').attr('src', e.target.result);
                    }
                    filerdr.readAsDataURL(input.files[0]);
                }
            }
        }
        // ==================================================================

        //For printing without opening the page =======================
        function closePrint() {
            document.body.removeChild(this.__container__);
        }

        function setPrint() {
            this.contentWindow.__container__ = this;
            this.contentWindow.onbeforeunload = closePrint;
            this.contentWindow.onafterprint = closePrint;
            this.contentWindow.focus(); // Required for IE
            this.contentWindow.print();
        }

        function printPage(sURL) {
            var oHiddFrame = document.createElement("iframe");
            oHiddFrame.onload = setPrint;
            oHiddFrame.style.visibility = "hidden";
            oHiddFrame.style.position = "fixed";
            oHiddFrame.style.right = "0";
            oHiddFrame.style.bottom = "0";
            oHiddFrame.src = sURL;
            document.body.appendChild(oHiddFrame);
        }

        function refreshPage() {
            window.location.href = 'barangay-add.php';
        }
    </script>

    <script src="./assets/js/sidebar.js"></script>
    <script src="./assets/js/header.js"></script>
    <script src="./assets/js/barangay-validation.js"></script>

    <?php
    if (isset($_POST['submit'])) {
        echo "
        <script>
        $(document).ready(function() {
            $('#staticBackdrop').modal('show');
        });
    </script>";
    } ?>
</body>

</html>