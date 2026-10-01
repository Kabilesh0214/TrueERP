<?php
function auth_user(): ?array
{
    $session = new Session();
    return $session->get('user');
}

function auth_check(): bool
{
    $session = new Session();
    return $session->has('user');
}
