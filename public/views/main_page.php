<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/mainpage.css">
    <link rel="stylesheet" type="text/css" href="public/css/mainpage_overlay.css">
    <link rel="stylesheet" type="text/css" href="public/css/map_essentials.css">
    <link rel="icon" href="public/img/icon.svg">
    <script src="https://kit.fontawesome.com/8ac407c03d.js" crossorigin="anonymous"></script>

    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css' rel='stylesheet' />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js'></script>
    <script src="/public/js/map.js" defer></script>

    <title>Fished - strona główna</title>
</head>

<body>
    <div class="base-container">
        <nav> 
            <div class="add-join-competition">
                <a href="?action=addCompetition">
                    <i class="fas fa-plus"></i>
                </a>
            </div>

            <div class ="user-profile">
                <a href="profile">
                    <i class="fas fa-user"></i>
                </a>
            </div>

            <div class ="settings">
                <a href="?action=options">
                    <i class="fas fa-cog"></i>
                </a>
            </div>

            <div class="logout">
                <a href="logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </nav>

        <main>
            <section>
                <?php foreach ($competitions as $competition): ?>
                <a class="competition"
                   onclick="<?php
                   $code_once_coded = base64_encode($competition->getCode());
                   $id = base64_encode($code_once_coded).COMP_HASH.$code_once_coded;
                   $id = base64_encode($id);
                   ?>"
                   href="competition?id=<?= $id; ?>">
                    <div class="inner-competition">
                        <h2><?= $competition->getName() ?></h2>
                        <p><?= date("d.m.Y", strtotime($competition->getDate()))."r."; ?></p>
                        <p><?= $competition->getFishery()->getTown() ?></p>
                    </div>
                </a>
                <?php endforeach; ?>
            </section>
        </main>

        <?php if(isset($_GET['action']) && $_GET['action'] !== null): ?>
        <div class="overlay">
            <div class="back">
                <a href="<?php if($_GET['action']=="addCompetition" || $_GET['action']=="options")
                                echo "main_page";
                                else echo "main_page?action=addCompetition"?>">
                    <i class="fas fa-long-arrow-alt-left"></i>
                </a>
            </div>

            <?php if($_GET['action']=="addCompetition"): ?>
            <form class="add-form" action="add_competition" method="POST">
                <h1>Formularz dodawania zawodów</h1>

                <div class="left-form">
                    <label for="name">Nazwa zawodów:</label>
                    <input name="name" type="text" placeholder='Nazwa zawodów' onfocus="this.placeholder = ''"
                           onblur="this.placeholder = 'Nazwa zawodów'">

                    <label for="date">Data zawodów:</label>
                    <input name="date" type="date">

                    <label for="gathering_time">Czas zbiórki:</label>
                    <input name="gathering_time" type="time">

                    <label for="start_time">Czas startu:</label>
                    <input name="start_time" type="time">

                    <label for="end_time">Czas zakończenia:</label>
                    <input name="end_time" type="time">

                    <label for="sites">Liczba miejsc na zawodach:</label>
                    <input name="sites" type="number" placeholder="Liczba miejsc">

                    <input name="fishery" type="text" hidden>

                    <button class="inner-buttons" type="submit">Dodaj zawody</button>
                </div>

                <div class="right-form">
                    <a href="?action=addFishery">
                        <button class="inner-buttons" type="button">Dodaj łowisko</button>
                    </a>

                    <div id="map"></div>
                </div>
            </form>
            <?php endif; ?>

            <?php if($_GET['action']=="addFishery"): ?>
            <form class="add-form" action="add_fishery" method="POST">
                <h1>Formularz dodawania zawodów</h1>

                <div class="left-form">
                    <label for="name">Nazwa łowiska:</label>
                    <input name="name" type="text" placeholder='Nazwa łowiska' onfocus="this.placeholder = ''"
                           onblur="this.placeholder = 'Nazwa łowiska'">

                    <label for="address">Adres łowiska:</label>
                    <input name="address" type="text" placeholder='Adres łowiska' onfocus="this.placeholder = ''"
                           onblur="this.placeholder = 'Adres łowiska'">

                    <label for="town">Miejscowość:</label>
                    <input name="town" type="text" placeholder='Miejscowość' onfocus="this.placeholder = ''"
                           onblur="this.placeholder = 'Miejscowość'">

                    <label for="postal">Kod pocztowy:</label>
                    <input name="postal" type="text" placeholder='Kod pocztowy' onfocus="this.placeholder = ''"
                           onblur="this.placeholder = 'Kod pocztowy'">

                    <input name="latitude" type="text" hidden>
                    <input name="longitude" type="text" hidden>

                    <button class="inner-buttons" type="submit">Dodaj łowisko</button>
                </div>

                <div class="right-form">
                    <div id="map"></div>
                </div>
            </form>
            <?php endif; ?>

            <?php if($_GET['action']=="options"): ?>
            <?php endif; ?>

        </div>
        <?php endif; ?>

    </div>
</body>