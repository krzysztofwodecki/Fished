<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/competition-photos.css"> 
    <link rel="icon" href="public/img/icon.svg">
    <script src="https://kit.fontawesome.com/8ac407c03d.js" crossorigin="anonymous"></script>
    <title>Fished - zdjęcia z zawodów</title>
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
                <div class="add-photo">
                    <form action="addCompetitionPhoto?id<?=
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
                <?php foreach ($photos as $photo): ?>
                <a href="#">
                    <img src="/public/uploads/<?=$photo->getName()?>" alt="<?=$photo->getName()?>">
                </a>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</body>