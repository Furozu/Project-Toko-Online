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
    <title>Edit <?php echo ucfirst($field); ?></title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <!-- Navbar -->
    <?php include 'nav.php'; ?>
    <!-- Main Content -->
    <section class="container py-5" style="margin-top: 80px;">
        <h1 class="text-center text-2xl font-bold mb-4 text-gray-800">Edit <?php echo ucfirst($field); ?></h1>
        <div class="card p-4 shadow border-0">
            <form method="POST" class="mx-auto" style="max-width: 500px;">
                <div class="mb-4">
                    <label for="new_value" class="form-label text-gray-700 font-semibold">New <?php echo ucfirst($field); ?>:</label>
                    <input type="<?php echo $field === 'password' ? 'password' : 'text'; ?>" 
                           name="new_value" 
                           id="new_value" 
                           class="form-control" 
                           placeholder="Enter new <?php echo $field; ?>"
                           required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-outline-warning text-dark fw-semibold px-4">Save</button>
                    <a href="profil.php" class="btn btn-outline-secondary px-4">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</body>

</html>
