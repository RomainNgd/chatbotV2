<div class="admin-container">
    <div class="container-text">
        <h3>Modifier votre catégorie</h3>
        <p>Enregistrer une nouvelle catégorie que le chatbot pourra retrouver grâce à son nom et la proposer à vos utilisateurs </p>
        <form action="<?= URL ?>admin/categorie/validateEdit" method="post">
            <input type="hidden" readonly id="id" name="id" value="<?= $_GET['id']?>">
            <label for="categorie">Nom de la catégorie :
                <input type="text" id="categorie" name="categorie" value="<?= $category['categorie'] ?>">
            </label>
            <label for="slug">Slug de la catégorie :
                <input type="text" id="slug" name="slug" value="<?= $category['slug']?>">
            </label>
            <button type="submit">Modifier</button>
        </form>
    </div>
</div>