<template>
    <div class="dropdown fluid" :class="showMenu ? 'is-active' : ''">
        <div class="dropdown-trigger" style="width: 100%">
            <input @blur="handleBlur($event)"
                   @keydown.tab="hoveredIndex !== -1 ? selectOption(filteredOptions[hoveredIndex]) : null"
                   @keyup.enter="hoveredIndex !== -1 ? selectOption(filteredOptions[hoveredIndex]) : null"
                   @keyup.down="traverse(true)"
                   @keyup.up="traverse(false)"
                   class="input" placeholder="جستجو..."
                   :disabled="disabled"
                   :placeholder="placeholder"
                   :readonly="readonly"
                   :class="classes"
                   aria-controls="dropdown-menu" @input="toggleMenu" v-model="keyword">
        </div>
        <div :ref="'dropdownContent'" class="dropdown-menu" id="dropdown-menu" role="menu" style="width: 100%">
            <div class="dropdown-content">
                <a v-if="filteredOptions.length <= 0" class="dropdown-item">نتیجه‌ای یافت نشد!</a>
                <a tabindex="-1" @mouseenter="hoveredIndex = index"
                   @click="selectOption(option)" :class="index === hoveredIndex ? 'is-hovered' : ''"
                   class="dropdown-item" v-for="(option, index) in filteredOptions">
                    {{option[searchKeyName]}}
                </a>
            </div>
        </div>
        <input :name="name" type="hidden" v-model="manualValue">
    </div>
</template>

<script>
    export default {
        props: {
            options: {}, value: {}, classes: {},
            name: {
                type: String,
                default: 'dropdown'
            },
            'search-key-name': {
                type: String,
                default: 'name'
            },
            'value-key-name': {
                type: String,
                default: null
            },
            'disabled': {
                type: Boolean,
                default: false,
            },
            readonly: {
                type: Boolean,
                default: false,
            },
            placeholder: {
                type: String,
                default: 'جستجو...'
            }
        },
        data() {
            return {
                keyword: '',
                showMenu: false,
                hoveredIndex: -1,
                manualValue: this.value,
            }
        },
        computed: {
            filteredOptions() {
                let options = _.filter(this.options, (option, index) => {
                    option.originalIndex = index;
                    return option[this.searchKeyName].includes(this.keyword);
                });
                if (options.length <= 0) {
                    this.hoveredIndex = -1
                }
                return _.take(options, 10);
            }
        },
        watch: {
            value: {
                handler(v) {
                    if (v == null) {
                        this.keyword = null;
                        this.manualValue = null;
                    }
                    if (v) {
                        this.keyword = _.find(this.options, (option) => {
                            if (this.valueKeyName) {
                                return option[this.valueKeyName] === v;
                            }
                            return option.id === v.id;
                        })[this.searchKeyName];
                    }
                },
                immediate: true
            }
        },
        methods: {
            selectOption(option) {
                let returnVal = null;
                switch (this.valueKeyName) {
                    case 'index':
                        returnVal = option.originalIndex;
                        break;
                    case null:
                        returnVal = option;
                        break;
                    default:
                        returnVal = option[this.valueKeyName]
                }
                this.$emit('input', returnVal);
                this.$emit('selected', returnVal);
                this.manualValue = returnVal;
                this.showMenu = false;
                this.hoveredIndex = -1;
                this.keyword = option[this.searchKeyName];
            },
            toggleMenu() {
                this.showMenu = this.keyword !== '';
            },
            traverse(isDown) {
                if (this.filteredOptions.length > 0) {
                    let length = this.filteredOptions.length;
                    if (isDown)
                        this.hoveredIndex = ++this.hoveredIndex % length;
                    else
                        this.hoveredIndex = ((--this.hoveredIndex % length) + length) % length;
                }
            },
            handleBlur(e) {
                if (this.$refs.dropdownContent.contains(e.relatedTarget))
                    return;
                if (this.keyword !== '') {
                    if (!this.value && !this.manualValue) {
                        this.keyword = null;
                    } else {
                        let option = _.find(this.options, (option) => {
                            if (this.valueKeyName != null)
                                return option[this.valueKeyName] === this.value;
                            return _.isEqual(option, this.value);
                        });
                        this.keyword = option[this.searchKeyName];
                    }
                } else {
                    this.$emit('input', null);
                }
                this.showMenu = false;
            }
        }
    }
</script>

<style scoped>

</style>