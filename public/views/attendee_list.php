<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/attendee-list.css"> 
    <link rel="icon" href="public/img/icon.svg">
    <script src="https://kit.fontawesome.com/8ac407c03d.js" crossorigin="anonymous"></script>
    <title>Fished - lista uczestników</title>
</head>

<body>
    <div class="base-container">
        <nav>
            <div class ="return">
                <a href="competition?id=<?= $_GET['id'] ?>">
                    <i class="fas fa-long-arrow-alt-left"></i>
                </a>
            </div>
        </nav>
    
        <main>
            <div class="attendee-list">
                <?php foreach($attendee as $attendant): ?>
                <div>
                    <div class="attendant-photo">
                        <?php if($attendant->getProfilePhoto() !== null): ?>
                            <img src="/public/uploads/<?= $attendant->getProfilePhoto()->getName(); ?>">
                        <?php else: ?>
                            <div></div>
                        <?php endif; ?>
                    </div>
                    <div class="informations">
                        <h1><?= $attendant->getName().' '.$attendant->getSurname() ?></h1>
                        <h3>stanowisko: <?= $attendant->getPosition();?> </h3>
                    </div>
                    <div class="more">
                        <a href="profile?id=<?= $_GET['id'] ?>&user=<?=$attendant->getEmail()?>">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</body>