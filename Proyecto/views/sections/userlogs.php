<?php
include_once 'controllers/UserLogController.php';
$userLogs = UserLogController::getAllUserLogs();
$logsCount = count($userLogs);
?>
<header>
    <?php include_once 'nav.php'; ?>
</header>

<main>
    <h2>Ultimos <?=$logsCount;?> logs de <?=$userLogs[0]['name'];?> </h2>
    <section>
        <?php if (isset($userLogs) && ($logsCount > 0)) : ?>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Action</th>
                            <th>Fecha de Creación</th>
                            <th>Fecha de Actualización</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1;
                        foreach ($userLogs as $userLog) : ?>
                            <tr>
                                <td><?= $counter ?></td>
                                <td><?= $userLog['action'] ?></td>
                                <td><?= $userLog['created_at'] ?></td>
                                <td><?= $userLog['updated_at'] ?></td>
                            </tr>
                    </tbody>
                <?php
                            $counter++;
                        endforeach ?>
                </table>
            </div>
        <?php else : ?>
            <h3 class="not-users">No hay logs que mostrar</h3>
        <?php endif; ?>
    </section>
</main>