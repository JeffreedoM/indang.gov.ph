
  const form = document.getElementById("myForm");
  const inputs = form.querySelectorAll("input");

  inputs.forEach(input => {
    input.setAttribute("required", "");
  });
