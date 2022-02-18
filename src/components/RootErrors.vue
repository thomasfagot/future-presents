<template>
    <div class="message-box ma0">
        <template v-for="error in errors" :key="error">
            <w-transition-fade>
                <w-alert class="text-light mb1 mt0" error icon-outside>
                    {{ error }}
                </w-alert>
            </w-transition-fade>
        </template>
    </div>
</template>
<script>
export default {
    name: 'RootErrors',
    functional: true,
    props: {
        errors: {
            type: Array,
            required: true,
        },
    },
}
</script>
