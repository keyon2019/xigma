<?php

namespace App\Models;

use App\Enum\ReturnEnquiry;
use App\Enum\ReturnReason;
use App\Enum\ReturnRequestStatus;
use App\Enum\ShippingMethod;
use App\Traits\Filterable;
use App\Traits\Shamsi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{

    use HasFactory, Shamsi, Filterable;

    protected $fillable = ['reason', 'variation_id', 'order_id', 'enquiry', 'discount', 'price', 'quantity', 'images', 'elaboration', 'technical_status', 'technical_comment',
        'status', 'receiver_number', 'receiver_name', 'payed_at', 'gateway', 'reference_number', 'shipping_method', 'shipped_at',
        'shipping_code', 'address_id'];

    protected $appends = ['statusName', 'reasonName', 'enquiryName'];

    protected $casts = ['images' => 'array'];

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function getStatusNameAttribute()
    {
        $statuses = new ReturnRequestStatus();
        return $statuses[$this->status];
    }

    public function getReasonNameAttribute()
    {
        $statuses = new ReturnReason();
        return $statuses[$this->reason];
    }

    public function getEnquiryNameAttribute()
    {
        $statuses = new ReturnEnquiry();
        return $statuses[$this->enquiry];
    }

    public function getShippingMethodNameAttribute()
    {
        $statuses = new ShippingMethod();
        return $statuses[$this->shipping_method];
    }

    public function getTotalAttribute()
    {
        return ($this->price - $this->discount) * $this->quantity;
    }
}
