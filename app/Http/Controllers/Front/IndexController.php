<?php namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->viewFactory->make('front.index');
    }
}
