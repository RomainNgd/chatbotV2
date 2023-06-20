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
                <td><?= $element['status']?></td>
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