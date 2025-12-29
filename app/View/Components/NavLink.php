<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavLink extends Component
{
    public int $totalKyc;
    public int $totalPending;
    public int $totalMemo;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->totalKyc = 0;
        $this->totalPending = 0;
        $this->totalMemo = 0;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav-link', [
            'totalKyc' => $this->totalKyc,
            'totalPending' => $this->totalPending,
            'totalMemo' => $this->totalMemo,
        ]);
    }
}
