<div class="admin-container">
    <div class="container-text">
        <h3>Enregistrer un nouveau produit </h3>
        <p>Enregistrer un nouveau produit que le chatbot pourra retrouver grâce a son nom et le proposer à vos utilisateurs </p>
        <form action="<?= URL ?>admin/produit/validateEdit" method="post">
            <input type="hidden" name="id" id="id" readonly required value="<?= $_GET['id'] ?>">
            <label for="name">Nom du produit :
                <input type="text" id="name" name="name" required value="<?= $product['produit'] ?>">
            </label>
            <label for="ref">Référence du produit :
                <input type="text" id="ref" name="ref" required value="<?= $product['ref'] ?>">
            </label>
            <label for="Slug">Slug du produit :
                <input type="text" id="slug" name="slug" required value="<?= $product['slug'] ?>">
            </label>
            <label for="price">Prix :
                <input type="number" id="price" step="0.01" required name="price" value="<?= $product['prix'] ?>">
            </label>
            <label for="category">Catégorie du produit :
                <select type="number" name="category" required id="category">
                    <?php
                    foreach ($categories as $category): ?>
                        <option value="<?= $category['id']?>" <?php if ($category['id'] === $product['categorie_id']):?> selected <?php endif ?>><?= $category['categorie']?></option>
                    <?php endforeach;?>
                </select>
            </label>
            <button type="submit">Enregistrer</button>
        </form>
    </div>
</div>