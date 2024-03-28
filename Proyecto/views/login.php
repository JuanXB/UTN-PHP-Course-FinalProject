<?php
include_once APP_CONFIG['sectionsPath'].'/head.php';
?>
<header>
    <h1>Login</h1>
</header>
<main>
    <section>
        <div class="form-section">
            <form id="login" onsubmit="loginFormSubmit(); return false;">
                <div>
                    <label for="name">Nombre:</label>
                    <input type="name" name="name" id="name">
                    <span id="e_name"></span>
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" id="password">
                    <span id="e_password"></span>

                </div>
                <input type="submit" value="Ingresar">
                <div class="go-register">
                    <a href="index.php?route=register">Ir a registrarme</a>
                </div>
            </form>
        </div>
    </section>
</main>
<?php
include_once APP_CONFIG['sectionsPath'].'/footer.php';
?>