<!-- Start Shopping Cart Modal -->
<div class="modal right fade shoppingCartModal" id="shoppingCartModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span>&times;</span>
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
                    <a href="/basket/" class="btn btn-primary">Оформить заказ</a>
                </div>

                <hr>

                <div class="quickOrderModal">
                    <h3>Быстрый заказ</h3>
                    <div class="mb-3">
                        <label for="qo_phone" class="form-label">Ваш телефон</label>
                        <input type="tel" class="form-control" id="qo_phone" placeholder="+7(000) 000-00-00">
                    </div>
                    <div class="mb-3">
                        <label for="qo_comment" class="form-label">Комментарий (не обязательно)</label>
                        <textarea class="form-control" id="qo_comment" rows="3"></textarea>
                    </div>
                    <div class="product-cart-btn">
                        <button data-order-quick-submit class="btn btn-light w-100">Заказать</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- End Shopping Cart Modal -->