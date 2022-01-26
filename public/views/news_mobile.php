<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/mobile-gallery.css"> 
    <link rel="icon" href="public/img/icon.svg">
    <script src="https://kit.fontawesome.com/8ac407c03d.js" crossorigin="anonymous"></script>
    <title>Fished - wiadomości</title>
</head>

<body>
    <div class = "base-container">
        <nav>
            <div class="return">
                <a href="competition?id=<?= $_GET['id'] ?>">
                    <i class="fas fa-long-arrow-alt-left"></i>
                </a>
            </div>
        </nav>

        <main>
            <div class="news">
                <?php foreach($announcements as $announcement): ?>
                <div>
                    <?php if($announcement->getCoverPhoto()->getName() !== null): ?>
                        <img class="news-photo" src="/public/uploads/<?=$announcement->getCoverPhoto()->getName()?>"
                             alt="<?= $announcement->getCoverPhoto()->getName()?>"/>
                    <?php endif; ?>
                    <h3><?= $announcement->getTitle() ?></h3>
                    <p><?= date("d.m.Y G:i", strtotime($announcement->getDate())) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</body>