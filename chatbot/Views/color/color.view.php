<section id="colors">
    <h3>Sélection d'une palette de couleur:</h3>
    <div class="d-flex">
        <form action="<?= URL ?>admin/color/usePalette" method="POST" id="form-palette">
            <div id="select-palette">
                <?php foreach($list as $key => $color): ?>
                    <label for="palette-<?= $key ?>" class="palette">
                        <div>
                            <input type="radio" value="<?= $color['id'] ?>" id="palette-<?= $key ?>" name="id" <?php if($color['active'] == true){ ?> checked <?php } ?>> <?= $color['libelle'] ?>
                        </div>
                        <div class="block-palette">
                            <div class="dark-maincolor palette-color" style="background-color: <?= $color['dark_color'] ?>;"></div>
                            <div class="main-color palette-color" style="background-color: <?= $color['main_color'] ?>;"></div>
                            <div class="light-color palette-color" style="background-color: <?= $color['light_color'] ?>;"></div>
                            <div class="gray-color palette-color" style="background-color: <?= $color['gray_color'] ?>;"></div>
                        </div>
                    </label>
                <?php endforeach; ?>
            </div>
            <button class="btn btn-validation" type="submit">Modifier</button>
        </form>
    </div>
</section>