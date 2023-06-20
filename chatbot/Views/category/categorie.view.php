<div class="admin-container">
    <div class="container-text">
        <h3>Enregistrer une nouvelle catégorie </h3>
        <p>Enregistrer une nouvelle catégorie que le chatbot pourra retrouver grâce à son nom et la proposer à vos utilisateurs </p>
        <form action="<?= URL ?>admin/categorie/new" method="post">
            <label for="categorie">Nom de la catégorie :
                <input type="text" id="categorie" name="categorie">
            </label>
            <label for="slug">Slug de la catégorie :
                <input type="text" id="slug" name="slug">
            </label>
            <button type="submit">Ajouter</button>
        </form>
    </div>
</div>

<div class="table-container">
    <h2 style="text-align: center">Liste des Catégories existantes</h2>
    <table class="fl-table">
        <thead>
        <tr>
            <th>Nom de la categorie</th>
            <th>Slug</th>
            <th>Url</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($list as $element):?>
            <tr>
                <td><?= $element['categorie']?></td>
                <td><?= $element['slug']?></td>
                <td><a href="<?= $element['url']?>"><?= $element['url']?></a></td>
                <td> <button><a href="<?= URL ?>admin/categorie/edit&id=<?= $element['id'] ?>">Modifier</a></button> </td>
                <td> <button style="background-color: darkred; background-image: none" value="<?= $element['id'] ?>" data-entity-name="<?= $element['categorie'] ?>" name="btn-delete" ><a href="#popup1">Supprimer</a></button> </td>
            </tr>
        <?php endforeach; ?>
        <tbody>
    </table>
</div>

<div id="popup1" class="overlay">
    <div class="popup">
        <h2>Suppression de catégorie</h2>
        <a class="close" href="#">&times;</a>
        <div class="content">
            Êtes-vous sur de vouloir supprimer la catégorie <p id="item"></p> ?<br>
            <p>En la supprimant, vous supprimez tous les produits qui lui sont liés.</p>
            <button style="background-color: darkred; background-image: none; margin-top: 2em" ><a id="delete" style="color: white" href="<?= URL ?>admin/categorie/delete&id=">supprimer</a></button>
        </div>
    </div>
</div>

