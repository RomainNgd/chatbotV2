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
                    <div class="icon">
                        <i class="bx bx-tachometer"></i>
                        <i class="bx bxs-tachometer"></i>
                    </div>
                    <span class="link hide">Accueil</span>
                </a>
            </li>
            <li class="tooltip-element <?php if($page === 'keyword'): ?>active-tab <?php endif ?>" data-tooltip="1">
                <a href="<?= URL; ?>admin/keyword" data-active="1">
                    <div class="icon">
                        <i class="bx bx-folder"></i>
                        <i class="bx bxs-folder"></i>
                    </div>
                    <span class="link hide">Mot clée</span>
                </a>
            </li>
            <li class="tooltip-element <?php if($page === 'produit'): ?>active-tab <?php endif ?>" data-tooltip="2">
                <a href="<?= URL; ?>admin/produit" data-active="2">
                    <div class="icon">
                        <i class="bx bx-message-square-detail"></i>
                        <i class="bx bxs-message-square-detail"></i>
                    </div>
                    <span class="link hide">Produit</span>
                </a>
            </li>
            <li class="tooltip-element <?php if($page === 'categorie'): ?> active-tab <?php endif ?>" data-tooltip="3">
                <a href="<?= URL; ?>admin/categorie" data-active="3">
                    <div class="icon">
                        <i class="bx bx-bar-chart-square"></i>
                        <i class="bx bxs-bar-chart-square"></i>
                    </div>
                    <span class="link hide">Categorie</span>
                </a>
            </li>
            <li class="tooltip-element <?php if($page === 'color'): ?> active-tab <?php endif ?>" data-tooltip="4">
                <a href="<?= URL; ?>admin/color" data-active="4">
                    <div class="icon">
                        <i class="bx bx-bar-chart-square"></i>
                        <i class="bx bxs-bar-chart-square"></i>
                    </div>
                    <span class="link hide">Palette</span>
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
                    <div class="icon">
                        <i class="bx bx-cog"></i>
                        <i class="bx bxs-cog"></i>
                    </div>
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