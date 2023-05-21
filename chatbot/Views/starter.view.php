<div class="container">
    <h1>Configurer vos identifiants</h1>
    <?php
    if(!empty($_SESSION['alert'])) {
        foreach($_SESSION['alert'] as $alert){
            echo "<div class='alert ". $alert['type'] ."' role='alert'>
                        ".$alert['message']."
                    </div>";
        }
        unset($_SESSION['alert']);
    }
    ?>
    <form id="form" method="post" action="<?= URL ?>validateStarter">
        <div id="step2" class="step">
            <h2>Connexion administrateur</h2>
            <p>Configurer le mot de passe et l'identifiant de l'espace de connexion </p>
            <label> Identifiant :
                <input required id="admin-id" name="admin-id" type="text" placeholder="admin">
            </label>
            <label> Mot de passe :
                <input required id="admin-password" name="admin-password" type="password" placeholder="password" >
            </label>
            <label> confirmation de mot de passe :
                <input required id="admin-password-confirm" name="admin-password-confirm" type="password" placeholder="password">
            </label>
        </div>
        <button type="submit"> Enregistrer </button>
    </form>
</div>

