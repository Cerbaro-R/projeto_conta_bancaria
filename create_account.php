<?php
include_once 'classes/Database.php';
include_once 'classes/Client.php';
include_once 'classes/Account.php';

$database = new Database();
$db = $database->getConnection();

$client = new Client($db);
$account = new Account($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account->setAccountNumber($_POST['account_number']);
    $account->setBalance($_POST['balance']);
    $account->setClientId($_POST['client_id']);
    if ($account->create()) {
        echo "Account created successfully.";
    } else {
        echo "Unable to create account.";
    }
}

$clients = $client->read();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Bank CRUD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="create_client.php">Create Client</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="create_account.php">Create Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Account List</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h2>Create Account</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="account_number" class="form-label">Account Number:</label>
                <input type="text" class="form-control" name="account_number" required>
            </div>
            <div class="mb-3">
                <label for="balance" class="form-label">Balance:</label>
                <input type="number" class="form-control" step="0.01" name="balance" required>
            </div>
            <div class="mb-3">
                <label for="client_id" class="form-label">Client:</label>
                <select class="form-select" name="client_id" required>
                    <?php while ($row = $clients->fetch(PDO::FETCH_ASSOC)) : ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
