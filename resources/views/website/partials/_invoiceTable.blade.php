<table class="uk-table uk-table-divider uk-border-rounded uk-table-middle">
    <thead>
    <tr>
        <th>#</th>
        <th>عکس</th>
        <th class="uk-table-expand">نام</th>
        <th>نوع</th>
        <th>تعداد</th>
        <th>فی</th>
        <th>جمع ردیف</th>
    </tr>
    </thead>
    <tbody>
    @php($totalQuantity = 0)
    @php($totalPrice = 0)
    @foreach($items as $index => $item)
        <tr>
            <td>{{$index + 1}}</td>
            <td><img class="uk-border-rounded" alt="{{$item->name}}" data-uk-img width="60" src="{{$item->picture->url ?? $item->splash}}">
            </td>
            <td>{{$item->productName ?? $item->name}}</td>
            <td>{{$item->filters}}</td>
            @php($quantity = $item->pivot->quantity ?? $item->quantity)
            @php($totalQuantity += $quantity)
            <td>{{$quantity}}</td>
            @php($price = $item->pivot->price ?? $item->price)
            <td>{{number_format($price)}}</td>
            @php($rowTotal = $price * $quantity)
            <td>{{number_format($rowTotal)}}</td>
            @php($totalPrice += $rowTotal)
        </tr>
    @endforeach
    </tbody>
    <tfoot class="uk-background-muted">
    <tr>
        <td colspan="4" class="uk-text-bold"></td>
        <td colspan="2">{{$totalQuantity}}</td>
        <td>{{number_format($totalPrice)}}</td>
    </tr>
    </tfoot>
</table>