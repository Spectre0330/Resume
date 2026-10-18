<?php

namespace App\Models\Contracts;

/**
 * A model whose records are displayed in an admin-defined order.
 */
interface HasSortOrder
{
    /**
     * Move the given record to a new zero-based position, shifting the others.
     */
    public static function moveTo(int $id, int $position): void;
}
