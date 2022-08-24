<?php

namespace App\Http\Controllers;

use App\Enum\ReturnRequestStatus;
use App\Enum\ReturnTechnicalStatus;
use App\Enum\ShippingMethod;
use App\Filters\ReturnRequestFilters;
use App\Http\Requests\ReturnRequestForm;
use App\Models\Order;
use App\Models\ReturnRequest;
use App\Rules\Mobile;
use App\Services\SMSService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;

class ReturnRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all(Request $request, ReturnRequestFilters $filters, ReturnRequestStatus $statuses)
    {
        Gate::authorize('edit-order');
        if ($request->wantsJson())
            return response()->json(ReturnRequest::filter($filters)->with('user')->latest()->paginate(15));
        return view('dashboard.return_request.index', compact('statuses'));
    }

    public function index(Request $request)
    {
        if ($request->wantsJson())
            return response()->json(auth()->user()->returnRequests()->with(['technician'])->latest()->paginate(10));
        return view('website.return_request.index');
    }

    public function show(ReturnRequest $returnRequest)
    {
        if (auth()->id() != $returnRequest->user_id)
            return abort(401, "Unauthorized");
        return view('website.return_request.show', compact('returnRequest'));
    }

    public function store(ReturnRequestForm $request, SMSService $service)
    {
        $data = $request->validated();

        $order = Order::with(['returnRequests', 'variations'])->find($data['order_id']);

        if ($order->user_id !== auth()->id()) {
            abort(401, "Unauthorized");
        }

        if ($order->returnRequests->contains('variation_id', $data['variation_id'])) {
            abort(401, "قبلا برای این محصول درخواست مرجوعی داده اید");
        }

        $variation = $order->variations->firstWhere('pivot.variation_id', $data['variation_id']);

        $data['price'] = $variation->pivot->price;
        $data['discount'] = $variation->pivot->discount;
        $data['points'] = $variation->pivot->points;
        $data['status'] = 0;

        $data['images'] = array_map(function ($image) {
            /** @var UploadedFile $image */
            return $image->store('images/returns');
        }, $data['images']);

        $returnRequest = auth()->user()->returnRequests()->create($data);

        $service->send($order->user->mobile, "{$order->user->name};$returnRequest->id", 93570);

        return response()->json($returnRequest, 200);
    }

    public function edit(ReturnRequest $returnRequest,
                         ReturnTechnicalStatus $technicalStatuses,
                         ReturnRequestStatus $statuses,
                         ShippingMethod $shippingMethods)
    {
        Gate::authorize('edit-order');
        $returnRequest->load(['variation', 'user', 'technician']);
        return view('dashboard.return_request.edit', compact('returnRequest', 'technicalStatuses', 'statuses', 'shippingMethods'));
    }

    public function update(ReturnRequest $returnRequest, Request $request, SMSService $service)
    {
        Gate::authorize('edit-order');
        $validated = $request->validate([
            'technical_status' => 'nullable|numeric',
            'technical_comment' => 'nullable|string',
            'payed_at' => 'nullable|date',
            'status' => 'nullable|numeric',
            'gateway' => 'nullable|numeric',
            'shipping_method' => 'nullable|numeric',
            'shipped_at' => 'nullable|date',
            'shipping_code' => 'nullable|numeric'
        ]);

        $validated = array_filter($validated, function ($value) {
            return $value != null;
        });

        $returnRequest->update($validated);

        if ($request->has('status')) {
            switch ($validated['status']) {
                case ReturnRequestStatus::WAITING_FOR_ADDRESS:
                    $service->send($returnRequest->order->user->mobile, $returnRequest->order->user->name, 93572);
                    break;
                case ReturnRequestStatus::REJECTED:
                    $service->send($returnRequest->order->user->mobile, "{$returnRequest->order->user->name};$returnRequest->id",
                        93572);
                    break;
                default:
                    break;
            }
        }

        return back()->with(['flash_message' => json_encode(['message' => 'درخواست عودت با موفقیت به‌روزرسانی شد', 'type' => 'success'])]);
    }

    public function setAddress(ReturnRequest $returnRequest, Request $request)
    {
        if ($returnRequest->user_id !== auth()->id())
            abort(401, "Unauthorized");

        $validated = $request->validate([
            'address_id' => 'required|numeric|exists:addresses,id',
            'receiver_name' => 'required|string',
            'receiver_number' => ['required', new Mobile()]
        ]);

        $returnRequest->update($validated);

        return back()->with(['flash_message' => json_encode(['message' => 'آدرس شما با موفقیت ثبت شد', 'type' => 'success'])]);

    }
}
