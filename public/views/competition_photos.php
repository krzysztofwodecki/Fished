<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/competition-photos.css"> 
    <link rel="stylesheet" type="text/css" href="public/css/overlay.css">
    <link rel="icon" href="public/img/icon.svg">
    <script src="https://kit.fontawesome.com/8ac407c03d.js" crossorigin="anonymous"></script>
    <title>Fished - zdjęcia z zawodów</title>

    <script type="text/javascript" src="/public/js/getScoreDetails.js" defer></script>
</head>

<body>
    <div class="base-container">
        <nav>
            <div class="return">
                <a href="competition?id=<?= $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id'] ?>">
                    <i class="fas fa-long-arrow-alt-left"></i>
                </a>
            </div>
        </nav>

        <main>
            <div class="photos">

                <?php if(!$isJudge && $takesPlace): ?>

<!--                TODO active only between start and end-->

                <div class="add-photo">
                    <form action="addCompetitionPhoto?id=<?=
                    $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id'] ?>"
                          method="POST" ENCTYPE="multipart/form-data">

                        <input type="file" name="file" id="upload-button" onchange="this.form.submit()" hidden/>

                        <input type="text" name="id" value="<?=
                        $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id'] ?>" hidden/>

                        <label for="upload-button">
                            <i class="fas fa-plus"></i>
                        </label>
                    </form>
                </div>
                <?php endif; ?>

                <?php foreach ($photos as $photo): ?>
                <a href="competition_photos?id=<?= $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id']
                ?>&photo=<?= $photo->getName() ?>">
                    <img src="/public/uploads/<?=$photo->getName()?>" alt="<?=$photo->getName()?>">
                </a>
                <?php endforeach; ?>
            </div>
        </main>

        <?php if(isset($_GET['photo']) && $_GET['photo'] !== null): ?>
        <div class="overlay" id="comp">
            <div class="back-photo">
                <a href="competition_photos?id=<?= $_GET['id'] ?>">
                    <i class="fas fa-long-arrow-alt-left"></i>
                </a>
            </div>

            <img src="/public/uploads/<?=$_GET['photo']?>"
                 alt="Nie znaleziono zdjęcia :(((((">
        </div>

        <div class="score">
            <?php if($isJudge): ?>
            <form class="grade-photo" action="grade_photo" method="POST">
                <h2>Oceń rybę</h2>

                <input name="score" type="number" placeholder='Ocena ryby' onfocus="this.placeholder = ''"
                       onblur="this.placeholder = 'Ocena ryby'">
<!--todo validate-->
                <label for="argumentation">Argumentacja oceny:</label>
                <textarea name="argumentation" rows="10"> </textarea>

                <input name="photo" type="text" value="<?= $_GET['photo'] ?>" hidden>

                <input type="text" name="id" value="<?=
                $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET['id'] : $_POST['id'] ?>" hidden/>

                <button class="inner-buttons" type="submit">Oceń</button>
            </form>
            <?php else: ?>
            <div class="grade-container">
                <h1>Ocena ryby:</h1>
                <h2 id="grade"></h2>
                <h2 id="argHeader" class="hidden">Argumentacja:</h2>
                <p id="argumentation" class="hidden"></p>
            </div>
            <?php endif; ?>
        </div>

        <?php endif; ?>

    </div>
</body>