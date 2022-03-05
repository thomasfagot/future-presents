<template>
    <section class="width-400px text-left margin-center mt10">
        <w-card
            shadow
            :title="
                'edit' === props.action
                    ? 'Modifier « ' + store.state.currentNetwork.name + ' »'
                    : 'Nouveau réseau'
            "
            title-class="blue-light5--bg"
        >
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
                    >
                        <template v-if="'edit' === props.action">
                            Valider
                        </template>
                        <template v-else>Créer</template>
                    </w-button>
                </div>
            </w-form>
        </w-card>
    </section>
</template>
<script setup>
import store from '@/store'
import Validators from '@/utils/Validators'
import RootErrors from '@/components/RootErrors'
import { ref, reactive, defineProps, watch } from 'vue'
import router from '@/router'

const props = defineProps({
    action: {
        type: String,
        required: true,
    },
})
const data = reactive({
    name: 'edit' === props.action ? store.state.currentNetwork.name : null,
})
const formErrors = ref([])

function submit() {
    Validators.resetErrors(formErrors)
    if ('edit' === props.action) {
        store.actions.editNetwork({ network: { name: data.name } }).then(
            (response) => {
                store.mutations.editNetwork(response.data.network)
                router.push({ name: 'Event.add' })
            },
            (error) => Validators.handleErrors(error.response, formErrors)
        )
    } else {
        store.actions.addNetwork({ network: { name: data.name } }).then(
            (response) => {
                store.mutations.addNetwork(response.data.network)
                router.push({ name: 'Event.add' })
            },
            (error) => Validators.handleErrors(error.response, formErrors)
        )
    }
}

watch(
    () => props.action,
    () =>
        (data.name =
            'edit' === props.action ? store.state.currentNetwork.name : null)
)
</script>
