function showInput() {
  var input = document.getElementById("otherInput");
  var othersRadio = document.getElementById("i_others");

  if (othersRadio.checked) {
    input.style.display = "block";
    input.removeAttribute("disabled");
  } else {
    input.style.display = "none";
    input.setAttribute("disabled", "");
  }
}
