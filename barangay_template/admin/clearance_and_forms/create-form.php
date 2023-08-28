<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/forms.css">
    <!-- <script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script> -->
    <script src="../../../ckeditor/ckeditor.js"></script>

    <title>Admin Panel</title>

    <style>
        .full-width-image {
            max-width: 100%;
            height: auto;
        }

        .cke_editable img {
            max-width: 100%;
            height: auto;
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
        <div class="wrapper">
            <!-- Alert if adding of officials is successful -->
            <?php if (isset($_GET['create']) and $_GET['create'] == 'success') : ?>
                <div id="alert-3" class="flex p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <span class="sr-only">Info</span>
                    <div class="text-center w-full">
                        <span class="font-medium">Form Successfully Created!</span>
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>

            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header" style="margin: 0 !important;">
                <h3 class="page-title ml-3 mb-4">Clearance and Forms</h3>

                <!-- page tabs -->
                <div class="border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center dark:text-gray-400">
                        <li class="mr-2">
                            <a href="index.php" class="inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Form Transactions
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="clearance-transactions.php" class="inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Form Transactions History
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="#" class="cursor-pointer inline-flex p-4 bg-white rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group">
                                Create Form
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="form-list.php" class="inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                List of Forms
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <?php include_once 'form-template.php' ?>
                <form action="includes/create-form.inc.php" method="POST" id="create-form">
                    <textarea name="form-content" id="form-content" rows="100" class="w-full" required></textarea>
                    <div class="mt-3">
                        <label for="form-name" class="text-base">Name of the form</label>
                        <input type="text" name="form-name" id="form-name" required placeholder="What do you want to name the form?" class="tracking-wider w-full block rounded ">
                        <div id="form-name-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <button type="submit" name="create-form" class="tracking-wider w-full mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Create Form</button>
                </form>
            </div>
        </div>

    </main>

    <script>
        var PLACEHOLDERS = [{
                id: 1,
                name: 'fullname',
                title: 'Full Name',
                description: 'Full Name of the resident'
            },
            {
                id: 2,
                name: 'firstname',
                title: 'First Name',
                description: 'First Name of the resident'
            },
            {
                id: 3,
                name: 'middlename',
                title: 'Middle Name',
                description: 'Middle Name of the resident'
            },
            {
                id: 4,
                name: 'lastname',
                title: 'Last Name',
                description: 'Last Name of the resident'
            },
            {
                id: 27,
                name: 'purpose',
                title: 'Purpose',
                description: "The resident's purpose for getting this form. Entered in the 'purpose' field"
            },
            {
                id: 5,
                name: 'suffix',
                title: 'Suffix',
                description: 'Suffix of the resident'
            },
            {
                id: 6,
                name: 'sex',
                title: 'Sex',
                description: 'Sex of the resident'
            },
            {
                id: 7,
                name: 'birthdate',
                title: 'Birthdate',
                description: 'Birthdate of the resident'
            },
            {
                id: 8,
                name: 'age',
                title: 'Age',
                description: 'Age of the resident'
            },
            {
                id: 9,
                name: 'civil status',
                title: 'Civil Status',
                description: 'Civil Status of the resident'
            },
            {
                id: 10,
                name: 'contact number',
                title: 'Contact Number',
                description: 'Contact Number of the resident'
            },
            {
                id: 11,
                name: 'contact type',
                title: 'Contact Type',
                description: 'Contact Type of the resident'
            },
            {
                id: 12,
                name: 'height',
                title: 'Height',
                description: 'Height of the resident'
            },
            {
                id: 13,
                name: 'weight',
                title: 'Weight',
                description: 'Weight of the resident'
            },
            {
                id: 15,
                name: 'citizenship',
                title: 'Citizenship',
                description: 'Citizenship of the resident'
            },
            {
                id: 15,
                name: 'religion',
                title: 'Religion',
                description: 'Religion of the resident'
            },
            {
                id: 16,
                name: 'occupation status',
                title: 'Occupation Status',
                description: 'Occupation Status of the resident'
            },
            {
                id: 17,
                name: 'occupation',
                title: 'Occupation',
                description: 'Occupation of the resident'
            },
            {
                id: 18,
                name: 'address',
                title: 'Address',
                description: 'Address of the resident'
            },
            {
                id: 19,
                name: 'date recorded',
                title: 'Date Recorded',
                description: 'Date when the resident is registered to the system.'
            },
            {
                id: 20,
                name: 'barangay',
                title: 'Barangay',
                description: 'Name of Current Barangay'
            },
            {
                id: 21,
                name: 'barangay address',
                title: 'Barangay Address',
                description: 'Address of the Current Barangay'
            },
            {
                id: 22,
                name: 'barangay captain',
                title: 'Barangay Captain',
                description: 'Barangay Captain/Chairman of the Barangay'
            },
            {
                id: 23,
                name: 'date',
                title: 'Form Release Date',
                description: 'The date of the releasing of the form. Refers to the date when the form is provided to a resident. (ex: January 01, 2023)'
            },
            {
                id: 24,
                name: 'year',
                title: 'Form Release Year',
                description: 'The year of the releasing of the form. Refers to the year when the form is provided to a resident'
            },
            {
                id: 25,
                name: 'day',
                title: 'Form Release Day',
                description: 'The day of the releasing of the form. Refers to the day when the form is provided to a resident'
            },
            {
                id: 26,
                name: 'month',
                title: 'Form Release Month',
                description: 'The month of the releasing of the form. Refers to the month when the form is provided to a resident'
            },


        ];

        CKEDITOR.addCss('span > .cke_placeholder { background-color: #ffeec2; }');

        CKEDITOR.replace('form-content', {
            height: 600,
            on: {
                instanceReady: function(evt) {
                    var itemTemplate = '<li data-id="{id}">' +
                        '<div><strong class="item-title">{title}</strong></div>' +
                        '<div><i>{description}</i></div>' +
                        '</li>',
                        outputTemplate = '[[{title}]]<span>&nbsp;</span>';

                    var autocomplete = new CKEDITOR.plugins.autocomplete(evt.editor, {
                        textTestCallback: textTestCallback,
                        dataCallback: dataCallback,
                        itemTemplate: itemTemplate,
                        outputTemplate: outputTemplate
                    });

                    // Override default getHtmlToInsert to enable rich content output.
                    autocomplete.getHtmlToInsert = function(item) {
                        return this.outputTemplate.output(item);
                    }
                }
            },
            removeButtons: 'PasteFromWord'
        });

        function textTestCallback(range) {
            if (!range.collapsed) {
                return null;
            }

            return CKEDITOR.plugins.textMatch.match(range, matchCallback);
        }

        function matchCallback(text, offset) {
            var pattern = /\[{2}([A-z]|\])*$/,
                match = text.slice(0, offset)
                .match(pattern);

            if (!match) {
                return null;
            }

            return {
                start: match.index,
                end: offset
            };
        }

        function dataCallback(matchInfo, callback) {
            var data = PLACEHOLDERS.filter(function(item) {
                var itemName = '[[' + item.name + ']]';
                return itemName.indexOf(matchInfo.query.toLowerCase()) == 0;
            });

            callback(data);
        }
    </script>
    <script>
        // const editor = CKEDITOR.replace('form-content', {
        //     height: 600
        // });

        const initialContent = editor.getData();
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const createFormForm = document.getElementById('create-form');
            const formNameInput = document.getElementById("form-name");
            const formNameError = document.getElementById("form-name-error");
            const forbiddenFormNames = ["Barangay Business Clearance", "Barangay Clearance", "Certificate of Good Moral Character", "Certificate of Indigency", "Certificate of Residency"];

            formNameInput.addEventListener("input", function() {
                const formName = formNameInput.value.trim();
                const lowerCaseFormName = formName.toLowerCase();
                const barangayId = <?php echo $barangayId ?>;
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "includes/check_form_name.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        const formNameExists = response.count > 0 || forbiddenFormNames.some(name => name === formName || name.toLowerCase() === lowerCaseFormName);
                        formNameError.textContent = formNameExists ? "Form name already exists for this barangay." : "";
                    }
                };

                xhr.send(`check_form_name=1&form_name=${encodeURIComponent(formName)}&barangay_id=${encodeURIComponent(barangayId)}`);
            });

            createFormForm.addEventListener("submit", function(event) {
                // Get the current date of the ckeditor
                const currentContent = editor.getData();

                // Prevent submission if form name already exists or is case-insensitive match
                if (formNameError.textContent.trim() !== "") {
                    event.preventDefault();
                    alert('Please provide a different form name.');
                }
                // Prevent form submission if no changes made to the ckeditor.
                else if (currentContent === initialContent) {
                    event.preventDefault();
                    alert("Please make changes to the content before submitting.");
                }
            });
        });
    </script>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>


</body>

</html>