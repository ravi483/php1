<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "myshop";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Initialize variables
$name = "";
$email = "";
$phone = "";
$address = "";
$errorMessage = "";
$successMessage = "";

// Get client ID
$id = $_GET['id'] ?? null;
if (!$id) {
    header("location: /myshop/index.php");
    exit;
}

// Fetch client details
$sql = "SELECT * FROM clients WHERE id = $id";
$result = $connection->query($sql);
$client = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    do {
        if (empty($name) || empty($email) || empty($phone) || empty($address)) {
            $errorMessage = "All fields are required";
            break;
        }

        // Update client data in the database
        $sql = "UPDATE clients SET name = '$name', email = '$email', phone = '$phone', address = '$address' WHERE id = $id";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $successMessage = "Client updated successfully";
        header("location: /myshop/index.php");
        exit;
    } while (false);
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <h2>Edit Client</h2>
        <?php if ($errorMessage): ?>
            <div class="alert alert-warning"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
        <form method="post">
            <!-- Form fields for name, email, phone, and address (pre-filled) -->
            <input type="text" name="name" value="<?php echo $client['name']; ?>" class="form-control" placeholder="Name">
            <input type="email" name="email" value="<?php echo $client['email']; ?>" class="form-control" placeholder="Email">
            <input type="text" name="phone" value="<?php echo $client['phone']; ?>" class="form-control" placeholder="Phone">
            <input type="text" name="address" value="<?php echo $client['address']; ?>" class="form-control" placeholder="Address">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="/myshop/index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>