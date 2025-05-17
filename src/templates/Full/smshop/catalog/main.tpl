{include file="/modules/page_title_area.tpl"}


<section class="category-boxes-area pt-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-6 col-md-6">
                <div class="category-boxes">
                    <img src="/templates/Full/assets/img/category-product-image/img1.jpg" alt="image">
                    <div class="content">
                        <h3>Корзины</h3>
                        <a href="#" class="shop-now-btn">Показать</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6 col-md-6">
                <div class="category-boxes">
                    <img src="/templates/Full/assets/img/category-product-image/img2.jpg" alt="image">
                    <div class="content">
                        <h3>Коробки</h3>
                        <a href="#" class="shop-now-btn">Показать</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6 col-md-6">
                <div class="category-boxes">
                    <img src="/templates/Full/assets/img/category-product-image/img3.jpg" alt="image">
                    <div class="content">
                        <h3>Букеты</h3>
                        <a href="#" class="shop-now-btn">Показать</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="products-collections-area pb-60">
    <div class="container">
        <div class="section-title">
            <h2>
                <span class="dot"></span>
                Каталог букетов
            </h2>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-12">
                {include file="/smshop/catalog/filters.tpl"}
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="products-filter-options">
                    <div class="row align-items-center">
                        <div class="col d-flex">
                            <span class="d-none">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#myModal">
                                    <i class="fas fa-filter"></i> Фильтр</a></span>
                            <span>Отображение:</span>
                            <div class="view-list-row">
                                <div class="view-column">
                                    <a href="#" class="icon-view-two active">
                                        <span></span>
                                        <span></span>
                                    </a>

                                    <a href="#" class="icon-view-three">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </a>

                                    <a href="#" class="view-grid-switch">
                                        <span></span>
                                        <span></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-center">
                            <p>Показано 22 из 102 результатов</p>
                        </div>
                        <div class="col d-flex">
                            <span>Лимит:</span>
                            <div class="show-products-number">
                                <select>
                                    <option value="1">30</option>
                                    <option value="2">50</option>
                                    <option value="3">100</option>
                                </select>
                            </div>
                            <span>Сортировка:</span>
                            <div class="products-ordering-list">
                                <select>
                                    <option value="1">По популярности</option>
                                    <option value="2">По цене</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="products-filter" class="products-collections-listing row products-col-two">
                    {items}
                </div>
                {navigation}
            </div>
        </div>
    </div>
</section>

{include file="modules/facility_area.tpl"}

{include file="/modules/basket_modal.tpl"}

{include file="/modules/modals.tpl"}


<script>
    const SMSHOPTPL = {
        basket: {
            count_target: $('[data-basket-count]'),
            total_target: $('[data-basket-total]'),
            short_target: $('#shoppingCartModal .product-cart-content'),
            short_item: function (item) {
                return `<div class="product-cart position-relative">
                        <div class="product-image">
                            <img src="${item['photo_main']}" alt="image">
                        </div>
                        <div class="product-content">
                            <h3><a href="/id/${item['item_id']}">${item['title']}</a></h3>
                            <span>${item['category_2']}</span>
                            <div class="product-price">
                                <span>${item['count']}</span>
                                <span>x</span>
                                <span class="price">${item['price']} <i class="fa fa-rub"></i> </span>
                            </div>
                        </div>
                        <span class="position-absolute top-0 end-0 text-danger cursor-pointer" data-basket-btn="remove" data-item-id="${item['item_id']}" ><i class="fa fa-remove"></i></span>
                    </div>`
            },
        }
    }
</script>