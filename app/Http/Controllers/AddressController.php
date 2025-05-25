<?php


namespace App\Http\Controllers;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AddressController extends Controller
{
    use AuthorizesRequests;
    // Tampilkan alamat 
    public function index(Request $request)
    {
        $addresses = Address::where('user_id', Auth::id())->get();

        return view('address.viewaddress', compact('addresses'));
    }

    public function create()
    {
        return view('address.createaddress');
    }

    // edit alamat
    public function edit(Address $address)
    {
        if ($address->user_id !== auth()->id()) {
        abort(403, 'Unauthorized');
    }

        return view('address.editaddress', compact('address'));
    }

    // Simpan alamat 
    public function store(Request $request)
    {
        $existing = Address::where('user_id', auth()->id())->first();
    
        $validated = $request->validate([
            'recipient_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'province_id' => 'required|string',
            'province' => 'required|string',
            'city_id' => 'required|string',
            'city' => 'required|string',
            'city_type' => 'required|string',
            'postal_code' => 'nullable|string|max:10',
            'address' => 'required|string',
        ]);

        Address::create([
        'user_id' => auth()->id(),
        'recipient_name' => $request->recipient_name,
        'phone' => $request->phone,
        'province_id' => $request->province_id,
        'province' => $request->province,
        'city_id' => $request->city_id,
        'city' => $request->city,
        'city_type' => $request->city_type,
        'postal_code' => $request->postal_code,
        'address' => $request->address, 
    ]);

        return redirect()->route('addresses.index')->with('success', 'Alamat berhasil disimpan');
    }
    
    // Update alamat
    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== auth()->id()) {
        abort(403, 'Unauthorized');
    }

        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'province_id' => 'required|string',
            'province' => 'required|string',
            'city_id' => 'required|string',
            'city' => 'required|string',
            'city_type' => 'required|string',
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string',
        ]);

        $address->update($request->all());

        return redirect()->route('addresses.index')->with('success', 'Alamat berhasil diperbarui');
    }

    // Hapus alamat
    public function destroy(Address $address)
    {

        if ($address->user_id !== auth()->id()) {
        abort(403, 'Unauthorized');
    }

        $address->delete();

        return redirect()->route('addresses.index')->with('success', 'Alamat berhasil dihapus');
    }
}
