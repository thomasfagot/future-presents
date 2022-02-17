<template>
    <section class="width-400px text-left margin-center mt10">
        <w-card shadow :title="'Connexion'" title-class="blue-light5--bg">
            <w-form :no-keyup-validation="true" @submit="login()">
                <w-input
                    autofocus
                    :class="'mb2'"
                    label="e-mail *"
                    v-model="email"
                    :maxlength="255"
                    :name="'username'"
                    :type="'email'"
                    :validators="[validators.required, validators.email]"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    v-model="password"
                    label="Mot de passe *"
                    :name="'password'"
                    :type="'password'"
                    :validators="[validators.required]"
                ></w-input>
                <div class="text-right mt4">
                    <w-button type="submit">Se connecter</w-button>
                </div>
            </w-form>
        </w-card>
        <small class="mt3 d-block">
            <router-link to="/register">S'inscrire</router-link>
        </small>
    </section>
</template>
<script setup>
import { reactive, ref } from 'vue'
import store from '@/store'

const email = ref(null)
const password = ref(null)
const validators = reactive({
    required: (value) => !!value || 'Champ requis',
    email: (value) =>
        value.match(/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/) ||
        'e-mail invalide',
})
function login() {
    store.actions
        .login({
            username: email.value,
            password: password.value,
        })
        .then(
            (response) => {
                console.log(response)
            },
            (error) => {
                console.log(error)
            }
        )
}
</script>
