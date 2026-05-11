<?php
include 'config.php';

if(isset($_POST['add_match'])){

    $team1_id = $_POST['team1_id'];
    $team2_id = $_POST['team2_id'];
    $score1 = $_POST['score1'];
    $score2 = $_POST['score2'];
    $match_date = $_POST['match_date'];

    if($team1_id == $team2_id){
        echo "<script>alert('Same team not allowed');</script>";
    }
    else {

        if($score1 > $score2){
            $winner_id = $team1_id;
        }
        elseif($score2 > $score1){
            $winner_id = $team2_id;
        }
        else{
            $winner_id = NULL;
        }

        $sql = "INSERT INTO matches
        (team1_id, team2_id, score1, score2, match_date, status, winner_id)
        VALUES
        ('$team1_id', '$team2_id', '$score1', '$score2', '$match_date', 'finished', '$winner_id')";

        mysqli_query($conn, $sql);

        header("Location: matches.php");
        exit();
    }
}

if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM matches WHERE id=$id");

    header("Location: matches.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Matches</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">

<h1>⚔️ Matches Module</h1>

<form method="POST">

<select name="team1_id" class="form-control mb-2" required>
    <option value="">Select Team 1</option>
    <?php
    $teams = mysqli_query($conn, "SELECT * FROM teams");
    while($t = mysqli_fetch_assoc($teams)){
        echo "<option value='{$t['id']}'>{$t['team_name']}</option>";
    }
    ?>
</select>

<select name="team2_id" class="form-control mb-2" required>
    <option value="">Select Team 2</option>
    <?php
    $teams = mysqli_query($conn, "SELECT * FROM teams");
    while($t = mysqli_fetch_assoc($teams)){
        echo "<option value='{$t['id']}'>{$t['team_name']}</option>";
    }
    ?>
</select>

<input type="number" name="score1" class="form-control mb-2" placeholder="Score 1" required>

<input type="number" name="score2" class="form-control mb-2" placeholder="Score 2" required>

<input type="date" name="match_date" class="form-control mb-2" required>

<button type="submit" name="add_match" class="btn btn-primary">
Add Match
</button>

</form>

<br>

<table class="table table-bordered table-striped table-hover">

<tr>
    <th>ID</th>
    <th>Team 1</th>
    <th>Score</th>
    <th>Team 2</th>
    <th>Date</th>
    <th>Winner</th>
    <th>Action</th>
</tr>

<?php
$sql = "SELECT
matches.*,
t1.team_name AS team1_name,
t2.team_name AS team2_name,
w.team_name AS winner_name
FROM matches
INNER JOIN teams t1 ON matches.team1_id = t1.id
INNER JOIN teams t2 ON matches.team2_id = t2.id
LEFT JOIN teams w ON matches.winner_id = w.id
ORDER BY matches.id DESC";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){
?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['team1_name']; ?></td>
    <td><?php echo $row['score1']." - ".$row['score2']; ?></td>
    <td><?php echo $row['team2_name']; ?></td>
    <td><?php echo $row['match_date']; ?></td>
    <td><?php echo $row['winner_name'] ?? 'Draw'; ?></td>
    <td>
        <a href="matches.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">
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