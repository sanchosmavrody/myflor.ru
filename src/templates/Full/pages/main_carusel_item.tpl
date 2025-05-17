<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="single-product-box">
        <div class="product-image position-relative">
            <a href="/{shop_catalog}/id/{id}"><img src="{photo_main}" alt="image"></a>
            <ul>
                <li><a href="#" data-tooltip="tooltip" data-placement="top" title="Quick View" data-bs-toggle="modal" data-bs-target="#productQuickView"><i class="far fa-eye"></i></a></li>
                <li><a href="product-type-3.html" data-tooltip="tooltip" data-placement="top" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
            </ul>

            <div class="art-tag">
                Арт. №{id}
            </div>
        </div>

        <div class="product-content">
            <h3 style=" height: 55px;"><a href="/{shop_catalog}/id/{id}">{title}</a></h3>

            <div class="product-price">
                <span class="new-price">
                    {price}
                    <i class="fa fa-ruble"></i></span>
            </div>

            <button class="btn btn-light" data-basket-btn="add" data-item-id="{id}">
                <span class="basket_btn_add">В корзину</span>
                <span class="basket_btn_remove">Убрать из корзины</span>
            </button>

        </div>
    </div>
</div>