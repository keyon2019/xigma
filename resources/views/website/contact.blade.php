@extends('website.layouts.app')

@section('title', 'تماس با ما')
@section('meta_title', 'تماس با ما')
@section('meta_description', 'تماس با ما')

@section('content')
    <div class="uk-section">
        <div class="uk-container">
            <h1 class="uk-heading">تماس با زیگما</h1>
            <hr/>
            <div class="uk-text-muted uk-text-large">
                <p>
                    دفتر مرکزی: تهران - تهران، نارمک، خ دماوند، بعد از چهارراه ۳۰ متری آیت، نبش کوچه مسعود سعد، پلاک ۴۶۸، واحد ۱۵
                </p>
                <p>
                    تلفن: ۳۳۳ ۴۰۳ ۷۷ ۰۲۱
                </p>
                <p>
                    واتساپ: ۲۳۵ ۱۰۰۶ ۰۹۳۶
                </p>
                <p>
                    تلفکس: ۳۳۳ ۴۰۳ ۷۷ ۰۲۱
                </p>
                <p>
                    ایمیل: info@xigma.ir
                </p>
                <mapbox height="430" :value="[51.492703, 35.715202]"></mapbox>
            </div>
            <h1 class="uk-heading">ارسال پیام</h1>
            <hr/>
            <contact></contact>
        </div>
    </div>
@endsection

