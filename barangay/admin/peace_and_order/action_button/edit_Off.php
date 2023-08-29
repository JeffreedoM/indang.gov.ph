<!-- Reporting Offender person -->
<div id="offender" style="display: none;">
    <form method="POST" id="offender">
        <table*>
            <h3><strong>Offender</strong></h3>
            <br>
            <div class="mb-4">
                <select onchange="showInput2()" id="res_type2" name="offender_type" class="bg-red-50 border border-red-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="resident" <?php if ($result['offender_type'] == 'resident') {
                                                    echo 'selected';
                                                } ?>>Resident</option>
                    <option value="not resident" <?php if ($result['offender_type'] == 'not resident') {
                                                        echo 'selected';
                                                    } ?>>Non-Resident</option>
                </select>
            </div>
            <!-- list of resident offender -->
            <?php include '../includes/resident_off.php'; ?>
            <div id="o_input">
                <!--Modal for selectiung offender  -->
                <div id="o_resident" style="display:none; width:fit-content;">
                    <button data-modal-target="offenderModal" data-modal-toggle="offenderModal" class="block mb-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        Select Resident
                    </button>
                </div>
                <!-- Name -->
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="hidden" name="offender_id" class="offender_id">
                        <input type="text" name="fname" value="<?php echo $fname; ?>" id="o_fname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="o_fname" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="lname" value="<?php echo $lname; ?>" id="o_lname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="o_lname" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
                    </div>
                </div>

                <!-- Number -->

                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="number" value="<?php echo $number; ?>" id="o_contact" oninput="NumberInput(this)" maxlength="11" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="o_contact" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone number</label>
                </div>

                <!-- Gender -->
                <div>
                    <label for="o_gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sex</label>
                    <select name="gender" id="o_gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected disabled>--Select--</option>
                        <option value="Male" <?php if ($gender == "Male") {
                                                    echo "selected";
                                                } ?>>Male</option>
                        <option value="Female" <?php if ($gender == "Female") {
                                                    echo "selected";
                                                } ?>>Female</option>
                    </select>
                </div>

                <!--Birthdate -->
                <div style="margin-top: .5rem;">
                    <label for="o_bdate">Birthdate <span class="required-input">*</span></label>
                    <div>
                        <input type="date" name="bdate" id="o_bdate" value="<?php echo $bdate; ?>" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                    </div>
                </div>
                <!--Address -->
                <div style="margin-top: 1rem;" class="relative z-0 w-full mb-6 group">
                    <input type="text" name="address" value="<?php echo $address; ?>" id="o_address" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="o_address" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        Address</label>
                </div>

                <!-- Description -->
                <div>
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <textarea name="desc" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a comment..." required><?php echo $desc; ?></textarea>
                </div>
            </div>
            <br>
            <button type="submit" name="add_off" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit</button>
            </table>

    </form>
</div>