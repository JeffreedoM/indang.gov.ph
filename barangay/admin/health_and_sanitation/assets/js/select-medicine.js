const medicineRows = document.querySelectorAll(".medicine-row");
const medicineNameInput = document.querySelector("#medicine_name");
const medicineIdInput = document.querySelector("#medicine_id");
const medicineQtyInput = document.querySelector("#medicine_quantity");

medicineRows.forEach((row) => {
  row.addEventListener("click", () => {
    const medicineId = row.getAttribute("id");
    const medicine_name = document.querySelector(
      `#${CSS.escape(medicineId)} td:nth-child(2)`
    ).textContent;
    const medicine_stock = document.querySelector(
      `#${CSS.escape(medicineId)} td:nth-child(3)`
    ).textContent;

    row.style.pointerEvents = "none";
    medicineNameInput.value = medicine_name;
    medicineIdInput.value = medicineId;
    medicineQtyInput.max = medicine_stock;

    // Check if the medicine_name input has a value
    const hasValue = medicineNameInput.value.trim() !== "";

    // Enable or disable the medicine_quantity input based on the value of medicine_name
    medicineQtyInput.disabled = !hasValue;
    if (hasValue) {
      medicineQtyInput.placeholder = `Enter quantity 0 - ${medicine_stock}`;
    }
  });
});

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
