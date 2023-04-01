<!DOCTYPE html>
<html>

<head>
    <title>Image Upload with Cropper</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-fS4QJ9ehyszt8YAFRzFrIDf4WA+3C2Lg+wXGUIFnjGMdz9ACqbRkxIaUYf0BRKOTCfLY25SB4IuP3ed/+G0t1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js" integrity="sha512-eHx4nbBTkIr2i0m9SANm/cczPESd0DUEcfl84JpIuutE6oDxPhXvskMR08Wmvmfx5wUpVjlWdi82G5YLvqqJdA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <!-- Modal for image cropper -->
    <div class="modal fade" id="imageCropperModal" tabindex="-1" role="dialog" aria-labelledby="imageCropperModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageCropperModalLabel">Crop Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <img id="imageCropper" src="" alt="image to crop">
                        </div>
                        <div class="col-md-4">
                            <div id="preview" style="width: 200px; height: 200px;"></div>
                            <br>
                            <button class="btn btn-primary" id="cropImageBtn">Crop Image</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Button to trigger the modal -->
    <button class="btn btn-primary" id="openCropperModalBtn">Select Image to Crop</button>

    <!-- Preview the cropped image -->
    <img id="previewCroppedImage" src="" alt="cropped image">

    <script>
        // Initialize the cropper
        var cropper;

        function initCropper(inputFile) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imageCropper').attr('src', e.target.result);
                cropper = new Cropper(document.getElementById('imageCropper'), {
                    aspectRatio: 1 / 1,
                    viewMode: 1
                });
            }
            reader.readAsDataURL(inputFile.files[0]);
        }

        // Open the modal when the 'Select Image to Crop' button is clicked
        $('#openCropperModalBtn').on('click', function() {
            $('#imageCropperModal').modal('show');
        });

        // Crop the image when the 'Crop Image' button is clicked
        $('#cropImageBtn').on('click', function() {
            var croppedCanvas = cropper.getCroppedCanvas();
            // Preview the cropped image
            $('#previewCroppedImage').attr('src', croppedCanvas.toDataURL());
            // Hide the modal
            $('#imageCropperModal').modal('hide');
        });

        // Reset the cropper and the image preview when the modal is closed
        $('#imageCropperModal').on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
            $('#imageCropper').attr('src', '');
            $('#previewCroppedImage').attr('src', '');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>

</html>