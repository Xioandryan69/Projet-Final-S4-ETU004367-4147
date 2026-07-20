<!DOCTYPE html>
<html lang="fr">
<head> 
    <meta charset="UTF-8"> 
    <title>Upload de fichier (CodeIgniter 4)</title>
</head>
<body> 
    <h2>Uploader une Image ou une Vidéo</h2> 

    <!-- Affichage des messages de statut -->
    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <!-- Affichage des erreurs de validation -->
    <?php if (session()->getFlashdata('errors')): ?>
        <ul style="color: red;">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Formulaire pointant vers la méthode du contrôleur -->
    <form action="<?= base_url('upload/file') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?> <!-- Protection CSRF native de CodeIgniter -->
        
        <label for="fichier">Choisir un fichier (Image ou Vidéo, max 20Mo) :</label> 
        <input type="file" name="fichier" id="fichier" required> 
        <br><br> 
        <input type="submit" value="Uploader"> 
    </form>
    
</body>
</html>