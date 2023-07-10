function showInput1() {
  const input = document.getElementById("c_resident");
  if (document.getElementById("res_type").value === "resident") {
    input.style.display = "block";
  } else {
    input.style.display = "none";
  }

  const residentType = document.getElementById("res_type").value;
  const selectField = document.getElementById("gender");
  const bdate = document.getElementById("bdate");
  const inputFields = document.querySelectorAll(
    "#c_input input, #c_input select"
  );

  if (residentType === "resident") {
    inputFields.forEach(function (field) {
      // field.readOnly = true;
      field.style.pointerEvents = "none";
      field.style.color = "gray"; // Set the text color to gray
    });
    selectField.style.pointerEvents = "none";
    bdate.style.pointerEvents = "none";
  } else {
    inputFields.forEach(function (field) {
      // field.readOnly = false;
      field.style.color = ""; // Reset the text color
    });
    selectField.style.pointerEvents = "auto";
    bdate.style.pointerEvents = "auto";
  }
}

function showInput2() {
  const input = document.getElementById("o_resident");
  if (document.getElementById("res_type2").value === "resident") {
    input.style.display = "block";
  } else {
    input.style.display = "none";
  }

  const residentType = document.getElementById("res_type2").value;
  const selectField = document.getElementById("o_gender");
  const bdate = document.getElementById("o_bdate");
  const inputFields = document.querySelectorAll(
    "#o_input input, #o_input select"
  );

  if (residentType === "resident") {
    inputFields.forEach(function (field) {
      // field.readOnly = true;
      field.style.pointerEvents = "none";
      field.style.color = "gray"; // Set the text color to gray
    });
    selectField.style.pointerEvents = "none";
    bdate.style.pointerEvents = "none";
  } else {
    inputFields.forEach(function (field) {
      // field.readOnly = false;
      field.style.color = ""; // Reset the text color
    });
    selectField.style.pointerEvents = "auto";
    bdate.style.pointerEvents = "auto";
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const resTypeElement1 = document.getElementById("res_type");
  const resTypeElement2 = document.getElementById("res_type2");

  // Call the showInput1() and showInput2() functions initially
  showInput1();
  showInput2();

  // Add event listeners to detect changes in the res_type elements
  resTypeElement1.addEventListener("change", showInput1);
  resTypeElement2.addEventListener("change", showInput2);
});
