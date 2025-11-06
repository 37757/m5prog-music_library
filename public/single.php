<?php
define('PAGE_TITLE', 'Single Details');
define('PAGE_ACTIVE', 'singles');

// verbind met de database
require_once('src/database.php');

// Haal single_id op uit URL
$single_id = isset($_GET['singleid']) ? intval($_GET['singleid']) : 0;

if ($single_id === 0) {
    header('Location: index.php');
    exit;
}

include('../views/navigation.php');
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= PAGE_TITLE ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="/dist/css/main.min.css" rel="stylesheet">
</head>
<body>
    <main class="container my-5">
        <?php
        /* Query voor één specifieke single */
        $query = "SELECT s.single_id, s.title, s.release_date, s.duration, s.image,
                         a.name AS artist_name, 
                         g.name AS genre_name
                  FROM singles s
                  LEFT JOIN artists a ON s.artist_id = a.artist_id
                  LEFT JOIN genres g ON s.genre_id = g.genre_id
                  WHERE s.single_id = ?";

        $stmt = $connection->prepare($query);
        $stmt->bind_param('i', $single_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($single = mysqli_fetch_assoc($result)) {
            ?>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="my-0"><?php echo htmlspecialchars($single['title']); ?></h2>
                        </div>
                        <div class="card-img">
                            <img class="card-img-top img-fluid" 
                                 src="<?php echo htmlspecialchars($single['image']); ?>"
                                 alt="<?php echo htmlspecialchars($single['title']); ?>">
                        </div>
                        <div class="card-body">
                            <h5>Details</h5>
                            <p><strong>Artist:</strong> <?php echo htmlspecialchars($single['artist_name']); ?></p>
                            <p><strong>Genre:</strong> <?php echo htmlspecialchars($single['genre_name']); ?></p>
                            <p><strong>Release Date:</strong> <?php echo htmlspecialchars($single['release_date']); ?></p>
                            <p><strong>Duration:</strong> <?php echo htmlspecialchars($single['duration']); ?></p>
                        </div>
                        <div class="card-footer">
                            <a href="index.php" class="btn btn-secondary">Terug naar overzicht</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            echo '<div class="alert alert-warning">Single niet gevonden.</div>';
            echo '<a href="index.php" class="btn btn-secondary">Terug naar overzicht</a>';
        }
        
        $stmt->close();
        ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="/dist/js/main.js"></script>
</body>
</html>