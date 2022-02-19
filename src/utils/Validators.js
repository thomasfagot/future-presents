const Validators = {
    required: (value) => !!value || 'Champ requis',
    email: (value) =>
        value.match(/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/) ||
        'e-mail invalide',
    date: (value) =>
        (!isNaN(new Date(value).getTime()) && new Date(value) < new Date()) ||
        'Date invalide',
    url: (value) =>
        !value ||
        value.match(
            /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_+.~#?&/=]*)/g
        ) ||
        'URL invalide',
    minLength8: (value) =>
        !value || value.length >= 8 || '8 caractères minimum',
    maxLength255: (value) =>
        !value || value.length <= 255 || '255 caractères maximum',
    handleErrors: (
        response,
        formErrors,
        fallback = 'Une erreur est survenue'
    ) => {
        if (response && response.data && response.data.errors) {
            for (const field in response.data.errors) {
                for (const message of response.data.errors[field]) {
                    formErrors.value.push(message)
                }
            }
        } else {
            formErrors.value.push(fallback)
        }
    },
    resetErrors: (formErrors) =>
        formErrors.value.splice(0, formErrors.value.length),
}

export default Validators
