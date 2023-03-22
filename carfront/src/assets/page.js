// Get the elements we need to interact with
const dataDisplay = document.getElementById('data-display');
const itemsPerPageSelect = document.getElementById('items-per-page-select');
const prevPageBtn = document.getElementById('prev-page-btn');
const nextPageBtn = document.getElementById('next-page-btn');

// Define some variables
let itemsPerPage = parseInt(itemsPerPageSelect.value);
let currentPage = 1;
let totalPages = Math.ceil(data.length / itemsPerPage);

// Define a function to display the data on the current page
function displayData() {
  // Calculate the start and end indexes for the current page
  const startIndex = (currentPage - 1) * itemsPerPage;
  const endIndex = Math.min(startIndex + itemsPerPage, data.length);

  // Clear the current display
  dataDisplay.innerHTML = '';

  // Display the items for the current page
  for (let i = startIndex; i < endIndex; i++) {
    const item = data[i];
    const itemElement = document.createElement('div');
    itemElement.textContent = item.name; // Replace this with the code to display your data
    dataDisplay.appendChild(itemElement);
  }

  // Update the pagination controls
  prevPageBtn.disabled = currentPage === 1;
  nextPageBtn.disabled = currentPage === totalPages;
}

// Handle changes to the items per page selection
itemsPerPageSelect.addEventListener('change', () => {
  // Update the items per page and total pages variables
  itemsPerPage = parseInt(itemsPerPageSelect.value);
  totalPages = Math.ceil(data.length / itemsPerPage);

  // Reset the current page to the first page
  currentPage = 1;

  // Update the display
  displayData();
});

// Handle clicks on the previous page button
prevPageBtn.addEventListener('click', () => {
  currentPage--;

  // Update the display
  displayData();
});

// Handle clicks on the next page button
nextPageBtn.addEventListener('click', () => {
  currentPage++;

  // Update the display
  displayData();
});

// Initial display of data
displayData();
