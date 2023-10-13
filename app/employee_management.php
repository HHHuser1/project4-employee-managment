<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

// require_once('./_includes/db_connect.php');


// // Initialize the $employees array to store employee data
// $employees = array();



// if ($_SERVER["CONTENT_TYPE"] === "application/json") {
//     $json_data = file_get_contents('php://input');
//     $data = json_decode($json_data, true);

//     // Check for specific JSON properties to determine the action
//     if (isset($data["fetchEmployees"])) {
//         // Fetch all employees from the database along with their department information
//         $query = "SELECT *
//           FROM employees
//           INNER JOIN departments ON employees.departmentID = departments.departmentID
//           ORDER BY employees.timestamp DESC";

//         // $query = "SELECT employees.*, departments.department 
//         //           FROM employees 
//         //           LEFT JOIN departments ON employees.department_id = departments.department_id 
//         //           ORDER BY employees.timestamp DESC";
//         $result = mysqli_query($link, $query);
//         while ($row = mysqli_fetch_assoc($result)) {
//             $employees[] = $row;
//         }
//     }
        

// if (isset($data["addEmployee"])) {
//     // Handle employee addition logic here
//     $first_name = $data["first_name"];
//     $last_name = $data["last_name"];
//     $email = $data["email"];
//     $employee_id = $data["employee_id"];
//     $department_name = $data["department_name"];

//     // Get the department ID based on the department name
//     $department_query = "SELECT departmentID FROM departments WHERE department_name = '$department_name' LIMIT 1";
//     $department_result = mysqli_query($link, $department_query);

//     if (!$department_result) {
//         // Handle the error as needed
//         $error_message = "Department query failed: " . mysqli_error($link);
//         echo json_encode(['error' => $error_message]);
//         exit;
//     }

//     $department_row = mysqli_fetch_assoc($department_result);

//     // Check if a department with the specified name exists
//     if (!$department_row) {
//         // Handle the case where the department doesn't exist
//         echo json_encode(['error' => 'Department does not exist']);
//         exit;
//     }

//     $departmentID = $department_row['departmentID'];

//     // Insert employee data into the employees table
//     $employee_query = "INSERT INTO employees (first_name, last_name, email, employee_id, departmentID) VALUES ('$first_name', '$last_name', '$email', '$employee_id', '$departmentID')";
//     $employee_insert_result = mysqli_query($link, $employee_query);

//     // Check for errors and provide appropriate response
//     if (!$employee_insert_result) {
//             $error_message = "Insert failed: " . mysqli_error($link);
//             echo json_encode(['error' => $error_message]);
//             exit; // Terminate the script after sending the error JSON response
            
//            }
//     }


// if (isset($data["updateEmployee"])) {
//     // Handle employee update logic here
//     $update_employee_id = $data["update_employee_id"];
//     $update_first_name = $data["update_first_name"];
//     $update_last_name = $data["update_last_name"];
//     $update_email = $data["update_email"];
//     $update_department_name = $data["update_department_name"];

//     // Check if the employee with the specified ID exists in the database
//     $check_query = "SELECT * FROM employees WHERE employee_id = '$update_employee_id'";
//     $check_result = mysqli_query($link, $check_query);

//     if (mysqli_num_rows($check_result) === 0) {
//         // Handle the case where the employee does not exist
//         echo json_encode(['error' => "Employee with ID $update_employee_id does not exist."]);
//         exit;
//     }

//     // Get the department ID based on the department name
//     $department_query = "SELECT departmentID FROM departments WHERE department_name = '$update_department_name' LIMIT 1";
//     $department_result = mysqli_query($link, $department_query);

//     if (!$department_result) {
//         // Handle the error as needed
//         $error_message = "Department query failed: " . mysqli_error($link);
//         echo json_encode(['error' => $error_message]);
//         exit;
//     }

//     $department_row = mysqli_fetch_assoc($department_result);

//     // Check if a department with the specified name exists
//     if (!$department_row) {
//         // Handle the case where the department doesn't exist
//         echo json_encode(['error' => 'Department does not exist']);
//         exit;
//     }

//     $departmentID = $department_row['departmentID'];

//     // Update employee data in the employees table
//     $update_query = "UPDATE employees SET first_name = '$update_first_name', last_name = '$update_last_name', email = '$update_email', departmentID = '$departmentID' WHERE employee_id = '$update_employee_id'";
//     $employee_update_result = mysqli_query($link, $update_query);

//     // Check for errors and provide an appropriate response
    
//     if (!$employee_update_result) {
//         $error_message = "Update failed: " . mysqli_error($link);
//         echo json_encode(['error' => $error_message]);
//         exit;
//     }

// }


//     if (isset($data["searchEmployee"])) {
//         $search_name = $data["search_name"];
//         $query = "SELECT employees.first_name, employees.last_name, employees.email, employees.employee_id, departments.department_name
//         FROM employees
//         LEFT JOIN departments ON employees.departmentID = departments.departmentID
//         WHERE employees.first_name LIKE '%$search_name%' OR employees.last_name LIKE '%$search_name%'
//         OR departments.department_name LIKE '%$search_name%'
//         ORDER BY employees.timestamp DESC;";
    
//         $search_result = mysqli_query($link, $query);
    
//         if (!$search_result) {
//             die("Query failed: " . mysqli_error($link));
//         }
    
//         while ($row = mysqli_fetch_assoc($search_result)) {
//             $employees[] = $row;       
//         }
//     }
    
    
    

//     // header('Content-Type: application/json');
//     // echo json_encode($employees);
    


// }

// // Send employee data as a JSON response
// header('Content-Type: application/json');
// echo json_encode($employees);







///////////////////


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('./_includes/db_connect.php');

// Initialize the $employees array to store employee data
$employees = array();

if ($_SERVER["CONTENT_TYPE"] === "application/json") {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    // Check for specific JSON properties to determine the action
    if (isset($data["fetchEmployees"])) {
        // Fetch all employees from the database along with their department information
        $query = "SELECT * FROM employees INNER JOIN departments ON employees.departmentID = departments.departmentID ORDER BY employees.timestamp DESC";

        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $employees[] = $row;
        }
    }

    if (isset($data["addEmployee"])) {
        // Handle employee addition logic here
        $first_name = $data["first_name"];
        $last_name = $data["last_name"];
        $email = $data["email"];
        $employee_id = $data["employee_id"];
        $department_name = $data["department_name"];

        // Get the department ID based on the department name
        $department_query = "SELECT departmentID FROM departments WHERE department_name = ? LIMIT 1";
        $stmt = mysqli_prepare($link, $department_query);
        mysqli_stmt_bind_param($stmt, "s", $department_name);
        mysqli_stmt_execute($stmt);
        $department_result = mysqli_stmt_get_result($stmt);

        if (!$department_result) {
            // Handle the error as needed
            $error_message = "Department query failed: " . mysqli_error($link);
            echo json_encode(['error' => $error_message]);
            exit;
        }

        $department_row = mysqli_fetch_assoc($department_result);

        // Check if a department with the specified name exists
        if (!$department_row) {
            // Handle the case where the department doesn't exist
            echo json_encode(['error' => 'Department does not exist']);
            exit;
        }

        $departmentID = $department_row['departmentID'];

        // Insert employee data into the employees table using prepared statement
        $employee_query = "INSERT INTO employees (first_name, last_name, email, employee_id, departmentID) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $employee_query);
        mysqli_stmt_bind_param($stmt, "ssssi", $first_name, $last_name, $email, $employee_id, $departmentID);
        $employee_insert_result = mysqli_stmt_execute($stmt);

        // Check for errors and provide an appropriate response
        if (!$employee_insert_result) {
            $error_message = "Insert failed: " . mysqli_error($link);
            echo json_encode(['error' => $error_message]);
            exit;
        }
    }

    if (isset($data["updateEmployee"])) {
        // Handle employee update logic here
        $update_employee_id = $data["update_employee_id"];
        $update_first_name = $data["update_first_name"];
        $update_last_name = $data["update_last_name"];
        $update_email = $data["update_email"];
        $update_department_name = $data["update_department_name"];

        // Check if the employee with the specified ID exists in the database
        $check_query = "SELECT * FROM employees WHERE employee_id = ?";
        $stmt = mysqli_prepare($link, $check_query);
        mysqli_stmt_bind_param($stmt, "s", $update_employee_id);
        mysqli_stmt_execute($stmt);
        $check_result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($check_result) === 0) {
            // Handle the case where the employee does not exist
            echo json_encode(['error' => "Employee with ID $update_employee_id does not exist."]);
            exit;
        }

        // Get the department ID based on the department name
        $department_query = "SELECT departmentID FROM departments WHERE department_name = ? LIMIT 1";
        $stmt = mysqli_prepare($link, $department_query);
        mysqli_stmt_bind_param($stmt, "s", $update_department_name);
        mysqli_stmt_execute($stmt);
        $department_result = mysqli_stmt_get_result($stmt);

        if (!$department_result) {
            // Handle the error as needed
            $error_message = "Department query failed: " . mysqli_error($link);
            echo json_encode(['error' => $error_message]);
            exit;
        }

        $department_row = mysqli_fetch_assoc($department_result);

        // Check if a department with the specified name exists
        if (!$department_row) {
            // Handle the case where the department doesn't exist
            echo json_encode(['error' => 'Department does not exist']);
            exit;
        }

        $departmentID = $department_row['departmentID'];

        // Update employee data in the employees table using prepared statement
        $update_query = "UPDATE employees SET first_name = ?, last_name = ?, email = ?, departmentID = ? WHERE employee_id = ?";
        $stmt = mysqli_prepare($link, $update_query);
        mysqli_stmt_bind_param($stmt, "sssis", $update_first_name, $update_last_name, $update_email, $departmentID, $update_employee_id);
        $employee_update_result = mysqli_stmt_execute($stmt);

        // Check for errors and provide an appropriate response
        if (!$employee_update_result) {
            $error_message = "Update failed: " . mysqli_error($link);
            echo json_encode(['error' => $error_message]);
            exit;
        }
    }

    if (isset($data["searchEmployee"])) {
        $search_name = $data["search_name"];
        $query = "SELECT employees.first_name, employees.last_name, employees.email, employees.employee_id, departments.department_name
        FROM employees
        LEFT JOIN departments ON employees.departmentID = departments.departmentID
        WHERE employees.first_name LIKE ? OR employees.last_name LIKE ? OR employees.email LIKE ? OR employees.employee_id LIKE ? OR departments.department_name LIKE ?
        ORDER BY employees.timestamp DESC";

        $stmt = mysqli_prepare($link, $query);
        $search_name = "%$search_name%"; // Add wildcards for the search
        mysqli_stmt_bind_param($stmt, "sssss", $search_name, $search_name, $search_name, $search_name, $search_name);
        mysqli_stmt_execute($stmt);
        $search_result = mysqli_stmt_get_result($stmt);

        if (!$search_result) {
            die("Query failed: " . mysqli_error($link));
        }

        while ($row = mysqli_fetch_assoc($search_result)) {
            $employees[] = $row;
        }
    }

    // Send employee data as a JSON response
    header('Content-Type: application/json');
    echo json_encode($employees);
}








?>