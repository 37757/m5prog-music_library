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
        <header>
            Header information
        </header>

        <div>
            <?php
            $query = 'SELECT * FROM Songs ORDER BY title';
            $stmt = $connection->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($single = mysqli_fetch_assoc($result)) {
                print_r($single);
            }
            ?>

        </div>

        <div class="album py-5 bg-light">
            <div class="row">
                Content of this project index
            </div>
        </div>
    </div>
    <!-- ik laad op dit moment een simpele bootstrap JavaScript library -->
    <!-- zie: https://getbootstrap.com/docs/5.3/getting-started/introduction/ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>