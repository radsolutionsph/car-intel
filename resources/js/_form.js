export default() => {
    return {
        errors: {},
        submitting: false,
        success: false,

        formClass() {
            if (this.submitting) {
                return 'potent-forms-disabled'
            }
        },

        errorSummary() {
            const summary = Object.entries(this.errors)
                .map(entry => entry[1]).join(' ')

            return summary
        },

        isInvalid(field) {
            return this.errors[field] !== undefined
        },

        getError(field) {
            // console.log(this.errors[field] ?? '')
            return this.errors[field] ?? ''
        },

        async post() {
            this.submitting = true
            this.errors = []

            const form = this.$refs.form
            const data = new FormData(form)
            const action = form.action

            window.axios.post(action, data)
                .then(response => {
                    this.success = true
                })
                .catch(error => {
                    if (error.response.data.errors) {
                        this.errors = error.response.data.errors
                    } else {
                        // if the page 500 (CSRF token mismatch etc) no data comes back
                        this.errors = {'form': 'Something went wrong. Please try refreshing the page and trying again.'}
                    }
                })
                .finally(() => {
                    this.submitting = false
                })
        }
    }
}