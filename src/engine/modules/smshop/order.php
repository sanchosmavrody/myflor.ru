<?php

$tpl->load_template('/smshop/order/main.tpl');
$tpl->set('{shop_catalog}', 'shop_catalog');
$tpl->compile('content');