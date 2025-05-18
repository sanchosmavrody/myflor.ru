<div class="modal right fade shoppingCartModal" id="quickOrderModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <div class="modal-body">
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