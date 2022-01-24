<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/register.css">
    <link rel="icon" href="public/img/icon.svg">
    <script type="text/javascript" src="./public/js/register.js" defer></script>
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
            <h1><b>Formularz rejestracji</b></h1>
            <input name="email" type="text" placeholder="E-mail" onfocus="this.placeholder = ''"
                   onblur="this.placeholder = 'E-mail'">
            <input name="password" type="password" placeholder="Hasło" onfocus="this.placeholder = ''"
                   onblur="this.placeholder = 'Hasło'">
            <input name="confirm_password" type="password" placeholder="Potwierdź hasło" onfocus="this.placeholder = ''"
                   onblur="this.placeholder = 'Potwierdź hasło'">
            <input name="name" type="text" placeholder="Imię" onfocus="this.placeholder = ''"
                   onblur="this.placeholder = 'Imię'">
            <input name="surname" type="text" placeholder="Nazwisko" onfocus="this.placeholder = ''"
                   onblur="this.placeholder = 'Nazwisko'">
            <div class="messages">
                <?php
                if(isset($messages)){
                    foreach($messages as $message) {
                        echo $message;
                    }
                }
                ?>
            </div>
            <button type="submit" disabled>Zarejestruj się</button>

            <div class="password-validate">
                <h1>Hasło musi zawierać:</h1>
                <p id="letter" class="invalid">Minimum jedną małą literę</p>
                <p id="capital" class="invalid">Minimum jedną dużą literę</p>
                <p id="number" class="invalid">Minimum jedną cyfrę</b></p>
                <p id="length" class="invalid">Minimum 8 znaków</p>
            </div>
        </form>
    </div>


</div>
</body>