const form = document.getElementById("myForm");
const inputs = form.querySelectorAll(
  "input:not([disabled]), select:not([disabled])"
);
const othersRadio = document.getElementById("i_others");
const caseMoreInput = document.querySelector("input[name='case_more']");

inputs.forEach((input) => {
  if (input.name !== "case_more") {
    input.setAttribute("required", "");
  }
});

othersRadio.addEventListener("click", function () {
  if (othersRadio.checked) {
    caseMoreInput.removeAttribute("disabled");
    caseMoreInput.setAttribute("required", "");
  } else {
    caseMoreInput.setAttribute("disabled", "");
    caseMoreInput.setAttribute("required", "");
  }
});

// Add your additional code here
inputs.forEach((input) => {
  input.addEventListener("input", function () {
    if (input.name !== "case_more" && !input.disabled) {
      if (input.value === "") {
        input.setCustomValidity("This field is required");
      } else {
        input.setCustomValidity("");
      }
    }
  });
});
