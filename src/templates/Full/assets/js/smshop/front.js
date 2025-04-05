const SMSHOPTPL = {
    basket: {
        count_target: $('[data-basket-count]'),
        total_target: $('[data-basket-total]'),
        short_target: $('#shoppingCartModal .product-cart-content'),
        short_item: function (item) {
            return `<div class="product-cart position-relative">
                        <div class="product-image">
                            <img src="${item['photo_main']}" alt="image">
                        </div>
                        <div class="product-content">
                            <h3><a href="/id/${item['item_id']}">${item['title']}</a></h3>
                            <span>${item['category_2']}</span>
                            <div class="product-price">
                                <span>${item['count']}</span>
                                <span>x</span>
                                <span class="price">${item['price']} <i class="fa fa-rub"></i> </span>
                            </div>
                        </div>
                        <span class="position-absolute top-0 end-0 text-danger cursor-pointer" data-basket-btn="remove" data-item-id="${item['item_id']}" ><i class="fa fa-remove"></i></span>
                    </div>`
        },
    }
}
const SMSHOP = {
    init: function () {
        this.basket.init()
    },
    ui: {},
    helpers: {
        ajax_url: '/engine/ajax/smshop/index.php',
        req: function (mod, action, data) {
            return $.ajax(this.ajax_url + `?mod=${mod}&act=${action}`, {data: data, type: 'POST'})
        },
    },
    basket: {
        state: null,
        uid: localStorage.getItem('basket_uid') ? localStorage.getItem('basket_uid') : '',
        init: function () {
            $('body').on('click', '[data-basket-btn]', (function (e) {
                this.req($(e.currentTarget).attr('data-basket-btn'), {'item_id': $(e.currentTarget).data('item-id').toString()})
            }).bind(this));
            this.req()
        },
        req: function (action = 'get', data = {}) {
            data['uid'] = this.uid
            SMSHOP.helpers.req('basket', action, data).done((function (res) {
                this.state = res
                if (!localStorage.getItem('basket_uid') && this.state.uid)
                    localStorage.setItem('basket_uid', this.state.uid)
                this.processItems()
            }).bind(this))
        },
        processItems: function () {
            if (this.state) {

                $(SMSHOPTPL.basket.count_target).text(this.state.pager.total)
                if (this.state.totals)
                    $(SMSHOPTPL.basket.total_target).text(this.state.totals.total)

                let item_id_list = [];
                $(SMSHOPTPL.basket.short_target).html('')
                this.state.data.map(function (item) {
                    $(SMSHOPTPL.basket.short_target).append(SMSHOPTPL.basket.short_item(item))
                    item_id_list.push(item['item_id'].toString())
                })
                //process all button to basket on page
                $('body [data-basket-btn]').each(function () {
                    $(this).attr('data-basket-btn', 'add')
                    if (item_id_list.indexOf($(this).data('item-id').toString()) > -1)
                        $(this).attr('data-basket-btn', 'remove')
                })
            }
        }
    },
    order: {}
}

$(document).ready(function () {
    console.log("ready!");
    SMSHOP.init()
});