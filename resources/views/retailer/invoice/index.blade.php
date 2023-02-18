@extends('dashboard.layouts.dashboard')

@section('title', 'فاکتورهای درب فروشگاه')

@section('content')
    <paginated-view>
        <template v-slot="scopeData">
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-background-default uk-border-rounded uk-box-shadow-small">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نمایندگی</th>
                        <th>زمان ثبت</th>
                        <th>مشاهده</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="invoice in scopeData.records">
                        <td class="uk-table-shrink">@{{invoice.id}}</td>
                        <td>@{{invoice.retailer.name}}</td>
                        <td>@{{invoice.created_at}}</td>
                        <td><a :href="`/dashboard/r/invoice/${invoice.id}`"
                               class="uk-button uk-button-small uk-button-primary">نمایش</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </paginated-view>
@endsection
