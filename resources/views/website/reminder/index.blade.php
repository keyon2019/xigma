@extends('website.layouts.profile')

@section('profile-content')
    <h4 class="uk-text-muted">درخواست‌های یادآوری</h4>
    <paginated-view>
        <template v-slot="scopeData">
            <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-background-default uk-border-rounded uk-box-shadow-small">
                <thead>
                <tr>
                    <th>تصویر</th>
                    <th>محصول</th>
                    <th>سریال</th>
                    <th>نوع</th>
                    <th>حذف</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="reminder in scopeData.records">
                    <td><a :href="'/product/' + reminder.variation.product.id">
                            <img uk-img width="50" :src="reminder.variation.product.splashUrl"></a></td>
                    <td>@{{reminder.variation.product.name}}</td>
                    <td>@{{reminder.variation.sku}}</td>
                    <td>@{{reminder.variation.filters}}</td>
                    <td>
                        <form method="post" :action="'/reminder/' + reminder.id">
                            @method('delete')
                            @csrf
                            <button class="uk-icon-button uk-text-danger" type="submit" uk-icon="trash"></button>
                        </form>
                    </td>
                </tr>
                </tbody>
            </table>
        </template>
    </paginated-view>
@endsection