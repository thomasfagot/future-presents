<template>
    <section class="width-400px text-left margin-center mt10">
        <w-card shadow :title="'Inscription'" title-class="blue-light5--bg">
            <w-form :no-keyup-validation="true">
                <w-input
                    autofocus
                    :class="'mb2'"
                    label="Prénom *"
                    :maxlength="255"
                    :model-value="user.person.firstname"
                    :name="'user[person][firstname]'"
                    :validators="[validators.required]"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    label="Nom"
                    :maxlength="255"
                    :name="'user[person][lastname]'"
                    :model-value="user.person.lastname"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    label="Date de naissance"
                    :model-value="user.person.dateOfBirth"
                    :name="'user[person][dateOfBirth]'"
                    :type="'date'"
                    :validators="[validators.date]"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    label="e-mail *"
                    :maxlength="255"
                    :model-value="user.email"
                    :name="'user[email]'"
                    :type="'email'"
                    :validators="[validators.required, validators.email]"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    label="Mot de passe *"
                    :model-value="user.plainPassword"
                    :name="'user[plainPassword]'"
                    :type="'password'"
                    :validators="[validators.required]"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    label="Image de profil"
                    :model-value="user.person.avatar"
                    :name="'user[person][avatar]'"
                    :type="'url'"
                    :validators="[validators.url]"
                ></w-input>
                <div class="text-right mt4">
                    <w-button type="submit">Se connecter</w-button>
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
        value.match(
            /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_+.~#?&/=]*)/g
        ) || 'URL invalide',
})
</script>
