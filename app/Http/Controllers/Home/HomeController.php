<?php

namespace App\Http\Controllers\Home;

use App\Constants\BannerTypes;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Banner::where('type', BannerTypes::SLIDER)
            ->where('is_active', true)
            ->orderBy('priority')
            ->get();

        $indexTopBanners = Banner::where('type', BannerTypes::INDEX_TOP)
            ->where('is_active', true)
            ->orderBy('priority')
            ->get();

        $indexBottomBanners = Banner::where('type', BannerTypes::INDEX_BOTTOM)
            ->where('is_active', true)
            ->orderBy('priority')
            ->get();

        return view('home.index', compact('sliders', 'indexTopBanners', 'indexBottomBanners'));
    }
}
