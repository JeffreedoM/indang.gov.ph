const form = document.getElementById("myForm");
const inputs = form.querySelectorAll("input");
const select = form.querySelectorAll("select");

inputs.forEach((input) => {
  input.setAttribute("required", "");
});

select.forEach((selectElement) => {
  selectElement.setAttribute("required", "");
});

// Add your additional code here
inputs.forEach((input) => {
  input.addEventListener("input", function () {
    if (input.value === "") {
      input.setCustomValidity("This field is required");
    } else {
      input.setCustomValidity("");
    }
  });
});

select.forEach((selectElement) => {
  selectElement.addEventListener("input", function () {
    if (selectElement.value === "") {
      selectElement.setCustomValidity("This field is required");
    } else {
      selectElement.setCustomValidity("");
    }
  });
});
