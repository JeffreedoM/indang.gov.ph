                   <?php
                    // // Update the complainant data
                    // if ($complainant_type === 'resident') {
                    //     $stmt = $pdo->prepare("UPDATE incident_complainant SET complainant_type = :complainant_type, resident_id = :resident_id WHERE incident_id = :incident_id");
                    //     $stmt->bindParam(':complainant_type', $complainant_type);
                    //     $stmt->bindParam(':resident_id', $complainant_id);
                    //     $stmt->bindParam(':incident_id', $incident_id);
                    // } else {
                    //     $stmt = $pdo->prepare("UPDATE non_resident SET non_res_firstname = :non_res_firstname, non_res_lastname = :non_res_lastname, non_res_gender = :non_res_gender, non_res_birthdate = :non_res_birthdate, non_res_contact = :non_res_contact, non_res_address = :non_res_address, barangay_id = :b_id WHERE incident_id = :incident_id");
                    //     $stmt->bindParam(':non_res_firstname', $complainant_fname);
                    //     $stmt->bindParam(':non_res_lastname', $complainant_lname);
                    //     $stmt->bindParam(':non_res_gender', $complainant_gender);
                    //     $stmt->bindParam(':non_res_birthdate', $complainant_bdate);
                    //     $stmt->bindParam(':non_res_contact', $complainant_number);
                    //     $stmt->bindParam(':non_res_address', $complainant_address);
                    //     $stmt->bindParam(':b_id', $barangayId);
                    //     $stmt->bindParam(':incident_id', $incident_id);
                    // }
                    // // Execute the update query
                    // $pdo->beginTransaction();
                    // $stmt->execute();
                    // $pdo->commit();

                    // // Update the offender data
                    // if ($offender_type === 'resident') {
                    //     $stmt = $pdo->prepare("UPDATE incident_offender SET offender_type = :offender_type, resident_id = :resident_id, `desc` = :desc WHERE incident_id = :incident_id");
                    //     $stmt->bindParam(':offender_type', $offender_type);
                    //     $stmt->bindParam(':resident_id', $offender_id);
                    //     $stmt->bindParam(':desc', $description);
                    //     $stmt->bindParam(':incident_id', $incident_id);
                    // } else {
                    //     $stmt = $pdo->prepare("UPDATE non_resident SET non_res_firstname = :non_res_firstname, non_res_lastname = :non_res_lastname, non_res_gender = :non_res_gender, non_res_contact = :non_res_contact, non_res_birthdate = :non_res_birthdate, non_res_address = :non_res_address, barangay_id = :b_id WHERE incident_id = :incident_id");
                    //     $stmt->bindParam(':non_res_firstname', $offender_fname);
                    //     $stmt->bindParam(':non_res_lastname', $offender_lname);
                    //     $stmt->bindParam(':non_res_gender', $offender_gender);
                    //     $stmt->bindParam(':non_res_contact', $offender_number);
                    //     $stmt->bindParam(':non_res_birthdate', $offender_bdate);
                    //     $stmt->bindParam(':non_res_address', $offender_address);
                    //     $stmt->bindParam(':b_id', $barangayId);
                    //     $stmt->bindParam(':incident_id', $incident_id);
                    // }

                    // // Execute the update query
                    // $pdo->beginTransaction();
                    // $stmt->execute();
                    // $pdo->commit();
                    ?>


                   <!-- Complainant -->
                   <h3>Reporting Person/Complainant</h3>

                   <div class="mb-1">
                       <select name="blotter_type" class="bg-green-50 border border-green-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                           <option value="" selected disabled>Select Blotter Type</option>
                           <option value="1" <?php if ($list['blotterType_id'] == 1) {
                                                    echo "selected";
                                                } ?>>Complaint</option>
                           <option value="2" <?php if ($list['blotterType_id'] == 2) {
                                                    echo "selected";
                                                } ?>>Incident</option>
                       </select>
                   </div>
                   <div class="mb-4">
                       <select onchange="showInput1()" id="res_type" name="c_res" class="bg-red-50 border border-red-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                           <option value="" selected disabled>Select Resident Type</option>
                           <option value="resident" <?php if ($list1['complainant_type'] == 'resident') {
                                                        echo 'selected';
                                                    } ?>>Resident</option>
                           <option value="not resident" <?php if ($list1['complainant_type'] == 'not resident') {
                                                            echo 'selected';
                                                        } ?>>Non-Resident</option>
                       </select>
                   </div>
                   <div id="c_input">
                       <?php include '../includes/resident_comp.php'; ?>


                       <!-- Name -->
                       <div class="grid md:grid-cols-2 md:gap-6">
                           <div class="relative z-0 w-full mb-6 group">
                               <input type="hidden" name="complainant_id" class="complainant_id">
                               <input type="text" name="c_fname" value="<?php echo $c_fname; ?>" id="complainant_fname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                               <label for="" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                           </div>
                           <div class="relative z-0 w-full mb-6 group">
                               <input type="text" name="c_lname" value="<?php echo $c_lname; ?>" id="complainant_lname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                               <label for="" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
                           </div>
                       </div>

                       <!-- Number -->
                       <div class="relative z-0 w-full mb-6 group">
                           <input type="tel" value="<?php echo $c_number; ?>" name="c_number" id="contact" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                           <label for="" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone number</label>
                       </div>

                       <!-- Gender -->
                       <div class="mb-3">
                           <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                           <select id="gender" name="c_gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                               <option value="" disabled selected>Gender</option>
                               <option value="Male" <?php if ($c_gender == 'Male') {
                                                        echo 'selected';
                                                    } ?>>Male</option>
                               <option value="Female" <?php if ($c_gender == 'Female') {
                                                            echo 'selected';
                                                        } ?>>Female</option>
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
                               <input type="date" value="<?php echo $c_bdate; ?>" name="c_bdate" id="bdate" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                           </div>
                       </div>

                       <!--Address -->
                       <div class="relative z-0 w-full mb-6 group">
                           <input type="text" name="c_address" value="<?php echo $c_bdate; ?>" id="address" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                           <label for="floating_address" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                               Address</label>
                       </div>
                   </div>
                   <br><br>

                   <!-- OFFENDER INPUTS-->
                   <h3>Offender Person</h3>
                   <!--horizontal line -->
                   <hr>
                   <div class="mb-3" style="margin-top: 10px;">
                       <select onchange="showInput2()" id="res_type2" name="o_res" class="bg-red-50 border border-red-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                           <option value="" selected disabled>Select Resident Type</option>
                           <option value="resident" <?php if ($list2['offender_type'] == 'resident') {
                                                        echo 'selected';
                                                    } ?>>Resident</option>
                           <option value="not resident" <?php if ($list2['offender_type'] == 'not resident') {
                                                            echo 'selected';
                                                        } ?>>Non-Resident</option>
                       </select>
                   </div>
                   <div id="o_input" style="margin-top: 10px;">
                       <?php include '../includes/resident_off.php'; ?>

                       <!-- Name -->
                       <input type="hidden" name="offender_id" class="offender_id">
                       <div class="grid md:grid-cols-2 md:gap-6">
                           <div class="relative z-0 w-full mb-6 group">

                               <input type="text" name="o_fname" id="o_fname" value="<?php echo $o_fname; ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                               <label for="" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                           </div>
                           <div class="relative z-0 w-full mb-6 group">
                               <input type="text" name="o_lname" id="o_lname" value="<?php echo $o_lname; ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                               <label for="" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
                           </div>
                       </div>

                       <!-- Number -->
                       <div class="relative z-0 w-full mb-6 group">
                           <input type="tel" value="<?php echo $o_number; ?>" name="o_number" id="o_contact" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                           <label for="" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone number</label>
                       </div>

                       <!-- Gender -->
                       <div class="mb-3">
                           <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                           <select id="o_gender" name="o_gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                               <option value="" disabled selected>Gender</option>
                               <option value="Male" <?php if ($o_gender == 'Male') {
                                                        echo 'selected';
                                                    } ?>>Male</option>
                               <option value="Female" <?php if ($o_gender == 'Female') {
                                                            echo 'selected';
                                                        } ?>>Female</option>
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
                               <input type="date" name="o_bdate" id="o_bdate" value="<?php echo $o_bdate; ?>" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                           </div>
                       </div>

                       <!--Address -->
                       <div class="relative z-0 w-full mb-6 group">
                           <input type="text" name="o_address" id="o_address" value="<?php echo $o_address; ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                           <label for="floating_address" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                               Address</label>
                       </div>

                       <!-- Description -->
                       <div>
                           <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                           <textarea name="desc" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter narrative..."><?php echo $desc; ?></textarea>
                       </div>
                   </div>