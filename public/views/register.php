<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/register.css">
    <link rel="icon" href="public/img/icon.svg">
    <script src="https://kit.fontawesome.com/8ac407c03d.js" crossorigin="anonymous"></script>
    <title>Fished - rejestracja</title>
</head>

<body>
<div class="base-container">
    <nav>
        <div class="return">
            <a href="../">
                <i class="fas fa-long-arrow-alt-left"></i>
            </a>
        </div>
    </nav>

    <div class="register-container">
        <form class="register" action="register" method="POST">
            <h1>Formularz rejestracji</h1>
            <input name="email" type="text" placeholder="E-mail" onfocus="this.placeholder = ''"
                   onblur="this.placeholder = 'E-mail'">
            <input name="password" type="password" placeholder="Hasło" onfocus="this.placeholder = ''"
                   onblur="this.placeholder = 'Hasło'">
            <input name="confirm-password" type="password" placeholder="Potwierdź hasło" onfocus="this.placeholder = ''"
                   onblur="this.placeholder = 'Potwierdź hasło'">
            <input name="name" type="text" placeholder="Imię" onfocus="this.placeholder = ''"
                   onblur="this.placeholder = 'Imię'">
            <input name="surname" type="password" placeholder="Nazwisko" onfocus="this.placeholder = ''"
                   onblur="this.placeholder = 'Nazwisko'">
            <label for="birth-date">Data urodzenia</label>
            <input class="birth-date" name="birth-date" type="date">
            <div class="messages">
                <?php
                if(isset($messages)){
                    foreach($messages as $message) {
                        echo $message;
                    }
                }
                ?>
            </div>
            <button type="submit">Zarejestruj się</button>
        </form>
    </div>
</div>
</body>