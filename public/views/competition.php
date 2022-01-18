<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/competition.css">
    <link rel="stylesheet" type="text/css" href="public/css/map_essentials.css">
    <link rel="icon" href="public/img/icon.svg">
    <script src="https://kit.fontawesome.com/8ac407c03d.js" crossorigin="anonymous"></script>
    <title>Fished - <?= $competition->getName(); ?></title>

    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css' rel='stylesheet' />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js'></script>
    <script src="/public/js/map.js" defer></script>
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
                        <p>zbiórka: <?= date("H:i", strtotime($competition->getStartTime())); ?></p>
                        <p>start: <?= date("H:i", strtotime($competition->getGatheringTime())); ?></p>
                    </div>
                    <div>
                        <p>sektor: B</p>
                        <p>stanowisko: 15</p>
                    </div>
                </div>

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
                        <div>
                            <div>
                                <p>Wiadomość</p>
                                <p>1h ago</p>
                            </div>
                            <div class="photo"></div>
                        </div>
                    </div>
                </div>
    
                <div class="map" id="map"></div>
    
                <div class="icons">
                    <div class="score-list">
                        <a href="results">
                            <i class="fas fa-trophy"></i>
                        </a>
                    </div>
                    
                    <div class="uploaded-photos">
                        <a href="competition_photos">
                            <i class="fas fa-images"></i>
                        </a>
                    </div>
    
                    <div class="attendees">
                        <a href="attendee_list">
                            <i class="fas fa-users"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mobile-view">
                <div class="map-icon">
                    <a href="map_mobile">
                        <i class="fas fa-map"></i>
                    </a>
                </div>

                <div class="return-mobile">
                    <a href="main_page">
                        <i class="fas fa-long-arrow-alt-left"></i>
                    </a>
                </div>
                
                <div class="uploaded-photos-mobile">
                    <a href="competition_photos">
                        <i class="fas fa-images"></i>
                    </a>
                </div>

                <div class="news-mobile">
                    <a href="news_mobile">
                        <i class="fas fa-bell"></i>
                    </a>
                </div>

                <div class="score-list-mobile">
                    <a href="results">
                        <i class="fas fa-trophy"></i>
                    </a>
                </div>

                <div class="attendees-mobile">
                    <a href="attendee_list">
                        <i class="fas fa-users"></i>
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>