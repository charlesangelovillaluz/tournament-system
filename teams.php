<?php
include 'config.php';

if(isset($_POST['add_team'])){

    $team_name = $_POST['team_name'];
    $coach = $_POST['coach'];

    $sql = "INSERT INTO teams(team_name, coach)
            VALUES('$team_name', '$coach')";

    mysqli_query($conn, $sql);

    header("Location: teams.php");
    exit();
}

if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM teams WHERE id=$id");

    header("Location: teams.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teams</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">

<h1>🏀 Teams Module</h1>

<form method="POST">

<input type="text" name="team_name" class="form-control mb-2" placeholder="Team Name" required>

<input type="text" name="coach" class="form-control mb-2" placeholder="Coach">

<button type="submit" name="add_team" class="btn btn-primary">
Add Team
</button>

</form>

<br>

<table class="table table-bordered table-striped table-hover">

<tr>
    <th>ID</th>
    <th>Team Name</th>
    <th>Coach</th>
    <th>Action</th>
</tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM teams");

while($row = mysqli_fetch_assoc($result)){
?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['team_name']; ?></td>
    <td><?php echo $row['coach']; ?></td>
    <td>
        <a href="teams.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">
            Delete
        </a>
    </td>
</tr>

<?php } ?>

</table>

<a href="dashboard.php">Back to Dashboard</a>

</div>
</body>
</html>