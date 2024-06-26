<?php
include_once 'classes/Database.php';
include_once 'classes/Client.php';
include_once 'classes/Account.php';

$database = new Database();
$db = $database->getConnection();

$client = new Client($db);
$account = new Account($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_account'])) {
        $account->setAccountNumber($_POST['account_number']);
        $account->setBalance($_POST['balance']);
        $account->setClientId($_POST['client_id']);
        $account->create();
    } elseif (isset($_POST['update_account'])) {
        $account->setId($_POST['id']);
        $account->setAccountNumber($_POST['account_number']);
        $account->setBalance($_POST['balance']);
        $account->setClientId($_POST['client_id']);
        $account->update();
    } elseif (isset($_POST['delete_account'])) {
        $account->setId($_POST['id']);
        $account->delete();
    } elseif (isset($_POST['deposit'])) {
        $account->setId($_POST['id']);
        $account->setBalance($account->getBalance() + $_POST['amount']);
        $account->deposit($_POST['amount']);
    } elseif (isset($_POST['withdraw'])) {
        $account->setId($_POST['id']);
        $account->withdraw($_POST['amount']);
    }
}

$clients = $client->read();
$accounts = $account->read();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Account CRUD</title>
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
                        <a class="nav-link" href="create_account.php">Create Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Account List</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h2>Account List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Account Number</th>
                    <th>Balance</th>
                    <th>Client Name</th>
                    <th>Client Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $accounts->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['account_number']; ?></td>
                        <td><?php echo $row['balance']; ?></td>
                        <td><?php echo $row['client_name']; ?></td>
                        <td><?php echo $row['client_email']; ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="amount" step="0.01" placeholder="Amount" required>
                                    <button class="btn btn-success" type="submit" name="deposit">Deposit</button>
                                    <button class="btn btn-danger" type="submit" name="withdraw">Withdraw</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
