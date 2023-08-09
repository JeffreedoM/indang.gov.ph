const rows = document.querySelectorAll("tr");
const residentNameInput = document.querySelector("#resident_name");
const residentIdInput = document.querySelector("#resident_id");
const residentAgeInput = document.querySelector("#resident_age");

rows.forEach((row) => {
  row.addEventListener("click", () => {
    // get the id of the clicked resident
    const residentId = row.getAttribute("id");
    // putting the id in the hidden input
    residentIdInput.value = residentId;

    // getting the right resident name of the clicked resident
    const resident_name = document.querySelector(
      `#${CSS.escape(residentId)} td:nth-child(2)`
    ).textContent;
    const resident_age = document.querySelector(
      `#${CSS.escape(residentId)} td:nth-child(3)`
    ).textContent;
    // putting the resident name in the input name
    residentNameInput.value = resident_name;
    residentAgeInput.value = resident_age;
    //close the popup
    closePopup();
  });
});
