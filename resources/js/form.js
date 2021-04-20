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

    asFormData(method = null) {
        let formData = new FormData();
        _.forEach(this, (field, key) => {
            if (field.value) {
                if (typeof field.value === 'object') {
                    _.forEach(field.value, (valueId, optionId) => {
                        console.log(key, valueId, optionId);
                        formData.append(`${key}[${optionId}]`, valueId)
                    });
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
        return [false, 'Field is Required']
    }

    static validateString(value) {
        if (typeof value === 'string')
            return [true, ''];
        return [false, 'Field Must Be String']
    }

    static validateDigits(value, digits) {
        return value.length === parseInt(digits) ? [true, ''] : [false, `Field must be ${digits} digits`];
    }

    static validateNumeric(value) {
        return !isNaN(value) ? [true, ''] : [false, 'Field must be numeric'];
    }
}

export {Form};