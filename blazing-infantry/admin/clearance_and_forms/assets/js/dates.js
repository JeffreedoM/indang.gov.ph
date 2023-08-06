window.onload = function () {
  window.print();
};

function getCurrentDate() {
  const currentDate = new Date();

  const day = currentDate.getDate();
  const month = currentDate.toLocaleString("default", {
    month: "long",
  });
  const year = currentDate.getFullYear();

  return {
    day,
    month,
    year,
  };
}

function getDayWithSuffix(day) {
  const suffixes = ["th", "st", "nd", "rd"];
  const relevantDigits = (day % 100).toString().slice(-2);

  return (
    day +
    (suffixes[relevantDigits - 20] ||
      suffixes[relevantDigits % 10] ||
      suffixes[0])
  );
}

function updateStatement() {
  const { day, month, year } = getCurrentDate();

  const dayElement = document.getElementById("day");
  dayElement.textContent = getDayWithSuffix(day);

  const monthElement = document.getElementById("month");
  monthElement.textContent = month;

  const yearElement = document.getElementById("year");
  yearElement.textContent = year.toString().substr(-2); // Get the last two digits (23) for underlining
}

// Call updateStatement() to set the initial statement
updateStatement();
