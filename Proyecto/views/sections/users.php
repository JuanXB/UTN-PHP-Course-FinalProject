<?php
include_once 'controllers/UserController.php';
$users = UserController::getUsers();
$userCount = count($users);
?>
<header>
    <?php include_once 'nav.php'; ?>
</header>

<main>
    <h2>Ultimos <?=$userCount;?> usuarios que se actualizaron</h2>
    <section>
        <?php if (isset($users) && ($userCount > 0)) : ?>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Conectado</th>
                            <th>Fecha de Creación</th>
                            <th>Fecha de Actualización</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1;
                        foreach ($users as $user) : ?>
                            <tr>
                                <td><?= $counter ?></td>
                                <td><?= $user['name'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['connected'] ? 'Si' : 'No'; ?></td>
                                <td><?= $user['created_at'] ?></td>
                                <td><?= $user['updated_at'] ?></td>
                            </tr>
                    </tbody>
                <?php
                            $counter++;
                        endforeach ?>
                </table>
            </div>
        <?php else : ?>
            <h3 class="not-users">No hay usuarios que mostrar</h3>
        <?php endif; ?>
    </section>
</main>