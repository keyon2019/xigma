@extends('website.layouts.profile')

@section('profile-content')
    <h4 class="uk-text-muted">نظرات من</h4>
    <paginated-view>
        <template v-slot="scopeData">
            <div v-for="comment in scopeData.records"
                 class="uk-background-default uk-margin-small-bottom uk-padding-small uk-border-rounded uk-box-shadow-small">
                <div class="uk-grid uk-grid-small uk-flex uk-flex-middle">
                    <div>
                        <img uk-img width="180" :src="comment.product.splashUrl">
                    </div>
                    <div class="uk-width-expand">
                        <div v-text="comment.product.name"></div>
                        <hr class="uk-margin-small"/>
                        <div v-text="comment.text" class="uk-text-small"></div>
                        <div v-if="comment.reply" class="uk-margin-small-top uk-text-meta">
                            <span>پاسخ زیگما: </span><span v-text="comment.reply"></span>
                        </div>
                    </div>
                    <div style="align-self: flex-start">
                        <div v-if="comment.approved == null">
                            <div class="uk-label uk-label-warning">در انتظار</div>
                        </div>
                        <div v-if="comment.approved === 1">
                            <div class="uk-label uk-label-success">تایید شده</div>
                        </div>
                        <div v-if="comment.approved === 0">
                            <div class="uk-label uk-label-danger">رد شده</div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </paginated-view>
@endsection