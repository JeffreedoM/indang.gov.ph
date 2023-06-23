<div id="o_resident" style="display:none;">
    <!--Modal for selectiung offender  -->
    <button data-modal-target="offenderModal" data-modal-toggle="offenderModal" class="block mb-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
        Select Resident
    </button>

    <!-- Modal for List of Residents -->
    <div id="offenderModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        List of Residents
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="offenderModal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <!--offender Modal body -->
                <div class="p-6 space-y-6">

                    <table id="o_residents-table" class="row-border hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>FirstName</th>
                                <th>LastName</th>
                                <th class="hidden-cell">Phone Number</th>
                                <th class="hidden-cell">Gender</th>
                                <th class="hidden-cell">Birthdate</th>
                                <th class="hidden-cell">Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($o_residents as $resident) { ?>
                                <tr id="<?php echo $resident['resident_id']; ?>" style="cursor:pointer" data-modal-hide="offenderModal">
                                    <td><?php echo $resident['resident_id']; ?></td>
                                    <td><?php echo $resident['firstname']; ?></td>
                                    <td><?php echo $resident['lastname']; ?></td>
                                    <td class="hidden-cell"><?php echo $resident['contact']; ?></td>
                                    <td class="hidden-cell"><?php echo $resident['sex']; ?></td>
                                    <td class="hidden-cell"><?php echo $resident['birthdate']; ?></td>
                                    <td class="hidden-cell"><?php echo $resident['address']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>