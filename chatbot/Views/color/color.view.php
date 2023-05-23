<h3>Sélection d'une palette de couleur:</h3>
<div class="d-flex">
    <?php var_dump($list);?>
    <form action="#" method="POST" id="form-palette">
        <div id="select-palette">
            <label for="palette-1" class="palette">
                <div>
                    <input type="radio" value="1" id="palette-1" name="palette"> Palette 1
                </div>
                <div class="block-palette">
                    <div class="dark-maincolor palette-color"></div>
                    <div class="main-color palette-color"></div>
                    <div class="light-color palette-color"></div>
                    <div class="gray-color palette-color"></div>
                </div>
            </label>
            <label for="palette-2" class="palette">
                <div>
                    <input type="radio" value="2" id="palette-2" name="palette"> Palette 2
                </div>
                <div class="block-palette">
                    <div class="dark-maincolor palette-color"></div>
                    <div class="main-color palette-color"></div>
                    <div class="light-color palette-color"></div>
                    <div class="gray-color palette-color"></div>
                </div>
            </label>
            <label for="palette-3" class="palette">
                <div>
                    <input type="radio" value="3" id="palette-3" name="palette"> Palette 3
                </div>
                <div class="block-palette">
                    <div class="dark-maincolor palette-color"></div>
                    <div class="main-color palette-color"></div>
                    <div class="light-color palette-color"></div>
                    <div class="gray-color palette-color"></div>
                </div>
            </label>
            <label for="palette-4" class="palette">
                <div>
                    <input type="radio" value="4" id="palette-4" name="palette"> Palette 4
                </div>
                <div class="block-palette">
                    <div class="dark-maincolor palette-color"></div>
                    <div class="main-color palette-color"></div>
                    <div class="light-color palette-color"></div>
                    <div class="gray-color palette-color"></div>
                </div>
            </label>
        </div>

        <button class="btn btn-validation">Modifier</button>
    </form>
</div>