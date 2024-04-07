<?php
session_start();
include_once 'header.php';
include_once '../connection/connect.php';

if(!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['edit_id'])) {
      $edit_id = $_POST['edit_id'];
      $edit_firstname = $_POST['edit_firstname'];
      $edit_lastname = $_POST['edit_lastname'];
      $edit_position = $_POST['edit_position'];
      $edit_description = $_POST['edit_description'];

      // Use prepared statement to update record
      $stmt = $conn->prepare("UPDATE about SET firstname=?, lastname=?, position=?, description=? WHERE id=?");
      $stmt->bind_param("ssssi", $edit_firstname, $edit_lastname, $edit_position, $edit_description, $edit_id);

      if ($stmt->execute()) {
          // Redirect to the current page to refresh the data
          header("Location: {$_SERVER['REQUEST_URI']}");
          exit();
      } else {
          echo "Error updating record: " . $stmt->error;
      }
  }
}



if(isset($_POST['delete_id'])) {
  // Retrieve the ID of the record to be deleted
  $delete_id = $_POST['delete_id'];
  
  // SQL query to delete the record with the given ID
  $delete_sql = "DELETE FROM about WHERE id = $delete_id";
  
  // Execute the delete query
  if ($conn->query($delete_sql) === TRUE) {
      // Redirect to the current page to refresh the data
      header("Location: {$_SERVER['REQUEST_URI']}");
      exit();
  } else {
      echo "Error deleting record: " . $conn->error;
  }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $position = $_POST['position'];
  $description = $_POST['description'];

  $stmt = $conn->prepare("INSERT INTO about (firstname, lastname, position, description) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $firstname, $lastname, $position, $description);

  if ($stmt->execute()) {
      header("Location: dashboard.php");
      exit();
  } else {
      echo "Error: " . $stmt->error;
  }
}

?>
    <section class="container-xl mt-5">
            <ul class="navbar-nav d-flex flex-row text-secondary hover">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link me-4" aria-expanded="false">About</a>
                   
                </li>
                <li class="nav-item">
                    <a href="works.php" class="nav-link me-4" aria-expanded="false">Works</a>
    
                </li>
                <li class="nav-item">
                    <a href="skills.php" class="nav-link me-4" aria-expanded="false">Skills</a>
                    
                </li>
            </ul>
            <button type="button" class="btn btn-outline-info btn-sm my-4" data-bs-toggle="modal" data-bs-target="#exampleModal"
            ><i class="bi bi-plus"></i>Add New</button>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Add your details</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="#">
                        <div class="mb-3">
                          <label for="firstname" class="col-form-label">First Name:</label>
                          <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input type="text" class="form-control" id="firstname" name="firstname">
                          </div>
                          
                        </div>
                        <div class="mb-3">
                          <label for="lastname" class="col-form-label">Last Name:</label>
                          <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input type="text" class="form-control" id="lastname" name="lastname">
                          </div>
                        </div>
                        <div class="mb-3">
                          <label for="position" class="col-form-label">Position:</label>
                          <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person-workspace"></i>
                            </span>
                            <input type="text" class="form-control" id="position" name="position">
                          </div>
                         
                        </div>
                        <div class="mb-3">
                          <label for="Description" class="col-form-label">Description:</label>
                          <textarea class="form-control" id="Description" name="description"></textarea>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            <div class="container-xl border-top">
              <div class="wrap-detail">
              <?php

        // Fetch data from the database
        $sql = "SELECT * FROM about";
        $result = $conn->query($sql);

        // Check if there are any records
        if ($result->num_rows > 0) {
            // Loop through each record
            while($row = $result->fetch_assoc()) {
              echo '<div class="button">';
              echo '<button class="greenBtn editBtn" data-bs-toggle="modal" data-bs-target="#editModal' . $row['id'] . '">Edit</button>';
              echo '<div class="modal fade" id="editModal' . $row['id'] . '" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">';
              echo '<div class="modal-dialog">';
              echo '<div class="modal-content">';
              echo '<div class="modal-header">';
              echo '<h5 class="modal-title" id="editModalLabel">Edit Details</h5>';
              echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
              echo '</div>';
              echo '<div class="modal-body">';
              echo '<form method="POST" action="#">';
              echo '<input type="hidden" name="edit_id" value="' . $row['id'] . '">';
              echo '<div class="mb-3">';
              echo '<label for="edit_firstname" class="col-form-label">First Name:</label>';
              echo '<input type="text" class="form-control" id="edit_firstname" name="edit_firstname" value="' . $row['firstname'] . '">';
              echo '</div>';
              echo '<div class="mb-3">';
              echo '<label for="edit_lastname" class="col-form-label">Last Name:</label>';
              echo '<input type="text" class="form-control" id="edit_lastname" name="edit_lastname" value="' . $row['lastname'] . '">';
              echo '</div>';
              echo '<div class="mb-3">';
              echo '<label for="edit_position" class="col-form-label">Position:</label>';
              echo '<input type="text" class="form-control" id="edit_position" name="edit_position" value="' . $row['position'] . '">';
              echo '</div>';
              echo '<div class="mb-3">';
              echo '<label for="edit_description" class="col-form-label">Description:</label>';
              echo '<textarea class="form-control" id="edit_description" rows="6" name="edit_description">' . htmlspecialchars($row['description']) . '</textarea>';
              echo '</div>';
              echo '<div class="modal-footer">';
              echo '<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>';
              echo '<button type="submit" class="btn btn-primary">Submit</button>';
              echo '</div>';
              echo '</form>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
              echo '</div>';

                            // Form for delete button
              echo '<form method="POST" action="#">';
              // Hidden input field to hold the ID of the record
              echo '<input type="hidden" name="delete_id" value="' . $row['id'] . '">';
              echo '<button type="submit" class="redBtn">Delete</button>';
              echo '</form>';
              echo '</div>';

              echo '<div class="name-detail">';
              echo '<p>First Name: </p>';
              echo '<p class="color">' . $row['firstname'] . '</p>'; // Display first name
              echo '</div>';

              echo '<div class="name-detail">';
              echo '<p>Last Name: </p>';
              echo '<p class="color">' . $row['lastname'] . '</p>'; // Display last name
              echo '</div>';

              echo '<div class="name-detail">';
              echo '<p>Career Objective: </p>';
              echo '<p class="color">' . $row['position'] . '</p>'; // Display position
              echo '</div>';

              echo '<div class="description">';
              echo '<p>' . nl2br(htmlspecialchars($row['description'])) . '</p>';
              echo '</div>';

            }
          } else {
              // Display a message if there are no records
              echo '<p>No records found</p>';
          }
           ?>
              </div>
            </div>
    </section>

<?php
include_once 'footer.php';
?>