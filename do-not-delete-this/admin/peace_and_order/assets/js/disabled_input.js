function showInput1() {
   const input = document.getElementById("c_resident");
   if (document.getElementById("res_type").value == "resident") {
      input.style.display = "block";
   } else {
      input.style.display = "none";
   }

   const residentType = document.getElementById("res_type").value;
   const selectField = document.getElementById("gender");
   const inputFields = document.querySelectorAll("#c_input input");


   if (residentType === "resident") {
      inputFields.forEach(function (input) {
         input.readOnly = true;
      });
      selectField.style.pointerEvents = 'none';
      // selectField.readOnly = true;
   } else {
      inputFields.forEach(function (input) {
         input.readOnly = false;
      });
      // selectField.readOnly = false;
      selectField.style.pointerEvents = 'auto';
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

   const residentType = document.getElementById("res_type2").value;
   const selectField = document.getElementById("o_gender");
   const inputFields = document.querySelectorAll("#o_input input");


   if (residentType === "resident") {
      inputFields.forEach(function (input) {
         input.readOnly = true;
      });
      selectField.style.pointerEvents = 'none';
      // selectField.readOnly = true;
   } else {
      inputFields.forEach(function (input) {
         input.readOnly = false;
      });
      selectField.style.pointerEvents = 'auto';
   }

}