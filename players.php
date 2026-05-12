<?php
include 'config.php';

if(isset($_POST['add_player'])){

    $team_id = $_POST['team_id'];
    $player_name = $_POST['player_name'];
    $position = $_POST['position'];
    $jersey_number = $_POST['jersey_number'];
    $age = $_POST['age'];

    $sql = "INSERT INTO players
    (team_id, player_name, position, jersey_number, age)
    VALUES
    ('$team_id', '$player_name', '$position', '$jersey_number', '$age')";

    mysqli_query($conn, $sql);

    header("Location: players.php");
    exit();
}

if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM players WHERE id=$id");

    header("Location: players.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Players</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">

<h1>👤 Players Module</h1>

<form method="POST">

<select name="team_id" class="form-control mb-2" required>
    <option value="">Select Team</option>
    <?php
    $teams = mysqli_query($conn, "SELECT * FROM teams");
    while($t = mysqli_fetch_assoc($teams)){
        echo "<option value='{$t['id']}'>{$t['team_name']}</option>";
    }
    ?>
</select>

<input type="text" name="player_name" class="form-control mb-2" placeholder="Player Name" required>

<input type="text" name="position" class="form-control mb-2" placeholder="Position">

<input type="number" name="jersey_number" class="form-control mb-2" placeholder="Jersey Number">

<input type="number" name="age" class="form-control mb-2" placeholder="Age">

<button type="submit" name="add_player" class="btn btn-primary">
Add Player
</button>

</form>

<br>

<table class="table table-bordered table-striped table-hover">

<tr>
    <th>ID</th>
    <th>Team</th>
    <th>Player Name</th>
    <th>Position</th>
    <th>Jersey</th>
    <th>Age</th>
    <th>Action</th>
</tr>

<?php
$sql = "SELECT players.*, teams.team_name
        FROM players
        INNER JOIN teams
        ON players.team_id = teams.id";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){
?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['team_name']; ?></td>
    <td><?php echo $row['player_name']; ?></td>
    <td><?php echo $row['position']; ?></td>
    <td><?php echo $row['jersey_number']; ?></td>
    <td><?php echo $row['age']; ?></td>
    <td>
        <a href="players.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">
            Delete
        </a>

        <a href="edit_player.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
            Edit
        </a>
    </td>
</tr>

<?php } ?>

</table>

<a href="dashboard.php">Back to Dashboard</a>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>