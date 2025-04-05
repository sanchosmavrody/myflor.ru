<section class="cart-area ptb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <form>
                    <div class="cart-table table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Позиция</th>
                                <th scope="col">Цена</th>
                                <th scope="col">Количество</th>
                                <th scope="col">Итого</th>
                            </tr>
                            </thead>

                            <tbody id="basket_full_grid"></tbody>
                        </table>
                    </div>
                    <div class="cart-buttons">
                        <div class="row align-items-center">
                            <div class="col-lg-7 col-md-7">
                                <div class="continue-shopping-box">
                                    <a href="/" class="btn btn-light">Продолжить покупки</a>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-5 text-right">
                                <a href="/order/" class="btn btn-primary">Оформить заказ</a>
                            </div>
                        </div>
                    </div>
                    <div class="cart-totals">
                        <h3>Итого</h3>

                        <ul>
                            <li>Товар <span data-basket-total></span></li>
                            <li>Доставка <span>0</span></li>
                            <li>Итого <span><b data-basket-total></b><i class="fa fa-rub"></i></span></li>
                        </ul>
                        <a href="/order/" class="btn btn-light">Оформить заказ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<script>
    const SMSHOPTPL = {
        basket: {
            count_target: $('[data-basket-count]'),
            total_target: $('[data-basket-total]'),
            short_target: $('#basket_full_grid'),
            short_item: function (item) {
                return `
                <tr>
                    <td class="product-thumbnail">
                        <a href="/{shop_catalog}/id/${item['id']}">
                            <img src="${item['photo_main']}" alt="image">
                        </a>
                    </td>

                    <td class="product-name">
                        <a href="/{shop_catalog}/id/${item['id']}">${item['title']}</a>
                        <ul>
                            <li>Раздел: <strong>${item['category_2']}</strong></li>
                            <li>Size: <strong>XL</strong></li>
                            <li>Material: <strong>Cotton</strong></li>
                        </ul>
                    </td>
                    <td class="product-price">
                        <span class="unit-amount">${item['price']}<i class="fa fa-rub"></i> </span>
                    </td>
                    <td class="product-quantity">
                        <div class="input-counter">
                            <span data-basket-change-count="minus" data-item-id="${item['item_id']}" class="minus-btn"><i class="fas fa-minus"></i></span>
                            <input data-basket-count data-item-id="${item['item_id']}" type="text" value="${item['count']}">
                            <span data-basket-change-count="plus" data-item-id="${item['item_id']}" class="plus-btn"><i class="fas fa-plus"></i></span>
                        </div>
                    </td>
                    <td class="product-subtotal">
                        <span class="subtotal-amount">${item['total']}<i class="fa fa-rub"></i></span>
                        <a href="#" class="remove" data-basket-btn="remove" data-item-id="${item['item_id']}"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>`
            },
        }
    }
</script>