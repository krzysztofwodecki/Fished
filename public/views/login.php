<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/login.css"> 
    <link rel="icon" href="public/img/icon.svg">
    <title>Fished - strona logowania</title>

</head>

<body>
    <div class="base-container">
        <div class="logo">
            <a href="../">
                <img src="public/img/logo.svg">
            </a>
        </div>

        <div class="login-container">
            <form class="login" action="login" method="POST">
                <div class="messages">
                    <?php
                    if(isset($messages)){
                        foreach($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <input name="email" type="text" placeholder="E-mail" onfocus="this.placeholder = ''"
                       onblur="this.placeholder = 'E-mail'">
                <input name="password" type="password" placeholder="Hasło" onfocus="this.placeholder = ''"
                       onblur="this.placeholder = 'Hasło'">
                <button type="submit">Zaloguj się</button>
            </form>
        </div>

        <div class="register">
            <a href="registerPage">Nie jesteś użytkownikiem? Kliknij, aby się zarejestrować...</a>
        </div>
    </div>
</body>