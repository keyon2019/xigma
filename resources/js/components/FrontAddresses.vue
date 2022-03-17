<template>
    <paginated-view @fetched="scroll" filterless="true" fetch-url="/address?paginated=true">
        <template v-slot="scopeData">
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>استان</th>
                        <th>شهر</th>
                        <th>نشانی</th>
                        <th>کد پستی</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(address, index) in scopeData.records">
                        <td class="uk-table-shrink">{{index + 1}}</td>
                        <td>{{address.province}}</td>
                        <td>{{address.city}}</td>
                        <td>{{address.directions}}</td>
                        <td>{{address.zip}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </paginated-view>
</template>

<script>
    export default {
        props: ['category', 'options'],
        methods: {
            scroll() {
                this.$el.scrollIntoView({behavior: 'smooth'});
            }
        }
    }
</script>

<style scoped>
    .section-container {
        font-weight: 300;
        border-radius: 10px;
    }

    .custom-padding {
        padding: 0.5rem;
    }

    .uk-accordion-title:before {
        background-image: url('/uploads/chevron-down.svg');
        opacity: 0.5;
    }

    .uk-open > .uk-accordion-title::before {
        background-image: url('/uploads/chevron-up.svg');
        opacity: 1;
    }
</style>