<div class="admin-container">
    <div class="container-text">
        <h3>Modifié votre categorie</h3>
        <p>Enregistrer une nouvelle categorie que le chatbot pourra retrouver grâce à son nom et la proposer à vos utilisteurs </p>
        <form action="<?= URL ?>admin/categorie/validateEdit" method="post">
            <input type="hidden" readonly id="id" name="id" value="<?= $_GET['id']?>">
            <label for="categorie">Nom de la categorie :
                <input type="text" id="categorie" name="categorie" value="<?= $category['categorie'] ?>">
            </label>
            <label for="slug">Slug de la categorie :
                <input type="text" id="slug" name="slug" value="<?= $category['slug']?>">
            </label>
            <button type="submit">Modifié</button>
        </form>
    </div>
</div>