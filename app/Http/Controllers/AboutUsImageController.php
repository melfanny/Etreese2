<?php

namespace App\Http\Controllers;

use App\Models\AboutUsImage;
use Illuminate\Http\Request;

class AboutUsImageController extends Controller
{
    public function edit()
    {
        $aboutUsImages = AboutUsImage::first();
        if (!$aboutUsImages) {
            $aboutUsImages = AboutUsImage::create([]);
        }
        $home = \App\Models\Home::first();
        return view('admin.home_admin', compact('aboutUsImages', 'home'));
    }

    public function update(Request $request)
    {
        $aboutUsImages = AboutUsImage::first();

        $data = $request->validate([
            'header_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'series_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'series_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'series_image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'series_image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'why_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'why_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'why_image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        foreach ($data as $key => $value) {
            if ($request->hasFile($key)) {
                $data[$key] = $request->file($key)->store('about_us_images', 'public');
            } else {
                $data[$key] = $aboutUsImages ? $aboutUsImages->$key : null;
            }
        }

        if ($aboutUsImages) {
            $aboutUsImages->update($data);
        } else {
            AboutUsImage::create($data);
        }

        return redirect()->route('admin.about_us_images.edit')->with('success', 'About Us images updated successfully.');
    }
}
