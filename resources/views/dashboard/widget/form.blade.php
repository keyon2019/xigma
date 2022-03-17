@csrf
<div class="uk-margin">
    <select name="category" class="uk-select">
        <option value="">دسته بندی</option>
        @foreach($categories as $category)
            <option @if($widget->category === $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
        @endforeach
    </select>
</div>
<div class="uk-margin">
    <select name="type" class="uk-select">
        <option value="">نوع ویجت</option>
        <option @if($widget->type === 1) selected @endif value="1">جدیدترین</option>
        <option @if($widget->type === 2) selected @endif value="2">محبوب‌‌‌ترین</option>
    </select>
</div>
<div class="uk-margin">
    <select name="order" class="uk-select">
        <option value="">ترتیب نمایش</option>
        <option @if($widget->order === 1) selected @endif value="1">1</option>
        <option @if($widget->order === 2) selected @endif value="2">2</option>
        <option @if($widget->order === 3) selected @endif value="3">3</option>
        <option @if($widget->order === 4) selected @endif value="4">4</option>
    </select>
</div>