<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/profile.css"> 
    <link rel="icon" href="public/img/icon.svg">
    <script src="https://kit.fontawesome.com/8ac407c03d.js" crossorigin="anonymous"></script>
    <title>Fished - profil</title>

    <script src="/public/js/deletePhoto.js" defer></script>
</head>

<body>
    <div class="base-container">
        <nav>
            <div class="messages">
                <?php
                if(isset($messages)){
                    foreach($messages as $message) {
                        echo $message;
                    }
                }
                ?>
            </div>

            <div class="add-photo">
                <form action="addPhotoOnProfile" method="POST" ENCTYPE="multipart/form-data">
                    <input type="file" name="file" id="upload-button" onchange="this.form.submit()" hidden/>
                    <label for="upload-button">
                        <i class="fas fa-plus"></i>
                    </label>
                </form>
            </div>

            <div class="edit">
                <a href ="#">
                    <i class="fas fa-edit"></i>
                </a>
            </div>

            <div class="return">
                <a href="main_page">
                    <i class="fas fa-long-arrow-alt-left"></i>
                </a>
            </div>
        </nav>

        <main>
            <div class="user-photo">
                <div></div>
            </div>

            <section class="informations">
                <div>
                    <h2><?= $name.' '.$surname ?></h2>
                    <h3><?= $birth_date ?></h3>
                    <h3/><?= $phone_number ?></h3></h3>
                    <p><?= $email ?></h3></p>
                </div>
            </section>

            <section class="gallery"> 
                <section class="gallery-inner">
                    <?php foreach($photos as $photo): ?>
                    <a href="?selectedPhoto=<?=$photo->getName()?>">
                        <img src="/public/uploads/<?=$photo->getName()?>" alt="<?=$photo->getName()?>">
                    </a>
                    <?php endforeach; ?>
                </section>
            </section>

            <section class="achievements-section">
                <section class="achievements-inner">
                    <div>
                        <p>I miejsce</p>
                        <p>Puchar Kocinki</p>
                        <div class = "cup-photo"></div>
                    </div>
                </section>
            </section>

            <?php if(isset($_GET['selectedPhoto']) && $_GET['selectedPhoto'] !== null): ?>
                <div class="image-overlay">
                    <div class="back-profile">
                        <a href="profile">
                            <i class="fas fa-long-arrow-alt-left"></i>
                        </a>
                    </div>

                    <div class="delete-photo">
                        <a href="deletePhotoOnProfile?selectedPhoto=<?=$_GET['selectedPhoto']?>">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </div>

                    <img src="/public/uploads/<?=$_GET['selectedPhoto']?>"
                         alt="<?=$_GET['selectedPhoto']?>">
                </div>
            <?php endif; ?>

            <div class="mobile-icons">
                <a href="achievements_mobile">
                    <i class="fas fa-trophy"></i>
                    <h2>Osiągnięcia</h2>
                </a>

                <a href="photos_mobile">
                    <i class="fas fa-images"></i>
                    <h2>Zdjęcia</h2>
                </a>

                <a href="#">
                    <i class="fas fa-edit"></i>
                    <h2>Edytuj profil</h2>
                </a>
            </div>
        </main>
    </div>
</body>