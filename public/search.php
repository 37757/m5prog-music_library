<?php
define('PAGE_TITLE', 'De zoek pagina');
define('PAGE_ACTIVE', 'search');

// verbind met de database
require_once('src/database.php');

// haal de zoekterm op wanneer deze ingesteld is
$zoekterm = '';
if (isset($_GET['searchquery'])) {
    $zoekterm = $_GET['searchquery'];
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
        <h2>Je zocht op: "<?= htmlspecialchars($zoekterm) ?>"</h2>
        <div class="row">
            <?php
            /* create a query */
            $query = "SELECT s.single_id, s.title, s.release_date, s.duration, s.image,
                             a.name AS artist_name, 
                             g.name AS genre_name
                      FROM singles s
                      LEFT JOIN artists a ON s.artist_id = a.artist_id
                      LEFT JOIN genres g ON s.genre_id = g.genre_id
                      WHERE s.title LIKE ?";

            /* create a prepared statement */
            $stmt = $connection->prepare($query);

            /* Bind the search term */
            $parameter = '%' . $zoekterm . '%';
            $stmt->bind_param('s', $parameter);

            /* execute query */
            $stmt->execute();

            /* get result */
            $result = $stmt->get_result();

            /* display results */
            if (mysqli_num_rows($result) > 0) {
                while ($single = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h4 class="my-0"><?php echo htmlspecialchars($single['title']); ?></h4>
                            </div>
                            <div class="card-img">
                                <img class="card-img-top" 
                                     src="<?php echo htmlspecialchars($single['image']); ?>"
                                     alt="<?php echo htmlspecialchars($single['title']); ?>">
                            </div>
                            <div class="card-body">
                                <p><strong>Artist:</strong> <?php echo htmlspecialchars($single['artist_name']); ?></p>
                                <p><strong>Genre:</strong> <?php echo htmlspecialchars($single['genre_name']); ?></p>
                                <p><strong>Release Date:</strong> <?php echo htmlspecialchars($single['release_date']); ?></p>
                                <p><strong>Duration:</strong> <?php echo htmlspecialchars($single['duration']); ?></p>
                            </div>
                            <div class="card-footer">
                                <a href="single.php?singleid=<?php echo $single['single_id']; ?>" 
                                   class="btn btn-sm btn-outline-secondary w-100">Bekijk</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="col-12"><p class="alert alert-info">Geen resultaten gevonden voor "' . htmlspecialchars($zoekterm) . '"</p></div>';
            }
            
            /* close statement */
            $stmt->close();
            ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="/dist/js/main.js"></script>
</body>
</html>