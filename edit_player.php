<?php
include 'config.php';

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM players WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update_player'])){

    $team_id = $_POST['team_id'];
    $player_name = $_POST['player_name'];
    $position = $_POST['position'];
    $jersey_number = $_POST['jersey_number'];
    $age = $_POST['age'];

    mysqli_query($conn,
        "UPDATE players SET
        team_id='$team_id',
        player_name='$player_name',
        position='$position',
        jersey_number='$jersey_number',
        age='$age'
        WHERE id=$id"
    );

    header("Location: players.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Player</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5" style="max-width:500px;">

<h2>✏️ Edit Player</h2>

<form method="POST">

<input type="text"
name="player_name"
class="form-control mb-3"
value="<?php echo $row['player_name']; ?>"
required>

<input type="text"
name="position"
class="form-control mb-3"
value="<?php echo $row['position']; ?>">

<input type="number"
name="jersey_number"
class="form-control mb-3"
value="<?php echo $row['jersey_number']; ?>">

<input type="number"
name="age"
class="form-control mb-3"
value="<?php echo $row['age']; ?>">

<button type="submit" name="update_player"
class="btn btn-primary">
Update Player
</button>

<a href="players.php" class="btn btn-secondary">
Back
</a>

</form>

</div>

</body>
</html>
