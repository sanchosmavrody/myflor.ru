<tr>
    <td class="product-thumbnail">
        <a href="/{shop_catalog}/id/{id}">
            <img src="{photo_main}" alt="image">
        </a>
    </td>

    <td class="product-name">
        <a href="/{shop_catalog}/id/{id}">{title}</a>
        <ul>
            <li>Раздел: <strong>{category_2}</strong></li>
            <li>Size: <strong>XL</strong></li>
            <li>Material: <strong>Cotton</strong></li>
        </ul>
    </td>

    <td class="product-price">
        <span class="unit-amount">{price}<i class="fa fa-rub"></i> </span>
    </td>

    <td class="product-quantity">
        <div class="input-counter">
            <span class="minus-btn"><i class="fas fa-minus"></i></span>
            <input type="text" value="1">
            <span class="plus-btn"><i class="fas fa-plus"></i></span>
        </div>
    </td>

    <td class="product-subtotal">
        <span class="subtotal-amount">{total}<i class="fa fa-rub"></i></span>
        <a href="#" class="remove"><i class="far fa-trash-alt"></i></a>
    </td>
</tr>