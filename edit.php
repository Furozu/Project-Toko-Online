<?php
session_start();
require_once 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$allowed_fields = ['username', 'password', 'user_telp', 'email', 'alamat'];
$field = isset($_GET['field']) ? $_GET['field'] : '';

if (!in_array($field, $allowed_fields)) {
    die("Invalid field specified.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_value = trim($_POST['new_value']);

    if ($field === 'password') {
        $new_value = password_hash($new_value, PASSWORD_DEFAULT);
    }

    $stmt = $mysqli->prepare("UPDATE Users SET $field = ? WHERE user_id = ?");
    $stmt->bind_param("si", $new_value, $user_id);

    if ($stmt->execute()) {
        header("Location: profil.php");
        exit;
    } else {
        echo "Error updating $field. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit <?php echo ucfirst($field); ?></h2>
        <form method="POST" class="card p-4 shadow-sm">
            <div class="mb-3">
                <label for="new_value" class="form-label">Enter New <?php echo ucfirst($field); ?>:</label>
                <input type="<?php echo $field === 'password' ? 'password' : 'text'; ?>" 
                       name="new_value" 
                       class="form-control" 
                       id="new_value" 
                       required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="profil.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>