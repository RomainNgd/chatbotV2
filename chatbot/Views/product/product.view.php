<div class="admin-container">
    <div class="container-text">
        <h3>Enregistrer un nouveau produit </h3>
        <p>Enregistrer un nouveau produit que le chatbot pourra retrouver grâce a son nom et le proposer a vos utilisateurs </p>
        <form action="<?= URL ?>admin/produit/new" method="post">
            <label for="name">Nom du porduit :
                <input type="text" name="name" id="name">
            </label>
            <label for="ref">Référence produit :
                <input type="text" name="ref" id="ref">
            </label>
            <label for="slug">Slug de la fiche produit :
                <input type="text" name="slug" id="slug">
            </label>
            <label for="url">URL de la fiche produit :
                <input type="text" name="url" id="url">
            </label>
            <label for="price">Prix :
                <input type="number" name="price" step="0.01" id="price">
            </label>
            <label for="category">Categorie du produit :
                <select id="category" name="category">
                    <?php
                    foreach ($categories as $category): ?>
                        <option value="<?= $category['id']?>"><?= $category['categorie']?></option>
                    <?php endforeach;?>
                </select>
            </label>
            <button type="submit">Enregistrer</button>
        </form>
    </div>
</div>

<div class="table-container">
    <h2 style="text-align: center">Liste des réponses et mots clées</h2>
    <table class="fl-table">
        <thead>
        <tr>
            <th>Nom du produit</th>
            <th>Référence</th>
            <th>Prix</th>
            <th>Url</th>
            <th>Slug</th>
            <th>Categorie</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($list as $element):?>
            <tr>
                <td><?= $element['produit']?></td>
                <td><?= $element['ref']?></td>
                <td><?= $element['prix']?></td>
                <td><?= $element['slug']?></td>
                <td><a href="<?= $element['url']?>"><?= $element['url']?></a></td>
                <td><?= $element['categorie']?></td>
                <td> <button><a href="<?= URL ?>admin/produit/edit&id=<?= $element['id'] ?>">modifié</a></button> </td>
                <td> <button style="background-color: darkred; background-image: none" value="<?= $element['id'] ?>" data-entity-name="<?= $element['produit'] ?>" name="btn-delete" ><a href="#popup1">Supprimer</a></button> </td>
            </tr>
        <?php endforeach; ?>
        <tbody>
    </table>
</div>
<div id="popup1" class="overlay">
    <div class="popup">
        <h2>Suppression de produit</h2>
        <a class="close" href="#">&times;</a>
        <div class="content">
            Etes-vous sur de vouloir supprimer le produit <p id="item"></p>
            <button style="background-color: darkred; background-image: none; margin-top: 2em" ><a id="delete" style="color: white" href="<?= URL ?>admin/produit/delete&id=">supprimer</a></button>
        </div>
    </div>
</div>

