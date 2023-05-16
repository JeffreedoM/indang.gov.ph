<?php

$id = $_GET['update_id'];

$sql = "
SELECT * FROM incident_table WHERE id=$id
";
$query = $pdo->prepare($sql);
$list = $query->fetchAll(PDO::FETCH_ASSOC);

$list1 = getIncidentComplainant($pdo, $id);
$list2 = getIncidentOffender($pdo, $id);


if ($sql) {
    $c_id = $list['person_id'];
    $o_id = $list1['offender_id'];

    //insert to incident_reporting_person db
    $complainant_name = $list1['firstname'];
    $complainant_gender = $list1['gender'];
    $complainant_number = $list1['phone_number'];
    $complainant_address = $list1['address'];

    //insert to incident_offender db
    $offender_gender = $list['offender_gender'];
    $offender_name = $list['offender_name'];
    $offender_address = $list['offender_address'];
    $description = $list['description'];

    //insert to incident_table db
    $case_incident = $list['case_incident'];
    $i_title = $list['incident_title'];
    $i_date = $list['date_incident'];
    $i_time = $list['time_incident'];
    $location = $list['location'];
    $narrative = $list['narrative'];
}


if (isset($_POST['submit'])) {

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

    //update incident_table
    $sql = "UPDATE incident_table SET case_incident = :case_incident, incident_title = :i_title, date_incident = :i_date, 
    time_incident = :i_time, location = :location, narrative = :narrative WHERE incident_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':case_incident', $case_incident, PDO::PARAM_STR);
    $stmt->bindParam(':i_title', $i_title, PDO::PARAM_STR);
    $stmt->bindParam(':i_date', $i_date, PDO::PARAM_STR);
    $stmt->bindParam(':i_time', $i_time, PDO::PARAM_STR);
    $stmt->bindParam(':location', $location, PDO::PARAM_STR);
    $stmt->bindParam(':narrative', $narrative, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();





    if ($stmt) {
        // Get the last inserted ID
        $incident_id = $pdo->lastInsertId();

        echo $incident_id;

        // Update data in the second table, using the last inserted ID as a foreign key
        $sql1 = "UPDATE incident_offender1 SET offender_name=:offender_name, offender_gender=:offender_gender, 
            offender_address=:offender_address, description=:description WHERE offender_id=:o_id";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->bindParam(':offender_name', $offender_name, PDO::PARAM_STR);
        $stmt1->bindParam(':offender_gender', $offender_gender, PDO::PARAM_STR);
        $stmt1->bindParam(':offender_address', $offender_address, PDO::PARAM_STR);
        $stmt1->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt1->bindParam(':o_id', $o_id, PDO::PARAM_INT);
        $stmt1->execute();

        $sql2 = "UPDATE incident_reporting_person SET name=:complainant_name, gender=:complainant_gender,
            phone_number=:complainant_number, address=:complainant_address WHERE person_id=:p_id";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(':complainant_name', $complainant_name, PDO::PARAM_STR);
        $stmt2->bindParam(':complainant_gender', $complainant_gender, PDO::PARAM_STR);
        $stmt2->bindParam(':complainant_number', $complainant_number, PDO::PARAM_STR);
        $stmt2->bindParam(':complainant_address', $complainant_address, PDO::PARAM_STR);
        $stmt2->bindParam(':p_id', $p_id, PDO::PARAM_INT);
        $stmt2->execute();

        if ($stmt1 && $stmt2) {
            echo "Data updated successfully";
        } else {
            echo "Error updating data: " . $pdo->errorInfo()[2];
        }
    } else {
        die("Error executing query: " . $pdo->errorInfo()[2]);
    }
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
                        <select name="blotter_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="1">Complaint</option>
                            <option value="2">Incident</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="c_res" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="resident">Resident</option>
                            <option value="not resident">Non-Resident</option>
                        </select>
                    </div>

                    <!-- Name -->
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="c_fname" value="" id="floating_first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="c_lname" id="floating_last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
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
                            <input datepicker type="text" name="c_bdate" id="res_bdate" onblur="getAge()" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
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
                            <input type="text" name="o_fname" id="floating_first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="o_lname" id="floating_last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
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
                            <input datepicker type="text" name="o_bdate" id="res_bdate" onblur="getAge()" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
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