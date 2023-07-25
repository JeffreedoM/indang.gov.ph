
// Get the input fields and result field
const num1Field = document.getElementById('num1');
const num2Field = document.getElementById('num2');
const resultField = document.getElementById('result');

// Function to calculate the result
function calculate() {
    const num1 = parseInt(num1Field.value);
    const num2 = parseInt(num2Field.value);

    if (!isNaN(num1) && !isNaN(num2)) {
        const result = num1 + num2;
        resultField.value = result;
    } else {
        resultField.value = "";
    }
}

// Add event listeners to the input fields
num1Field.addEventListener('input', calculate);
num2Field.addEventListener('input', calculate);
