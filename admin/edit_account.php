<?php
session_start();
include_once 'header.php';
include_once '../connection/connect.php';

// Fetch user data
$username = $_SESSION['username'];

$stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo '<div class="alert alert-danger">User not found!</div>';
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($newUsername) && !empty($password)) {
    
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE username = ?");
        $stmt->bind_param("sss", $newUsername, $hashed_password, $username);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success">Account updated successfully!</div>';
            
            $_SESSION['username'] = $newUsername;
        } else {
            echo '<div class="alert alert-danger">Error updating account: ' . $stmt->error . '</div>';
        }

       
        $stmt->close();
    } else {
        echo '<div class="alert alert-danger">All fields are required!</div>';
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-white">
                <div class="card-header">
                    Edit Account
                </div>
                <div class="card-body">
                    <form action="#" method="post">
                        <!-- Username Field -->
                        <div class="mb-3 text-start">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3 text-start">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once 'footer.php';
?>
