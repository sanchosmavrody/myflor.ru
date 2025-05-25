<section class="checkout-area ptb-60">
    <div class="container">


        <div class="d-flex justify-content-center align-items-center">
            <div class="card col-md-8 bg-white shadow p-5">
                <div class="mb-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                </div>
                <div class="text-center">
                    <h1>Спасибо за заказ!</h1>
                    <p>Ваш заказ успешно оформлен. Мы отправили подтверждение на вашу почту.</p>
                    <a class="btn btn-outline-success" href="/">Вернуться на главную</a>
                </div>
            </div>
        </div>


    </div>
</section>


<script>
    const SMSHOPTPL = {
        order: {
            message_target: $('.messages'),
            message_item: function (item) {
                return `<div class="alert alert-${item['type']}" role="alert">${item['text']} </div>`
            },
            delivery_price_target: $('[data-basket-delivery-price]'),
            delivery_des_target: $('[data-basket-delivery-des]'),
        },
        basket: {
            count_target: $('[data-basket-count]'),
            total_target: $('[data-basket-total]'),
            short_target: $('#basket_full_grid'),
            short_item: function (item) {
                return `<tr>
                    <td class="product-name">
                        <a target="_blank" href="/{shop_catalog}/id/${item['id']}"><b>${item['count']}х</b> ${item['title']}</a>
                    </td>
                    <td class="product-total">
                        <span class="subtotal-amount">${item['total']} <i class="fa fa-rub"></i></span>
                    </td>
                </tr>`
            },
        }
    }
</script>


