<?php
if(isset($_POST['submit'])){
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
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Add Records</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
    

<!-- Complainant -->
            <h3>Reporting person/Complainant</h3>
            <div>
            <div>
                <select name="comp_type">
                    <option value="1">Complaint</option>
                    <option value="2">Incident</option>
                </select>
            </div>
            <div>
                <select name="resident_type">
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
        <div>
            <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                <select name="c_gender" id="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Your Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                </select>
        </div>

        <!--Birthdate -->
        <div>
            <label for="">Birthdate <span class="required-input">*</span></label>
            <div>
            <input type="date" name="c_bday" id="res_bdate" placeholder="Birthdate" onblur="getAge()" required>
            </div>
        </div>
        <!--Address -->
        <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="c_address" id="floating_address" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_address" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    Address</label>
        </div>


<!-- offender -->

        <div>
            <h3>Offender</h3>
                <select name="o_res">
                    <option value="resident">Resident</option>
                    <option value="not resident">Non-Resident</option>
                </select>
            </div>

        <!-- Name -->
        <tr>
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
                <div>
            <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                <select name="o_gender" id="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Your Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                </select>
        </div>

        <!--Birthdate -->
        <div>
            <label for="">Birthdate <span class="required-input">*</span></label>
            <div>
            <input type="date" name="o_bday" id="res_bdate" placeholder="Birthdate" onblur="getAge()" required>
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
        <textarea name="desc" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a comment..."></textarea>
        </div>
    <!-- criminal case -->
    <div>
    <input type="radio" id="c1" name="i_case" value="criminal">
                <label for="c1">Criminal</label>
    <input type="radio" id="c2" name="i_case" value="civil">
                <label for="c2">Civil</label>
    <input type="radio" id="c0" name="i_case" value="others">
                <label for="c0">Others</label>
    </div>
    <!-- incident title -->
    <div>
    <label>Incident Title</label>        
    <input type="text" name="i_title" required>
    </div>
    <!-- date -->
    <div>
        <label>Date of Incident</label>
        <input type="date" name="i_date" required>
    </div>
    <!-- time -->
    <div>
    <label>Time of Incident</label>
     <input type="time" name="i_time" required>
    </div>
    <!-- location -->
    <div>
    <label>Location of incident</label>
    <input type="text" name="i_location" required>
    </div>
    <!-- Narrative -->
    <div>
        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Narrative</label>
        <textarea name="narrative" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a comment..."></textarea>
    </div>
    

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button name="submit">Save changes</button>
      </div>
    </div>
  </div>
</div>