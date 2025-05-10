<div class="navbar-area">
    <div class="comero-mobile-nav">
        <div class="logo">
            <a href="/">
                MyFlor.RU
            </a>
        </div>
    </div>

    <div class="comero-nav">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="/">
                    MyFlor.RU
                </a>
                <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item p-relative">
                            <a href="#" class="nav-link">Главная </a>
                        </li>

                        <li class="nav-item megamenu">
                            <a href="/catalog/" class="nav-link active">
                                Каталог
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <div class="container">
                                        <div class="row">
                                            {include file="/engine/modules/smshop/front/submenu_items.php?parent_id=1&cols=4"}
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item p-relative">
                            <a href="#" class="nav-link">Букеты <i class="fas fa-chevron-down"></i></a>
                            <ul class="dropdown-menu">
                                {include file="/engine/modules/smshop/front/submenu_items.php?parent_id=6"}
                            </ul>
                        </li>
                        <li class="nav-item p-relative">
                            <a href="#" class="nav-link">Корзины <i class="fas fa-chevron-down"></i></a>
                            <ul class="dropdown-menu">
                                {include file="/engine/modules/smshop/front/submenu_items.php?parent_id=7"}
                            </ul>
                        </li>
                        <li class="nav-item p-relative">
                            <a href="#" class="nav-link">Свадебная флористика <i class="fas fa-chevron-down"></i></a>
                            <ul class="dropdown-menu">

                            </ul>
                        </li>

                        [group=1]
                        <li class="nav-item p-relative">
                            <a href="#" class="nav-link"><i class="fa fa-gear fa-lg"></i> <i class="fas fa-chevron-down"></i></a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a href="/?do=admin#/shop_catalog" class="nav-link">Букеты</a></li>
                                <li class="nav-item"><a href="/?do=admin#/shop_category" class="nav-link">Категории</a></li>
                                <li class="nav-item"><a href="/?do=admin#/shop_composition" class="nav-link">Составлюящие</a></li>
                                <li class="nav-item"><a href="/?do=admin#/fields" class="nav-link">Настройка полей</a></li>
                            </ul>
                        </li>
                        [/group]

                    </ul>
                    <div class="others-option">
                        <div class="option-item"><a href="#">Оплата <i class="fa-regular fa-credit-card"></i></a></div>
                        <div class="option-item"><a href="#">Доставка <i class="fa-solid fa-truck-fast"></i></a></div>
                        <div class="option-item"><a href="#" data-bs-toggle="modal" data-bs-target="#shoppingCartModal">
                                Корзина(<span data-basket-count>0</span>)
                                <i class="fas fa-shopping-bag"></i></a></div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>