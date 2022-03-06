<template>
    <section class="width-400px text-left margin-center mt4">
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
                    :validators="[Validators.required, Validators.maxLength255]"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    label="Nom"
                    :maxlength="255"
                    :name="'user[person][lastname]'"
                    v-model="user.person.lastname"
                    :validators="[Validators.maxLength255]"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    inner-icon-left="mdi mdi-cake"
                    label="Date de naissance"
                    v-model="user.person.dateOfBirth"
                    :name="'user[person][dateOfBirth]'"
                    :type="'date'"
                    :validators="[Validators.dateInPast]"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    inner-icon-left="mdi mdi-email"
                    label="e-mail *"
                    :maxlength="255"
                    :name="'user[email]'"
                    :type="'email'"
                    :validators="[
                        Validators.required,
                        Validators.email,
                        Validators.maxLength255,
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
                    :validators="[Validators.required, Validators.minLength8]"
                    @click:inner-icon-right="isPassword = !isPassword"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    inner-icon-left="mdi mdi-image"
                    label="Image de profil"
                    v-model="user.person.avatar"
                    :name="'user[person][avatar]'"
                    :type="'url'"
                    :validators="[Validators.url, Validators.maxLength255]"
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
            <router-link :to="{ name: 'Login' }">Connexion</router-link>
        </small>
    </section>
</template>
<script setup>
import { reactive, ref } from 'vue'
import store from '@/store'
import RootErrors from '@/components/RootErrors'
import router from '@/router'
import Validators from '@/utils/Validators'

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

function register() {
    Validators.resetErrors(formErrors)
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
        .then(
            () => {
                store.actions
                    .login({
                        username: user.email,
                        password: user.plainPassword,
                    })
                    .then((response) => {
                        store.mutations.setUser(response.data.data)
                        router.push({ name: 'Network.add' })
                    })
            },
            (error) => Validators.handleErrors(error.response, formErrors)
        )
}
</script>
