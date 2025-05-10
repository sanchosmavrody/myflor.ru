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