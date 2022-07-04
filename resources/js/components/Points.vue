<template>
    <div>
        <div class="uk-margin-small-bottom">کل امتیاز قابل استفاده: {{totalPoints}}</div>
        <button class="uk-button uk-button-default uk-border-rounded uk-margin-bottom uk-button-secondary"
                @click="pointsModal.show()">افزایش/کاهش امتیاز
        </button>
        <paginated-view ref="pv" :fetch-url="fetchUrl">
            <template v-slot="scopeData">
                <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>زمان</th>
                        <th>میزان</th>
                        <th>بابت</th>
                        <th>وضعیت</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="point in scopeData.records">
                        <td class="uk-table-shrink">{{point.id}}</td>
                        <td>{{point.created_at}}</td>
                        <td>{{point.amount}}</td>
                        <td>{{point.description}}</td>
                        <td>{{point.status}}</td>
                    </tr>
                    </tbody>
                </table>
            </template>
        </paginated-view>
        <modal name="points">
            <form @input="form.errors.clear($event.target.name)">
                <div class="uk-margin">
                    <label class="uk-form-label">میزان امتیاز</label>
                    <div class="uk-form-controls">
                        <input v-model="form.amount.value" type="number"
                               class="uk-input uk-border-rounded"
                               name="amount"
                               placeholder="مقدار امتیاز را وارد کنید (برای کاهش اعداد منفی وارد کنید)">
                    </div>
                    <div v-if="form.errors.has('amount')"
                         class="uk-text-danger uk-text-small">{{form.errors['amount']}}
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label">بابت</label>
                    <div class="uk-form-controls">
                        <input name="description" v-model="form.description.value" class="uk-input uk-border-rounded"
                               placeholder="بابت">
                    </div>
                    <div v-if="form.errors.has('description')"
                         class="uk-text-danger uk-text-small">{{form.errors['description']}}
                    </div>
                </div>
                <div class="uk-margin">
                    <button type="button" class="uk-button uk-button-primary uk-border-rounded" @click="submitPoints()">ثبت
                        امتیاز
                    </button>
                </div>
            </form>
        </modal>
    </div>
</template>

<script>
    export default {
        props: ['fetch-url', 'user'],
        data() {
            return {
                pointsModal: new Modal('points'),
                totalPoints: this.user.total_points,
                form: new Form({
                    amount: {
                        rules: 'required|numeric',
                        value: ''
                    },
                    description: {
                        rules: 'required|string',
                        value: ''
                    },
                    user_id: {
                        default: this.user.id,
                        rules: 'required|numeric',
                        value: this.user.id,
                    }
                })
            }
        },
        methods: {
            submitPoints() {
                if (this.form.validate()) {
                    Loading.show();
                    axios.post(`/dashboard/user/${this.user.id}/point`, this.form.asFormData()).then((response) => {
                        this.$refs.pv.add(response.data);
                        this.totalPoints = parseInt(response.data.amount) + parseInt(this.totalPoints);
                        this.form.clear();
                        this.pointsModal.close();
                        Toast.message("امتیاز با موفقیت افزوده شد").success().show();
                    }).catch((e) => Toast.message(e.response.data.message).danger().show())
                        .then(() => Loading.hide())
                }
            }
        }
    }
</script>

<style scoped>

</style>