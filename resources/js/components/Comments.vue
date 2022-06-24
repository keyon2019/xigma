<template>
    <paginated-view>
        <template v-slot:filters>
            <div class="uk-background-default uk-box-shadow-small uk-padding-small uk-border-rounded">
                <div class="uk-margin-remove">جستجو</div>
                <hr class="uk-margin-remove-top"/>
                <div>
                    <div class="uk-margin-small">
                        <label><input class="uk-checkbox" type="checkbox" name="approved" value="1"> تاییدشده </label>
                    </div>
                    <div class="uk-margin-small-top">
                        <button class="uk-button uk-width-expand uk-button-primary uk-border-rounded"
                                type="submit">اعمال فیلترها
                        </button>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot="scopeData">
            <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-background-default uk-border-rounded uk-box-shadow-small">
                <thead>
                <tr>
                    <th>#</th>
                    <th>کاربر</th>
                    <th>محصول</th>
                    <th>امتیاز</th>
                    <th>زمان ثبت</th>
                    <th>وضعیت</th>
                    <th>مشاهده</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="comment in scopeData.records">
                    <td class="uk-table-shrink">{{comment.id}}</td>
                    <td>{{comment.user.name}}</td>
                    <td>{{comment.product.name}}</td>
                    <td>
                        <stars-rating :rating="comment.rating"></stars-rating>
                    </td>
                    <td>{{comment.created_at}}</td>
                    <td><span v-if="comment.approved != null" :data-uk-icon="!!comment.approved ? 'check' : 'close'"></span></td>
                    <td><a @click="Modal.show(comment.id)" class="uk-button uk-button-small uk-button-primary">نمایش</a>
                        <modal :name="comment.id">
                            <div>
                                <p class="uk-margin-remove uk-text-bold">{{comment.user.name}}</p>
                                <p class="uk-text-meta uk-margin-remove">
                                        <span class="uk-display-inline-block uk-width-expand">
                                            <span class="uk-float-left">{{comment.created_at}}</span>
                                            <span class="uk-float-right"><stars-rating
                                                    :rating="comment.rating"></stars-rating></span>
                                        </span>
                                </p>
                                <hr class="uk-margin-remove-top"/>
                                <p class="uk-margin-remove-top uk-padding-small uk-padding-remove-vertical uk-padding-remove-right"
                                   v-text="comment.text"></p>
                                <textarea v-model="comment.reply" class="uk-textarea uk-border-rounded uk-margin-small-bottom"
                                          placeholder="ارسال پاسخ"></textarea>
                                <button @click="update(comment)"
                                        class="uk-float-right uk-border-rounded uk-margin-small-left uk-button uk-button-default">
                                    ثبت پاسخ
                                </button>
                                <div v-if="!comment.approved">
                                    <button @click="approve(comment)"
                                            class="uk-float-right uk-border-rounded uk-button uk-button-primary">تایید
                                    </button>
                                </div>
                                <div v-else>
                                    <button @click="disapprove(comment)"
                                            class="uk-float-right uk-border-rounded uk-button uk-button-danger">رد نظر
                                    </button>
                                </div>
                            </div>
                        </modal>
                    </td>
                </tr>
                </tbody>
            </table>
        </template>
    </paginated-view>
</template>

<script>

    export default {
        methods: {
            approve(comment) {
                Loading.show();
                axios.post(`/dashboard/comment/${comment.id}/approve`).then(() => {
                    comment.approved = true;
                    Toast.message('نظر با موفقیت تایید شد').success().show();
                }).catch((e) => {
                    Toast.message(e.response.data.message).danger().show();
                }).then(() => {
                    Loading.hide();
                })
            },
            disapprove(comment) {
                Loading.show();
                axios.post(`/dashboard/comment/${comment.id}`, {_method: 'delete'}).then(() => {
                    comment.approved = false;
                    Toast.message('نظر با موفقیت رد شد').success().show();
                }).catch((e) => {
                    Toast.message(e.response.data.message).danger().show();
                }).then(() => {
                    Loading.hide();
                })
            },
            update(comment) {
                Loading.show();
                axios.post(`/dashboard/comment/${comment.id}`, {
                    _method: 'patch',
                    reply: comment.reply,
                }).then(() => {
                    Toast.message('پاسخ نظر با موفقیت ثبت شد').success().show();
                }).catch((e) => {
                    Toast.message(e.response.data.message).danger().show();
                }).then(() => {
                    Loading.hide();
                })
            }
        }
    }
</script>

<style scoped>

</style>