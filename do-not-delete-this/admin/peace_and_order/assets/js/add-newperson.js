const select = document.getElementById("select_type");
const form1 = document.getElementById("complainant");
const form2 = document.getElementById("offender");

select.addEventListener("change", function() {
    if (select.value === "complainant") {
        complainant.style.display = "block";
        offender.style.display = "none";
    } else if (select.value === "offender") {
        complainant.style.display = "none";
        offender.style.display = "block";
    }
});

