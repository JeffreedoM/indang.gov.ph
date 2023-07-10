
/*-------------------------------------------------------------------*/
/* Pop=up for adding resident in resident profiling */

let popup = document.querySelector('.popup')
let modalBg = document.querySelector('.modal-bg')

function openPopup() {
    popup.classList.add('open-popup')
    modalBg.classList.add('modal-bg-active')
    let modalContentHeight = document.getElementById('modal-container').clientHeight;
    document.getElementsByClassName('modal-bg')[0].style.minHeight = modalContentHeight + 100 + 'px';
}
function closePopup() {
    popup.classList.remove('open-popup')
    modalBg.classList.remove('modal-bg-active')
    modalBg.style.minHeight = '0';
}

/*-------------------------------------------------------------------*/
/* Getting age based on the birthdate */

function getAge() {
    let dob = document.getElementById('res_bdate').value;
    dob = new Date(dob);
    let today = new Date();
    let age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
    document.getElementById('res_age').value = age;
}


/*-------------------------------------------------------------------*/
/* Maxlength of the Contact Number based on the Contact type selected */
function maxLengthFunction() {
    let contactType = document.getElementById("res_contacttype");
    let contactTypeOption = contactType.options[contactType.selectedIndex].text
    document.getElementById("res_contactnum").value = '';

    if (contactTypeOption == "Mobile") {
        document.getElementById("res_contactnum").maxLength = "11";
        document.getElementById("res_contactnum").readOnly = false;
    }
    else if (contactTypeOption == "Tel.") {
        document.getElementById("res_contactnum").maxLength = "7";
        document.getElementById("res_contactnum").readOnly = false;
    }
    else if (contactTypeOption == "N/A")
        document.getElementById("res_contactnum").readOnly = true;

}

/* Number only on contact number */
function numbersOnly(input) {
    let regex = /[^0-9]/gi;
    input.value = input.value.replace(regex, "");
}

/* Occupation */
function occupationFunction() {
    let occupationStatus = document.getElementById("res_occupation-status")
    let occupationStatusOption = occupationStatus.options[occupationStatus.selectedIndex].text
    let occupation = document.getElementById("res_occupation")
    occupation.value = '';

    console.log(occupationStatus)
    console.log(occupation.value)
    if (occupationStatusOption == "Unemployed") {
        occupation.readOnly = true;
        occupation.value = "Unemployed";
    }
    else {
        occupation.readOnly = false;
    }

}


/* Image Validation */
function validateImage() {
    var fileInput = document.getElementById('image');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if (!allowedExtensions.exec(filePath)) {
        alert('Invalid file type. Only JPG, JPEG, PNG and GIF files are allowed.');
        fileInput.value = '';
        return false;
    } else {
        // Image preview code (optional)
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('imagePreview').innerHTML = '<img src="' + e.target.result + '" width="200" height="200"/>';
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}





