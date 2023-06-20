<div class="admin-container">
    <div class="container-text">
        <form action="<?= URL ?>admin/keyword/validateEdit" method="post">
            <label for="response">Votre réponse à modifier </label>
            <textarea  id="response" name="response" required placeholder="La réponse donnée par le chatbot" ><?= $response[0]['response'] ?></textarea>
            <input type="hidden" id="response-id" name="response-id" readonly value="<?= $response[0]['id'] ?>">
            <label class="keyword-legend">Le/Les mot(s)-clé(s) à associer</label>
            <fieldset>
                <?php $i = 0;
                foreach ($keywords as $keyword): $i++; ?>
                <div>
                    <label class="keyword-label" for="keyword-<?= $i ?>">Mot clée 1 :</label>
                    <input type="text" id="keyword-<?= $i ?>" required name="keyword-<?= $i ?>" placeholder="mot-clée" value="<?= $keyword['keyword'] ?>">
                    <label class="keyword-label" for="priority-<?= $i ?>">Priorité :</label>
                    <input type="number" id="priority-<?= $i ?>" required name="priority-<?= $i ?>" placeholder="2" value="<?= $keyword['priority'] ?>">
                    <input type="hidden" id="k-id-<?= $i ?>" name="k-id-<?= $i ?>" readonly value="<?= $keyword['id'] ?>">
                </div>
                <?php endforeach; ?>
                <div id="btn-div">
                    <input type="hidden" readonly id="k-length" name="k-length" value="<?= $i ?>">
                    <input type="hidden" readonly id="k-length-new" name="k-length-new" value="<?= $i ?>">
                    <button type="button" id="btn-add">Ajouter</button>
                    <button type="button" id="btn-delete">Retirer</button>
                </div>
            </fieldset>
            <button type="submit">Ajouter</button>
        </form>
    </div>
</div>