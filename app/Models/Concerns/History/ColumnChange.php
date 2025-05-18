<?php

namespace App\Models\Concerns\History;

class ColumnChange
{
    public function __construct(
        public string $column,
        public mixed $from,
        public mixed $to
    ) {
        
    }
}
