<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Holiday;
use App\Models\RestaurantSetting;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::where('active', true)
            ->with('foodItems', function ($query) {
                $query->where('available', true)->orderBy('order', 'asc');
            })
            ->orderBy('order', 'asc')
            ->get();

        $isOpen = $this->isRestaurantOpen();
        $openTime = RestaurantSetting::get('open_time', '09:00');
        $closeTime = RestaurantSetting::get('close_time', '22:00');

        return view('customer.menu', compact('categories', 'isOpen', 'openTime', 'closeTime'));
    }

    private function isRestaurantOpen()
    {
        if (Holiday::isHolidayToday()) {
            return false;
        }

        $now = now();
        $openTime = RestaurantSetting::get('open_time', '09:00');
        $closeTime = RestaurantSetting::get('close_time', '22:00');

        $openDateTime = $now->copy()->setTimeFromTimeString($openTime);
        $closeDateTime = $now->copy()->setTimeFromTimeString($closeTime);

        return $now->between($openDateTime, $closeDateTime);
    }
}
