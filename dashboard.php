<?php
include 'config.php';
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$teams = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM teams"));
$players = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM players"));
$matches = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM matches"));

/* SAFE TOP TEAM */
$top_team = mysqli_query($conn,"
SELECT teams.team_name, COUNT(matches.id) AS wins
FROM teams
LEFT JOIN matches ON matches.winner_id = teams.id
GROUP BY teams.id
ORDER BY wins DESC
LIMIT 1
");

$top = mysqli_fetch_assoc($top_team);

/* RECENT MATCH */
$recent_match = mysqli_query($conn,"
SELECT * FROM matches ORDER BY id DESC LIMIT 1
");

$recent = mysqli_fetch_assoc($recent_match);
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container">

<h1>🏆 Dashboard</h1>

<div class="row mt-4">

<div class="col-md-3">
<div class="card bg-primary text-white"><div class="card-body">
<h4><?php echo $teams; ?></h4><p>Teams</p>
</div></div></div>

<div class="col-md-3">
<div class="card bg-success text-white"><div class="card-body">
<h4><?php echo $players; ?></h4><p>Players</p>
</div></div></div>

<div class="col-md-3">
<div class="card bg-danger text-white"><div class="card-body">
<h4><?php echo $matches; ?></h4><p>Matches</p>
</div></div></div>

<div class="col-md-3">
<div class="card bg-dark text-white"><div class="card-body">
<h4><?php echo $top['team_name'] ?? 'N/A'; ?></h4><p>Top Team</p>
</div></div></div>

</div>

<div class="card mt-4">
<div class="card-body">

<h5>Recent Match</h5>

<?php if($recent){ ?>
<p>
Team <?php echo $recent['team1_id']; ?>
vs
Team <?php echo $recent['team2_id']; ?>
</p>
<?php } else { ?>
<p>No matches yet</p>
<?php } ?>

</div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>