<section class="checkout-area ptb-60">
    <div class="container">
        <form>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="billing-details">
                        <h3 class="title">Billing Details</h3>

                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label>Country <span class="required">*</span></label>

                                    <div class="select-box">
                                        <select class="form-control" style="display: none;">
                                            <option value="5">United Arab Emirates</option>
                                            <option value="1">China</option>
                                            <option value="2">United Kingdom</option>
                                            <option value="0">Germany</option>
                                            <option value="3">France</option>
                                            <option value="4">Japan</option>
                                        </select>
                                        <div class="nice-select form-control" tabindex="0"><span class="current">China</span>
                                            <ul class="list">
                                                <li data-value="5" class="option focus">United Arab Emirates</li>
                                                <li data-value="1" class="option selected">China</li>
                                                <li data-value="2" class="option">United Kingdom</li>
                                                <li data-value="0" class="option">Germany</li>
                                                <li data-value="3" class="option">France</li>
                                                <li data-value="4" class="option">Japan</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>First Name <span class="required">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Last Name <span class="required">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-6">
                                <div class="form-group">
                                    <label>Address <span class="required">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-6">
                                <div class="form-group">
                                    <label>Town / City <span class="required">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>State / County <span class="required">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Postcode / Zip <span class="required">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Email Address <span class="required">*</span></label>
                                    <input type="email" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Phone <span class="required">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="create-an-account">
                                    <label class="form-check-label" for="create-an-account">Create an account?</label>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="ship-different-address">
                                    <label class="form-check-label" for="ship-different-address">Ship to a different address?</label>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <textarea name="notes" id="notes" cols="30" rows="6" placeholder="Order Notes" class="form-control"></textarea>
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

                                <tbody id="basket_full_grid">

                                </tbody>
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
                                <label for="direct-bank-transfer">Direct Bank Transfer</label>

                                Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.
                            </p>
                            <p>
                                <input type="radio" id="paypal" name="radio-group">
                                <label for="paypal">PayPal</label>
                            </p>
                            <p>
                                <input type="radio" id="cash-on-delivery" name="radio-group">
                                <label for="cash-on-delivery">Cash on Delivery</label>
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


