// Function to fetch employee data from the server
function fetchEmployees() {
    fetch("./app/employee_management.php", {
        method: "POST",
        body: JSON.stringify({ fetchEmployees: true }),
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(response => response.json())
    .then(data => displayData(data))
    .catch(error => console.error(error));
}


///////////    no longer need to display data on page since we have a table
// // Function to display employee data on the web page
// function displayData(data) {
//     const employeeList = document.getElementById("employeeList");
//     employeeList.innerHTML = '';

//     const ul = document.createElement('ul');
    
//     data.forEach((employee) => {
//         const li = document.createElement('li');
//         li.innerHTML = `EmployeeID: ${employee.employee_id}, Name: ${employee.first_name} ${employee.last_name}, Email: ${employee.email}, Department: ${employee.department_name}`;
//         ul.appendChild(li);
//     })

//     employeeList.appendChild(ul);
// }

// // Call the function to fetch employee data when the page loads
// fetchEmployees();
//////////////

    // Function to display error messages on the page
    function displayError2(errorMessage) {
        const errorContainer = document.getElementById("errorContainer2");
        // errorContainer.innerHTML = `<p style="color: red;">Error: ${errorMessage}</p>`;
        if (errorMessage) {
          errorContainer.innerHTML = `<p style="color: red; font-weight: bold; background-color: #ff5">Error: ${errorMessage}</p>`;
        } else {
          errorContainer.innerHTML = ''; // Clear the error message
        }
    }



    // Function to handle updating an employee
document.getElementById("updateEmployeeForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission

    const form = event.target;
    const updateEmployeeId = form.querySelector("#update_employee_id").value;
    const updateFirstName = form.querySelector("#update_first_name").value;
    const updateLastName = form.querySelector("#update_last_name").value;
    const updateEmail = form.querySelector("#update_email").value;
    const updateDepartmentName = form.querySelector("#update_department_name").value;

    // Create a JSON object with the updated employee data
    const data = {
        updateEmployee: true,
        update_employee_id: updateEmployeeId,
        update_first_name: updateFirstName,
        update_last_name: updateLastName,
        update_email: updateEmail,
        update_department_name: updateDepartmentName
    };

    // Send the data to your PHP script using a fetch request
    fetch("./app/employee_management.php", {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            // Handle the error (e.g., display an error message)
            console.error(data.error);
            displayError2(data.error);
        } else {
            // Clear the error message and reload the page after updating an employee successfully
            displayError2("");
            alert("Employee updated successfully");
            // location.reload();
            form.reset();
            fetchEmployees();
        }
    })
    .catch(error => {
        // Handle network errors here
        console.error(error);
        // Display an appropriate error message
        displayError2("An error occurred while processing the request.");
    });
});



        // Function to handle searching for employees
        document.getElementById("searchEmployee").addEventListener("click", function() {
            const searchName = document.getElementById("search_name").value;

            fetch("./app/employee_management.php", {
                method: "POST",
                body: JSON.stringify({ 
                    searchEmployee: true,
                    search_name: searchName
                }),
                headers: {
                    "Content-Type": "application/json"
                }
                
            })
            .then(response => response.json())
            .then(data => displayData(data))
            .catch(error => console.error(error));
            
        });

        /////////////////////----------------table ----------------------
// Function to display employee data on the web page as a table

let currentSortColumn = null;
let isAscending = true;
function displayData(data) {
  console.log(data);
  const display = document.querySelector("#employeeList");
  display.innerHTML = "";

  if (!data) {
    display.innerHTML = "No data available.";
    return;
  }

  if (data.length === 0) {
    display.innerHTML = "No data available.";
    return;
  }

  const table = document.createElement("table");
  table.classList.add("employee-table");

  const thead = document.createElement("thead");
  const headerRow = document.createElement("tr");
  const headers = [
    "▼ EMPLOYEE ID",
    "▼ Name",
    "▼ Last Name",
    "▼ Email",
    "▼ Department",
  ];

  headers.forEach((headerText, index) => {
    const th = document.createElement("th");
    th.textContent = headerText;
    th.dataset.columnIndex = index; // Store the column index for sorting
    th.addEventListener("click", () => sortTable(index)); // Add a click event listener for sorting
    headerRow.appendChild(th);
  });

  thead.appendChild(headerRow);
  table.appendChild(thead);

  const tbody = document.createElement("tbody");

  data.forEach((employee) => {
    const row = document.createElement("tr");
    const columns = [
      "employee_id",
      "first_name",
      "last_name",
      "email",
      "department_name",
    ];
    columns.forEach((columnKey) => {
      const cell = document.createElement("td");
      cell.textContent = employee[columnKey];
      row.appendChild(cell);
    });
    tbody.appendChild(row);
  });

  table.appendChild(tbody);

  display.appendChild(table);
}

// ----------------------sort table---------------------
function sortTable(columnIndex) {
  const table = document.querySelector(".employee-table");
  const tbody = table.querySelector("tbody");
  const rows = Array.from(tbody.querySelectorAll("tr"));

  const isNumeric = columnIndex < 0; // Assuming the Employee ID column is numeric

  rows.sort((a, b) => {
    const aValue = isNumeric
      ? parseInt(a.cells[columnIndex].textContent)
      : a.cells[columnIndex].textContent;
    const bValue = isNumeric
      ? parseInt(b.cells[columnIndex].textContent)
      : b.cells[columnIndex].textContent;

    return aValue.localeCompare(bValue);
  });

  // Reverse the order if it was already sorted in ascending order
  if (currentSortColumn === columnIndex && isAscending) {
    rows.reverse();
    isAscending = false;
  } else {
    isAscending = true;
  }

  // Remove existing rows from the table
  tbody.innerHTML = "";

  // Append sorted rows to the table body
  rows.forEach((row) => tbody.appendChild(row));

  // Update the current sort column
  currentSortColumn = columnIndex;
}
fetchEmployees();
///////////////////----------------------end table----------------------
