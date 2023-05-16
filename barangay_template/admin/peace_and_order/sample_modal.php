<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet">
    <title>Modal</title>


</head>

<body>
    <!-- Trigger button -->
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Open Modal
    </button>

    <!-- Modal -->
    <div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center hidden">
        <!-- Overlay -->
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

        <!-- Modal body -->
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <!-- Modal header -->
            <div class="modal-header py-3 px-4">
                <h2 class="text-lg font-semibold text-gray-700">Modal Title</h2>
                <button class="modal-close ml-auto bg-transparent text-gray-700 hover:text-gray-900" onclick="closeModal()">
                    <svg class="fill-current w-6 h-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.348 5.652a.999.999 0 0 0-1.414 0L10 8.586 7.066 5.652a.999.999 0 1 0-1.414 1.414L8.586 10l-2.934 2.934a.999.999 0 1 0 1.414 1.414L10 11.414l2.934 2.934a.999.999 0 1 0 1.414-1.414L11.414 10l2.934-2.934a.999.999 0 0 0 0-1.414z" />
                    </svg>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body py-4 px-4">
                <p class="text-gray-700">Modal content goes here.</p>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer py-3 px-4">
                <button class="modal-close bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        const openModal = () => {
            const modal = document.querySelector('.modal');
            modal.classList.remove('hidden');
        }

        const closeModal = () => {
            const modal = document.querySelector('.modal');
            modal.classList.add('hidden');
        }

        const trigger = document.querySelector('.trigger');
        trigger.addEventListener('click', openModal);
    </script>

</body>

</html>