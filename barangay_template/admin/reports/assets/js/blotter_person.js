function fetchResident() {
  const selectElement = document.getElementById("blotter");
  const selectedIncidentId = selectElement.value;
  const residentInfoElement = document.getElementById("residentInfo");
  if (selectedIncidentId) {
    // Make an AJAX request to get the resident data for the selected incident_id
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const responseData = JSON.parse(xhr.responseText);
        if (responseData.success) {
          const complainants = responseData.complainants;
          const offenders = responseData.offenders;

          // Assuming the data is an array of objects with a "name" property for residents
          let residentData = "";
          for (const complainant of complainants) {
            residentData += `<span style="color:green">Complainant:</span> ${complainant}<br>`;
          }

          for (const offender of offenders) {
            residentData += `<span style="color:red">Offender:</span> ${offender}<br>`;
          }

          residentInfoElement.innerHTML = residentData;
        } else {
          residentInfoElement.textContent =
            "Resident data not found for this incident.";
        }
      }
    };
    xhr.open(
      "GET",
      `blotter_person.php?incident_id=${selectedIncidentId}`,
      true
    );
    xhr.send();
  } else {
    residentInfoElement.textContent = ""; // Clear the resident info if no incident is selected
  }
}
