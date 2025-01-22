<?php

namespace App\Traits;

trait SelectTrait {
    
    public function scopeSelectElements($query, $column)
    {
        return $query->orderBy($column, 'asc')->pluck($column, 'id');
    }
}