window.onload = function () {
  showInput();
};

// const select = document.getElementById("select_type");
// const complainant = document.getElementById("complainant");
// const offender = document.getElementById("offender");

// select.addEventListener("change", function () {
//   if (select.value === "complainant") {
//     complainant.style.display = "block";
//     offender.style.display = "none";
//   } else {
//     complainant.style.display = "none";
//     offender.style.display = "block";
//   }
// });

function showInput() {
  const select = document.getElementById("select_type");
  const form1 = document.getElementById("complainant");
  const form2 = document.getElementById("offender");

  if (document.getElementById("select_type").value == "complainant") {
    form1.style.display = "block";
    form2.style.display = "none";
  }
  if (document.getElementById("select_type").value == "offender") {
    form1.style.display = "none";
    form2.style.display = "block";
  }
}
