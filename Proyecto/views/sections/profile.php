<?php
include_once 'controllers/UserController.php';
$user = UserController::getUserById();
?>

<header>
    <?php include_once 'nav.php'; ?>
</header>

<main>
    <section>
        <h2>Perfil</h2>
        <div class="profile">
            <div class="info">
                <label for="">Nombre:</label>
                <p><?= $user['name']; ?></p>
            </div>
            <div class="info">
                <label for="">Email:</label>
                <p><?= $user['email']; ?></p>
            </div>
            <div class="info">
                <label for="">Conectado:</label>
                <p><?= $user['connected'] ? 'Si' : 'No'; ?></p>
            </div>
            <div class="info">
                <label for="">Ultima Actualización del Perfil:</label>
                <p><?= $user['updated_at']; ?></p>
            </div>
        </div>
        <a class="delete" href="index.php?route=delete">Eliminar cuenta</a>
    </section>
</main>