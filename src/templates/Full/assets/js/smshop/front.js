const SMSHOP = {
    init: function () {
        if (window.location.pathname === '/order/')
            this.order.init()
        else {
            this.basket.init()
            this.order_quick.init()
        }
        $('input[type="tel"]').mask('+7(000) 000-00-00');
    },
    ui: {},
    helpers: {
        ajax_url: '/engine/ajax/smshop/index.php', req: function (mod, action, data) {
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
                    'count': $(e.currentTarget).val(), 'item_id': $(e.currentTarget).data('item-id').toString()
                })
            }).bind(this));
            this.req()
        },
        req: function (action = 'get', data = {}) {
            data['uid'] = this.uid
            SMSHOP.helpers.req('basket', action, data).done((function (res) {
                this.state = res
                if (!localStorage.getItem('basket_uid') && this.state.uid) localStorage.setItem('basket_uid', this.state.uid)
                this.processItems()
            }).bind(this))
        },
        processItems: function () {
            if (this.state) {

                $(SMSHOPTPL.basket.count_target).text(this.state.pager.total)
                if (this.state.totals) $(SMSHOPTPL.basket.total_target).text(this.state.totals.total)

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
    order: {
        uid: localStorage.getItem('basket_uid') ? localStorage.getItem('basket_uid') : '',
        state: {
            messages: [],
            address: '',
            addressPoint: '',
            apartment: '',
            date: '',
            time: '',
            name: '',
            phone: '',
            nameP: '',
            phoneP: '',
            basket: {data: []},
            delivery: {
                price: 0,
                des: ''
            },
            paymentType: '',
            totalSumm: 0
        },
        init: function () {
            if ($('#address').length > 0) {
                $('#address').change(function (e) {
                    $('[name="adressP"]').val($(this).val());
                });
                $('#address').suggestions({
                    token: "5eaf99e5874141a6ce002e8d3badc229ecb42825", type: "ADDRESS",
                    onSelect: (function (suggestion) {
                        const Selected = {name: suggestion.value, coordinates: [suggestion.data.geo_lat, suggestion.data.geo_lon], type: suggestion.data.fias_level, metro: suggestion.data.metro}
                        this.state.address = Selected.name
                        this.state.addressPoint = Selected.coordinates
                        this.setState(this.state)
                        this.req('calc', this.state)
                    }).bind(this)
                });
            }

            $('#recipient_other').change(function () {
                if (!$(this).is(':checked'))
                    $('[name="nameP"],[name="phoneP"]').val('')
            })

            $('#formOrder [name]').change((function (item) {
                this.state[$(item.target).attr('name')] = $(item.target).val()
                if (['date', 'time', 'addressPoint'].indexOf($(item.target).attr('name')) > -1)
                    this.req('calc', this.state)
            }).bind(this))

            $('body').on('click', '[data-order-quick-submit]', (function (e) {
                this.req('add', this.state)
            }).bind(this));

            this.req()
        },
        setState: function (newState) {
            this.state = {...this.state, ...newState};

            $(SMSHOPTPL.order.message_target).html('')
            this.state.messages.map(function (item) {
                $(SMSHOPTPL.order.message_target).append(SMSHOPTPL.order.message_item(item))
            })

            $('#formOrder [name]').each((function (i, item) {
                if (this.state[$(item).attr('name')] === undefined)
                    return
                if ($(item).attr('type') === 'radio')
                    $('input:radio[name="' + $(item).attr('name') + '"][value=' + this.state[$(item).attr('name')] + ']').prop('checked', true);
                else
                    $(item).val(this.state[$(item).attr('name')])
            }).bind(this))

            $(SMSHOPTPL.order.delivery_price_target).text(this.state.delivery.price)
            $(SMSHOPTPL.order.delivery_des_target).text(this.state.delivery.des)
            $(SMSHOPTPL.basket.total_target).text(this.state.totalSumm)
            $(SMSHOPTPL.basket.short_target).html('')
            this.state.basket.data.map(function (item) {
                $(SMSHOPTPL.basket.short_target).append(SMSHOPTPL.basket.short_item(item))
            })
        },
        req: function (action = 'get', data = {}) {
            data['uid'] = this.uid
            delete data['basket']
            SMSHOP.helpers.req('order', action, data).done((function (newState) {
                if (action === 'add' && newState.messages.length === 0 && newState.order_id)
                    location.href = '/order/' + newState.order_id
                this.setState(newState)
            }).bind(this))
        },
    },
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
                if (!localStorage.getItem('basket_uid') && this.state.uid) localStorage.setItem('basket_uid', this.state.uid)
            }).bind(this))
        },
    }
}

$(document).ready(function () {
    console.info("ready!");
    SMSHOP.init()
});