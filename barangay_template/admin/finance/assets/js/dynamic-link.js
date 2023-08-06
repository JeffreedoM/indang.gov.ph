// Get the current date
const currentDate = new Date();

// Get the first day of the current month
const firstDayOfMonth = new Date(
  currentDate.getFullYear(),
  currentDate.getMonth(),
  1
);

// Format the dates as yyyy-mm-dd
const formattedDateFrom = formatDate(firstDayOfMonth);
const formattedDateTo = formatDate(currentDate);

// Set the href attribute with the dynamic dates
const linkElement = document.getElementById("dynamic-link");
linkElement.href = `budget-report.php?date_from=${formattedDateFrom}&date_to=${formattedDateTo}&sort_date=`;

// Function to format the date as yyyy-mm-dd
function formatDate(date) {
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const day = String(date.getDate()).padStart(2, "0");
  return `${year}-${month}-${day}`;
}
