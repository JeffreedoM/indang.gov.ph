<?php
include '../../includes/dbh.inc.php';
include '../../includes/session.inc.php';
include '../../includes/deactivated.inc.php';

if(isset($_POST['submit'])){
$resident_type = $_POST['resident_type'];
$comp_type = $_POST['comp_type'];

//insert to incident_reporting_person db
$name = $_POST['name'];
$gender = $_POST['gender'];
$number = $_POST['number'];
$address = $_POST['address'];
$desc = $_POST['desc'];

// Prepare the first query
if($comp_type==2){
$stmt1 = $pdo->prepare("INSERT INTO incident_offender1(offender_name, offender_gender, offender_address,description) VALUES(:name,:gender,:address,:desc)");
$stmt1->bindParam(':offender_name', $name);
$stmt1->bindParam(':offender_gender', $gender);
$stmt1->bindParam(':offender_address', $address);
$stmt1->bindParam(':description', $desc);
// Execute the first query and get the inserted ID
$pdo->beginTransaction();
if ($stmt1->execute()) {
    echo "Data inserted successfully";
    } else {
    echo "Error inserting data: " . $pdo->errorInfo()[2];
    }
    $pdo->commit();
}

// Prepare the second query
elseif($comp_type==1){
$stmt2 = $pdo->prepare("INSERT INTO incident_reporting_person(name, gender, phone_number, address) VALUES(:name,:gender,:number,:complainant_address)");
$stmt2->bindParam(':complainant_name', $complainant_name);
$stmt2->bindParam(':complainant_gender', $complainant_gender);
$stmt2->bindParam(':complainant_number', $complainant_number);
$stmt2->bindParam(':complainant_address', $complainant_address);

// Execute the second query and get the inserted ID
$pdo->beginTransaction();
if ($stmt2->execute()) {
    echo "Data inserted successfully";
    } else {
    echo "Error inserting data: " . $pdo->errorInfo()[2];
    }
    $pdo->commit();
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="POST">



<!-- Involve Person -->
            <select name="comp_type">
                <option value="1">Complainant</option>
                <option value="2">Offender</option>
            </select>
            <br>
<!-- Reporting person/Complainant -->
            <h3>Reporting person/Complainant</h3>
            <div>
                <select name="resident_type">
                    <option value="resident">Resident</option>
                    <option value="not resident">Non-Resident</option>
                </select>
            </div>

        <!-- Name -->
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="name" id="floating_first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="floating_last_name" id="floating_last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
            </div>
        </div>
        
        <!-- Number -->
        
        <div class="relative z-0 w-full mb-6 group">
                <input type="tel" pattern="[0-9]{4}[0-9]{3}[0-9]{4}" name="number" id="floating_phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone number</label>
        </div>

        <!-- Gender -->
        <div>
            <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                <select name="gender" id="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Your Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                </select>
        </div>

        <!--Birthdate -->
        <div>
            <label for="">Birthdate <span class="required-input">*</span></label>
            <div>
            <input type="date" name="bday" id="res_bdate" placeholder="Birthdate" onblur="getAge()" required>
            </div>
        </div>
        <!--Address -->
        <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="address" id="floating_address" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_address" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    Address</label>
        </div>
        <!-- Description -->
        <div>
        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
        <br>
        <textarea name="desc" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a comment..."></textarea>
        </div>
        <br>
        <button type="submit" name="submit">Submit</button>

</form>
</body>
</html>