<?php
include '../../includes/dbh.inc.php';
include '../../includes/session.inc.php';
include '../../includes/deactivated.inc.php';
include_once 'includes/function.php';
include './includes/addblotter_isset.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/datepicker.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/main.css" />

    <!-- Specific module styling -->
    <link rel="stylesheet" href="./assets/css/styles.css">

    <!-- <link rel="stylesheet" href="../../assets/css/bs-overwrite.css" /> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="icon" type="image/x-icon" href="../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <title>Admin Panel | Peace and Order</title>
    <style>
        hr {
            border: none;
            border-top: 5px solid #ccc;
        }

        .hidden-cell {
            display: none;
        }
    </style>
</head>

<body>
    <?php
    include '../../partials/nav_sidebar.php';
    ?>

    <main class="main-content">
        <?php
        include '../../partials/nav_header.php';
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

                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <a href="list_incident.php"> Back</a></button>
                <br>
                <h1 style="text-align:center; font-size: 20px;"><b>New Incident</b></h1>
                <br>
                <!-- INPUT FORMS IN ADD INCIDENT -->
                <!-- Modal -->
                <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <form id="myForm" action="" method="POST">
                            <div>
                                <div>


                                    <!-- Complainant -->
                                    <h3>Reporting Person/Complainant</h3>

                                    <div class="mb-1">
                                        <select name="blotter_type" class="bg-green-50 border border-green-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="" selected disabled>Select Blotter Type</option>
                                            <option value="1">Complaint</option>
                                            <option value="2">Incident</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <select onchange="showInput1()" id="res_type" name="c_res" class="bg-red-50 border border-red-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="" selected disabled>Select Resident Type</option>
                                            <option value="resident">Resident</option>
                                            <option value="not resident">Non-Resident</option>
                                        </select>
                                    </div>
                                    <?php include 'includes/resident_comp.php'; ?>
                                    <div id="c_input">

                                        <!--Modal for selectiung complainant  -->
                                        <div id="c_resident" style="display:none;">
                                            <button data-modal-target="complainantModal" data-modal-toggle="complainantModal" class="block mb-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                                Select Resident
                                            </button>
                                        </div>

                                        <!-- Name -->
                                        <div class="grid md:grid-cols-2 md:gap-6">
                                            <div class="relative z-0 w-full mb-6 group">
                                                <input type="hidden" name="complainant_id" class="complainant_id">
                                                <input type="text" name="c_fname" id="complainant_fname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                                <label for="complainant_fname" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                                            </div>
                                            <div class="relative z-0 w-full mb-6 group">
                                                <input type="text" name="c_lname" id="complainant_lname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                                <label for="complainant_lname" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
                                            </div>
                                        </div>

                                        <!-- Number -->
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="c_number" id="contact" oninput="NumberInput(this)" maxlength="11" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                            <label for="contact" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone number</label>
                                        </div>

                                        <!-- Gender -->
                                        <div class="mb-3">
                                            <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sex</label>
                                            <select id="gender" name="c_gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                <option value="" disabled selected>--Select--</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>

                                        <!--Birthdate -->
                                        <div class="mb-5">
                                            <label for="bdate">Birthdate <span class="required-input">*</span></label>
                                            <div class="relative w-1/2 sm:w-full">
                                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <input type="date" name="c_bdate" id="bdate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date" required>
                                            </div>
                                        </div>

                                        <!--Address -->
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="c_address" id="address" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <label for="address" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                                Address</label>
                                        </div>
                                    </div>
                                    <br><br>



                                    <!-- OFFENDER INPUTS-->
                                    <h3>Offender Person</h3>
                                    <!--horizontal line -->
                                    <hr>
                                    <div class="mb-3" style="margin-top: 10px;">
                                        <select onchange="showInput2()" id="res_type2" name="o_res" class="bg-red-50 border border-red-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="" selected disabled>Select Resident Type</option>
                                            <option value="resident">Resident</option>
                                            <option value="not resident">Non-Resident</option>
                                        </select>
                                    </div>
                                    <?php include 'includes/resident_off.php'; ?>
                                    <div id="o_input" style="margin-top: 10px;">
                                        <!--Modal for selectiung offender  -->
                                        <div id="o_resident" style="display:none;">
                                            <button data-modal-target="offenderModal" data-modal-toggle="offenderModal" class="block mb-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                                Select Resident
                                            </button>
                                        </div>
                                        <!-- Name -->
                                        <div class="grid md:grid-cols-2 md:gap-6">
                                            <div class="relative z-0 w-full mb-6 group">
                                                <input type="hidden" name="offender_id" class="offender_id">
                                                <input type="text" name="o_fname" id="o_fname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                                <label for="o_fname" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                                            </div>
                                            <div class="relative z-0 w-full mb-6 group">
                                                <input type="text" name="o_lname" id="o_lname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                                <label for="o_lname" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
                                            </div>
                                        </div>

                                        <!-- Number -->
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="o_number" id="o_contact" oninput="NumberInput(this)" maxlength="11" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                            <label for="o_contact" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone number</label>
                                        </div>

                                        <!-- Gender -->
                                        <div class="mb-3">
                                            <label for="o_gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sex</label>
                                            <select name="o_gender" id="o_gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                <option value="" disabled selected>--Select--</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>

                                        <!--Birthdate -->
                                        <div class="mb-5">
                                            <label for="o_bdate">Birthdate <span class="required-input">*</span></label>
                                            <div class="relative w-1/2 sm:w-full">
                                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <input type="date" name="o_bdate" id="o_bdate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date" required />
                                            </div>
                                        </div>


                                        <!--Address -->
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="o_address" id="o_address" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                            <label for="o_address" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                                Address</label>
                                        </div>
                                    </div>
                                    <!-- Description -->
                                    <div>
                                        <label for="desc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                        <textarea name="desc" id="desc" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter description..." required></textarea>
                                    </div>
                                </div>


                                <!-- INCIDENT DETAILS -->
                                <!-- criminal case -->
                                <br>
                                <br>
                                <br>
                                <h3>Incident Details</h3>
                                <hr>

                                <div id="radio" class="flex" style="margin-top: 10px;">
                                    <div class="flex items-center mr-4">
                                        <input onclick="showInput()" id="criminalRadio" type="radio" value="criminal" name="i_case" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" required>
                                        <label for="criminalRadio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Criminal</label>
                                    </div>
                                    <div class="flex items-center mr-4">
                                        <input onclick="showInput()" id="civilRadio" type="radio" value="civil" name="i_case" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="civilRadio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Civil</label>
                                    </div>
                                    <div class="flex items-center mr-4">
                                        <input onclick="showInput()" type="radio" id="i_others" name="i_case" value="more" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="i_others" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Others</label>
                                    </div>
                                    <div id="otherInput" style="display:none;">
                                        <input type="text" name="case_more" class="block w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" placeholder="other case...">
                                    </div>
                                </div>


                                <!-- incident title -->
                                <div class="my-3">
                                    <label>Incident Title</label>
                                    <input type="text" name="i_title" required class="block w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" required>
                                </div>

                                <!-- date -->
                                <div class="mb-3">
                                    <label>Date of Incident</label>
                                    <input type="date" name="i_date" id="date" required class="block w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" required>
                                </div>

                                <!-- time -->
                                <div class="mb-3">
                                    <label>Time of Incident</label>
                                    <input type="time" name="i_time" required class="block w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" required>
                                </div>

                                <!-- location -->
                                <div class="mb-3">
                                    <label>Location of incident</label>
                                    <input type="text" name="i_location" required class="block w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" required>
                                </div>
                                <!-- Narrative -->
                                <div>
                                    <label for="narr" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Narrative</label>
                                    <textarea name="narrative[]" id="narr" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter narrative..." required></textarea>
                                </div>
                            </div>

                            <div class="modal-footer" class="mt-2">
                                <button name="submit" type="submit" class="w-full mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Save Changes</button>
                            </div>
                        </form>
                    </div>


                </div>

            </div>
        </div>

        </div>
    </main>


    <script>
        // Initialize CKEditor for the textarea with the unique ID
        CKEDITOR.replace('narr');
        CKEDITOR.on("dialogDefinition", function(ev) {
            // Check if the dialog being defined is the "image" dialog
            if (ev.data.name === "image") {
                var dialogDefinition = ev.data.definition;

                // Find the width and height inputs in the dialog
                var widthInput = dialogDefinition.getContents("info").get("txtWidth");
                var heightInput = dialogDefinition.getContents("info").get("txtHeight");

                // Change the labels of the width and height inputs
                widthInput.label = "Width (px)";
                heightInput.label = "Height (px)";
            }
        });
    </script>
    <script src="../../assets/js/sidebar.js"></script>
    <script src="./assets/js/add-incident.js"></script>
    <script src="./assets/js/remote_modals.js"></script>
    <!-- <script src="./assets/js/required.js"></script> -->
    <script src="./assets/js/radioInput_more.js"></script>
    <script src="./assets/js/select-resident.js"></script>
    <script src="./assets/js/disabled_input.js"></script>
    <script src="./assets/js/numberOnly.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        /* set max date to current date */
        document.getElementById("bdate").max = new Date().toISOString().split("T")[0];
        /* set max date to current date */
        document.getElementById("o_bdate").max = new Date().toISOString().split("T")[0];
        /* set max date to current date */
        document.getElementById("date").max = new Date().toISOString().split("T")[0];

        $(document).ready(function() {
            $('#residents-table').DataTable({
                "dom": 'frtip',
            });
        });
        $(document).ready(function() {
            $('#o_residents-table').DataTable({
                "dom": 'frtip',
            });
        });
        //Selecting resident
        // function validateForm() {
        //     const input = document.getElementById("resident_name").value;
        //     if (input == "") {
        //         alert("Select resident");
        //         return false;
        //     }
        // }
    </script>


</body>