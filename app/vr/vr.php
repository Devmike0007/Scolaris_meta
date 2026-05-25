<?php
require '../config/config.php';

if (!is_logged_in()) {
    redirect('auth/auth.php?action=login');
}

$image = $_GET['image'] ?? '';
$image = filter_var($image, FILTER_VALIDATE_URL);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vue VR - <?php echo APP_NAME; ?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <style>
        * { margin: 0; padding: 0; }
        body { background: #000; font-family: Arial; }
        #vr-container { width: 100vw; height: 100vh; }
        .controls { position: absolute; top: 20px; left: 20px; color: white; }
        .controls a { color: #0066cc; text-decoration: none; }
        .controls a:hover { text-decoration: underline; }
        .info { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); color: white; text-align: center; font-size: 12px; }
    </style>
</head>
<body>
    <div id="vr-container"></div>
    <div class="controls">
        <p><?php echo APP_NAME; ?></p>
        <a href="index.php">← Retour</a>
    </div>
    <div class="info">
        <p>Utilisez votre souris pour explorer (ou votre téléphone en mode VR)</p>
    </div>

    <script>
        // Scène Three.js simple
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.getElementById('vr-container').appendChild(renderer.domElement);

        // Charger la texture (image)
        const imageUrl = '<?php echo htmlspecialchars($image); ?>';
        const textureLoader = new THREE.TextureLoader();
        const texture = textureLoader.load(imageUrl);

        // Créer une sphère et appliquer la texture
        const geometry = new THREE.SphereGeometry(100, 64, 32);
        const material = new THREE.MeshBasicMaterial({ map: texture, side: THREE.BackSide });
        const sphere = new THREE.Mesh(geometry, material);
        scene.add(sphere);

        camera.position.z = 0.1;

        // Contrôles à la souris
        let mouse = { x: 0, y: 0 };
        document.addEventListener('mousemove', (e) => {
            mouse.x = (e.clientX / window.innerWidth) * 2 - 1;
            mouse.y = -(e.clientY / window.innerHeight) * 2 + 1;
        });

        // Animation
        function animate() {
            requestAnimationFrame(animate);
            camera.rotation.x = mouse.y * 0.5;
            camera.rotation.y = mouse.x * 0.5;
            renderer.render(scene, camera);
        }
        animate();

        // Responsive
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
    </script>
</body>
</html>
