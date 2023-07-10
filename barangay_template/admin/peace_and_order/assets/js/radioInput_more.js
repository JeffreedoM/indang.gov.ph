function showInput() {
  var input = document.getElementById("otherInput");
  var othersRadio = document.getElementById("i_others");
  var inputField = input.getElementsByTagName("input")[0];

  if (othersRadio.checked) {
    input.style.display = "block";
    inputField.setAttribute("name", "case_more");
    inputField.setAttribute("required", ""); // Add the "required" attribute
  } else {
    input.style.display = "none";
    inputField.setAttribute("name", "");
    inputField.removeAttribute("required"); // Remove the "required" attribute
  }
}
