<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'connect.php';
$user_id = $_SESSION['user_id'];
$query = "SELECT username, user_telp, email, alamat FROM Users WHERE user_id = ?";
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['field']) && isset($_POST['value'])) {
        $field = $_POST['field'];
        $value = $_POST['value'];

        // Validate email
        if ($field === 'email') {
            $email = filter_var($value, FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            } else {
                $value = $email;
            }
        }
        
        // Validate phone number
        if ($field === 'user_telp') {
            $phone = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
            if (!preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
                $emailErr = "Invalid phone number format"; 
            } else {
                $value = $phone;
            }
        }

        if (!$emailErr) {
            $updateQuery = "UPDATE Users SET $field = ? WHERE user_id = ?";
            $updateStmt = $mysqli->prepare($updateQuery);
            if (!$updateStmt) {
                die("Failed to prepare statement: " . $mysqli->error);
            }
            $updateStmt->bind_param("si", $value, $user_id);
            $updateStmt->execute();

            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    } else {
        $emailErr = "Missing required data.";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- judul yang terdisplay di bar atas -->
    <title>Toko Online</title>

    <!-- Inisialisasi Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- Inisialisasi Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .edit-section {
            display: none;
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <?php 
    include 'nav.php'; 
    ?>
    
    <div class="container py-5">
        <h1 class="mb-0 bg-dark text-warning p-3">Profile Page</h1>
        <div class="card p-4 rounded-0">
            <?php foreach ($user_data as $field => $value): ?>
                <div class="mb-3">
                    <strong><?php echo ucfirst($field); ?>:</strong>
                    <span class="view-section" id="view-<?php echo $field; ?>">
                        <?php echo htmlspecialchars($value); ?>
                        <button class="btn btn-dark btn-sm text-yellow-400 hover:text-white edit-btn" style="float: right" data-field="<?php echo $field; ?>">Edit</button>
                    </span>
                    <form class="edit-section" id="edit-<?php echo $field; ?>" method="post">
                        <input type="hidden" name="field" value="<?php echo $field; ?>">
                        <input type="text" name="value" class="form-control d-inline-block w-50" value="<?php echo htmlspecialchars($value); ?>">
                        <button type="submit" class="btn btn-success btn-sm">Save</button>
                        <button type="submit" class="btn btn-warning btn-sm cancel-btn">Cancel</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Modal for error messages -->
    <?php if ($emailErr): ?>
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="errorModalLabel">Error</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php echo $emailErr; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script>
        // Trigger the modal if there's an error
        <?php if ($emailErr): ?>
            var myModal = new bootstrap.Modal(document.getElementById('errorModal'));
            myModal.show();
        <?php endif; ?>

        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                const field = this.getAttribute('data-field');
                document.getElementById('view-' + field).style.display = 'none';
                document.getElementById('edit-' + field).style.display = 'block';
            });
        });
        document.querySelectorAll('.cancel-btn').forEach(button => {
            button.addEventListener('click', function () {
                const field = this.getAttribute('data-field');
                document.getElementById('edit-' + field).style.display = 'none';
                document.getElementById('view-' + field).style.display = 'block';
            });
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>