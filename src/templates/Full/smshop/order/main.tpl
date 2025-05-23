<section class="checkout-area ptb-60">
    <div class="container">
        <form id="formOrder">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="billing-details">
                        <h3 class="title">Оформление заказа</h3>

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
                                        <option value="00.00-00.00" data-end="0">Согласовать с получателем</option>
                                        <option value="11.00-13.00" data-end="11">09.00-11.00</option>
                                        <option value="13.00-15.00" data-end="13">11.00-13.00</option>
                                        <option value="15.00-17.00" data-end="15">13.00-15.00</option>
                                        <option value="17.00-19.00" data-end="17">15.00-17.00</option>
                                        <option value="19.00-21.00" data-end="19">17.00-19.00</option>
                                        <option value="21.00-23.00" data-end="21">19.00-21.00</option>
                                        <option value="21.00-23.00" data-end="23">21.00-23.00</option>
                                        <option value="23.00-09.00" data-end="99">23.00-09.00</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Ваше имя <span class="required">*</span></label>
                                    <input name="name" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Ваш телефон <span class="required">*</span></label>
                                    <input name="phone" type="tel" class="form-control"/>
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
                                            <label class="form-label">Имя получателя <span class="required">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Телефон получателя<span class="required">*</span></label>
                                            <input type="tel" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label>Адрес <span class="required">*</span></label>
                                    <input name="address" type="text" class="form-control">
                                    <input name="addressP" type="hidden">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>кв./офис, подъезд, этаж <span class="required">*</span></label>
                                    <input name="apartment" type="text" class="form-control">
                                </div>
                            </div>


                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <textarea name="notes" id="notes" cols="30" rows="6" placeholder="Комментарий к заказу" class="form-control"></textarea>
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
                                        <span>Доставка</span>
                                    </td>

                                    <td class="shipping-price">
                                        <span>0</span> <i class="fa fa-rub"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="total-price">
                                        <span>Всего по заказу</span>
                                    </td>

                                    <td class="product-subtotal">
                                        <span class="subtotal-amount"><span data-basket-total></span> <i class="fa fa-rub"></i></span>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="payment-method">
                            <p>
                                <input type="radio" id="direct-bank-transfer" name="radio-group" checked="">
                                <label for="direct-bank-transfer">Онлайн по ссылке</label>
                                После создания заказа вы сразу сможете оплатить онлайн картой или п СПБ. А так же частями в рассрочку.

                            </p>
                            <p>
                                <input type="radio" id="paypal" name="radio-group">
                                <label for="paypal">Наличными</label>
                                Обращаем внимание - оплатить заказ при получении возможно только если доставка осуществляется вам и вы лично принимаете заказ.
                            </p>
                            <p>
                                <input type="radio" id="cash-on-delivery" name="radio-group">
                                <label for="cash-on-delivery">Расчётный счет</label>
                                Согласовывайте оплату за ренее, отправка заказа будет осуществлена только после физического прихода средств.
                            </p>
                        </div>

                        <a href="#" class="btn btn-primary order-btn">Оформить</a>
                    </div>
                </div>
            </div>
        </form>
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
                    <td class="product-name">
                        <a href="/{shop_catalog}/id/${item['id']}">${item['title']}</a>
                    </td>
                    <td class="product-total">
                        <span class="subtotal-amount">${item['total']} <i class="fa fa-rub"></i></span>
                    </td>
                </tr>`
            },
        }
    }
</script>


