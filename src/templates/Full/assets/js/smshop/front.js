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
                let count = 1
                if ($('[data-basket-count][data-item-id="' + $(e.currentTarget).data('item-id') + '"]').length)
                    count = $('[data-basket-count][data-item-id="' + $(e.currentTarget).data('item-id') + '"]').val()
                this.req($(e.currentTarget).attr('data-basket-btn'), {'count': count, 'item_id': $(e.currentTarget).data('item-id').toString()})
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
    order: {}
}

$(document).ready(function () {
    console.log("ready!");
    SMSHOP.init()
});