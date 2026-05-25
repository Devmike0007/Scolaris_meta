<?php
require '../app/config/config.php';

if (!is_logged_in()) {
    redirect('app/auth/auth.php?action=login');
}

require '../app/models/Model.php';
require '../app/controllers/Controller.php';
require '../app/views/View.php';

// Router Image
$controller = new ImageController();
$result = $controller->generate();

$image = $result['image'] ?? null;
$prompt = $result['prompt'] ?? '';

view_generator($image, $prompt);
?>
