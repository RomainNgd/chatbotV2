<nav>
    <div class="sidebar-top">
      <span class="shrink-btn">
        <i class="bx bx-chevron-left"></i>
      </span>
        <img src="/chatbot/assets/img/logo.svg" class="logo" alt="">
        <h3 class="hide">Billy</h3>
    </div>
<?php
$page = $page_menu;
?>
    <div class="sidebar-links">
        <ul>
            <li class="tooltip-element <?php if($page === 'accueil'): ?>active-tab <?php endif ?>" data-tooltip="0">
                <a href="<?= URL; ?>admin/accueil"  data-active="0">
                    <i class="fa-solid fa-house icon"></i>
                    <span class="link hide">Accueil</span>
                </a>
            </li>
            <li class="tooltip-element <?php if($page === 'keyword'): ?>active-tab <?php endif ?>" data-tooltip="1">
                <a href="<?= URL; ?>admin/keyword" data-active="1">
<<<<<<< HEAD
                    <i class="fa-solid fa-keyboard icon"></i>
=======
                    <div class="icon">
                        <i class="bx bx-folder"></i>
                        <i class="bx bxs-folder"></i>
                    </div>
>>>>>>> 2b9871f56e899976e98feba40d144a3ad4102e0e
                    <span class="link hide">Mots-clés</span>
                </a>
            </li>
            <li class="tooltip-element <?php if($page === 'produit'): ?>active-tab <?php endif ?>" data-tooltip="2">
                <a href="<?= URL; ?>admin/produit" data-active="2">
                    <i class="fa-brands fa-product-hunt icon"></i>
                    <span class="link hide">Produit</span>
                </a>
            </li>
            <li class="tooltip-element <?php if($page === 'categorie'): ?> active-tab <?php endif ?>" data-tooltip="3">
                <a href="<?= URL; ?>admin/categorie" data-active="3">
<<<<<<< HEAD
                    <i class="fa-solid fa-list icon"></i>
=======
                    <div class="icon">
                        <i class="bx bx-bar-chart-square"></i>
                        <i class="bx bxs-bar-chart-square"></i>
                    </div>
>>>>>>> 2b9871f56e899976e98feba40d144a3ad4102e0e
                    <span class="link hide">Catégorie</span>
                </a>
            </li>
            <li class="tooltip-element <?php if($page === 'color'): ?> active-tab <?php endif ?>" data-tooltip="4">
                <a href="<?= URL; ?>admin/color" data-active="4">
                    <i class="fa-solid fa-palette icon"></i>
                    <span class="link hide">Palette</span>
                </a>
            </li>
            <li class="tooltip-element <?php if($page === 'commande'): ?> active-tab <?php endif ?>" data-tooltip="4">
                <a href="<?= URL; ?>admin/commande" data-active="4">
                    <i class="fa-sharp fa-solid fa-cart-shopping icon"></i>
                    <span class="link hide">Commande</span>
                </a>
            </li>
            <div class="tooltip" style="top: 62.5%;">
                <span class="">Dashboard</span>
                <span class="">Projects</span>
                <span class="show">Messages</span>
                <span>Analytics</span>
            </div>
        </ul>

        <h4 class="hide">Autre</h4>

        <ul>
            <li class="tooltip-element" data-tooltip="2">
                <a href="<?= URL; ?>deconnexion" data-active="6">
                    <i class="fa-solid fa-right-from-bracket icon"></i>
                    <span class="link hide">Deconnexion</span>
                </a>
            </li>
            <div class="tooltip" style="top: 16.6667%;">
                <span class="show">Tasks</span>
                <span>Help</span>
                <span>Settings</span>
            </div>
        </ul>
    </div>
</nav>