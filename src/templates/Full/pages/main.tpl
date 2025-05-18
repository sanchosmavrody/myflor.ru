<div class="home-slides owl-carousel owl-theme">
    <div class="main-banner-two">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="banner-image">
                                <div class="circle"></div>
                                <img src="/templates/Full/assets/img/women.png" alt="image">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="main-banner-content">
                                <span>Новинка в каталоге 2025</span>
                                <h1>Ограниченное предложение!</h1>
                                <p>Новый тренд во флористике</p>

                                <a href="/?do=catalog" class="btn btn-primary">Заказать букет</a>
                                <a href="/?do=catalog" class="btn btn-light">В каталог</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-banner-two">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="banner-image">
                                <div class="circle"></div>
                                <img src="/templates/Full/assets/img/women2.png" alt="image">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="main-banner-content">
                                <span>Сезонная экзотика</span>
                                <h1>Удиви по настоящему редким букетом</h1>
                                <p>Сборка композиции по экслюзивным заказам</p>

                                <a href="/?do=catalog" class="btn btn-primary">Сделать заказ</a>
                                <a href="/?do=catalog" class="btn btn-light">В каталог</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-banner-two">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="banner-image">
                                <div class="circle"></div>
                                <img src="/templates/Full/assets/img/women.png" alt="image">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="main-banner-content">
                                <span>Новинка в каталоге 2025</span>
                                <h1>Ограниченное предложение!</h1>
                                <p>Новый тренд во флористике</p>

                                <a href="/?do=catalog" class="btn btn-primary">Заказать букет</a>
                                <a href="/?do=catalog" class="btn btn-light">В каталог</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{include file="modules/facility_area.tpl"}

<section class="all-products-area ptb-60">
    <div class="container">
        <div class="tab products-category-tab">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <ul class="tabs without-bg">
                        <li>
                            <a href="/?do=catalog">
                                <div class="dot"></div>
                                Новинки
                            </a>
                        </li>
                        <li>
                            <a href="/?do=catalog">
                                <div class="dot"></div>
                                Популярное
                            </a>
                        </li>
                        <li>
                            <a href="/?do=catalog">
                                <div class="dot"></div>
                                Акции
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-12 col-md-12">
                    <div class="tab_content">
                        <div class="tabs_item">
                            <div class="row">
                                <div class="all-products-slides owl-carousel owl-theme">
                                    {include file="engine/modules/smshop/front/carusel_items.php?carousel_name=Новинки"}
                                </div>
                            </div>
                        </div>

                        <div class="tabs_item">
                            <div class="row">
                                <div class="all-products-slides owl-carousel owl-theme">
                                    {include file="engine/modules/smshop/front/carusel_items.php?carousel_name=Популярное"}
                                </div>
                            </div>
                        </div>

                        <div class="tabs_item">
                            <div class="row">
                                <div class="all-products-slides owl-carousel owl-theme">
                                    {include file="engine/modules/smshop/front/carusel_items.php?carousel_name=Акции"}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{include file="pages/main_banners.tpl"}

<section class="trending-products-area pb-60">
    <div class="container">
        <div class="section-title">
            <h2>
                <span class="dot"></span>
                Топ 15 букетов дня
            </h2>
        </div>

        <div class="row">
            <div class="trending-products-slides owl-carousel owl-theme">
                {include file="engine/modules/smshop/front/carusel_items.php?carousel_name=Топ 15"}
            </div>
        </div>
    </div>
</section>

<section class="best-sellers-area pb-60 d-none">
    <div class="container">
        <div class="section-title">
            <h2>
                <span class="dot"></span>
                Самые популярные корзины
            </h2>
        </div>

        <div class="row">
            <div class="best-sellers-products-slides owl-carousel owl-theme">
                {include file="engine/modules/smshop/front/carusel_items.php?carousel_name=Самые популярные"}
            </div>
        </div>
    </div>
</section>

<section class="testimonials-area ptb-60 jarallax" data-jarallax='{"speed": 0.3}'>
    <div class="container">
        <div class="testimonials-slides owl-carousel owl-theme">
            {custom category="442" template="pages/main_reviews_item" available="global" navigation="no" from="0" limit="30" order="date" sort="desc" cache="yes"}
        </div>
    </div>
</section>


<section class="best-sellers-area pb-60">
    <div class="container">
        <div class="section-title">
            <h2>
                <span class="dot"></span>
                Вы смотрели
            </h2>
        </div>

        <div class="row">
            <div class="best-sellers-products-slides owl-carousel owl-theme">
                {include file="engine/modules/smshop/front/carusel_items.php"}
            </div>
        </div>
    </div>
</section>

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
                            <span>${item['category_2_name']}</span>
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