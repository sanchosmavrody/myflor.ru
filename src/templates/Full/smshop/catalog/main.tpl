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
                            <span class="d-none"><a href="#" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fas fa-filter"></i> Фильтр</a></span>

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


<!-- Start Facility Area -->
<section class="facility-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="facility-box">
                    <div class="icon">
                        <i class="fas fa-plane"></i>
                    </div>
                    <h3>Доставка до 2 часов по мск.</h3>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="facility-box">
                    <div class="icon">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                    <h3>Оплата любыми способами</h3>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="facility-box">
                    <div class="icon">
                        <i class="far fa-flag"></i>
                    </div>
                    <h3>Есть самовывоз</h3>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="facility-box">
                    <div class="icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>24/7 приём заказов</h3>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Facility Area -->

<!-- Start Shopping Cart Modal -->
<div class="modal right fade shoppingCartModal" id="shoppingCartModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <div class="modal-body">
                <h3>Корзина (<span data-basket-count></span>)</h3>

                <div class="product-cart-content">
                    <div class="product-cart">
                        <div class="product-content">
                            <h3>Корзина пуста</h3>
                        </div>
                    </div>
                </div>

                <div class="product-cart-subtotal">
                    <span>Итого по товару</span>
                    <span class="subtotal">
                       <span data-basket-total></span> <i class="fa fa-rub"></i>
                    </span>
                </div>

                <div class="product-cart-btn">
                    <a href="/order/" class="btn btn-primary">Быстрый заказ</a>
                    <a href="/order/" class="btn btn-light">Оформить</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Shopping Cart Modal -->

<!-- Start Wishlist Modal -->
<div class="modal right fade shoppingWishlistModal" id="shoppingWishlistModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <div class="modal-body">
                <h3>My Wish List (3)</h3>

                <div class="product-cart-content">
                    <div class="product-cart">
                        <div class="product-image">
                            <img src="/templates/Full/assets/img/img2.jpg" alt="image">
                        </div>

                        <div class="product-content">
                            <h3><a href="/?do=item">Belted chino trousers polo</a></h3>
                            <span>Blue / XS</span>
                            <div class="product-price">
                                <span>1</span>
                                <span>x</span>
                                <span class="price">$191.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="product-cart">
                        <div class="product-image">
                            <img src="/templates/Full/assets/img/img3.jpg" alt="image">
                        </div>

                        <div class="product-content">
                            <h3><a href="/?do=item">Belted chino trousers polo</a></h3>
                            <span>Blue / XS</span>
                            <div class="product-price">
                                <span>1</span>
                                <span>x</span>
                                <span class="price">$191.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="product-cart">
                        <div class="product-image">
                            <img src="/templates/Full/assets/img/img4.jpg" alt="image">
                        </div>

                        <div class="product-content">
                            <h3><a href="/?do=item">Belted chino trousers polo</a></h3>
                            <span>Blue / XS</span>
                            <div class="product-price">
                                <span>1</span>
                                <span>x</span>
                                <span class="price">$191.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-cart-btn">
                    <a href="cart.html" class="btn btn-light">View Shopping Cart</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Wishlist Modal -->

<!-- Start Products QuickView Modal Area -->
<div class="modal fade productQuickView" id="productQuickView" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fas fa-times"></i></span>
            </button>
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="productQuickView-image">
                        <img src="/templates/Full/assets/img/quick-view-img.jpg" alt="image">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="product-content">
                        <h3><a href="/?do=item">Belted chino trousers polo</a></h3>

                        <div class="price">
                            <span class="new-price">$191.00</span>
                        </div>

                        <div class="product-review">
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <a href="#" class="rating-count">3 reviews</a>
                        </div>

                        <ul class="product-info">
                            <li>
                                <span>Vendor:</span>
                                <a href="#">Lereve</a></li>
                            <li>
                                <span>Availability:</span>
                                <a href="#">In stock (7 items)</a></li>
                            <li>
                                <span>Product Type:</span>
                                <a href="#">T-Shirt</a></li>
                        </ul>

                        <div class="product-color-switch">
                            <h4>Color:</h4>

                            <ul>
                                <li><a href="#" title="Black" class="color-black"></a></li>
                                <li><a href="#" title="White" class="color-white"></a></li>
                                <li class="active"><a href="#" title="Green" class="color-green"></a></li>
                                <li><a href="#" title="Yellow Green" class="color-yellowgreen"></a></li>
                                <li><a href="#" title="Teal" class="color-teal"></a></li>
                            </ul>
                        </div>

                        <div class="product-size-wrapper">
                            <h4>Size:</h4>

                            <ul>
                                <li><a href="collections-style-1.html">XS</a></li>
                                <li class="active"><a href="collections-style-1.html">S</a></li>
                                <li><a href="collections-style-1.html">M</a></li>
                                <li><a href="collections-style-1.html">XL</a></li>
                                <li><a href="collections-style-1.html">XXL</a></li>
                            </ul>
                        </div>

                        <div class="product-add-to-cart">
                            <div class="input-counter">
                                <span class="minus-btn"><i class="fas fa-minus"></i></span>
                                <input type="text" value="1">
                                <span class="plus-btn"><i class="fas fa-plus"></i></span>
                            </div>

                            <button type="submit" class="btn btn-primary"><i class="fas fa-cart-plus"></i> В корзину</button>
                        </div>

                        <a href="/?do=item" class="view-full-info">View full info</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Products QuickView Modal Area -->

<!-- Start Size Guide Modal Area -->
<div class="modal fade sizeGuideModal" id="sizeGuideModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fas fa-times"></i></span>
            </button>

            <div class="modal-sizeguide">
                <h3>Size Guide</h3>
                <p>This is an approximate conversion table to help you find your size.</p>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Italian</th>
                            <th>Spanish</th>
                            <th>German</th>
                            <th>UK</th>
                            <th>US</th>
                            <th>Japanese</th>
                            <th>Chinese</th>
                            <th>Russian</th>
                            <th>Korean</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>34</td>
                            <td>30</td>
                            <td>28</td>
                            <td>4</td>
                            <td>00</td>
                            <td>3</td>
                            <td>155/75A</td>
                            <td>36</td>
                            <td>44</td>
                        </tr>
                        <tr>
                            <td>36</td>
                            <td>32</td>
                            <td>30</td>
                            <td>6</td>
                            <td>0</td>
                            <td>5</td>
                            <td>155/80A</td>
                            <td>38</td>
                            <td>44</td>
                        </tr>
                        <tr>
                            <td>38</td>
                            <td>34</td>
                            <td>32</td>
                            <td>8</td>
                            <td>2</td>
                            <td>7</td>
                            <td>160/84A</td>
                            <td>40</td>
                            <td>55</td>
                        </tr>
                        <tr>
                            <td>40</td>
                            <td>36</td>
                            <td>34</td>
                            <td>10</td>
                            <td>4</td>
                            <td>9</td>
                            <td>165/88A</td>
                            <td>42</td>
                            <td>55</td>
                        </tr>
                        <tr>
                            <td>42</td>
                            <td>38</td>
                            <td>36</td>
                            <td>12</td>
                            <td>6</td>
                            <td>11</td>
                            <td>170/92A</td>
                            <td>44</td>
                            <td>66</td>
                        </tr>
                        <tr>
                            <td>44</td>
                            <td>40</td>
                            <td>38</td>
                            <td>14</td>
                            <td>8</td>
                            <td>13</td>
                            <td>175/96A</td>
                            <td>46</td>
                            <td>66</td>
                        </tr>
                        <tr>
                            <td>46</td>
                            <td>42</td>
                            <td>40</td>
                            <td>16</td>
                            <td>10</td>
                            <td>15</td>
                            <td>170/98A</td>
                            <td>48</td>
                            <td>77</td>
                        </tr>
                        <tr>
                            <td>48</td>
                            <td>44</td>
                            <td>42</td>
                            <td>18</td>
                            <td>12</td>
                            <td>17</td>
                            <td>170/100B</td>
                            <td>50</td>
                            <td>77</td>
                        </tr>
                        <tr>
                            <td>50</td>
                            <td>46</td>
                            <td>44</td>
                            <td>20</td>
                            <td>14</td>
                            <td>19</td>
                            <td>175/100B</td>
                            <td>52</td>
                            <td>88</td>
                        </tr>
                        <tr>
                            <td>52</td>
                            <td>48</td>
                            <td>46</td>
                            <td>22</td>
                            <td>16</td>
                            <td>21</td>
                            <td>180/104B</td>
                            <td>54</td>
                            <td>88</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Size Guide Modal Area -->

<!-- Start Shipping Modal Area -->
<div class="modal fade productShippingModal" id="productShippingModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fas fa-times"></i></span>
            </button>

            <div class="shipping-content">
                <h3>Shipping</h3>
                <ul>
                    <li>Complimentary ground shipping within 1 to 7 business days</li>
                    <li>In-store collection available within 1 to 7 business days</li>
                    <li>Next-day and Express delivery options also available</li>
                    <li>Purchases are delivered in an orange box tied with a Bolduc ribbon, with the exception of certain items</li>
                    <li>See the delivery FAQs for details on shipping methods, costs and delivery times</li>
                </ul>

                <h3>Returns and Exchanges</h3>
                <ul>
                    <li>Easy and complimentary, within 14 days</li>
                    <li>See conditions and procedure in our return FAQs</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Shipping Modal Area -->

<!-- Start Products Filter Modal Area -->
<div class="modal left fade productsFilterModal" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fas fa-times"></i> Close</span>
            </button>

            <div class="modal-body">
                <div class="woocommerce-sidebar-area">
                    <div class="collapse-widget filter-list-widget">
                        <h3 class="collapse-widget-title">
                            Current Selection

                            <i class="fas fa-angle-up"></i>
                        </h3>

                        <div class="selected-filters-wrap-list">
                            <ul>
                                <li><a href="/?do=item">44</a></li>
                                <li><a href="/?do=item">XI</a></li>
                                <li><a href="/?do=item">Clothing</a></li>
                                <li><a href="/?do=item">Shoes</a></li>
                                <li><a href="/?do=item">Accessories</a></li>
                            </ul>

                            <div class="delete-selected-filters">
                                <a href="#"><i class="far fa-trash-alt"></i>
                                    <span>Clear All</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="collapse-widget collections-list-widget">
                        <h3 class="collapse-widget-title">
                            Collections

                            <i class="fas fa-angle-up"></i>
                        </h3>

                        <ul class="collections-list-row">
                            <li class="active"><a href="collections-style-1.html">Women’s</a></li>
                            <li><a href="collections-style-1.html">Men</a></li>
                            <li><a href="collections-style-1.html">Clothing</a></li>
                            <li><a href="collections-style-1.html">Shoes</a></li>
                            <li><a href="collections-style-1.html">Accessories</a></li>
                            <li><a href="collections-style-1.html">Uncategorized</a></li>
                        </ul>
                    </div>

                    <div class="collapse-widget brands-list-widget">
                        <h3 class="collapse-widget-title">
                            Brands

                            <i class="fas fa-angle-up"></i>
                        </h3>

                        <ul class="brands-list-row">
                            <li class="active"><a href="category-left-sidebar-with-block-2.html">Adidas</a></li>
                            <li><a href="category-left-sidebar-with-block-2.html">Nike</a></li>
                            <li><a href="category-left-sidebar-with-block-2.html">Reebok</a></li>
                            <li><a href="category-left-sidebar-with-block-2.html">Shoes</a></li>
                            <li><a href="category-left-sidebar-with-block-2.html">Ralph Lauren</a></li>
                            <li><a href="category-left-sidebar-with-block-2.html">Delpozo</a></li>
                        </ul>
                    </div>

                    <div class="collapse-widget size-list-widget">
                        <h3 class="collapse-widget-title">
                            Size

                            <i class="fas fa-angle-up"></i>
                        </h3>

                        <ul class="size-list-row">
                            <li><a href="product-type-2.html">20</a></li>
                            <li><a href="product-type-2.html">24</a></li>
                            <li><a href="product-type-2.html">36</a></li>
                            <li><a href="product-type-2.html">30</a></li>
                            <li class="active"><a href="product-type-2.html">XS</a></li>
                            <li><a href="product-type-2.html">S</a></li>
                            <li><a href="product-type-2.html">M</a></li>
                            <li><a href="product-type-2.html">L</a></li>
                            <li><a href="product-type-2.html">L</a></li>
                            <li><a href="product-type-2.html">XL</a></li>
                        </ul>
                    </div>

                    <div class="collapse-widget price-list-widget">
                        <h3 class="collapse-widget-title">
                            Price

                            <i class="fas fa-angle-up"></i>
                        </h3>

                        <ul class="price-list-row">
                            <li><a href="product-type-3.html">$10 - $100</a></li>
                            <li class="active"><a href="product-type-3.html">$100 - $200</a></li>
                            <li><a href="product-type-3.html">$200 - $300</a></li>
                            <li><a href="product-type-3.html">$300 - $400</a></li>
                            <li><a href="product-type-3.html">$400 - $500</a></li>
                            <li><a href="product-type-3.html">$500 - $600</a></li>
                        </ul>
                    </div>

                    <div class="collapse-widget color-list-widget">
                        <h3 class="collapse-widget-title">
                            Color

                            <i class="fas fa-angle-up"></i>
                        </h3>

                        <ul class="color-list-row">
                            <li><a href="product-type-3.html" title="Black" class="color-black"></a></li>
                            <li><a href="product-type-3.html" title="Red" class="color-red"></a></li>
                            <li><a href="product-type-3.html" title="Yellow" class="color-yellow"></a></li>
                            <li><a href="product-type-3.html" title="White" class="color-white"></a></li>
                            <li><a href="product-type-3.html" title="Blue" class="color-blue"></a></li>
                            <li><a href="product-type-3.html" title="Green" class="color-green"></a></li>
                            <li><a href="product-type-3.html" title="Yellow Green" class="color-yellowgreen"></a></li>
                            <li><a href="product-type-3.html" title="Pink" class="color-pink"></a></li>
                            <li><a href="product-type-3.html" title="Violet" class="color-violet"></a></li>
                            <li><a href="product-type-3.html" title="Blue Violet" class="color-blueviolet"></a></li>
                            <li><a href="product-type-3.html" title="Lime" class="color-lime"></a></li>
                            <li><a href="product-type-3.html" title="Plum" class="color-plum"></a></li>
                            <li><a href="product-type-3.html" title="Teal" class="color-teal"></a></li>
                        </ul>
                    </div>

                    <div class="collapse-widget tag-list-widget">
                        <h3 class="collapse-widget-title">
                            Popular Tags

                            <i class="fas fa-angle-up"></i>
                        </h3>

                        <ul class="tags-list-row">
                            <li><a href="#">Vintage</a></li>
                            <li><a href="#">Black</a></li>
                            <li class="active"><a href="#">Discount</a></li>
                            <li><a href="#">Good</a></li>
                            <li><a href="#">Jeans</a></li>
                            <li><a href="#">Summer</a></li>
                            <li><a href="#">Winter</a></li>
                        </ul>
                    </div>

                    <div class="collapse-widget aside-products-widget">
                        <h3 class="aside-widget-title">
                            Popular Products
                        </h3>

                        <div class="aside-single-products">
                            <div class="products-image">
                                <a href="/?do=item">
                                    <img src="/templates/Full/assets/img/img2.jpg" alt="image">
                                </a>
                            </div>

                            <div class="products-content">
                                <span><a href="category-left-sidebar.html">Men's</a></span>
                                <h3><a href="/?do=item">Belted chino trousers polo</a></h3>

                                <div class="product-price">
                                    <span class="new-price">$191.00</span>
                                    <span class="old-price">$291.00</span>
                                </div>
                            </div>
                        </div>

                        <div class="aside-single-products">
                            <div class="products-image">
                                <a href="/?do=item">
                                    <img src="/templates/Full/assets/img/img3.jpg" alt="image">
                                </a>
                            </div>

                            <div class="products-content">
                                <span><a href="category-left-sidebar.html">Men's</a></span>
                                <h3><a href="/?do=item">Belted chino trousers polo</a></h3>

                                <div class="product-price">
                                    <span class="new-price">$191.00</span>
                                    <span class="old-price">$291.00</span>
                                </div>
                            </div>
                        </div>

                        <div class="aside-single-products">
                            <div class="products-image">
                                <a href="/?do=item">
                                    <img src="/templates/Full/assets/img/img4.jpg" alt="image">
                                </a>
                            </div>

                            <div class="products-content">
                                <span><a href="category-left-sidebar.html">Men's</a></span>
                                <h3><a href="/?do=item">Belted chino trousers polo</a></h3>

                                <div class="product-price">
                                    <span class="new-price">$191.00</span>
                                    <span class="old-price">$291.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="collapse-widget aside-trending-widget">
                        <div class="aside-trending-products">
                            <img src="/templates/Full/assets/img/bestseller-hover-img1.jpg" alt="image">

                            <div class="category">
                                <h4>Top Trending</h4>
                                <span>Spring/Summer 2024 Collection</span>
                            </div>

                            <a href="#"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Products Filter Modal Area -->


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