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

function addPerson(incidentId) {
    window.location.href = "action_button/add_newperson.php?add_id=" + incidentId;
  }
  
  function viewIncident(incidentId) {
    window.location.href = "action_button/action_view.php?view_id=" + incidentId;
  }
  
  function editIncident(incidentId) {
    window.location.href = "action_button/action_edit.php?update_id=" + incidentId;
  }
  
  function deleteIncident(incidentId) {
    window.location.href = "action_button/action_delete.php?delete_id=" + incidentId;
  }
  
