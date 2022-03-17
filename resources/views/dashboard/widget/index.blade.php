@extends('dashboard.layouts.dashboard')

@section('title', 'ویجت‌ها')

@section('content')
    <div>
        <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-background-default uk-border-rounded uk-box-shadow-small">
            <thead>
            <tr>
                <th>#</th>
                <th>دسته‌بندی</th>
                <th>نوع</th>
                <th>ترتیب</th>
                <th>ویرایش</th>
                <th>حذف</th>
                <th>خالی کردن کش</th>
            </tr>
            </thead>
            <tbody>
            @foreach($widgets as $widget)
                <tr>
                    <td>{{$widget->id}}</td>
                    <td>{{$widget->categoryItSelf->name}}</td>
                    <td>{{$widget->type === 1 ? 'جدیدترین' : 'محبوب‌ترین'}}</td>
                    <td>{{$widget->order}}</td>
                    <td><a class="uk-button uk-button-primary uk-border-rounded uk-button-small"
                           href="/dashboard/widget/{{$widget->id}}/edit">ویرایش</a></td>
                    <td>
                        <form method="post" action="/dashboard/widget/{{$widget->id}}">
                            @csrf
                            @method('delete')
                            <button class="uk-button uk-button-danger uk-border-rounded uk-button-small" type="submit">حذف
                            </button>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="/dashboard/widget/{{$widget->id}}/purge">
                            @csrf
                            <button class="uk-button uk-button-secondary uk-border-rounded uk-button-small">خالی کردن</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection