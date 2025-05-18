<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminOrderBranchFilter extends Component {
    public function __construct(public $branches = []) {
        $this->branches = $branches;
    }
    public function render(): View|Closure|string {
        return view('components.orders.admin-order-branch-filter');
    }
}
