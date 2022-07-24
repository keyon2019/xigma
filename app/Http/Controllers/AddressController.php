<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use App\Rules\Mobile;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $result = $request->has('paginated') ? auth()->user()->addresses()->latest()->paginate(15) : ['addresses' => auth()->user()->addresses];
            return response()->json($result);
        }
        return view('website.address.index');
    }

    public function userAddresses(User $user)
    {
        return response()->json($user->addresses()->latest()->paginate(10));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'province_id' => 'required|numeric|exists:provinces,id',
            'city_id' => 'required|numeric|exists:cities,id',
            'directions' => 'required|string',
            'zip' => 'required|string|size:10',
            'phone' => 'required|string|size:11',
            'mobile' => ['required', new Mobile()],
            'lat' => 'required|numeric',
            'lng' => 'required|numeric'
        ]);
        $data['latitude'] = $request->lat;
        $data['longitude'] = $request->lng;

        $address = auth()->user()->addresses()->create($data);
        return response()->json(['address' => $address]);
    }

    public function update(Address $address, Request $request)
    {
        if (!auth()->user()->is_admin || auth()->id() != $address->user_id)
            return abort(401, "Unauthorized");
        $data = $request->validate([
            'province_id' => 'required|numeric|exists:provinces,id',
            'city_id' => 'required|numeric|exists:cities,id',
            'directions' => 'required|string',
            'zip' => 'required|string|size:10',
            'phone' => 'required|string|size:11',
            'mobile' => ['required', new Mobile()],
            'lat' => 'required|numeric',
            'lng' => 'required|numeric'
        ]);

        $data['latitude'] = $data['lat'];
        $data['longitude'] = $data['lng'];

        if (!auth()->user()->is_admin)
            if (Order::whereAddressId($address->id)->exists()) {
                return abort(402, "با نشانی مورد نظر سفارش ثبت شده در سیستم وجود دارد، لطفا برای تغییر، نشانی جدید ایجاد نمایید.");
            }

        $address->update($data);

        return response([], 200);
    }

    public function destroy(Address $address)
    {
        if (!auth()->is_admin || auth()->id() != $address->user_id)
            return abort(401, "Unauthorized");
        if (Order::whereAddressId($address->id)->exists()) {
            return abort(402, "با نشانی مورد نظر سفارش ثبت شده در سیستم وجود دارد، امکان حذف آدرس وجود ندارد");
        }
        $address->delete();
        return response([]);
    }
}
