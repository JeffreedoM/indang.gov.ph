<!-- Large Modal -->

<form method="POST">

    <!-- Default Modal -->
    <div id="medium-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        Complaint Report
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="medium-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <div class="p-1 space-y-2">
                        <label for="blotter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Blotter:</label>
                        <select name="blotter" id="blotter" onchange="fetchResident()" required class="bg-green-50 border border-green-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" selected disabled>ID | Blotter Title</option>
                            <?php
                            foreach ($rows as $row) {
                                $id = $row['incident_id'];
                                $incident_title = $row['incident_title'];
                            ?>
                                <option value="<?php echo $id ?>"><?php echo "$id | $incident_title";  ?></option>

                            <?php }

                            ?>
                        </select>
                        <div id="residentInfo"></div>
                    </div>
                    <hr>
                    <button class="show" type="button">Click to fill up</button>
                    <div class="fillup" style="display:none">
                        <table width="100%">
                            <tr>
                                <td>
                                    <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date submitted:</label>
                                    <input datepicker type="text" name="date_s" id="date_s" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-3/4 pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </td>
                                <td>
                                    <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date accepted:</label>
                                    <input datepicker type="text" name="date_a" id="date_a" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-3/4 pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <!-- <input type="date" name="date_a" id="date_accepted"> -->
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <br>
                                        <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usaping BarangayBlg.</label>
                                        <input type="text" id="" name="blg" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
                                    </div>
                                    <div>
                                        <br>
                                        <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Para sa:</label>
                                        <input type="text" id="" name="para_sa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <!-- content -->
                        <div>
                            <br>
                            <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Content:</label>
                            <hr>
                            <br>
                            <h1 style="text-align: center; font-weight:bold">REKLAMO</h1>


                            <br>
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                <span class="pr-4"></span>AKO / KAMI AY NAGREREKLAMO LABAN SA MGA TAONG PINANGALANAN SA
                                ITAAS DAHIL SA PAGLABAG SA AKING/AMING KARAPATAN AT INTERES SA MGA SUMUSUNOD;
                            </p>
                            <div style="margin-top: 1rem; margin-bottom:1rem">
                                <textarea name="content" id="" rows="10" maxlength="1200" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter complaint..."></textarea>
                            </div>
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                DAHIL DITO, AKO/KAMI AY NAKIKIUSAP NA ANG MGA SUMUSUNOD NA LUNAS
                                AY IPAGKALOOB SA AKIN/AMIN NANG NAAYON SA BATAS AT / SA KATARUNGAN.
                            </p>
                        </div>
                    </div>

                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button name="submit" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
                    <button data-modal-hide="medium-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    const showButton = document.querySelector('.show');
    const fillupDiv = document.querySelector('.fillup');

    showButton.addEventListener('click', () => {
        if (fillupDiv.style.display === 'none' || fillupDiv.style.display === '') {
            fillupDiv.style.display = 'block'; // Show the 'fillup' div
        } else {
            fillupDiv.style.display = 'none'; // Hide the 'fillup' div
        }
    });
</script>