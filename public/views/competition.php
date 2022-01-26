<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/competition.css">
    <link rel="stylesheet" type="text/css" href="public/css/overlay.css">
    <link rel="stylesheet" type="text/css" href="public/css/competition-overlay.css">
    <link rel="stylesheet" type="text/css" href="public/css/map_essentials.css">
    <link rel="icon" href="public/img/icon.svg">
    <script src="https://kit.fontawesome.com/8ac407c03d.js" crossorigin="anonymous"></script>
    <title>Fished - <?= $competition->getName(); ?></title>

    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css' rel='stylesheet' />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js'></script>
    <script src="/public/js/mapCompetition.js" defer></script>
    <script src="/public/js/getAnnouncement.js" defer></script>
</head>

<body>
    <div class="base-container">
        <nav>
            <div class ="return">
                <a href="main_page">
                    <i class="fas fa-long-arrow-alt-left"></i>
                </a>
            </div>
        </nav>

        <main>
            <div class="informations">
                <h1><?= $competition->getName(); ?></h1>
                <h3><?= date("d.m.Y", strtotime($competition->getDate()))."r."; ?></h3>
                <h3><?= $competition->getFishery()->getTown(); ?></h3>
                <div>
                    <div>
                        <p>Zbiórka: <?= date("H:i", strtotime($competition->getStartTime())); ?></p>
                        <p>Start: <?= date("H:i", strtotime($competition->getGatheringTime())); ?></p>
                    </div>
                    <div>
                        <p>Stanowisko: <?= $position ?></p>
                    </div>
                </div>

                <?php if($creator): ?>
                    <h3>Kod: <?= $competition->getCode() ?></h3>
                <?php endif; ?>

                <div class="fishery-info" style="display: none">
                    <div id="name"><?= $competition->getFishery()->getName(); ?></div>
                    <div id="address"><?= $competition->getFishery()->getAddress(); ?></div>
                    <div id="town"><?= $competition->getFishery()->getTown(); ?></div>
                    <div id="postal"><?= $competition->getFishery()->getPostal(); ?></div>
                    <div id="longitude"><?= $competition->getFishery()->getLongitude(); ?></div>
                    <div id="latitude"><?= $competition->getFishery()->getLatitude(); ?></div>
                </div>
            </div>

            <div class="desktop-view">
                <div class="news">
                    <div class="inner-news">
                        <?php if($creator): ?>
                        <a href="?id=<?= $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id'] ?>&action=addAnnouncement"
                           class="add-announcement">
                            <h2>Dodaj ogłoszenie</h2>
                            <i class="fas fa-plus"></i>
                        </a>
                        <?php endif; ?>

                        <?php foreach($announcements as $announcement): ?>
                        <a
                                href="?id=<?= $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id']
                        ?>&announcementTitle=<?= $announcement->getTitle()
                        ?>&announcementDate=<?= $announcement->getDate()
                                ?>">
                            <div>
                                <h2><?= $announcement->getTitle() ?></h2>
                                <p><?= date("d.m.Y G:i", strtotime($announcement->getDate())) ?></p>
                            </div>
                            <?php if($announcement->getCoverPhoto()->getName() !== null): ?>
                            <img src="/public/uploads/<?=$announcement->getCoverPhoto()->getName()?>"
                                 alt="<?= $announcement->getCoverPhoto()->getName()?>"/>
                            <?php endif; ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
    
                <div class="map" id="map"></div>
    
                <div class="icons">
                    <div class="score-list">
                        <a href="results?id=<?= $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id'] ?>">
                            <i class="fas fa-trophy"></i>
                        </a>
                    </div>
                    
                    <div class="uploaded-photos">
                        <a href="competition_photos?id=<?= $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id'] ?>">
                            <i class="fas fa-images"></i>
                        </a>
                    </div>
    
                    <div class="attendees">
                        <a href="attendee_list?id=<?= $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id'] ?>">
                            <i class="fas fa-users"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mobile-view">
                <div class="map-icon">
                    <a href="map_mobile?id=<?= $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id'] ?>">
                        <i class="fas fa-map"></i>
                    </a>
                </div>

                <div class="return-mobile">
                    <a href="main_page">
                        <i class="fas fa-long-arrow-alt-left"></i>
                    </a>
                </div>
                
                <div class="uploaded-photos-mobile">
                    <a href="competition_photos?id=<?= $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id'] ?>">
                        <i class="fas fa-images"></i>
                    </a>
                </div>

                <div class="news-mobile">
                    <a href="news_mobile?id=<?= $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id'] ?>">
                        <i class="fas fa-bell"></i>
                    </a>
                </div>

                <div class="score-list-mobile">
                    <a href="results?id=<?= $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id'] ?>">
                        <i class="fas fa-trophy"></i>
                    </a>
                </div>

                <div class="attendees-mobile">
                    <a href="attendee_list?id=<?= $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id'] ?>">
                        <i class="fas fa-users"></i>
                    </a>
                </div>
            </div>

            <?php if((isset($_GET['action']) && $_GET['action'] !== null)
                || (isset($_GET['announcementTitle']) && $_GET['announcementTitle'] !== null)): ?>
            <div class="overlay">
                <div class="back">
                    <a href="competition?id=<?= $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id'] ?>">
                        <i class="fas fa-long-arrow-alt-left"></i>
                    </a>
                </div>

                <?php if(isset($_GET['action']) && $_GET['action'] !== null): ?>
                <form class="add-form" action="add_announcement?id=<?=
                $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id'] ?>"
                      method="POST" ENCTYPE="multipart/form-data">
                    <h1>Formularz dodawania ogłoszenia</h1>

                    <label for="title">Tytuł ogłoszenia:</label>
                    <input name="title" type="text" placeholder='Tytuł ogłoszenia' onfocus="this.placeholder = ''"
                           onblur="this.placeholder = 'Tytuł ogłoszenia'">

                    <label for="cover-photo">Zdjęcie tytułowe:</label>
                    <input class="file" name="cover-photo" type="file">

                    <label for="content">Zawartość ogłoszenia:</label>
                    <textarea name="content"> </textarea>

                    <label for="attachment">Załącznik:</label>
                    <input class="file" name="attachment" type="file">

                    <input type="text" name="id" value="<?=
                    $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id'] ?>" hidden/>
                    <button class="inner-buttons" type="submit">Dodaj ogłoszenie</button>
                </form>
                <?php endif; ?>

                <?php if(isset($_GET['announcementTitle']) && $_GET['announcementTitle'] !== null): ?>
                    <div class="announcement">
                        <div>
                            <img id="image">
                            <p><?=date("d.m.Y G:i", strtotime($_GET['announcementDate']))?></p>
                            <h1><?=$_GET['announcementTitle']?></h1>
                            <p id="content"></p>
                            <label for="attachment" id="label" class="hidden">Załącznik:</label>
                            <a id="attachment" href="" download></a>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
            <?php endif; ?>
        </main>
    </div>
</body>