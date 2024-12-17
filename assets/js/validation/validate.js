class Messages {
    /**
     * message template for required messages
     */
    requiredMessage(field) {
        return `${field} is Required`;
    }
}

/**
 * Validation class for HTML Form validation
 */
class Validator extends Messages {
    /**
     * Theough error messsages
     * @var
     */
    throwErrorMessages = false;

    /**
     * Send With messages
     * @var
     */
    withErrorMessages = false;

    /**
     * Error should be appended to the main element
     * @var
     */
    useFormErrorElements = false;

    /**
     * Creating a form instance where the validation error shows up
     * @param {*} form
     */
    constructor(form) {
        super(Messages);
        this.activeForm = form;
    }

    /**
     * Assign error messages to the error elements
     * @returns {object} temp
     */
    throwableFormErrorMessages() {
        // get the error fields
        const messages = this.notValidRecords;
        const temp = {};
        // assigning the error messages to the objects
        messages.map((message) => {
            temp[message] = this.requiredMessage(message);
        });
        // returning the obj
        return temp;
    }

    writeOwnMessage(callback) {
        const messages = this.notValidRecords;
        const temp = {};

        // assigning the error messages to the objects
        messages.map((message) => {
            temp[message] = callback(message);
        });
        // returning the obj
        return temp;
    }

    /**
     * Allow through error mesages
     * @returns this
     */
    withThrowableErrorMessages() {
        this.withErrorMessages = true;
        return this;
    }

    /**
     * Assing a form to the validator
     * @description this form can be a any HTML Element
     * @param {*} form
     * @returns
     */
    form(form) {
        this.form = form;
        return this;
    }

    /**
     * Get all the forms which belongs to the main form
     * @returns this
     */
    hasMultipleForms() {
        this.forms = this.form.querySelectorAll("[data-validation-form]");
        return this;
    }

    /**
     * Collects all the form input and returns as an array
     * @returns object
     */
    collectMany() {
        return [...this.forms].map((form) => {
            const inputs = this.inputs(form);
            const temp = {};

            [...inputs].map((input) => {
                input.classList.remove("form-error");
                temp[input.dataset.name] = input.value;
            });
            return temp;
        });
    }

    collect() {
        const inputs = this.inputs(this.form);
        const temp = {};

        [...inputs].map((input) => {
            input.classList.remove("form-error");
            temp[input.dataset.name] = input.value;
        });

        return temp;
    }

    /**
     *  Get all the input elements of a single form
     * @param {HTMLElement} form
     * @returns  NodeListOf<HTMLInputElement>
     */
    inputs(form) {
        return form.querySelectorAll("input");
    }

    /**
     * Validates all the fields
     * @returns this
     */
    validateAll() {
        const data = this.collectMany();

        this.notValidRecords = [];

        data.map((items) => {
            const shouldBeValidated = this.checkArrayValues(
                Object.values(items)
            );

            if (shouldBeValidated == true) {
                Object.entries(items).map((item) => {
                    if (item[1] == "" || !item[1]) {
                        this.notValidRecords.push(item[0]);
                    }
                });
            }
        });

        return this;
    }

    validate() {
        const data = this.collect();
        this.notValidRecords = [];

        Object.entries(items).map((item) => {
            if (item[1] == "" || !item[1]) {
                this.notValidRecords.push(item[0]);
            }
        });
    }

    /**
     * Check if the array should be validated or not
     * @param {array} array
     * @returns
     */
    checkArrayValues(array) {
        var shouldBeValidated = false;

        array.forEach((item) => {
            if (item !== "") {
                shouldBeValidated = true;
            }
        });

        return shouldBeValidated;
    }

    /**
     * Through error message to the screen
     * @returns bool
     */
    throwError() {
        const inputs = this.notValidRecords;

        if (this.useFormErrorElements == true) {
            // getting the error messages
            this.throughErrorToFormElements();
            return !(inputs.length > 0);
        }

        inputs.map((input) => {
            const elem = this.activeForm.querySelector(
                `[data-name="${input}"]`
            );

            elem.classList.add("form-error");
        });

        return !(inputs.length > 0);
    }

    // throw(obj) {
    //     Object.entries(obj).map(item => {
    //         const element = this.form.querySelector();
    //     });
    // }

    /**
     *  Directly through error message to the elements
     * @param {object} elements
     */
    throughErrorToFormElements() {
        // getting the error messages
        const errorMessages = this.throwableFormErrorMessages();
        console.log(errorMessages);
        // adding error messages to the screen
        Object.entries(errorMessages).map((item) => {
            // selecting the element
            const element = this.activeForm.querySelector(
                `[data-error-for="${item[0]}"]`
            );

            console.log(element);
            // adding the error messages
            if (element) {
                element.innerText = item[1];
            }
        });

        return true;
    }
}
