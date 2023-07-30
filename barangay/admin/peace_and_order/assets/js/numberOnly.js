function NumberInput(input) {
  // Remove any non-numeric characters from the input value using a regular expression
  input.value = input.value.replace(/[^0-9]/g, "");
}
