@extends('website.layouts.app')

@section('title', 'تماس با ما')
@section('meta_title', 'تماس با ما')
@section('meta_description', 'تماس با ما')

@section('content')
    <div class="uk-section">
        <div class="uk-container">
            <h1 class="uk-heading">تماس با زیگما</h1>
            <hr/>
            <div class="ck-content"><p>دفتر مرکزی : تهران ، نارمک ، خیابان دماوند ، بعد از چهارراه 30 متری آیت ، نبش کوچه مسعود
                    سعد ، پلاک 468 ، واحد 15</p>
                <p>کارخانه : قم ، شهرک صنعتی شکوهیه ، بلوار آیت الله خامنه ای ، خیابان بنفشه 2 ، پلاک 372</p>
                <p>تلفن : 77403333 021</p>
                <p>شماره واتس آپ و ایتا : 1005235 0936</p>
                <p>تلفکس : 77403333 021</p>
                <p>کد پستی دفتر مرکزی : 1743674563</p>
                <p>ایمیل : info@xigma.ir</p>
            <div>
                <mapbox height="430" :value="[51.492703, 35.715202]"></mapbox>
            </div>
            <h1 class="uk-heading">ارسال پیام</h1>
            <hr/>
            <contact></contact>
        </div>
    </div>
@endsection

