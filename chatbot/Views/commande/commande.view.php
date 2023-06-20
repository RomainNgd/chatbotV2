<div class="">
    <h2 style="text-align: center">Liste des réponses et mots clées</h2>
    <table class="fl-table" style="margin-top: 30px">
        <thead>
        <tr>
            <th>Numéro de commande</th>
            <th>addresse mail utilisateur</th>
            <th>date de création</th>
            <th>ref des produit</th>
            <th>status</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($list) {
        foreach ($list as $element): ?>
            <tr>
                <td><?= $element['id']?></td>
                <td><?= $element['email']?></td>
                <td><?= $element['create_at']?></td>
                <td><?= $element['product'] ?></td>
                <td><?= $element['status']?> <i class="fa-solid fa-pen edit-status"></i>
                    <form id="edit-status" method="post" class="hidden">
                        <input type="hidden" id="id" name="id" value="<?= $element['id'] ?>">
                        <label for="status" class="hidden">Choix du status</label><select name="status" id="status">
                            <option value="call">enregistré</option>
                            <option value="payed">payé</option>
                            <option value="sent">envoyé</option>
                        </select>
                        <button type="submit">Validé</button>
                    </form>
                </td>
            </tr>
        <?php endforeach;
        } else { ?>
            <tr>
                <td>
                    <h4> Aucune commande de passé</h4>
                </td>
            </tr>
        <?php } ?>

        <tbody>
    </table>
</div>