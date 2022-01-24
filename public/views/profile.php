<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/profile.css"> 
    <link rel="icon" href="public/img/icon.svg">
    <script src="https://kit.fontawesome.com/8ac407c03d.js" crossorigin="anonymous"></script>
    <title>Fished - profil</title>

    <script src="/public/js/deletePhoto.js" defer></script>
    <script src="/public/js/editForm.js" defer></script>
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
            <!--TODO decrease size of the button-->


            <div class="edit">
                <a href ="?action=editProfile">
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
                <?php if($user->getProfilePhoto() !== null): ?>
                    <img src="/public/uploads/<?= $user->getProfilePhoto()->getName(); ?>">
                <?php else: ?>
                    <div></div>
                <?php endif; ?>
<!--                TODO opening and deleting photo-->
            </div>

            <section class="informations">
                <div>
                    <h2><?= $user->getName().' '.$user->getSurname() ?></h2>

                    <?php if($user->getBirthDate() !== null): ?>
                        <p> <?= date("d.m.Y", strtotime($user->getBirthDate()))."r."; ?> </p>
                    <?php endif; ?>

                    <p><?= $user->getPhoneNumber() ?></p>
                    <p><?= $user->getEmail() ?></h3></p>
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

            <?php if((isset($_GET['selectedPhoto']) && $_GET['selectedPhoto'] !== null)
            || (isset($_GET['action']) && $_GET['action'] === 'editProfile')): ?>
                <div class="image-overlay">
                    <div class="back-profile">
                        <a href="profile">
                            <i class="fas fa-long-arrow-alt-left"></i>
                        </a>
                    </div>

                    <?php if(isset($_GET['selectedPhoto']) && $_GET['selectedPhoto'] !== null): ?>
                    <div class="delete-photo">
                        <a href="deletePhotoOnProfile?selectedPhoto=<?=$_GET['selectedPhoto']?>">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </div>

                    <img src="/public/uploads/<?=$_GET['selectedPhoto']?>"
                         alt="Nie znaleziono zdjęcia :(((((">
                    <?php endif; ?>

                    <?php if(isset($_GET['action']) && $_GET['action'] === 'editProfile'): ?>
                    <div class="settings">
                        <form class="edit_profile" action="edit_profile" method="POST" ENCTYPE="multipart/form-data">
                            <h1><b>Edytuj swoje dane</b></h1>
                            <div>
                                <div class="left-form">
                                    <label for="file">Zdjęcie profilowe:</label>
                                    <input class="profile_photo_class" name="file" type="file">

                                    <label for="name">Imię:</label>
                                    <input name="name" type="text" placeholder="Imię" onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = 'Imię'">

                                    <label for="surname">Nazwisko:</label>
                                    <input name="surname" type="text" placeholder="Nazwisko" onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = 'Nazwisko'">

                                    <label for="birth_date">Data urodzenia:</label>
                                    <input name="birth_date" type="date">

                                    <label for="phone_number">Numer telefonu:</label>
                                    <input name="phone_number" type="text" placeholder="Numer telefonu" onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = 'Numer telefonu'">
                                </div>

                                <div class="right-form">
                                    <label for="email">E-mail:</label>
                                    <input name="email" type="text" placeholder="E-mail" onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = 'E-mail'">

                                    <label for="password">Hasło:</label>
                                    <input name="password" type="password" placeholder="Hasło" onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = 'Hasło'">

                                    <label for="Potwierdź hasło">Potwierdź hasło:</label>
                                    <input name="confirm_password" type="password" placeholder="Potwierdź hasło" onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = 'Potwierdź hasło'">
                                </div>
                            </div>
                            <button type="submit">Zmień dane</button>
                        </form>
                    </div>
                    <?php endif; ?>
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