<?php
function json_response(mixed $data, int $status = 200): string
{
    $res = new Response();
    return $res->json($data, $status);
}
