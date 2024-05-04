<?php

session_start();
include_once 'header.php';
include_once '../connection/connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $skill_name = $_POST['skill_name'];
  $image = $_FILES['skill_image']['name'];
  $target_dir = "../images/";
  $target_file = $target_dir . basename($image);
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  $check = getimagesize($_FILES["skill_image"]["tmp_name"]);
  if ($check !== false) {
    if (move_uploaded_file($_FILES["skill_image"]["tmp_name"], $target_file)) {
      
      $sql = "INSERT INTO skills (skill_name, skill_img) VALUES ('$skill_name', '$image')";

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_skills'])) {
  $id = $_POST['edit_id'];
  $edit_skill = $_POST['edit_skill'];

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
      
      $stmt = $conn->prepare("UPDATE skills SET skill_name=?, skill_img=? WHERE id=?");
      $stmt->bind_param("ssi", $edit_skill, $image, $id);
      $stmt->execute();
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  } else {
    
    $image = $_POST['existing_image'];
    $stmt = $conn->prepare("UPDATE skills SET skill_name=?, skill_img=? WHERE id=?");
    $stmt->bind_param("ssi", $edit_skill, $image, $id);
    $stmt->execute();
  }

  header("Location: {$_SERVER['REQUEST_URI']}");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  $id = $_POST['delete_id'];

  $sql = "SELECT image FROM skills WHERE id = $id";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $image = $row['image'];
  unlink("uploads/$image");

 
  $sql = "DELETE FROM skills WHERE id = $id";

  if (mysqli_query($conn, $sql)) {
    header('Location: skills.php');
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
  <button type="button" class="btn btn-outline-info btn-sm my-4" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>Add new</button>

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Add new skills</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="#" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="skill_name" class="col-form-label">Skill Name:</label>
              <div class="input-group">
                <span class="input-group-text">
                  <i class="bi bi-person-fill"></i>
                </span>
                <input type="text" class="form-control" id="skill_name" name="skill_name">
              </div>
            </div>

            <div class="mb-3">
              <label for="skill_image" class="col-form-label">Image:</label>
              <div class="input-group">
                <span class="input-group-text">
                  <i class="bi bi-person-workspace"></i>
                </span>
                <input type="file" class="form-control" id="skill_image" name="skill_image" required>
              </div>
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
    <div class="work-container">

      <div class="skills-container">
        <?php
        $sql = "SELECT * FROM skills ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {

        ?>
            <div class="skills">
              <img src="../images/<?php echo $row['skill_img']; ?>" alt="">
              <p class="skill_name"><?php echo $row['skill_name']; ?></p>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Skill</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                      <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                      <div class="mb-3">
                        <label for="edit_skill" class="form-label">Skill Name</label>
                        <input type="text" id="edit_skill" name="edit_skill" class="form-control" value="<?php echo $row['skill_name']; ?>">
                      </div>

                      <div class="mb-3">
                        <input type="hidden" name="existing_image" value="<?php echo $row['skill_img']; ?>">
                        <label for="edit_image" class="form-label">Image</label>
                        <input type="file" id="edit_image" name="edit_image" class="form-control">
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="edit_skills">Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        <?php
          }
        } else {
          echo '<p class="data">No data found.</p>';
        }
        ?>
      </div>
    </div>
  </div>
</div>

<?php
include_once 'footer.php';
?>