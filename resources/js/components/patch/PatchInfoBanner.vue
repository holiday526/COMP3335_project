<template>
    <b-alert show :variant="variant">
        <h4 class="alert-heading">{{ heading }}</h4>
        <p>
            {{ description }}
        </p>
        <hr>
        <div><a :href="urlToDoc" class="btn btn-secondary btn-sm" target="_blank">Learn More (Redirect to outside)</a></div>
    </b-alert>
</template>

<script>
export default {
    name: "PatchInfoBanner",
    props: {
        variant: {
            type: String,
            require: false,
            default: 'info'
        },
        heading: {
            type: String,
            require: true,
        },
        description: {
            type: String,
            require: true
        },
        urlToDoc: {
            require: true
        }
    }
}
</script>

<style scoped>

</style>
