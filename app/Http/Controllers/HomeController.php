<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function edit()
    {
        $home = Home::first();
        if (!$home) {
            $home = Home::create([]);
        }
        return view('admin.home_admin', compact('home'));
    }

    public function update(Request $request)
    {
        $home = Home::first();

        $data = $request->validate([
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'upcoming_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'upcoming_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'upcoming_image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'upcoming_image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'what_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('home_images', 'public');
        } else {
            $data['banner_image'] = $home ? $home->banner_image : null;
        }

        for ($i = 1; $i <= 4; $i++) {
            $field = 'upcoming_image_' . $i;
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('home_images', 'public');
            } else {
                $data[$field] = $home ? $home->$field : null;
            }
        }

        if ($request->hasFile('what_image_1')) {
            $data['what_image_1'] = $request->file('what_image_1')->store('home_images', 'public');
        } else {
            $data['what_image_1'] = $home ? $home->what_image_1 : null;
        }

        if ($home) {
            $home->update($data);
        } else {
            Home::create($data);
        }

        return redirect()->route('admin.home.edit')->with('success', 'Home images updated successfully.');
    }
}
