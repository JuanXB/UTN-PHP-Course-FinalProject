<?php
include_once APP_CONFIG['sectionsPath'].'/head.php';
?>
<header>
    <h1>Registrarse</h1>
</header>
<main>
    <section>
        <div class="form-section">
            <form id="register" onsubmit="registerFormSubmit(); return false;">
                <div>
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" name="name">
                    <span id="e_name"></span>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email">
                    <span id="e_email"></span>
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" id="password">
                    <span id="e_password"></span>
                </div>
                <input type="submit" value="Registrarse">
                <div class="go-register">
                    <a href="index.php?route=login">Loguearme</a>
                </div>
            </form>
        </div>
    </section>
</main>
<?php
include_once APP_CONFIG['sectionsPath'].'/footer.php';
?>