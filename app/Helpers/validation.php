<?php
function validate(array $data, array $rules): ?array
{
    $v = new Validator();
    return $v->validate($data, $rules) ? null : $v->getErrors();
}
