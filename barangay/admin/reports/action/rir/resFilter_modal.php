<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['column'])) {
        $columns = $_POST['column'];
        $date_filters = $_POST['date-filter'];
        $_SESSION['filters'] = $columns;
        $_SESSION['date_filters'] = $date_filters;
    }

    // Redirect to another page after processing the form
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}


// Determine selected checkboxes from session or default values
if (isset($_SESSION['filters'])) {
    $columns = $_SESSION['filters'];
    $date_filters = $_SESSION['date_filters'];

    // var_dump($date_filters);
    // exit;
} else {
    $columns = array(
        'lastname', 'firstname', 'middlename', 'suffix',
        'birthdate', 'civil_status', 'sex', 'religion',
        'citizenship', 'occupation', 'occupation_status', 'date_recorded'
    );
}
?>

<form action="" method="post">

    <!-- Small Modal -->
    <div id="filter-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        Filter
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="filter-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div id="column_name" class="p-4 space-y-4">
                    <div class="button-container">
                        <button id=checkButton>Select all</button>
                        <button id=uncheckButton style="margin-left: auto;">Clear all</button>
                    </div>
                    <div class="flex items-center">
                        <input name="column[]" <?php echo (!in_array('lastname', $columns)) ? '' : 'checked'; ?> id="checked-checkbox" type="checkbox" value="lastname" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Last Name</label>
                    </div>
                    <div class="flex items-center">
                        <input name="column[]" <?php echo (!in_array('firstname', $columns)) ? '' : 'checked'; ?> id="checked-checkbox" type="checkbox" value="firstname" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">First Name</label>
                    </div>
                    <div class="flex items-center">
                        <input name="column[]" <?php echo (!in_array('middlename', $columns)) ? '' : 'checked'; ?> id="checked-checkbox" type="checkbox" value="middlename" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Middle Name</label>
                    </div>
                    <div class="flex items-center">
                        <input name="column[]" <?php echo (!in_array('suffix', $columns)) ? '' : 'checked'; ?> id="checked-checkbox" type="checkbox" value="suffix" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Suffix</label>
                    </div>
                    <div class="flex items-center">
                        <input name="column[]" <?php echo (!in_array('birthdate', $columns)) ? '' : 'checked'; ?> id="checked-checkbox" type="checkbox" value="birthdate" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Birthdate</label>
                    </div>
                    <div class="flex items-center">
                        <input name="column[]" <?php echo (!in_array('civil_status', $columns)) ? '' : 'checked'; ?> id="checked-checkbox" type="checkbox" value="civil_status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Marital</label>
                    </div>
                    <div class="flex items-center">
                        <input name="column[]" <?php echo (!in_array('sex', $columns)) ? '' : 'checked'; ?> id="checked-checkbox" type="checkbox" value="sex" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Sex</label>
                    </div>
                    <div class="flex items-center">
                        <input name="column[]" <?php echo (!in_array('religion', $columns)) ? '' : 'checked'; ?> id="checked-checkbox" type="checkbox" value="religion" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Religion</label>
                    </div>
                    <div class="flex items-center">
                        <input name="column[]" <?php echo (!in_array('citizenship', $columns)) ? '' : 'checked'; ?> id="checked-checkbox" type="checkbox" value="citizenship" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Nationality</label>
                    </div>
                    <div class="flex items-center">
                        <input name="column[]" <?php echo (!in_array('occupation', $columns)) ? '' : 'checked'; ?> id="checked-checkbox" type="checkbox" value="occupation" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Occupation</label>
                    </div>
                    <div class="flex items-center">
                        <input name="column[]" <?php echo (!in_array('occupation_status', $columns)) ? '' : 'checked'; ?> id="checked-checkbox" type="checkbox" value="occupation_status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Status</label>
                    </div>
                    <div class="flex items-center">
                        <input name="column[]" id="date_r" <?php echo (!in_array('date_recorded', $columns)) ? '' : 'checked'; ?> id="checked-checkbox" type="checkbox" value="date_recorded" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Date Record</label>
                    </div>

                    <div id="date-custom">
                        <div class="mt-4">
                            <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter by Resident's Added Year (optional):</label>

                            <div date-rangepicker class="flex items-center">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="date-filter[]" type="text" value="<?php echo !empty($date_filters) ? $date_filters[0] : null; ?>" autocomplete="off" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date start">
                                </div>
                                <span class="mx-4 text-gray-500">to</span>
                                <div class="relative grow">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="date-filter[]" type="text" value="<?php echo !empty($date_filters) ? $date_filters[1] : null; ?>" autocomplete="off" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date end">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button id="saveButton" type="submit" name="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
                    <button data-modal-hide="filter-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    // date record filter
    const dateRangeRadio = document.getElementById('date_r');
    const datePickerContainer = document.getElementById('date-custom');

    dateRangeRadio.addEventListener('change', function() {
        if (dateRangeRadio.checked) {
            datePickerContainer.style.display = 'block';
        } else {
            datePickerContainer.style.display = 'none';
        }
    });

    // Check the initial state and set the date picker container accordingly
    if (dateRangeRadio.checked) {
        datePickerContainer.style.display = 'block';
    } else {
        datePickerContainer.style.display = 'none';
    }

    document.getElementById("checkButton").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent form submission
        var checkboxes = document.querySelectorAll("input[type='checkbox']");
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = true;
        });
    });

    document.getElementById("uncheckButton").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent form submission
        var checkboxes = document.querySelectorAll("input[type='checkbox']");
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
    });
    var alertShown = false;

    // Add event listener to form submission
    document.getElementById("saveButton").addEventListener("click", function(event) {
        if (!alertShown) {
            var checkboxes = document.querySelectorAll("input[type='checkbox']");
            var isAnyCheckboxChecked = false;

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    isAnyCheckboxChecked = true;
                }
            });

            if (!isAnyCheckboxChecked) {
                event.preventDefault(); // Prevent form submission
                alert("Please select at least one checkbox.");
                alertShown = true;
            }
        }
    });
</script>