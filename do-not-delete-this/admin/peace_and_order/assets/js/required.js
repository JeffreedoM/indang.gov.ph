
const form = document.getElementById("myForm");
const inputs = form.querySelectorAll("input");
const select = form.querySelectorAll("select");

inputs.forEach(input => {
  input.setAttribute("required", "");
});

select.forEach(selectElement => {
  selectElement.setAttribute("required", "");
});

