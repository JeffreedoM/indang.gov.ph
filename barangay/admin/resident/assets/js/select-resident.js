const femaleRows = document.querySelectorAll(".female-residents");
const selectedFemaleIdInput = document.querySelectorAll(".selected_id");

const hideBackdrop = () => {
  const backdropElement = document.querySelector("[modal-backdrop]");
  if (backdropElement) {
    backdropElement.remove();
  }
};

femaleRows.forEach((row) => {
  row.addEventListener("click", () => {
    // get the id of the clicked resident
    const selectedId = row.getAttribute("id");

    // putting the selected id of female or male residents in the hidden input
    selectedFemaleIdInput.forEach((input) => {
      input.value = selectedId;
    });

    let motherModal = new Modal(document.getElementById("motherModal"));
    let motherAlert = new Modal(document.getElementById("motherAlert"));
    hideBackdrop();
    motherModal.hide();
    motherAlert.show();
  });
});

const motherCancel = document.getElementById("mother-cancel");
motherCancel.addEventListener("click", () => {
  let motherModal = new Modal(document.getElementById("motherModal"));
  let motherAlert = new Modal(document.getElementById("motherAlert"));
  motherAlert.hide();
  hideBackdrop();
  motherModal.toggle();
});

/* Father */

const maleRows = document.querySelectorAll(".male-residents");
const selectedMaleIdInput = document.querySelectorAll(".selected_id");

maleRows.forEach((row) => {
  row.addEventListener("click", () => {
    // get the id of the clicked resident
    const selectedId = row.getAttribute("id");

    // putting the selected id of female or male residents in the hidden input
    selectedMaleIdInput.forEach((input) => {
      input.value = selectedId;
    });

    let fatherModal = new Modal(document.getElementById("fatherModal"));
    let fatherAlert = new Modal(document.getElementById("fatherAlert"));
    hideBackdrop();
    fatherModal.hide();
    fatherAlert.show();
  });
});

const fatherCancel = document.getElementById("father-cancel");
fatherCancel.addEventListener("click", () => {
  let fatherModal = new Modal(document.getElementById("fatherModal"));
  let fatherAlert = new Modal(document.getElementById("fatherAlert"));
  fatherAlert.hide();
  hideBackdrop();
  fatherModal.toggle();
});
