<?php

if ($member_id['user_group'] == 1)
    echo file_get_contents(ROOT_DIR . '/templates/Full/demo/' . $_REQUEST['file'] . '.html');
exit();