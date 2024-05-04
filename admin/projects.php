<?php
session_start();
include_once 'header.php';
include_once '../connection/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_project'])) {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $year = mysqli_real_escape_string($conn, $_POST['year']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $image = mysqli_real_escape_string($conn, $_FILES['image']['name']);
  $target_dir = "../images/";
  $target_file = $target_dir . basename($image);
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  $check = getimagesize($_FILES["image"]["tmp_name"]);
  if ($check !== false) {
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

          $sql = "INSERT INTO projects (title, year, description, image) VALUES ('$title', '$year', '$description', '$image')";

          if (mysqli_query($conn, $sql)) {
              echo "New record created successfully";
          } else {
              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
  } else {
      echo "File is not an image.";
  }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_project'])) {
  $id = $_POST['edit_id'];
  $title = $_POST['edit_title'];
  $year = $_POST['edit_year'];
  $description = $_POST['edit_description'];

  if (isset($_FILES['edit_image']) && $_FILES['edit_image']['size'] > 0) {
    $image = $_FILES['edit_image']['name'];
    $target_dir = "../images/";
    $target_file = $target_dir . basename($_FILES["edit_image"]["name"]);

    if ($_FILES["edit_image"]["size"] > 1000000) {
      echo "Sorry, your file is too large.";
      exit();
    }

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      exit();
    }

    if (move_uploaded_file($_FILES["edit_image"]["tmp_name"], $target_file)) {
      // Update database with new image path
      $stmt = $conn->prepare("UPDATE projects SET title=?, year=?, description=?, image=? WHERE id=?");
      $stmt->bind_param("ssssi", $title, $year, $description, $image, $id);
      $stmt->execute();
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  } else {
    
    $image = $_POST['existing_image'];
    $stmt = $conn->prepare("UPDATE projects SET title=?, year=?, description=?, image=? WHERE id=?");
    $stmt->bind_param("ssssi", $title, $year, $description, $image, $id);
    $stmt->execute();
  }

  header("Location: {$_SERVER['REQUEST_URI']}");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  $id = $_POST['delete_id'];

  $sql = "SELECT image FROM projects WHERE id = $id";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $image = $row['image'];
  unlink("uploads/$image");

  $sql = "DELETE FROM projects WHERE id = $id";

  if (mysqli_query($conn, $sql)) {
    header('Location: projects.php');
  } else {
    echo "Error deleting record: " . mysqli_error($conn);
  }
}

$current_page = basename($_SERVER['PHP_SELF']);

?>


<section class="container-xl mt-5">
  <ul class="navbar-nav d-flex flex-row text-secondary hover">
    <li class="nav-item">
      <a href="about.php" class="nav-link me-4 <?php echo $current_page === 'dashboard.php' ? 'active' : ''; ?>" aria-expanded="false">About</a>
    </li>
    <li class="nav-item">
      <a href="projects.php" class="nav-link me-4 <?php echo $current_page === 'projects.php' ? 'active' : ''; ?>" aria-expanded="false">Projects</a>
    </li>
    <li class="nav-item">
      <a href="skills.php" class="nav-link me-4 <?php echo $current_page === 'skills.php' ? 'active' : ''; ?>" aria-expanded="false">Skills</a>
    </li>
  </ul>

  <button type="button" class="btn btn-outline-info btn-sm my-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
    <i class="bi bi-plus"></i>Add New
  </button>

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Add new projects</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="#" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="title" class="col-form-label">Title Project:</label>
              <div class="input-group">
                <span class="input-group-text">
                  <i class="bi bi-person-fill"></i>
                </span>
                <input type="text" class="form-control" id="title" name="title" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="year" class="col-form-label">Year:</label>
              <div class="input-group">
                <span class="input-group-text">
                  <i class="bi bi-person-fill"></i>
                </span>
                <input type="text" class="form-control" id="year" name="year" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="description" class="col-form-label">Description:</label>
              <div class="input-group">
                <span class="input-group-text">
                  <i class="bi bi-person-fill"></i>
                </span>
                <input type="text" class="form-control" id="description" name="description" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="image" class="col-form-label">Image:</label>
              <div class="input-group">
                <span class="input-group-text">
                  <i class="bi bi-person-workspace"></i>
                </span>
                <input type="file" class="form-control" id="image" name="image" required>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary" name="add_project">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="container-x1 border-top">
    <div class="wrap-detail">
      <div class="work-container">

        <div class="works">
          <?php
          $sql = "SELECT * FROM projects ORDER BY id DESC";
          $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {


          ?>
              <div class="card">
                <img src="../images/<?php echo $row['image']; ?>" alt="image">
                <h4><?php echo $row['title']; ?> <span><?php echo $row['year']; ?></span></h4>
                <p><?php echo $row['description']; ?></p>
                <div class="button">
                  <button class="greenBtn" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                  <form action="#" method="POST">
                    <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="redBtn">Delete</button>
                  </form>
                </div>
              </div>

              <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editModalLabel">Edit Project</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="#" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                        <div class="mb-3">
                          <label for="edit_title" class="form-label">Project Title</label>
                          <input type="text" id="edit_title" name="edit_title" class="form-control" value="<?php echo $row['title']; ?>">
                        </div>

                        <div class="mb-3">
                          <label for="edit_year" class="form-label">Year</label>
                          <input type="text" id="edit_year" name="edit_year" class="form-control" value="<?php echo $row['year']; ?>">
                        </div>

                        <div class="mb-3">
                          <label for="edit_description" class="form-label">Description</label>
                          <input type="text" id="edit_description" name="edit_description" class="form-control" value="<?php echo $row['description']; ?>">
                        </div>

                        <div class="mb-3">
                          <input type="hidden" name="existing_image" value="<?php echo $row['image']; ?>">
                          <label for="edit_image" class="form-label">Image</label>
                          <input type="file" id="edit_image" name="edit_image" class="form-control">
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary" name="edit_project">Save</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

          <?php
            }
          } else {
            echo '<p>No data found.</p>';
          }
          ?>
        </div>

      </div>
    </div>
  </div>
</section>

<?php
include_once 'footer.php';
?>