<?php
/*
 *  Used to write in ..env file
 *  @param
 *  $data as array of ..env key & value
 *  @return nothing
 */

function generateSelectOption($data): array
{
    $options = array();
    foreach ($data as $key => $value) {
        $options[] = ['title' => $value, 'value' => $key];
    }
    return $options;
}
