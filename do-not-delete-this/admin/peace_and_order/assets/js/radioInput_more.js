function showInput() {
  var input = document.getElementById("otherInput");
  var othersRadio = document.getElementById("i_others");

  if (othersRadio.checked) {
    input.style.display = "block";
    input.getElementsByTagName("input")[0].setAttribute("name", "case_more");
  } else {
    input.style.display = "none";
    input.getElementsByTagName("input")[0].setAttribute("name", "");
    input.getElementsByTagName("input")[0].value = "none";
  }
}
