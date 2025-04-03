<?php

if (!empty($_FILES['file'])) {
    if (empty($_FILES['file']['tmp_name']) or empty($_FILES['file']['name']))
        $Res = ['messages' => ['Ошибка 1']];
    else {
        $type = FilesHelper::get_ext_from_url($_FILES['file']['name']);
        if (is_uploaded_file($_FILES['file']['tmp_name']) and in_array($type, ["jpg", "jpeg", "png", "gif"])) {
            $fileName = $_REQUEST['id'] . "_" . $_REQUEST['field'] . "_" . time() . "." . $type;
            $filePath = FilesHelper::$upload_dir . "/{$_REQUEST['module_name']}/" . date('Y-m-d') . "/";

            if (FilesHelper::save($_FILES['file']['tmp_name'], $filePath, $fileName))
                $Res = ['link' => 'https://' . $_SERVER['HTTP_HOST'] . $filePath . $fileName];
            else
                $Res = ['messages' => ['Ошибка 2 #']];
        } else
            $Res = ['messages' => ['Ошибка 3']];
    }
} else if (!empty($_FILES['files'])) {

    $Res = [];
    foreach ($_FILES['files']['tmp_name'] as $index => $tmp_name) {
        if (empty($_FILES['files']['tmp_name'][$index]) or empty($_FILES['files']['name']))
            $Errors[] = 'Ошибка 1';
        else {
            $type = FilesHelper::get_ext_from_url($_FILES['files']['name'][$index]);
            if (is_uploaded_file($_FILES['files']['tmp_name'][$index]) and in_array($type, ["jpg", "jpeg", "png", "gif"])) {
                $fileName = $_REQUEST['id'] . "_" . $_REQUEST['field'] . "_" . time() . $index . "." . $type;
                $filePath = FilesHelper::$upload_dir . "/{$_REQUEST['module_name']}/" . date('Y-m-d') . "/";
                if (FilesHelper::save($_FILES['files']['tmp_name'][$index], $filePath, $fileName))
                    $links[] = 'https://' . $_SERVER['HTTP_HOST'] . $filePath . $fileName;
                else
                    $Errors[] = 'Ошибка 2 #';
            } else
                $Errors[] = 'Ошибка 3';
        }

        if (empty($Errors))
            $Res = ['link' => implode(',', $links)];
        else
            $Res = ['messages' => $Errors, '_FILES' => var_export($_FILES)];
    }

} else
    $Res = ['messages' => ['Ошибка 0', '_FILES' => var_export($_FILES)]];