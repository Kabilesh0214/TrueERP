<?php
class Item extends Model
{
    protected string $table = 'items';

    public function findByCode(string $code): ?array
    {
        return $this->findBy('code', $code);
    }
}
