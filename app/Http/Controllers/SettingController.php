<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Updates settings
     *
     * @param object $request
     * @return resource
     */
    public function update(Request $request)
    {
        $data = $request->all();
        foreach ($data as $option => $value) {
            Setting::where('option', $option)->update(['value' => $value]);
        }

        return redirect(route('admin/settings'))
            ->withMessage(__('messages.item_updated', ['item' => 'Settings']));
    }
}
