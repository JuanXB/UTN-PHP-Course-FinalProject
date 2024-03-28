<?php
include_once APP_CONFIG['sectionsPath'].'/head.php';

include_once 'controllers/SectionController.php';
include_once SectionController::getSection($route);

include_once APP_CONFIG['sectionsPath'].'/footer.php';
?>
