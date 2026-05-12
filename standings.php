<?php
include 'config.php';

/* RESET standings table */
mysqli_query($conn, "TRUNCATE standings");

/* Get all teams */
$teams = mysqli_query($conn, "SELECT * FROM teams");

while($team = mysqli_fetch_assoc($teams)){

    $team_id = $team['id'];

    /* Count Wins */
    $wins_query = mysqli_query($conn,
        "SELECT COUNT(*) AS total_wins
         FROM matches
         WHERE winner_id = '$team_id'"
    );

    $wins = mysqli_fetch_assoc($wins_query)['total_wins'];

    /* Count Losses */
    $losses_query = mysqli_query($conn,
        "SELECT COUNT(*) AS total_losses
         FROM matches
         WHERE (team1_id = '$team_id'
         OR team2_id = '$team_id')
         AND winner_id != '$team_id'
         AND winner_id IS NOT NULL"
    );

    $losses = mysqli_fetch_assoc($losses_query)['total_losses'];

    /* Played */
    $played = $wins + $losses;

    /* Insert standings */
    mysqli_query($conn,
        "INSERT INTO standings
        (team_id, wins, losses, points, played)
        VALUES
        ('$team_id', '$wins', '$losses', '$wins', '$played')"
    );
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Standings</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5">
<h1>🏅 Tournament Standings</h1>

<table class="table table-bordered table-striped table-hover">

<tr>
    <th>Rank</th>
    <th>Team</th>
    <th>Wins</th>
    <th>Losses</th>
    <th>Played</th>
    <th>Points</th>
</tr>

<?php

$sql = "SELECT standings.*,
teams.team_name

FROM standings
INNER JOIN teams
ON standings.team_id = teams.id
ORDER BY wins DESC, points DESC";
$result = mysqli_query($conn, $sql);
$rank = 1;
while($row = mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $rank++; ?></td>
<td><?php echo $row['team_name']; ?></td>
<td><?php echo $row['wins']; ?></td>
<td><?php echo $row['losses']; ?></td>
<td><?php echo $row['played']; ?></td>
<td><?php echo $row['points']; ?></td>
</tr>

<?php } ?>

</table>

<br>

<a href="dashboard.php">Back to Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>