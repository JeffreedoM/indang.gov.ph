const rows = document.querySelectorAll("tr");

const complainantIdInput = document.querySelector(".complainant_id");
const complainantFNameInput = document.querySelector("#complainant_fname");
const complainantLNameInput = document.querySelector("#complainant_lname");
const contactInput = document.querySelector("#contact");
const genderInput = document.querySelector("#gender");
const bdateInput = document.querySelector("#bdate");
const addrInput = document.querySelector("#address");

const offenderIdInput = document.querySelector(".offender_id");
const offenderFNameInput = document.querySelector("#o_fname");
const offenderLNameInput = document.querySelector("#o_lname");
const o_contactInput = document.querySelector("#o_contact");
const o_genderInput = document.querySelector("#o_gender");
const o_bdateInput = document.querySelector("#o_bdate");
const o_addrInput = document.querySelector("#o_address");

let selectedComplainant = null;
let selectedOffender = null;
rows.forEach((row) => {
  row.addEventListener("click", () => {
    const selectedId = row.getAttribute("id");
    console.log("Selected ID:", selectedId);
    const selectedRowCells = row.querySelectorAll("td");

    const [_, fname, lname, contact, gender, bdate, address] = selectedRowCells;

    if (row.getAttribute("data-modal-hide") === "offenderModal") {
      console.log("Selected Offender ID:", selectedId);
      // Check if the selected resident is already the complainant or in oIds
      try {
        if (
          (selectedComplainant && selectedComplainant.id === selectedId) ||
          (oIds && oIds.includes(selectedId))
        ) {
          alert("This resident is already selected as the complainant.");
          return; // Skip selecting the same resident as both complainant and offender
        }
      } catch (error) {
        // Ignore the error and continue execution
      }

      // Set values for offender
      selectedOffender = {
        id: selectedId,
        fname: fname.textContent,
        lname: lname.textContent,
        contact: contact.textContent.trim() || "N/A",
        gender: gender.textContent,
        bdate: bdate.textContent,
        address: address.textContent,
      };

      // Set values for offender
      offenderIdInput.value = selectedOffender.id;
      offenderFNameInput.value = selectedOffender.fname;
      offenderLNameInput.value = selectedOffender.lname;
      o_contactInput.value = selectedOffender.contact;
      o_genderInput.value = selectedOffender.gender;
      o_bdateInput.value = selectedOffender.bdate;
      o_addrInput.value = selectedOffender.address;

      // Retain complainant's values
      complainantIdInput.value = selectedComplainant
        ? selectedComplainant.id
        : "";
      complainantFNameInput.value = selectedComplainant
        ? selectedComplainant.fname
        : "";
      complainantLNameInput.value = selectedComplainant
        ? selectedComplainant.lname
        : "";
      contactInput.value = selectedComplainant
        ? selectedComplainant.contact
        : "";
      genderInput.value = selectedComplainant ? selectedComplainant.gender : "";
      bdateInput.value = selectedComplainant ? selectedComplainant.bdate : "";
      addrInput.value = selectedComplainant ? selectedComplainant.address : "";
    } else {
      console.log("Selected Complainant ID:", selectedId);
      // Check if the selected resident is already the offender or in cIds
      try {
        if (
          (selectedOffender && selectedOffender.id === selectedId) ||
          (cIds && cIds.includes(selectedId))
        ) {
          alert("This resident is already selected as the offender.");
          return; // Skip selecting the same resident as both complainant and offender
        }
        console.log(cIds);
      } catch (error) {
        // Ignore the error and continue execution
      }

      // Set values for complainant
      selectedComplainant = {
        id: selectedId,
        fname: fname.textContent,
        lname: lname.textContent,
        contact: contact.textContent.trim() || "N/A",
        gender: gender.textContent,
        bdate: bdate.textContent,
        address: address.textContent,
      };

      // Set values for complainant
      complainantIdInput.value = selectedComplainant.id;
      complainantFNameInput.value = selectedComplainant.fname;
      complainantLNameInput.value = selectedComplainant.lname;
      contactInput.value = selectedComplainant.contact;
      genderInput.value = selectedComplainant.gender;
      bdateInput.value = selectedComplainant.bdate;
      addrInput.value = selectedComplainant.address;

      // Retain offender's values
      offenderIdInput.value = selectedOffender ? selectedOffender.id : "";
      offenderFNameInput.value = selectedOffender ? selectedOffender.fname : "";
      offenderLNameInput.value = selectedOffender ? selectedOffender.lname : "";
      o_contactInput.value = selectedOffender ? selectedOffender.contact : "";
      o_genderInput.value = selectedOffender ? selectedOffender.gender : "";
      o_bdateInput.value = selectedOffender ? selectedOffender.bdate : "";
      o_addrInput.value = selectedOffender ? selectedOffender.address : "";
    }

    let offenderModal = new Modal(document.getElementById("offenderModal"), {
      closable: false,
    });
    let complainantModal = new Modal(
      document.getElementById("complainantModal"),
      { closable: false }
    );
    offenderModal.hide();
    complainantModal.hide();
    hideBackdrop();
  });
});

const hideBackdrop = () => {
  const backdropElements = document.querySelectorAll("[modal-backdrop]");
  backdropElements.forEach((backdropElement) => {
    if (backdropElement && document.contains(backdropElement)) {
      backdropElement.remove();
    }
  });
};

// // hideBackdrop();

const complainantModalBtn = document.getElementById("c_resident");
const offdenderModalBtn = document.getElementById("o_resident");

complainantModalBtn.addEventListener("click", () => {
  let cModal = new Modal(document.getElementById("complainantModal"), {
    closable: false,
  });
  hideBackdrop();
  cModal.show();
});
offdenderModalBtn.addEventListener("click", () => {
  let oModal = new Modal(document.getElementById("offenderModal"), {
    closable: false,
  });
  hideBackdrop();
  oModal.show();
});

// const rows = document.querySelectorAll('tr');
// const complainantIdInput = document.querySelector('.complainant_id');
// const complainantFNameInput = document.querySelector('#complainant_fname');
// const complainantLNameInput = document.querySelector('#complainant_lname');
// const contactInput = document.querySelector('#contact');
// const genderInput = document.querySelector('#gender');
// const bdateInput = document.querySelector('#bdate');
// const addrInput = document.querySelector('#address');

// rows.forEach(row => {
//     row.addEventListener('click', () => {
//         // get the id of the clicked resident
//         const selectedId = row.getAttribute('id');

//         // putting the selected id of female or male residents in the hidden input
//         complainantIdInput.value = selectedId;
//         const complainant_fname = document.querySelector(`#${CSS.escape(selectedId)} td:nth-child(2)`).textContent;
//         const complainant_lname = document.querySelector(`#${CSS.escape(selectedId)} td:nth-child(3)`).textContent;
//         const contact = document.querySelector(`#${CSS.escape(selectedId)} td:nth-child(4)`).textContent;
//         const gender = document.querySelector(`#${CSS.escape(selectedId)} td:nth-child(5)`).textContent;
//         const bdate = document.querySelector(`#${CSS.escape(selectedId)} td:nth-child(6)`).textContent;
//         const address = document.querySelector(`#${CSS.escape(selectedId)} td:nth-child(7)`).textContent;
//         // putting the values in the input name
//         complainantFNameInput.value = complainant_fname;
//         complainantLNameInput.value = complainant_lname;
//         contactInput.value = contact;
//         genderInput.value = gender;
//         bdateInput.value = bdate;
//         addrInput.value = address;

//     });
// });

// const offenderIdInput = document.querySelector('.offender_id');
// const offenderFNameInput = document.querySelector('#o_fname');
// const offenderLNameInput = document.querySelector('#o_lname');
// const o_contactInput = document.querySelector('#o_contact');
// const o_genderInput = document.querySelector('#o_gender');
// const o_bdateInput = document.querySelector('#o_bdate');
// const o_addrInput = document.querySelector('#o_address');

// rows.forEach(row => {
//     row.addEventListener('click', () => {
//         // get the id of the clicked resident
//         const o_selectedId = row.getAttribute('id');

//         // putting the selected id of female or male residents in the hidden input
//         offenderIdInput.value = selectedId;
//         const offender_fname = document.querySelector(`#${CSS.escape(o_selectedId)} td:nth-child(2)`).textContent;
//         const offender_lname = document.querySelector(`#${CSS.escape(o_selectedId)} td:nth-child(3)`).textContent;
//         const o_contact = document.querySelector(`#${CSS.escape(o_selectedId)} td:nth-child(4)`).textContent;
//         const o_gender = document.querySelector(`#${CSS.escape(o_selectedId)} td:nth-child(5)`).textContent;
//         const o_bdate = document.querySelector(`#${CSS.escape(o_selectedId)} td:nth-child(6)`).textContent;
//         const o_address = document.querySelector(`#${CSS.escape(o_selectedId)} td:nth-child(7)`).textContent;
//         // putting the values in the input name
//         offenderFNameInput.value = offender_fname;
//         offenderLNameInput.value = offender_lname;
//         o_contactInput.value = o_contact;
//         o_genderInput.value =o_gender;
//         o_bdateInput.value = o_bdate;
//         o_addrInput.value = o_address;

//     });
// });
