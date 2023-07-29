const medicineRows = document.querySelectorAll(".medicine-row");
const medicineNameInput = document.querySelector("#medicine_name");

medicineRows.forEach((row) => {
  row.addEventListener("click", () => {
    const medicineId = row.getAttribute("id");
    const medicine_name = document.querySelector(
      `#${CSS.escape(medicineId)} td:nth-child(2)`
    ).textContent;
    medicineNameInput.value = medicine_name;
  });
});
