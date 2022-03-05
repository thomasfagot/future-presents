<template>
    <section class="width-400px text-left margin-center mt10">
        <w-card shadow :title="'Connexion'" title-class="blue-light5--bg">
            <root-errors :errors="formErrors" />
            <w-form :no-keyup-validation="true" @success="login()">
                <w-input
                    autofocus
                    :class="'mb2'"
                    inner-icon-left="mdi mdi-email"
                    label="e-mail *"
                    :maxlength="255"
                    :name="'username'"
                    :type="'email'"
                    :validators="[
                        Validators.required,
                        Validators.email,
                        Validators.maxLength255,
                    ]"
                    v-model="email"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    inner-icon-left="mdi mdi-key"
                    label="Mot de passe *"
                    :name="'password'"
                    v-model="password"
                    :type="isPassword ? 'password' : 'text'"
                    :inner-icon-right="
                        isPassword ? 'mdi mdi-eye-off' : 'mdi mdi-eye'
                    "
                    :validators="[Validators.required, Validators.minLength8]"
                    @click:inner-icon-right="isPassword = !isPassword"
                ></w-input>
                <div class="text-right mt4">
                    <w-button
                        type="submit"
                        :loading="store.state.isLoading"
                        :disabled="store.state.isLoading"
                        >Se connecter</w-button
                    >
                </div>
            </w-form>
        </w-card>
        <small class="mt3 d-block">
            <router-link :to="{ name: 'Register' }">S'inscrire</router-link>
        </small>
    </section>
</template>
<script setup>
import { ref } from 'vue'
import store from '@/store'
import router from '@/router'
import Validators from '@/utils/Validators'
import RootErrors from '@/components/RootErrors'

const isPassword = ref(true)
const email = ref(null)
const password = ref(null)
const formErrors = ref([])

function login() {
    Validators.resetErrors(formErrors)
    store.actions
        .login({
            username: email.value,
            password: password.value,
        })
        .then((response) => {
            store.mutations.setUser(response.data.data)
            router.push({ name: 'Account' })
        })
        .catch((error) =>
            Validators.handleErrors(
                error.response,
                formErrors,
                'Adresse e-mail ou mot de passe invalide.'
            )
        )
}
</script>
