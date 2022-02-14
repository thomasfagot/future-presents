<template>
    <section class="width-300px text-left margin-center mt10">
        <w-card shadow :title="'Connexion'" title-class="blue-light5--bg">
            <w-form :no-keyup-validation="true">
                <w-input
                    :class="'mb2'"
                    label="e-mail"
                    :model-value="email"
                    :maxlength="255"
                    :name="'username'"
                    :type="'email'"
                    :validators="[validators.required, validators.email]"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    :model-value="plainPassword"
                    label="Mot de passe"
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
<script>
export default {
    name: 'Login',
    data() {
        return {
            email: null,
            plainPassword: null,
            validators: {
                required: (value) => !!value || 'Champs requis',
                email: (value) =>
                    value.match(
                        /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/
                    ) || 'e-mail invalide',
            },
        }
    },
}
</script>
