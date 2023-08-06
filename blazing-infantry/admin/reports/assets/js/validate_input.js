function validateInputs() {
    var inputs = document.getElementsByTagName("input");
    var selects = document.getElementsByTagName("select");
    for (var i = 0; i < inputs.length; i++) {
      if (inputs[i].value.trim() === '') {
        alert("Please fill in all inputs before submitting.");
        return false;
      }
    }
    for (var i = 0; i < selects.length; i++) {
      if (selects[i].value === '') {
        alert("Please select an option before submitting.");
        return false;
      }
    }
    return true;
  }

function deleteItem() {
  if (confirm("Are you sure?")) {
    alert("Item is already deleted!");
  }
}


