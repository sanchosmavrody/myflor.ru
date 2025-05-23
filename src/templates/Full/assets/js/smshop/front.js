const SMSHOP = {
    init: function () {
        this.basket.init()
        this.order_quick.init()
        $('input[type="tel"]').mask('+7(000) 000-00-00');
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
                let item_id = $(e.currentTarget).data('item-id').toString();
                let count = 1
                if ($('[data-basket-add-count][data-item-id="' + item_id + '"]').length)
                    count = $('[data-basket-add-count][data-item-id="' + item_id + '"]').val()
                this.req($(e.currentTarget).attr('data-basket-btn'), {'count': count, 'item_id': item_id})

                if ($(e.currentTarget).attr('data-basket-btn') === 'add') {
                    let myModal = new bootstrap.Modal(document.getElementById("shoppingCartModal"), {});
                    myModal.show();
                }

            }).bind(this));

            $('body').on('click', '[data-basket-change-count]', (function (e) {
                this.req($(e.currentTarget).attr('data-basket-change-count'), {
                    'item_id': $(e.currentTarget).data('item-id').toString()
                })
            }).bind(this));

            $('body').on('change', '[data-basket-count]', (function (e) {
                this.req('set_count', {
                    'count': $(e.currentTarget).val(),
                    'item_id': $(e.currentTarget).data('item-id').toString()
                })
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
    order: {},
    order_quick: {
        state: null,
        init: function () {

            $('body').on('click', '[data-order-quick-btn]', (function (e) {
                let item_id = $(e.currentTarget).data('item-id').toString();
                SMSHOP.basket.req('add', {'count': 1, 'item_id': item_id})
                let myModal = new bootstrap.Modal(document.getElementById("quickOrder"), {});
                myModal.show();
            }).bind(this));

            $('#quickOrder').on('click', '[data-order-quick-submit]', (function (e) {
                this.req('add', {'phone': $('.quickOrder #qo_phone').val(), 'comment': $('.quickOrder #qo_comment').val()})
            }).bind(this));
        },
        req: function (action = 'get', data = {}) {
            data['uid'] = SMSHOP.basket.uid
            SMSHOP.helpers.req('order_quick', action, data).done((function (res) {
                this.state = res
                if (!localStorage.getItem('basket_uid') && this.state.uid)
                    localStorage.setItem('basket_uid', this.state.uid)
                //this.processItems()
            }).bind(this))
        },
    }
}

$(document).ready(function () {
    console.info("ready!");
    SMSHOP.init()
});