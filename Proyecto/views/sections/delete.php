<?php
include_once 'controllers/UserController.php';
$user = UserController::getUserById();
?>
<header>
    <?php include_once 'nav.php'; ?>
</header>
<main>
    <section>
        <div class="delete-section">
            <h3>¿Esta seguro que desea eliminar la cuenta?</h3>
            <form id="delete" class="delete-form" onsubmit="deleteProfileFormSubmit(); return false;">
                <input type="hidden" name="action" value="delete">
                <input class="delete" type="submit" value="Eliminar">
                <a class="go-back" href="index.php?route=profile">Cancelar</a>
            </form>
        </div>
    </section>
</main>