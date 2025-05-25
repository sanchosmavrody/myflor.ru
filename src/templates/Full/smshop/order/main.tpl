<section class="checkout-area ptb-60">
    <div class="container">
        <div id="formOrder">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="billing-details">
                        <h3 class="title">Оформление заказа</h3>

                        <div class="messages"></div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Дата доставки <span class="required">*</span></label>
                                    <input name="date" type="date" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Интервал времени <span class="required">*</span></label>
                                    <select name="time" class="form-control">
                                        <option value="" selected="selected">Выберите время</option>
                                        <option value="00:00-00:00">Согласовать с получателем</option>
                                        <option value="09.00-11.00">09.00-11.00</option>
                                        <option value="11:00-13:00">11.00-13.00</option>
                                        <option value="13:00-15:00">13.00-15.00</option>
                                        <option value="15:00-17:00">15.00-17.00</option>
                                        <option value="17:00-19:00">17.00-19.00</option>
                                        <option value="19:00-21:00">19.00-21.00</option>
                                        <option value="21:00-23:00">21.00-23.00</option>
                                        <option value="23:00-09:00">23.00-09.00</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Ваш телефон <span class="required">*</span></label>
                                    <input name="phone" type="tel" class="form-control"/>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Ваше имя</label>
                                    <input name="name" type="text" class="form-control"/>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-check cursor-pointer">
                                    <input type="checkbox" class="form-check-input" id="recipient_other"
                                           data-bs-target="#recipientFields" data-bs-toggle="collapse">
                                    <label class="form-check-label" for="recipient_other">Получатель другой человек (доставим сюрпризом)</label>
                                </div>
                            </div>
                            <div class="collapse in multi-collapse" id="recipientFields">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Телефон получателя<span class="required">*</span></label>
                                            <input name="phoneP" type="tel" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Имя получателя <span class="required">*</span></label>
                                            <input name="nameP" type="text" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label>Адрес <span class="required">*</span></label>
                                    <input id="address" type="text" class="form-control"/>
                                    <input name="address" type="hidden"/>
                                    <input name="addressPoint" type="hidden"/>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>кв./офис, подъезд, этаж</label>
                                    <input name="apartment" type="text" class="form-control"/>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <textarea name="comment" id="notes" cols="30" rows="6" placeholder="Комментарий к заказу" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="order-details">
                        <h3 class="title">Ваш заказ</h3>

                        <div class="order-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Наименование</th>
                                    <th scope="col">Итого</th>
                                </tr>
                                </thead>
                                <tbody id="basket_full_grid"></tbody>
                                <tfoot>
                                <tr>
                                    <td class="order-shipping">
                                        <span>Доставка:</span> <b data-basket-delivery-des></b>
                                    </td>

                                    <td class="shipping-price">
                                        <span id="totalDelivery" data-basket-delivery-price>0</span> <i class="fa fa-rub"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="total-price">
                                        <span>Всего по заказу</span>
                                    </td>

                                    <td class="product-subtotal">
                                        <span class="subtotal-amount"><span data-basket-total>0</span> <i class="fa fa-rub"></i></span>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="payment-method">
                            <p>
                                <input value="online" type="radio" id="pt_online" name="paymentType" checked="checked">
                                <label for="pt_online">Онлайн по ссылке</label>
                                После создания заказа вы сразу сможете оплатить онлайн картой или п СПБ. А так же частями в рассрочку.
                            </p>
                            <p>
                                <input value="courier" type="radio" id="pt_cash" name="paymentType">
                                <label for="pt_cash">Наличными</label>
                                Обращаем внимание - оплатить заказ при получении возможно только если доставка осуществляется вам и вы лично принимаете заказ.
                            </p>
                            <p>
                                <input value="rs" type="radio" id="pt_rs" name="paymentType">
                                <label for="pt_rs">Расчётный счет</label>
                                Уважаемые клиенты! Просим заранее согласовать условия оплаты. Отгрузка товара производится исключительно после поступления денежных средств на наш счет.
                            </p>
                        </div>

                        <button data-order-submit class="btn btn-primary order-btn">Оформить</button>
                    </div>
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


