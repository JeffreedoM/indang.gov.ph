/*-------------------------------------------------------------------*/
/* Pop=up for adding resident in resident profiling */

let popup = document.querySelector(".popup");
let modalBg = document.querySelector(".modal-bg");

function openPopup() {
  popup.classList.add("open-popup");
  modalBg.classList.add("modal-bg-active");
  let modalContentHeight =
    document.getElementById("modal-container").clientHeight;
  document.getElementsByClassName("modal-bg")[0].style.minHeight =
    modalContentHeight + 100 + "px";
}
function closePopup() {
  popup.classList.remove("open-popup");
  modalBg.classList.remove("modal-bg-active");
  modalBg.style.minHeight = "0";
}

/*-------------------------------------------------------------------*/
/* Getting age based on the birthdate */

function getAge() {
  let dob = document.getElementById("res_bdate").value;
  dob = new Date(dob);
  let today = new Date();
  let age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
  document.getElementById("res_age").value = age;
}

/*-------------------------------------------------------------------*/
/* Maxlength of the Contact Number based on the Contact type selected */
// JavaScript
function maxLengthFunction() {
  let contactType = document.getElementById("res_contacttype");
  let contactTypeOption = contactType.options[contactType.selectedIndex].text;
  let contactNumberInput = document.getElementById("res_contactnum");

  if (contactTypeOption == "Mobile") {
    contactNumberInput.maxLength = "15"; // Considering dashes (e.g., "0965-388-9584")
    contactNumberInput.readOnly = false;
  } else if (contactTypeOption == "Tel.") {
    contactNumberInput.maxLength = "8"; // Considering dashes (e.g., "123-4567")
    contactNumberInput.readOnly = false;
  } else if (contactTypeOption == "N/A") {
    contactNumberInput.maxLength = "0";
    contactNumberInput.readOnly = true;
    contactNumberInput.value = "";
  }

  formatContactNumber(); // Format the contact number to allow dashes but not count them in the maxlength
}

function formatContactNumber() {
  let contactNumberInput = document.getElementById("res_contactnum");
  let contactNumber = contactNumberInput.value.replace(/[^0-9]/g, ""); // Remove existing dashes

  let contactType = document.getElementById("res_contacttype");
  let contactTypeOption = contactType.options[contactType.selectedIndex].text;

  if (contactTypeOption == "Mobile") {
    if (contactNumber.length > 11) {
      // Trim the input to a maximum of 11 digits (not counting dashes)
      contactNumber = contactNumber.substring(0, 11);
    }

    if (contactNumber.length > 7) {
      // Insert dashes for formatting
      contactNumber =
        contactNumber.slice(0, 4) +
        "-" +
        contactNumber.slice(4, 7) +
        "-" +
        contactNumber.slice(7);
    } else if (contactNumber.length > 4) {
      contactNumber = contactNumber.slice(0, 4) + "-" + contactNumber.slice(4);
    }
  } else if (contactTypeOption == "Tel.") {
    if (contactNumber.length > 7) {
      // Trim the input to a maximum of 7 digits (not counting dashes)
      contactNumber = contactNumber.substring(0, 7);
    }

    if (contactNumber.length > 3) {
      // Insert dashes for formatting
      contactNumber = contactNumber.slice(0, 3) + "-" + contactNumber.slice(3);
    }
  }

  contactNumberInput.value = contactNumber;
}

/* Occupation */
function occupationFunction() {
  let occupationStatus = document.getElementById("res_occupation-status");
  let occupationStatusOption =
    occupationStatus.options[occupationStatus.selectedIndex].text;
  let occupation = document.getElementById("res_occupation");
  occupation.value = "";

  if (occupationStatusOption == "Unemployed") {
    occupation.readOnly = true;
    occupation.value = "Unemployed";
  } else if (occupationStatusOption == "N/A") {
    occupation.readOnly = true;
    occupation.value = "N/A";
  } else {
    occupation.readOnly = false;
  }
}

/* Image Validation */
function validateImage() {
  var fileInput = document.getElementById("image");
  var filePath = fileInput.value;
  var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
  if (!allowedExtensions.exec(filePath)) {
    alert("Invalid file type. Only JPG, JPEG, PNG and GIF files are allowed.");
    fileInput.value = "";
    return false;
  } else {
    // Image preview code (optional)
    if (fileInput.files && fileInput.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        document.getElementById("imagePreview").innerHTML =
          '<img src="' + e.target.result + '" width="200" height="200"/>';
      };
      reader.readAsDataURL(fileInput.files[0]);
    }
  }
}
