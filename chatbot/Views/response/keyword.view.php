<div class="admin-container">
    <div class="container-text">
        <form action="<?= URL ?>admin/keyword/new" method="post">
            <label for="response">Votre réponse à enregistrer </label>
            <textarea  id="response" name="response" required placeholder="La reponse donné par le chatbot" ></textarea>
            <label class="keyword-legend">Le/Les mot(s)-clé(s) à associer</label>
            <fieldset>
                <div>
                    <label class="keyword-label" for="keyword-1">Mot-clé 1 :</label>
                    <input type="text" id="keyword-1" required name="keyword-1" placeholder="mot-clée">
                    <label class="keyword-label" for="priority-1">Priorité :</label>
                    <input type="number" id="priority-1" required name="priority-1" placeholder="2">
                </div>
                <div id="btn-div">
                    <button type="button" id="btn-add">Ajouter</button>
                    <button type="button" id="btn-delete">Retirer</button>
                </div>
            </fieldset>
            <button type="submit">Ajouter</button>
        </form>
    </div>
</div>
<div class="table-container">
    <h2 style="text-align: center">Liste des réponses et mots-clés</h2>
    <table class="fl-table">
        <thead>
        <tr>
            <th>Réponse</th>
            <th>Mots-clés</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=0;
        foreach ($list as $element):?>
            <tr>
                <td><?php echo key($element);?></td>
                <td>
                    <?php
                    $count= 0;
                    foreach ($element as $response){
                        foreach ($response as $word){
                            if ($count > 0){
                                echo ', ';
                            }
                            echo $word['keyword'];
                            $count++;
                        };
                    }
                    ?>
                </td>
                <td> <button><a href="<?= URL ?>admin/keyword/edit&id=<?= $id[$i]['id'] ?>">Modifier</a></button> </td>
                <td> <a href="#popup1"><button style="background-color: darkred; background-image: none" value="<?= $id[$i]['id'] ?>" name="delete" >Supprimer</button></a> </td>
                <?php $i++ ?>
            </tr>
        <?php endforeach; ?>
        <tbody>
    </table>
</div>
<div id="popup1" class="overlay">
    <div class="popup">
        <h2>Suppression de Reponse</h2>
        <a class="close" href="#">&times;</a>
        <div class="content">
            Êtes-vous sûr de vouloir supprimer la réponse <br>
            En supprimant la réponse vous supprimerez aussi les mots-clés associés
            <button style="background-color: darkred; background-image: none; margin-top: 2em" ><a id="deleteUrl" style="color: white" href="<?= URL ?>admin/keyword/delete&id=">supprimer</a></button>
        </div>
    </div>
</div>
