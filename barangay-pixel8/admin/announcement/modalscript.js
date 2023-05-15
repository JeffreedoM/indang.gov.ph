
  // Get the modal
  var modal = document.getElementById("myModal");

  // Get the button that opens the modal
  var btn = document.getElementsByTagName("button")[0];

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

  // Opens modal
  function openModal() {
    modal.style.display = "block";
  }

  // form close!!
  function closeModal() {
    modal.style.display = "none";
  }

  // CLICK ANYWHERE TO  CLOSE!!!
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }


  // date script
const now = new Date();
// Format the date and time (YEAR MONTH DAY HRS)
const year = now.getFullYear();
const month = ('0' + (now.getMonth() + 1)).slice(-2); // add leading zero if needed
const day = ('0' + now.getDate()).slice(-2); // add leading zero if needed
const hours = ('0' + now.getHours()).slice(-2); // add leading zero if needed
const minutes = ('0' + now.getMinutes()).slice(-2); // add leading zero if needed
const seconds = ('0' + now.getSeconds()).slice(-2); // add leading zero if needed
const formattedDate = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

// Insert the formatted date into the input element
document.getElementById('date').value = formattedDate;



   //CK EDITOR SCRIPT FOR TEXT AREA
		ClassicEditor
      .create( document.querySelector( '#msg' ) )
			.catch( error => {
				console.error( error );
			} );
	

