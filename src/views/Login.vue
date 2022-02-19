<template>
    <section class="width-400px text-left margin-center mt10">
        <w-card shadow :title="'Connexion'" title-class="blue-light5--bg">
            <root-errors :errors="formErrors" />
            <w-form :no-keyup-validation="true" @submit="login()">
                <w-input
                    autofocus
                    :class="'mb2'"
                    inner-icon-left="mdi mdi-email"
                    label="e-mail *"
                    :maxlength="255"
                    :name="'username'"
                    :type="'email'"
                    :validators="[validators.required, validators.email]"
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
                    :validators="[validators.required]"
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
import { reactive, ref } from 'vue'
import store from '@/store'
import RootErrors from '@/components/RootErrors'
import router from '@/router'

const isPassword = ref(true)
const email = ref(null)
const password = ref(null)
const formErrors = ref([])
const validators = reactive({
    required: (value) => !!value || 'Champ requis',
    email: (value) =>
        value.match(/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/) ||
        'e-mail invalide',
})
function login() {
    formErrors.value.splice(0, formErrors.value.length)
    store.actions
        .login({
            username: email.value,
            password: password.value,
        })
        .then((response) => {
            store.mutations.setUser(response.data.data)
            router.push('/account')
        })
        .catch(() =>
            formErrors.value.push('Adresse e-mail ou mot de passe invalide.')
        )
}
</script>
