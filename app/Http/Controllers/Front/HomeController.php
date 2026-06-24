<?php
declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\VehicleModel;
use App\Models\Vehicle;
use Illuminate\Contracts\View\View;

final class HomeController extends Controller
{
    public function index(): View
    {
        $categories = VehicleModel::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $featuredProducts = Vehicle::query()
            ->with(['category', 'brand'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->limit(6)
            ->get();

        $latestProducts = Vehicle::query()
            ->with(['category', 'brand'])
            ->where('is_active', true)
            ->latest()
            ->limit(6)
            ->get();

        return view('front.home.index', [
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
            'latestProducts' => $latestProducts,
        ]);
    }
}
