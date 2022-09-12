\App\Models\Order::with('user')->with('variations')
            ->whereIn('status', [\App\Enum\OrderStatus::SHIPPED, OrderStatus::PREPARING])->get()->each(function ($order) {
                $points = $order->points;
                if ($points <= 0) {
                    return;
                }
                $user = $order->user;

                $user->total_points += $points;

                $user->save();

                \App\Models\Point::create([
                    'user_id' => $user->id,
                    'amount' => $points,
                    'description' => "بابت سفارش شماره {$order->id}"
                ]);
            });
