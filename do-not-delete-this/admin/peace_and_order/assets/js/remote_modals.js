function addPerson(incidentId) {
  window.location.href = "action_button/add_newperson.php?add_id=" + incidentId;
}

function viewIncident(incidentId) {
  window.location.href = "action_button/action_view.php?view_id=" + incidentId;
}

function editIncident(incidentId) {
  window.location.href =
    "action_button/action_edit.php?update_id=" + incidentId;
}

function deleteIncident(incidentId) {
  window.location.href =
    "action_button/action_delete.php?delete_id=" + incidentId;
}
function printIncident(incidentId) {
  window.location.href = "includes/print.php?print_id=" + incidentId;
}
