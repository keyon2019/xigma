@extends('website.layouts.app')

@section('title', "صفحه جستجو $keyword")
@section('meta_title', "صفحه جستجو $keyword")
@section('meta_description', "نتایج پیدا شده برای جستجوی کلمه $keyword")

@section('content')
    <div class="uk-section">
        <div class="uk-container">
            <front-products :quarter="true" :filterless="true"></front-products>
        </div>
    </div>
@endsection

