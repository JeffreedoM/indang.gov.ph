function showInput1() {
    const input = document.getElementById("c_resident");
    if (document.getElementById("res_type").value == "resident") {
        input.style.display = "block";
    } else {
        input.style.display = "none";
    }

        const residentType = document.getElementById("res_type").value;
        const selectField = document.getElementById("c_gender");
        const inputFields = document.querySelectorAll("#c_input input");
   

        if (residentType === "resident") {
           inputFields.forEach(function(input) {
              input.disabled = true;
           });
           selectField.disabled = true;
        } else {
           inputFields.forEach(function(input) {
              input.disabled = false;
           });
           selectField.disabled = false;
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
           inputFields.forEach(function(input) {
              input.disabled = true;
           });
           selectField.disabled = true;
        } else {
           inputFields.forEach(function(input) {
              input.disabled = false;
           });
           selectField.disabled = false;
        } 
    
}