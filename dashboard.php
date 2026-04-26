<?php
session_start();
require 'database.php';

// Redirect if not logged in
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}

$student_id = $_SESSION['student_id'];
$error = '';
$success = '';

// Fetch logged-in student data
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch();

if (!$student) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Handle profile update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $course = $_POST['course'] ?? '';

    if (!$full_name || !$email) {
        $error = "Full Name and Email are required.";
    } else {
        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['profile_photo']['tmp_name'];
            $fileName = $_FILES['profile_photo']['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($fileExtension, $allowedExts)) {
                $newFileName = 'profile_' . $student_id . '.' . $fileExtension;
                $uploadFileDir = 'uploads/';
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0755, true);
                }
                $dest_path = $uploadFileDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $profile_photo = $newFileName;
                } else {
                    $error = "There was an error uploading your profile photo.";
                }
            } else {
                $error = "Only jpg, jpeg, png, gif files are allowed for profile photo.";
            }
        }

        if (!$error) {
            $sql = "UPDATE students SET full_name = ?, email = ?, phone = ?, course = ?";
            $params = [$full_name, $email, $phone, $course];

            if (isset($profile_photo)) {
                $sql .= ", profile_photo = ?";
                $params[] = $profile_photo;
            }

            $sql .= " WHERE id = ?";
            $params[] = $student_id;

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            $success = "Profile updated successfully.";

            // Refresh student data
            $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
            $stmt->execute([$student_id]);
            $student = $stmt->fetch();

            $_SESSION['student_name'] = $student['full_name'];
        }
    }
}
?>

<?php require 'partials/header.php'; ?>

<div class="container mt-4 mb-5">
    <h2>Dashboard / Profile</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-md-4 text-center">
            <img src="uploads/<?= htmlspecialchars($student['profile_photo'] ?: 'default.png') ?>" alt="Profile Photo" class="img-thumbnail" style="max-width: 250px;">
        </div>
        <div class="col-md-8">
            <form method="POST" action="dashboard.php" enctype="multipart/form-data" novalidate>
                <div class="form-group">
                    <label for="full_name">Full Name *</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" required value="<?= htmlspecialchars($student['full_name']) ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($student['email']) ?>">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($student['phone']) ?>">
                </div>
                <div class="form-group">
                    <label for="course">Course</label>
                    <select name="course" id="course" class="form-control" required>
                        <option value="">-- Select your course --</option>
                        <option value="Web Development" <?= ($student['course'] == 'Web Development') ? 'selected' : '' ?>>Web Development</option>
                        <option value="Software Engineering" <?= ($student['course'] == 'Software Engineering') ? 'selected' : '' ?>>Software Engineering</option>
                        <option value="Artificial Intelligence" <?= ($student['course'] == 'Artificial Intelligence') ? 'selected' : '' ?>>Artificial Intelligence</option>
                        <option value="Data Science" <?= ($student['course'] == 'Data Science') ? 'selected' : '' ?>>Data Science</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="profile_photo">Profile Photo (jpg, jpeg, png, gif)</label>
                    <input type="file" class="form-control-file" id="profile_photo" name="profile_photo" accept=".jpg,.jpeg,.png,.gif">
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button type="submit" class="btn btn-success">Update Profile</button>
                    
                    <a href="logout.php" class="btn btn-outline-secondary">Logout</a>
                    
                    <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#confirmDeleteModal">
                        Delete Profile
                    </button>
                </div>
            </form>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius: 1rem;">
                  <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteLabel">Are you sure?</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body text-center">
                    <p>This will permanently delete your profile.</p>
                    <p>This action cannot be undone.</p>
                  </div>
                  <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="delete.php" class="btn btn-danger">Yes, Delete</a>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<?php require 'partials/footer.php'; ?>

