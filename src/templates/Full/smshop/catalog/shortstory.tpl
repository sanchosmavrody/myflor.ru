<div class="col-lg-6 col-md-6 products-col-item">
    <div class="product-box">
        <div class="product-image">
            <a href="/{shop_catalog}/id/{id}"><img src="{photo_main}" alt="image"></a>

            <ul class="d-none">
                <li><a href="#" data-tooltip="tooltip" data-placement="top" title="Quick View" data-bs-toggle="modal" data-bs-target="#productQuickView"><i class="far fa-eye"></i></a></li>
                <li><a href="product-type-3.html" data-tooltip="tooltip" data-placement="top" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
            </ul>

            {tag_html}


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

            <button class="btn btn-light d-inline-block" data-basket-btn="add" data-item-id="{id}">
                <span class="basket_btn_add">В корзину</span>
                <span class="basket_btn_remove">Убрать из корзины</span>
            </button>

        </div>
    </div>
</div>