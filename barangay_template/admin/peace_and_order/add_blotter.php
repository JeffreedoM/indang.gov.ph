<?php
if (isset($_POST['submit'])) {
    //
    $incident_id;
    $resident_id;
    $resident_type = $_POST['resident_type'];
    $comp_type = $_POST['comp_type'];

    //insert to incident_reporting_person db
    $complainant_name = $_POST['c_name'];
    $complainant_gender = $_POST['c_gender'];
    $complainant_number = $_POST['c_number'];
    $complainant_address = $_POST['c_address'];

    //insert to incident_offender db
    $offender_name = $_POST['o_name'];
    $offender_gender = $_POST['o_gender'];
    $offender_number = $_POST['o_number'];
    $offender_address = $_POST['o_address'];
    $description = $_POST['desc'];

    //insert to incident_table db
    $case_incident = $_POST['i_case'];
    $i_title = $_POST['i_title'];
    $i_date = $_POST['i_date'];
    $i_time = $_POST['i_time'];
    $location = $_POST['i_location'];
    $narrative = $_POST['narrative'];





    // $complainant_type = $_POST['complainant_type'];

    // if ($resident_type == 'non-resident') {
    //     // INSERT INTO non-resident table

    //     // Insert ng data sa complainant table
    //     // complainant_id, complainant_reference_id, complainant_type, name, gender, phone_number, address
    //     // ang value ng complainant_type ay yung $resident_type
    // } else {

    //     // Insert ng data sa complainant table
    //     // complainant_id, complainant_reference_id, complainant_type, name, gender, phone_number, address
    // }



    // Prepare the first query
    $stmt1 = $pdo->prepare("INSERT INTO incident_offender1(offender_name, offender_gender, offender_address, description) VALUES(:offender_name,:offender_gender,:offender_address,:description)");
    $stmt1->bindParam(':offender_name', $offender_name);
    $stmt1->bindParam(':offender_gender', $offender_gender);
    $stmt1->bindParam(':offender_address', $offender_address);
    $stmt1->bindParam(':description', $description);

    // Execute the first query and get the inserted ID
    $pdo->beginTransaction();
    $stmt1->execute();
    $offender_id = $pdo->lastInsertId();
    $pdo->commit();

    // Prepare the second query
    $stmt2 = $pdo->prepare("INSERT INTO incident_reporting_person(name, gender, phone_number, address) VALUES(:complainant_name,:complainant_gender,:complainant_number,:complainant_address)");
    $stmt2->bindParam(':complainant_name', $complainant_name);
    $stmt2->bindParam(':complainant_gender', $complainant_gender);
    $stmt2->bindParam(':complainant_number', $complainant_number);
    $stmt2->bindParam(':complainant_address', $complainant_address);

    // Execute the second query and get the inserted ID
    $pdo->beginTransaction();
    $stmt2->execute();
    $person_id = $pdo->lastInsertId();
    $pdo->commit();

    // Prepare the third query
    $stmt3 = $pdo->prepare("INSERT INTO incident_table(case_incident, incident_title, date_incident, time_incident, location, narrative, offender_id, person_id,complainantType_id) VALUES(:case_incident,:i_title,:i_date,:i_time,:location,:narrative,:offender_id,:person_id,:comp_type)");
    $stmt3->bindParam(':case_incident', $case_incident);
    $stmt3->bindParam(':i_title', $i_title);
    $stmt3->bindParam(':i_date', $i_date);
    $stmt3->bindParam(':i_time', $i_time);
    $stmt3->bindParam(':location', $location);
    $stmt3->bindParam(':narrative', $narrative);
    $stmt3->bindParam(':offender_id', $offender_id);
    $stmt3->bindParam(':person_id', $person_id);
    $stmt3->bindParam(':comp_type', $comp_type);

    // Execute the third query
    $pdo->beginTransaction();
    if ($stmt3->execute()) {
        echo "Data inserted successfully";
    } else {
        echo "Error inserting data: " . $pdo->errorInfo()[2];
    }
    $pdo->commit();

    // $sql = mysqli_query($con,"INSERT INTO incident_offender1(offender_name, offender_gender, offender_address, description)
    // VALUES('$offender_name','$offender_gender', '$offender_address', '$description')");
    // $offender_id = mysqli_insert_id($con);

    // $sql2 =mysqli_query($con,"INSERT INTO incident_reporting_person(name, gender, phone_number, address)
    // VALUES('$complainant_name','$complainant_gender', '$complainant_number', '$complainant_address')");

    // $person_id = mysqli_insert_id($con);

    // if ($sql && $sql2) {
    //     // Get the last inserted ID


    //     echo $person_id." ".$offender_id;

    //     // Insert data into the second table, using the last inserted ID as a foreign key


    //     $sql1 = "INSERT INTO incident_table(case_incident, incident_title, date_incident, time_incident, location, narrative, offender_id, person_id,complainantType_id)
    //     VALUES('$case_incident', '$i_title', '$i_date','$i_time','$location','$narrative','$offender_id','$person_id', '$comp_type')";

    //     if (mysqli_query($con, $sql1)) {

    //         echo "Data inserted successfully";
    //     } else {

    //         echo "Error inserting data: " . mysqli_error($con);
    //     }
    //     // header("location: index.php");
    // }else{
    //     die(mysqli_error($con));
    // }

}
?>

<!-- Modal -->
<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-body">
            </div>

            <form action="" method="POST">

                <!-- Complainant -->
                <h3>Reporting Person/Complainant</h3>
                <div>
                    <div class="mb-1">
                        <select name="comp_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="1">Complaint</option>
                            <option value="2">Incident</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="resident_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="resident">Resident</option>
                            <option value="not resident">Non-Resident</option>
                        </select>
                    </div>

                    <!-- Name -->
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="c_name" id="floating_first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="floating_last_name" id="floating_last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
                        </div>
                    </div>

                    <!-- Number -->
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="tel" pattern="[0-9]{4}[0-9]{3}[0-9]{4}" name="c_number" id="floating_phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone number</label>
                    </div>

                    <!-- Gender -->
                    <div class="mb-3">
                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                        <select name="c_gender" id="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" disabled selected>Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <!--Birthdate -->
                    <div class="mb-5">
                        <label for="">Birthdate <span class="required-input">*</span></label>
                        <div class="relative w-1/2 sm:w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input datepicker type="text" name="c_bday" id="res_bdate" onblur="getAge()" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                        </div>
                    </div>



                    <!--Address -->
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="c_address" id="floating_address" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="floating_address" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Address</label>
                    </div>

                    <!-- offender -->
                    <div class="mb-3">
                        <h3>Offender</h3>
                        <select name="o_res" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" disabled selected>Offender</option>
                            <option value="resident">Resident</option>
                            <option value="not resident">Non-Resident</option>
                        </select>
                    </div>

                    <!-- Name -->
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="o_name" id="floating_first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="floating_last_name" id="floating_last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
                        </div>
                    </div>

                    <!-- Number -->
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="tel" pattern="[0-9]{4}[0-9]{3}[0-9]{4}" name="o_number" id="floating_phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone number</label>
                    </div>

                    <!-- Gender -->
                    <div class="mb-3">
                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                        <select name="o_gender" id="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" disabled selected>Offender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <!--Birthdate -->
                    <div class="mb-5">
                        <label for="">Birthdate <span class="required-input">*</span></label>
                        <div class="relative w-1/2 sm:w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input datepicker type="text" name="o_bday" id="res_bdate" onblur="getAge()" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                        </div>
                    </div>

                    <!--Address -->
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="o_address" id="floating_address" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="floating_address" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Address</label>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea name="desc" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter narrative..."></textarea>
                    </div>

                    <!-- criminal case -->
                    <div class="flex">
                        <div class="flex items-center mr-4">
                            <input id="inline-radio" type="radio" value="criminal" name="i_case" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="inline-radio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Criminal</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="inline-2-radio" type="radio" value="civil" name="i_case" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="inline-2-radio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Civil</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input checked id="inline-checked-radio" type="radio" value="others" name="i_case" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="inline-checked-radio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Others</label>
                        </div>
                    </div>

                    <!-- incident title -->
                    <div class="my-3">
                        <label>Incident Title</label>
                        <input type="text" name="i_title" required class="block w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    </div>

                    <!-- date -->
                    <div class="mb-3">
                        <label>Date of Incident</label>
                        <input type="date" name="i_date" required class="block w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    </div>

                    <!-- time -->
                    <div class="mb-3">
                        <label>Time of Incident</label>
                        <input type="time" name="i_time" required class="block w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    </div>

                    <!-- location -->
                    <div class="mb-3">
                        <label>Location of incident</label>
                        <input type="text" name="i_location" required class="block w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    </div>
                    <!-- Narrative -->
                    <div>
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Narrative</label>
                        <textarea name="narrative" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a comment..."></textarea>
                    </div>
                </div>

                <div class="modal-footer" class="mt-2">
                    <button name="submit" type="submit" class="w-full mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Save Changes</button>
                </div>
            </form>
        </div>

    </div>
</div>