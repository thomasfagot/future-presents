<template>
    <section class="width-400px text-left margin-center mt10">
        <w-card shadow title="Nouveau réseau" title-class="blue-light5--bg">
            <root-errors :errors="formErrors" />
            <w-form :no-keyup-validation="true" @success="submit()">
                <w-input
                    autofocus
                    :class="'mb2'"
                    inner-icon-left="mdi mdi-label"
                    label="Nom *"
                    :maxlength="255"
                    :name="'network[name]'"
                    :type="'text'"
                    :validators="[Validators.required, Validators.maxLength255]"
                    v-model="data.name"
                ></w-input>
                <div class="text-right mt4">
                    <w-button
                        type="submit"
                        :loading="store.state.isLoading"
                        :disabled="store.state.isLoading"
                        >Créer</w-button
                    >
                </div>
            </w-form>
        </w-card>
    </section>
</template>
<script setup>
import store from '@/store'
import Validators from '@/utils/Validators'
import RootErrors from '@/components/RootErrors'
import { ref, reactive } from 'vue'
import router from '@/router'

const data = reactive({
    name: null,
})
const formErrors = ref([])

function submit() {
    Validators.resetErrors(formErrors)
    store.actions.addNetwork({ network: { name: data.name } }).then(
        (response) => {
            store.mutations.addNetwork(response.data.network)
            router.push({ name: 'Event.add' })
        },
        (error) => Validators.handleErrors(error.response, formErrors)
    )
}
</script>
