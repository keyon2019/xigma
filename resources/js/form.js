class Form {
    constructor(object) {
        _.forEach(object, (value, key) => {
            this[key] = value;
        });
        this.errors = new Errors(Object.keys(this));
    }

    validate(fields) {
        let formFields = fields || this;
        let finalResult = true;
        _.forEach(formFields, (field, name) => {
            if (field.rules) {
                let rules = field.rules.split('|');
                if (rules.length > 0) {
                    if (_.indexOf(rules, 'required') < 0 && (field.value == null || field.value === ''))
                        return true;
                    if (_.indexOf(rules, 'required') < 0 && (field.rules.includes('file') && typeof field.value === 'string'))
                        return true;
                    _.forEach(rules, rule => {
                        rule = rule.split(':');
                        let arg = rule[1];
                        let fn = `validate${_.capitalize(rule[0])}`;
                        if (typeof Validator[fn] === 'function') {
                            let result = Validator[fn](field.value, arg || null);
                            if (!result[0]) {
                                finalResult = false;
                                this.errors[name] = result[1];
                            }
                        }
                    })
                }
            }
        });
        return finalResult;
    }

    fill(obj) {
        _.forEach(obj, (value, key) => {
            if (this.hasOwnProperty(key)) {
                this[key].value = value;
            }
        });
    }

    clear() {
        _.forEach(this, (obj, key) => {
            if (!!obj.default) {
                obj.value = obj.default;
            } else {
                obj.value = null;
            }
        });
    }

    asFormData(method = null) {
        let formData = new FormData();
        _.forEach(this, (field, key) => {
            if ((field.value != null && field.value !== '') || (!!field.rules && field.rules.includes('nullable'))) {
                if (field.rules.includes('file') && !(field.value instanceof Blob)) {
                    return;
                }
                if (field.rules.includes('boolean')) {
                    formData.append(key, field.value ? 1 : 0);
                    return
                }
                if (field.rules.includes('array')) {
                    _.forEach(field.value, (valueId, optionId) => {
                        formData.append(`${key}[${optionId}]`, valueId)
                    });
                    return
                }
                if (field.rules.includes('object')) {
                    for (const [objKey, value] of Object.entries(field.value)) {
                        if (typeof value === 'object') {
                            _.forEach(value, (nestedValue, nestedKey) => {
                                formData.append(`${key}[${objKey}][${nestedKey}]`, nestedValue);
                            });
                        } else {
                            formData.append(objKey, value)
                        }
                    }
                    return
                }
                formData.append(key, field.value)
            }
        });
        if (method) {
            formData.append('_method', method);
        }
        return formData;
    }
}

class Errors {
    constructor(fields) {
        _.forEach(fields, field => this[field] = null)
    }

    has(field) {
        return this[field] != null;
    }

    clear(field) {
        if (field) {
            return this[field] = null;
        }
        _.forEach(this, (value, field) => {
            this[field] = null;
        });
    }
}

class Validator {
    static validateRequired(value) {
        if (value !== '' && value != null) {
            return [true, ''];
        }
        return [false, 'این فیلد الزامی است']
    }

    static validateString(value) {
        if (typeof value === 'string')
            return [true, ''];
        return [false, 'ورودی این نامعتبر است']
    }

    static validateDigits(value, digits) {
        return value.length === parseInt(digits) ? [true, ''] : [false, `تعداد ارقام این فیلد ${digits} عدد است`];
    }

    static validateNumeric(value) {
        return !isNaN(value) ? [true, ''] : [false, 'فیلد فقط مقادیر عددی را می‌پذیرد'];
    }

    static validateFile(value) {
        return (value instanceof Blob || value.match(/\.(jpeg|jpg|gif|png)$/)) ? [true, ''] : [false, 'تصویر انتخابی معتبر نیست'];
    }
}

export {Form};