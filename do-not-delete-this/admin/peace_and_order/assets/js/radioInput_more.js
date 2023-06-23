function showInput() {
  var input = document.getElementById("otherInput");
  var othersRadio = document.getElementById("i_others");
  var inputField = input.getElementsByTagName("input")[0];

  if (othersRadio.checked) {
    input.style.display = "block";
    inputField.setAttribute("name", "case_more");
    inputField.value = ""; // Clear the input field when "other" is selected
  } else {
    input.style.display = "none";
    inputField.setAttribute("name", "");
    inputField.value = "none";
  }
}
