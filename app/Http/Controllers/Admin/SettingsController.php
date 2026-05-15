<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use App\Models\RestaurantSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $openTime = RestaurantSetting::get('open_time', '09:00');
        $closeTime = RestaurantSetting::get('close_time', '22:00');
        $whatsappRestaurantNumber = RestaurantSetting::get('whatsapp_restaurant_number', config('services.whatsapp.restaurant_number'));
        $whatsappRestaurantTemplate = RestaurantSetting::get('whatsapp_restaurant_template', null);
        $whatsappCustomerTemplate = RestaurantSetting::get('whatsapp_customer_template', null);
        $holidays = Holiday::orderBy('date', 'asc')->get();

        return view('admin.settings.index', compact(
            'openTime',
            'closeTime',
            'whatsappRestaurantNumber',
            'whatsappRestaurantTemplate',
            'whatsappCustomerTemplate',
            'holidays'
        ));
    }

    public function updateTimings(Request $request)
    {
        $validated = $request->validate([
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i|after:open_time',
        ]);

        RestaurantSetting::set('open_time', $validated['open_time']);
        RestaurantSetting::set('close_time', $validated['close_time']);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Timings updated successfully.');
    }

    public function addHoliday(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'note' => 'nullable',
        ]);

        Holiday::create($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Holiday added successfully.');
    }

    public function updateWhatsApp(Request $request)
    {
        $validated = $request->validate([
            'whatsapp_restaurant_number' => 'required|string|max:30',
            'whatsapp_restaurant_template' => 'required|string|max:1000',
            'whatsapp_customer_template' => 'required|string|max:1000',
        ]);

        RestaurantSetting::set('whatsapp_restaurant_number', $validated['whatsapp_restaurant_number']);
        RestaurantSetting::set('whatsapp_restaurant_template', $validated['whatsapp_restaurant_template'], 'text');
        RestaurantSetting::set('whatsapp_customer_template', $validated['whatsapp_customer_template'], 'text');

        return redirect()->route('admin.settings.index')
            ->with('success', 'WhatsApp settings updated successfully.');
    }

    public function removeHoliday(Holiday $holiday)
    {
        $holiday->delete();
        return redirect()->route('admin.settings.index')
            ->with('success', 'Holiday removed successfully.');
    }
}
