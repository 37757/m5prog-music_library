<?php 
include_once __DIR__ . '/../views/navigation.php'; 
require_once ('src/database.php'); 
?>
<html>
<head>
    <title>Music Library</title>
    <!-- ik laad op dit moment een simpele bootstrap css library -->
    <!-- zie: https://getbootstrap.com/docs/5.3/getting-started/introduction/ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="/dist/css/main.min.css" rel="stylesheet">
    <script src="/dist/js/main.js" defer></script>
</head>

<body>
    <div class="container">
        <?php
        // BELANGRIJKE FIX: Voeg s.single_id toe aan de SELECT
        $query = "SELECT s.single_id, s.title, s.release_date, s.duration, s.image,
            a.name AS artist, g.name AS genre
        FROM singles s
        JOIN artists a ON s.artist_id = a.artist_id
        JOIN genres g ON s.genre_id = g.genre_id";
        
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>
        
        <div class="row">
            <?php foreach ($result as $single): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">
                            <?php echo ($single['title']); ?>
                        </h4>
                    </div>
                    
                    <div class="card-img">
                        <img class="card-img-top"
                             src="<?php echo ($single['image']); ?>"
                             alt="<?php echo ($single['title']); ?>">
                    </div>
                    
                    <div class="card-body">
                        <p><strong>Artist:</strong> <?php echo ($single['artist']); ?></p>
                        <p><strong>Genre:</strong> <?php echo ($single['genre']); ?></p>
                        <p><strong>Release Date:</strong> <?php echo ($single['release_date']); ?></p>
                        <p><strong>Duration:</strong> <?php echo ($single['duration']); ?></p>
                    </div>
                    
                    <div class="card-footer">
                        <a href="single.php?singleid=<?php echo $single['single_id']; ?>"
                           class="btn btn-sm btn-outline-secondary w-100">Bekijk</a>
                    </div>
                </div>
            </div>
            <?php endforeach;
            
            $request_url = explode('/', $_SERVER['REQUEST_URI']);     
            $mijn_pagina = end($request_url);      
            ?>
        </div>
    
    <!-- ik laad op dit moment een simpele bootstrap JavaScript library -->
    <!-- zie: https://getbootstrap.com/docs/5.3/getting-started/introduction/ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>