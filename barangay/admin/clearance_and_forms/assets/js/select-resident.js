const rows = document.querySelectorAll("tr");
const residentNameInput = document.querySelector("#resident_name");
const residentIdInput = document.querySelector("#resident_id");
const isOffenderInput = document.querySelector("#isOffender");

rows.forEach((row) => {
  row.addEventListener("click", () => {
    // get the id of the clicked resident
    const residentId = row.getAttribute("id");
    // putting the id in the hidden input
    residentIdInput.value = residentId;

    // getting the right resident name of the clicked resident
    const resident_name = document
      .querySelector(`#${CSS.escape(residentId)} td:nth-child(2)`)
      .textContent.trim();
    // putting the resident name in the input name
    residentNameInput.value = resident_name;

    const isOffender = document
      .querySelector(`#${CSS.escape(residentId)} td:nth-child(3)`)
      .textContent.trim();
    isOffenderInput.value = isOffender;

    //close the popup
    closePopup();

    // for debugging purpose only
    // console.log(residentId)
    // console.log(residentIdInput);
    // console.log(resident_name);
  });
});
