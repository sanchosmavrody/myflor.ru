<?php

$tpl->load_template('/smshop/basket.tpl');
$tpl->set('{shop_catalog}', 'shop_catalog');
$tpl->compile('content');