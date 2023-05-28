window.onload = function () {
  showInput1();
};

function showInput1() {
  const input = document.getElementById("c_resident");
  if (document.getElementById("res_type").value == "resident") {
    input.style.display = "block";
  } else {
    input.style.display = "none";
  }

  const residentType = document.getElementById("res_type").value;
  const selectField = document.getElementById("gender");
  const bdate = document.getElementById("bdate");
  const inputFields = document.querySelectorAll("#c_input input");

  if (residentType === "resident") {
    inputFields.forEach(function (input) {
      input.readOnly = true;
    });
    selectField.style.pointerEvents = "none";
    bdate.style.pointerEvents = "none";
  } else {
    inputFields.forEach(function (input) {
      input.readOnly = false;
    });
    selectField.style.pointerEvents = "auto";
    bdate.style.pointerEvents = "auto";
  }
}

//offender inputs
function showInput2() {
  const input = document.getElementById("o_resident");
  if (document.getElementById("res_type2").value == "resident") {
    input.style.display = "block";
  } else {
    input.style.display = "none";
  }

  const residentType = document.getElementById("res_type").value;
  const selectField = document.getElementById("o_gender");
  const bdate = document.getElementById("o_bdate");
  const inputFields = document.querySelectorAll("#o_input input");

  if (residentType === "resident") {
    inputFields.forEach(function (input) {
      input.readOnly = true;
    });
    selectField.style.pointerEvents = "none";
    bdate.style.pointerEvents = "none";
  } else {
    inputFields.forEach(function (input) {
      input.readOnly = false;
    });
    selectField.style.pointerEvents = "auto";
    bdate.style.pointerEvents = "auto";
  }
}
