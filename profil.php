<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'connect.php';
$user_id = $_SESSION['user_id'];
$query = "SELECT username, user_telp, email, alamat FROM users WHERE user_id = ?";
$stmt = $mysqli->prepare($query);
if (!$stmt) {
    die("Failed to prepare statement: " . $mysqli->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
if (!$user_data) {
    die("User not found.");
}

$emailErr = "";
$phoneErr = "";
$validationError = "";
$successMsg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['current_password'], $_POST['new_password'], $_POST['confirm_password'])) {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];
    
        // Check if any field is empty
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $validationError = "All fields are required.";
        } else {
            // Fetch the stored password
            $passwordQuery = "SELECT password FROM users WHERE user_id = ?";
            $passwordStmt = $mysqli->prepare($passwordQuery);
            if (!$passwordStmt) {
                die("Failed to prepare statement: " . $mysqli->error);
            }
            $passwordStmt->bind_param("i", $user_id);
            $passwordStmt->execute();
            $passwordResult = $passwordStmt->get_result();
            $passwordData = $passwordResult->fetch_assoc();
    
            if ($passwordData) {
                $storedPassword = $passwordData['password'];
    
                // Verify the current password
                if ($currentPassword !== $storedPassword) {
                    $validationError = "Current password is incorrect.";
                } elseif ($newPassword !== $confirmPassword) {
                    $validationError = "New passwords do not match.";
                } else {
                    // Update the password
                    $updateQuery = "UPDATE users SET password = ? WHERE user_id = ?";
                    $updateStmt = $mysqli->prepare($updateQuery);
                    if (!$updateStmt) {
                        die("Failed to prepare statement: " . $mysqli->error);
                    }
                    $updateStmt->bind_param("si", $newPassword, $user_id);
    
                    if ($updateStmt->execute()) {
                        $successMsg = "Password updated successfully.";
                    } else {
                        $validationError = "Error updating password.";
                    }
                }
            } else {
                $validationError = "User not found.";
            }
        }
        $passwordChangeStatus = $successMsg;
    }
    $updatedFields = [];
    foreach ($user_data as $field => $value) {
        if (isset($_POST[$field])) {
            $newValue = $_POST[$field];
            // Validate email
            if ($field === 'email') {
                $email = filter_var($newValue, FILTER_SANITIZE_EMAIL);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                    $validationError = $emailErr;
                    break;
                }
                $newValue = $email;
            }
            // Validate phone number
            if ($field === 'user_telp') {
                $phone = filter_var($newValue, FILTER_SANITIZE_NUMBER_INT);
                if (!preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
                    $phoneErr = "Invalid phone number format";
                    $validationError = $phoneErr;
                    break;
                }
                $newValue = $phone;
            }
            $updatedFields[$field] = $newValue;
        }
    }

    if (!$validationError && !empty($updatedFields)) {
        foreach ($updatedFields as $field => $newValue) {
            $updateQuery = "UPDATE Users SET $field = ? WHERE user_id = ?";
            $updateStmt = $mysqli->prepare($updateQuery);
            if (!$updateStmt) {
                die("Failed to prepare statement: " . $mysqli->error);
            }
            $updateStmt->bind_param("si", $newValue, $user_id);
            $updateStmt->execute();
        }
        $successMsg = "Profile updated successfully.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Toko Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <?php include 'nav.php'; ?>

    <div class="container py-5">
        <h1 class="mb-0 bg-dark text-warning p-3">Profile Page</h1>
        <div class="card p-4 rounded-0">
            <form method="post">
            <form method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?php echo htmlspecialchars($user_data['username']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="user_telp" class="form-label">No. Telpon:</label>
                    <input type="number" name="user_telp" id="user_telp" class="form-control" value="<?php echo htmlspecialchars($user_data['user_telp']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat:</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo htmlspecialchars($user_data['alamat']); ?>" required>
                </div>
                <button type="submit" class="btn btn-success" style="float: right">Save</button>
                <button type="button" class="btn btn-primary btn-sm mt-3 d-inline-block" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</button>
            </form>
        </div>
    </div>

    <!-- Validation Error Modal -->
    <div class="modal fade" id="validationErrorModal" tabindex="-1" aria-labelledby="validationErrorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="validationErrorMessage">
                    <!-- Error message will be inserted here dynamically -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Change Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <div class="modal-header bg-dark text-yellow-400">
                        <h5 class="modal-title text-center" id="changePasswordModalLabel">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Success/Error Modal -->
     <div class="modal fade" id="passwordChangeStatusModal" tabindex="-1" aria-labelledby="passwordChangeStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="passwordChangeStatusMessage">
                </div>
                </div>
            </div>
        </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const validationError = "<?php echo $validationError; ?>";
            if (validationError) {
                const validationErrorMessage = document.getElementById('validationErrorMessage');
                validationErrorMessage.textContent = validationError;
                const validationErrorModal = new bootstrap.Modal(document.getElementById('validationErrorModal'));
                validationErrorModal.show();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const passwordChangeStatus = "<?php echo htmlspecialchars($passwordChangeStatus); ?>";
            if (passwordChangeStatus) {
                const passwordChangeStatusMessage = document.getElementById('passwordChangeStatusMessage');
                passwordChangeStatusMessage.textContent = passwordChangeStatus;
                const passwordChangeStatusModal = new bootstrap.Modal(document.getElementById('passwordChangeStatusModal'));
                passwordChangeStatusModal.show();
            }
        });
    </script>
</body>

</html>