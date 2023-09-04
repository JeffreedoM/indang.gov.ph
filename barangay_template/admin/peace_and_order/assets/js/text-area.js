document.addEventListener("DOMContentLoaded", function () {
  // Attach event listeners to delete buttons
  attachDeleteButtonListeners();
});

var num_hearing = 0;

document
  .getElementById("addNarrative")
  .addEventListener("click", function (event) {
    event.preventDefault(); // Prevent the default form submission behavior

    var numInput = document.getElementById("num");
    var currentValue = numInput.value;

    // if (currentValue >= 3) {
    //   alert("You have reached the maximum limit of 3 text areas.");
    //   return; // Exit the function if the limit is reached
    // }

    if (currentValue === "") {
      numInput.value = "1"; // Update the value in the input field
    } else {
      num_hearing = parseInt(currentValue, 10); // Set num_hearing to the current value
      numInput.value = (num_hearing + 1).toString(); // Increment the value and update the input field
    }

    var container = document.getElementById("textNarrative");
    var newTextArea = document.createElement("div");
    newTextArea.setAttribute("class", "text-area-container");

    // hidden input for hearing no.
    var hiddenNo = document.createElement("input");
    hiddenNo.setAttribute("type", "hidden");
    hiddenNo.setAttribute("name", "hearing[]");
    hiddenNo.setAttribute("value", num_hearing + 1); // Increment the value

    // adding text area
    var textArea = document.createElement("textarea");
    var textareaId = "narrative_" + (num_hearing + 1); // Generate a unique ID for each textarea
    textArea.setAttribute("id", textareaId); // Set the ID of the textarea
    textArea.setAttribute("name", "narrative[]");
    textArea.setAttribute("rows", "3");
    textArea.setAttribute(
      "class",
      "block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-green-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
    );
    textArea.setAttribute("placeholder", "Enter Narrative...");

    // date of hearing
    var inputDate = document.getElementById("inputDate").value;
    var parsedDate = new Date(inputDate);
    var monthNames = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];
    var day = parsedDate.getDate();
    var monthIndex = parsedDate.getMonth(); // Months are 0-indexed
    var year = parsedDate.getFullYear();
    day = day < 10 ? "0" + day : day;
    var monthName = monthNames[monthIndex];
    var formattedDate = monthName + " " + day + ", " + year;

    var dateHearing = document.createElement("input");
    dateHearing.setAttribute("value", inputDate);
    dateHearing.setAttribute("readOnly", "");
    dateHearing.setAttribute("name", "dateHearing[]");
    dateHearing.setAttribute(
      "style",
      "display: block; margin-left: auto; outline:none; min-width: 220px;"
    );

    // text label for hearing no.
    var status = document.getElementById("status").value;
    var textLabel = document.createElement("label");
    textLabel.setAttribute("for", "narrative");
    textLabel.setAttribute("style", "margin-top:20px");
    textLabel.className =
      "block text-m font-medium text-gray-900 dark:text-white";

    textLabel.textContent =
      getHearingLabel(num_hearing + 1) + " " + getStatusText(status);

    // hidden input for hearing status
    var statusinput = document.createElement("input");
    statusinput.setAttribute("type", "hidden");
    statusinput.setAttribute("value", getStatusText(status));
    statusinput.setAttribute("readOnly", "");
    statusinput.setAttribute("name", "statusInput[]");

    newTextArea.appendChild(textLabel);
    newTextArea.appendChild(dateHearing);
    newTextArea.appendChild(statusinput);
    newTextArea.appendChild(textArea);
    newTextArea.appendChild(hiddenNo);

    container.appendChild(newTextArea);

    setTimeout(function () {
      CKEDITOR.replace(textareaId);
    }, 0);

    // Attach event listener to the delete button
    deleteButton.addEventListener("click", function () {
      var confirmed = confirm(
        "Are you sure you want to delete this narrative?"
      );
      if (!confirmed) {
        return false; // Cancel the deletion if not confirmed
      }

      var container = document.getElementById("textNarrative");
      var textAreaContainer = this.parentNode;
      container.removeChild(textAreaContainer);
    });
  });

function attachDeleteButtonListeners() {
  var deleteButtons = document.getElementsByClassName("delete-button");
  for (var i = 0; i < deleteButtons.length; i++) {
    deleteButtons[i].addEventListener("click", function () {
      var container = document.getElementById("textNarrative");
      var textAreaContainer = this.parentNode;
      container.removeChild(textAreaContainer);
    });
  }
}

function getHearingLabel(num) {
  var label = "";
  switch (num) {
    case 1:
      label = "1st hearing:";
      break;
    case 2:
      label = "2nd hearing:";
      break;
    case 3:
      label = "3rd hearing:";
      break;
    default:
      label = num + "th hearing:";
      break;
  }
  return label;
}

function getStatusText(statusValue) {
  switch (statusValue) {
    case "1":
      return "On-going";
    case "2":
      return "Dismiss";
    case "3":
      return "Certified 4a";
    case "4":
      return "Mediated";
    case "5":
      return "Resolved";
    default:
      return "";
  }
}
