$(document).ready(function () {


    $('#catalog_search_control input').keyup(function () {

        var val = $(this).val();

        if (val.toString().length < 3) {
            $('#catalog_search').hide();
            $('#catalog_page').show();
            return;
        }
        $('#catalog_search_control .spinner-border').show();
        $('#catalog_search_control .ti-search').hide();

        var data = {'search_text': val};
        $.ajax({
            type: "POST",
            crossDomain: true,
            url: '/engine/ajax/shop/index.php?mod=catalog&act=search_catalog',
            data: data,
            dataType: "json",
            success: function (res) {
                $('#catalog_search_control .spinner-border').hide();
                $('#catalog_search_control .ti-search').show();

                $('#catalog_search').show();
                $('#catalog_page').hide();

                $('#catalog_search tbody').text('');
                $.each(res['data'], function (key, row) {
                    $('#catalog_search tbody').append(`<tr class="price_row">
                                <td class="text-muted td_code" scope="row">${row['code']}</td>
                                <td class="text-muted td_img" scope="row"></td>
                                <td class="text-muted td_name" scope="row">${row['name']}</td>
                                <td class="text-muted td_amount" scope="row">8</td>
                                <td class="text-muted td_availability" scope="row">Да</td>
                                <td class="text-muted td_price_1" scope="row">276 ₽</td>
                                <td class="text-muted td_basket" scope="row">+</td>
                            </tr>`);
                });
            },
            error: function (errMsg) {
                $('#catalog_search_control .spinner-border').hide();
                $('#catalog_search_control .ti-search').show();
            }
        });

    });


});