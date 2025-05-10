{include file="/modules/page_title_area.tpl"}
<section class="products-details-area ptb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="products-page-gallery">
                    <div class="product-page-gallery-main">
                        {photos}
                    </div>

                    <div class="product-page-gallery-preview">
                        {photos}
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="product-details-content">
                    <h3>{title}</h3>
                    <div class="price">
                        Цена: <span class="new-price">{price}<i class="fa fa-ruble"></i></span>
                    </div>
                    <ul class="product-info">
                        <li><span>Цветы:</span> <a href="#">Пионы</a>,<a href="#">Эвкалипт</a></li>
                        <li><span>Упаковка:</span> <a href="#">Фомиран</a></li>
                        <li><span>Высота:</span> <a href="#">60см.</a></li>
                    </ul>
                    <p class="fst-italic border-start border-2 border-primary ps-1 text-bg-light mt-2 mb-2">{description}</p>
                    <div class="product-size-wrapper">
                        <h4>Выбрать размер букета:</h4>
                        <ul>
                            <li><a href="#">19 пионов</a></li>
                            <li class="active"><a href="#">21 пионов</a></li>
                            <li><a href="#">25 пионов</a></li>
                        </ul>
                    </div>
                    <div class="product-info-btn">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#sizeGuideModal"><i class="fas fa-crop"></i> Изменить состав при заказе </a>
                    </div>

                    <div class="product-add-to-cart">
                        <div class="input-counter">
                            <span class="minus-btn"><i class="fas fa-minus"></i></span>
                            <input type="text" value="1">
                            <span class="plus-btn"><i class="fas fa-plus"></i></span>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="fas fa-cart-plus"></i> В корзину</button>
                    </div>

                    <div class="buy-checkbox-btn">
                        <div class="item">
                            <input class="inp-cbx" id="cbx" type="checkbox">
                            <label class="cbx" for="cbx">
                                        <span>
                                            <svg width="12px" height="10px" viewbox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                <span>Я на всё согласен</span>
                            </label>
                        </div>

                        <div class="item">
                            <a href="#" class="btn btn-primary">Купить сейчас!</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
                <div class="tab products-details-tab">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <ul class="tabs">
                                <li><a href="#">
                                        <div class="dot"></div>
                                        Описание
                                    </a></li>

                                <li><a href="#">
                                        <div class="dot"></div>
                                        Доставка и оплата
                                    </a></li>

                                <li><a href="#">
                                        <div class="dot"></div>
                                        Отзывы
                                    </a></li>
                            </ul>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="tab_content">
                                <div class="tabs_item">
                                    <div class="products-details-tab-content">
                                        <p>Вот вам яркий пример современных тенденций — понимание сути ресурсосберегающих технологий способствует повышению качества соответствующих условий активизации.
                                            Сложно сказать, почему независимые государства, вне зависимости от их уровня, должны быть ассоциативно распределены по отраслям. Но действия представителей оппозиции, вне зависимости от их уровня, должны быть подвергнуты целой серии независимых исследований. Современные технологии достигли такого уровня,
                                            что современная методология разработки выявляет срочную потребность экономической целесообразности принимаемых решений.</p>

                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <ul>
                                                    <li>Сложно сказать, почему независимые государства</li>
                                                    <li>Но действия представителей оппозиции</li>
                                                    <li>Вот вам яркий пример современных тенденций</li>
                                                </ul>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <ol>
                                                    <li>Сложно сказать, почему независимые государства</li>
                                                    <li>Но действия представителей оппозиции</li>
                                                    <li>Вот вам яркий пример современных тенденций</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tabs_item">
                                    <div class="products-details-tab-content">
                                        <div class="table-responsive">
                                            <table class="table table-striped">

                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tabs_item">
                                    <div class="products-details-tab-content">
                                        <div class="product-review-form">
                                            <h3>Отзывы наших клиентов</h3>

                                            <div class="review-title">
                                                <div class="rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                                <p>Based on 3 reviews</p>

                                                <a href="#" class="btn btn-light">Write a Review</a>
                                            </div>

                                            <div class="review-comments">
                                                <div class="review-item">
                                                    <div class="rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <h3>Good</h3>
                                                    <span><strong>Admin</strong> on <strong>Sep 21, 2024</strong></span>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>

                                                    <a href="#" class="review-report-link">Report as Inappropriate</a>
                                                </div>

                                                <div class="review-item">
                                                    <div class="rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <h3>Good</h3>
                                                    <span><strong>Admin</strong> on <strong>Sep 21, 2024</strong></span>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>

                                                    <a href="#" class="review-report-link">Report as Inappropriate</a>
                                                </div>

                                                <div class="review-item">
                                                    <div class="rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <h3>Good</h3>
                                                    <span><strong>Admin</strong> on <strong>Sep 21, 2024</strong></span>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>

                                                    <a href="#" class="review-report-link">Report as Inappropriate</a>
                                                </div>
                                            </div>

                                            <div class="review-form">
                                                <h3>Write a Review</h3>

                                                <form>
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" id="name" name="name" placeholder="Enter your name" class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" id="email" name="email" placeholder="Enter your email" class="form-control">
                                                    </div>

                                                    <div class="review-rating">
                                                        <p>Rate this item</p>

                                                        <div class="star-source">
                                                            <svg>
                                                                <linearGradient x1="50%" y1="5.41294643%" x2="87.5527344%" y2="65.4921875%" id="grad">
                                                                    <stop stop-color="#f2b01e" offset="0%"></stop>
                                                                    <stop stop-color="#f2b01e" offset="60%"></stop>
                                                                    <stop stop-color="#f2b01e" offset="100%"></stop>
                                                                </linearGradient>
                                                                <symbol id="star" viewBox="153 89 106 108">
                                                                    <polygon id="star-shape" stroke="url(#grad)" stroke-width="5" fill="currentColor" points="206 162.5 176.610737 185.45085 189.356511 150.407797 158.447174 129.54915 195.713758 130.842203 206 95 216.286242 130.842203 253.552826 129.54915 222.643489 150.407797 235.389263 185.45085"></polygon>
                                                                </symbol>
                                                            </svg>
                                                        </div>

                                                        <div class="star-rating">
                                                            <input type="radio" name="star" id="five">
                                                            <label for="five">
                                                                <svg class="star">
                                                                    <use xlink:href="#star"/>
                                                                </svg>
                                                            </label>

                                                            <input type="radio" name="star" id="four">
                                                            <label for="four">
                                                                <svg class="star">
                                                                    <use xlink:href="#star"/>
                                                                </svg>
                                                            </label>

                                                            <input type="radio" name="star" id="three">
                                                            <label for="three">
                                                                <svg class="star">
                                                                    <use xlink:href="#star"/>
                                                                </svg>
                                                            </label>

                                                            <input type="radio" name="star" id="two">
                                                            <label for="two">
                                                                <svg class="star">
                                                                    <use xlink:href="#star"/>
                                                                </svg>
                                                            </label>

                                                            <input type="radio" name="star" id="one">
                                                            <label for="one">
                                                                <svg class="star">
                                                                    <use xlink:href="#star"/>
                                                                </svg>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Review Title</label>
                                                        <input type="text" id="review-title" name="review-title" placeholder="Enter your review a title" class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Body of Review (1500)</label>
                                                        <textarea name="review-body" id="review-body" cols="30" rows="10" placeholder="Write your comments here" class="form-control"></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-light">Submit Review</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="related-products-area">
        <div class="container">
            <div class="section-title">
                <h2><span class="dot"></span> Related Products</h2>
            </div>

            <div class="row">
                <div class="trending-products-slides-two owl-carousel owl-theme">
                    <div class="col-lg-12 col-md-12">
                        <div class="single-product-box">
                            <div class="product-image">
                                <a href="product-type-1.html">
                                    <img src="assets/img/trending-img5.jpg" alt="image">
                                    <img src="assets/img/trending-hover-img5.jpg" alt="image">
                                </a>

                                <ul>
                                    <li><a href="#" data-tooltip="tooltip" data-placement="left" title="Quick View" data-bs-toggle="modal" data-bs-target="#productQuickView"><i class="far fa-eye"></i></a></li>
                                    <li><a href="product-type-1.html" data-tooltip="tooltip" data-placement="left" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                    <li><a href="product-type-3.html" data-tooltip="tooltip" data-placement="left" title="Add to Compare"><i class="fas fa-sync"></i></a></li>
                                </ul>
                            </div>

                            <div class="product-content">
                                <h3><a href="product-type-1.html">Belted chino trousers polo</a></h3>

                                <div class="product-price">
                                    <span class="new-price">$191.00</span>
                                </div>

                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>

                                <a href="cart.html" class="btn btn-light">Add to Cart</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12">
                        <div class="single-product-box">
                            <div class="product-image">
                                <a href="product-type-1.html">
                                    <img src="assets/img/trending-img6.jpg" alt="image">
                                    <img src="assets/img/trending-hover-img6.jpg" alt="image">
                                </a>

                                <ul>
                                    <li><a href="#" data-tooltip="tooltip" data-placement="left" title="Quick View" data-bs-toggle="modal" data-bs-target="#productQuickView"><i class="far fa-eye"></i></a></li>
                                    <li><a href="product-type-1.html" data-tooltip="tooltip" data-placement="left" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                    <li><a href="product-type-3.html" data-tooltip="tooltip" data-placement="left" title="Add to Compare"><i class="fas fa-sync"></i></a></li>
                                </ul>
                            </div>

                            <div class="product-content">
                                <h3><a href="product-type-1.html">Belted chino trousers polo</a></h3>

                                <div class="product-price">
                                    <span class="old-price">$200.00</span>
                                    <span class="new-price">$191.00</span>
                                </div>

                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>

                                <a href="cart.html" class="btn btn-light">Add to Cart</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12">
                        <div class="single-product-box">
                            <div class="product-image">
                                <a href="product-type-1.html">
                                    <img src="assets/img/bestseller-img5.jpg" alt="image">
                                    <img src="assets/img/bestseller-hover-img5.jpg" alt="image">
                                </a>

                                <ul>
                                    <li><a href="#" data-tooltip="tooltip" data-placement="left" title="Quick View" data-bs-toggle="modal" data-bs-target="#productQuickView"><i class="far fa-eye"></i></a></li>
                                    <li><a href="product-type-1.html" data-tooltip="tooltip" data-placement="left" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                    <li><a href="product-type-3.html" data-tooltip="tooltip" data-placement="left" title="Add to Compare"><i class="fas fa-sync"></i></a></li>
                                </ul>

                                <div class="sale-tag">
                                    Sale
                                </div>
                            </div>

                            <div class="product-content">
                                <h3><a href="product-type-1.html">Belted chino trousers polo</a></h3>

                                <div class="product-price">
                                    <span class="new-price">$191.00</span>
                                </div>

                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>

                                <a href="cart.html" class="btn btn-light">Add to Cart</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12">
                        <div class="single-product-box">
                            <div class="product-image">
                                <a href="product-type-1.html">
                                    <img src="assets/img/trending-img8.jpg" alt="image">
                                    <img src="assets/img/trending-hover-img8.jpg" alt="image">
                                </a>

                                <ul>
                                    <li><a href="#" data-tooltip="tooltip" data-placement="left" title="Quick View" data-bs-toggle="modal" data-bs-target="#productQuickView"><i class="far fa-eye"></i></a></li>
                                    <li><a href="product-type-1.html" data-tooltip="tooltip" data-placement="left" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                    <li><a href="product-type-3.html" data-tooltip="tooltip" data-placement="left" title="Add to Compare"><i class="fas fa-sync"></i></a></li>
                                </ul>
                            </div>

                            <div class="product-content">
                                <h3><a href="product-type-1.html">Belted chino trousers polo</a></h3>

                                <div class="product-price">
                                    <span class="new-price">$191.00</span>
                                </div>

                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>

                                <a href="cart.html" class="btn btn-light">Add to Cart</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12">
                        <div class="single-product-box">
                            <div class="product-image">
                                <a href="product-type-1.html">
                                    <img src="assets/img/img2.jpg" alt="image">
                                    <img src="assets/img/img-hover2.jpg" alt="image">
                                </a>

                                <ul>
                                    <li><a href="#" data-tooltip="tooltip" data-placement="left" title="Quick View" data-bs-toggle="modal" data-bs-target="#productQuickView"><i class="far fa-eye"></i></a></li>
                                    <li><a href="product-type-1.html" data-tooltip="tooltip" data-placement="left" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                    <li><a href="product-type-3.html" data-tooltip="tooltip" data-placement="left" title="Add to Compare"><i class="fas fa-sync"></i></a></li>
                                </ul>
                            </div>

                            <div class="product-content">
                                <h3><a href="product-type-1.html">Belted chino trousers polo</a></h3>

                                <div class="product-price">
                                    <span class="new-price">$191.00</span>
                                </div>

                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>

                                <a href="cart.html" class="btn btn-light">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
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