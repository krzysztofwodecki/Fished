<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/results.css"> 
    <link rel="icon" href="public/img/icon.svg">
    <script src="https://kit.fontawesome.com/8ac407c03d.js" crossorigin="anonymous"></script>
    <title>Fished - wyniki</title>
</head>

<body>
    <div class="base-container">
        <nav>
            <div class="return">
                <a href="competition?id=<?= $id ?>   ">
                    <i class="fas fa-long-arrow-alt-left"></i>
                </a>
            </div>
        </nav>

        <main>
            <div class="result-list">
                <?php foreach ($scores as $score): ?>
                <div>
                    <p><?=array_search($score, $scores) + 1;?>.</p>
                    <p><?=$score->getName()." ".$score->getSurname()?></p>
                    <p><?=$score->getScore()?> punktów</p>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</body>