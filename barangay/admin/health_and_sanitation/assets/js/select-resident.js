const residentRows = document.querySelectorAll(".resident-row");
const residentNameInput = document.querySelector("#resident_name");
const residentIdInput = document.querySelector("#resident_id");

residentRows.forEach((row) => {
  row.addEventListener("click", () => {
    const residentId = row.getAttribute("id");
    const resident_name = document.querySelector(
      `#${CSS.escape(residentId)} td:nth-child(2)`
    ).textContent;
    residentNameInput.value = resident_name;
    residentIdInput.value = residentId;
  });
});
