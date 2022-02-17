<template>
    <section class="width-400px text-left margin-center mt10">
        <w-card shadow :title="'Inscription'" title-class="blue-light5--bg">
            <w-form
                :no-keyup-validation="true"
                @submit.prevent="isValid && register()"
                v-model="isValid"
            >
                <w-input
                    autofocus
                    :class="'mb2'"
                    label="Prénom *"
                    :maxlength="255"
                    v-model="user.person.firstname"
                    :name="'user[person][firstname]'"
                    :validators="[validators.required]"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    label="Nom"
                    :maxlength="255"
                    :name="'user[person][lastname]'"
                    v-model="user.person.lastname"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    label="Date de naissance"
                    v-model="user.person.dateOfBirth"
                    :name="'user[person][dateOfBirth]'"
                    :type="'date'"
                    :validators="[validators.date]"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    label="e-mail *"
                    :maxlength="255"
                    v-model="user.email"
                    :name="'user[email]'"
                    :type="'email'"
                    :validators="[validators.required, validators.email]"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    label="Mot de passe *"
                    v-model="user.plainPassword"
                    :name="'user[plainPassword]'"
                    :type="'password'"
                    :validators="[validators.required]"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    label="Image de profil"
                    v-model="user.person.avatar"
                    :name="'user[person][avatar]'"
                    :type="'url'"
                    :validators="[validators.url]"
                ></w-input>
                <div class="text-right mt4">
                    <w-button type="submit">S'inscrire</w-button>
                </div>
            </w-form>
        </w-card>
        <small class="mt3 d-block">
            <router-link to="/">Connexion</router-link>
        </small>
    </section>
</template>
<script setup>
import { reactive } from 'vue'
import store from '@/store'

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
const validators = reactive({
    required: (value) => !!value || 'Champs requis',
    email: (value) =>
        value.match(/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/) ||
        'e-mail invalide',
    date: (value) => !isNaN(new Date(value).getTime()) || 'Date invalide',
    url: (value) =>
        !value ||
        value.match(
            /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_+.~#?&/=]*)/g
        ) ||
        'URL invalide',
})
function register() {
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
            (response) => {
                console.log(response)
            },
            () => {
                console.log('request error')
            }
        )
}
</script>
