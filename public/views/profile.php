<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/profile.css"> 
    <link rel="icon" href="public/img/icon.svg">
    <script src="https://kit.fontawesome.com/8ac407c03d.js" crossorigin="anonymous"></script>
    <title>Fished - profil</title>
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
                <form action="addPhoto" method="POST" ENCTYPE="multipart/form-data">
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
                <a href="mainpage">
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
                    <img src="public/uploads/photos_on_profile/obraz_2022-01-08_202027.png">
                    <img src="public/uploads/photos_on_profile/obraz_2022-01-08_202027.png">
                    <img src="public/uploads/photos_on_profile/obraz_2022-01-08_202027.png">
                    <img src="public/uploads/photos_on_profile/obraz_2022-01-08_202027.png">

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