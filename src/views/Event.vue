<template>
    <section class="width-400px text-left margin-center mt10">
        <w-card
            shadow
            :title="
                'edit' === props.action
                    ? 'Modifier « ' + store.state.currentEvent.name + ' »'
                    : 'Nouvel évènement'
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
                    :name="'event[name]'"
                    :type="'text'"
                    :validators="[Validators.required, Validators.maxLength255]"
                    v-model="data.name"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    inner-icon-left="mdi mdi-calendar"
                    label="Date *"
                    :name="'event[date]'"
                    :type="'date'"
                    :validators="[Validators.required, Validators.date]"
                    v-model="data.date"
                ></w-input>
                <w-input
                    :class="'mb2'"
                    inner-icon-left="mdi mdi-image"
                    label="Image"
                    :maxlength="255"
                    :name="'event[cover]'"
                    :type="'url'"
                    :validators="[Validators.url, Validators.maxLength255]"
                    v-model="data.cover"
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
import { ref, reactive, defineProps, watch } from 'vue'
import router from '@/router'

const props = defineProps({
    action: {
        type: String,
        required: true,
    },
})
const data = reactive({
    name: 'edit' === props.action ? store.state.currentEvent.name : null,
    date:
        'edit' === props.action
            ? store.state.currentEvent.date.substring(0, 10)
            : null,
    cover: 'edit' === props.action ? store.state.currentEvent.cover : null,
})
const formErrors = ref([])

function submit() {
    Validators.resetErrors(formErrors)
    if ('edit' === props.action) {
        store.actions
            .editEvent({
                event: {
                    name: data.name,
                    date: data.date,
                    cover: data.cover,
                    network: store.state.currentNetwork.id,
                },
            })
            .then(
                (response) => {
                    store.mutations.editEvent(response.data.event)
                    router.push({ name: 'Account' })
                },
                (error) => Validators.handleErrors(error.response, formErrors)
            )
    } else {
        store.actions
            .addEvent({
                event: {
                    name: data.name,
                    date: data.date,
                    cover: data.cover,
                    network: store.state.currentNetwork.id,
                },
            })
            .then(
                (response) => {
                    store.mutations.addEvent(response.data.event)
                    router.push({ name: 'Account' })
                },
                (error) => Validators.handleErrors(error.response, formErrors)
            )
    }
}

watch(
    () => props.action,
    () => {
        if ('edit' === props.action) {
            data.name = store.state.currentEvent.name
            data.date = store.state.currentEvent.date.substring(0, 10)
            data.cover = store.state.currentEvent.cover
        } else {
            data.name = null
            data.date = null
            data.cover = null
        }
    }
)
</script>
