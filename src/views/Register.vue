<template>
    <section class="width-400px text-left margin-center mt10">
        <w-card shadow :title="'Inscription'" title-class="blue-light5--bg">
            <root-errors :errors="formErrors" />
            <w-form
                :no-keyup-validation="true"
                @success="register()"
                v-model="isValid"
            >
                <w-input
                    autofocus
                    :class="'mb2'"
                    label="Prénom *"
                    :maxlength="255"
                    v-model="user.person.firstname"
                    :name="'user[person][firstname]'"
                    :validators="[validators.required, validators.maxLength255]"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    label="Nom"
                    :maxlength="255"
                    :name="'user[person][lastname]'"
                    v-model="user.person.lastname"
                    :validators="[validators.maxLength255]"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    inner-icon-left="mdi mdi-cake"
                    label="Date de naissance"
                    v-model="user.person.dateOfBirth"
                    :name="'user[person][dateOfBirth]'"
                    :type="'date'"
                    :validators="[validators.date]"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    inner-icon-left="mdi mdi-email"
                    label="e-mail *"
                    :maxlength="255"
                    :name="'user[email]'"
                    :type="'email'"
                    :validators="[
                        validators.required,
                        validators.email,
                        validators.maxLength255,
                    ]"
                    v-model="user.email"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    inner-icon-left="mdi mdi-key"
                    label="Mot de passe *"
                    v-model="user.plainPassword"
                    :name="'user[plainPassword]'"
                    :type="isPassword ? 'password' : 'text'"
                    :inner-icon-right="
                        isPassword ? 'mdi mdi-eye-off' : 'mdi mdi-eye'
                    "
                    :validators="[validators.required, validators.minLength8]"
                    @click:inner-icon-right="isPassword = !isPassword"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    inner-icon-left="mdi mdi-image"
                    label="Image de profil"
                    v-model="user.person.avatar"
                    :name="'user[person][avatar]'"
                    :type="'url'"
                    :validators="[validators.url, validators.maxLength255]"
                ></w-input>
                <div class="text-right mt4">
                    <w-button
                        :loading="store.state.isLoading"
                        :disabled="store.state.isLoading"
                        type="submit"
                    >
                        S'inscrire
                    </w-button>
                </div>
            </w-form>
        </w-card>
        <small class="mt3 d-block">
            <router-link to="/">Connexion</router-link>
        </small>
    </section>
</template>
<script setup>
import { reactive, ref } from 'vue'
import store from '@/store'
import RootErrors from '@/components/RootErrors'
import router from '@/router'

const isPassword = ref(true)
const isValid = null
const user = reactive({
    person: {
        firstname: null,
        lastname: null,
        dateOfBirth: null,
        avatar: null,
    },
    email: null,
    plainPassword: null,
})
const formErrors = ref([])
const validators = {
    required: (value) => !!value || 'Champs requis',
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
}

function handleErrors(response) {
    if (response && response.data && response.data.errors) {
        for (const field in response.data.errors) {
            for (const message of response.data.errors[field]) {
                formErrors.value.push(message)
            }
        }
    } else {
        formErrors.value.push('Une erreur est survenue.')
    }
}

function register() {
    formErrors.value.splice(0, formErrors.value.length)
    store.actions
        .register({
            user: {
                person: {
                    firstname: user.person.firstname,
                    lastname: user.person.lastname,
                    dateOfBirth: user.person.dateOfBirth,
                    avatar: user.person.avatar,
                },
                email: user.email,
                plainPassword: user.plainPassword,
            },
        })
        .then(() => {
            store.actions
                .login({
                    username: user.email,
                    password: user.plainPassword,
                })
                .then((response) => {
                    store.mutations.setUser(response.data.data)
                    router.push('/account')
                })
        })
        .catch((error) => handleErrors(error.response))
}
</script>
