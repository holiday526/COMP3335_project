<template>
    <b-table stacked :items="systemInformation"></b-table>
</template>

<script>
export default {
    name: "SystemInformationStackTable",
    props: {
        systemInformation: {
            type: Object,
            require: true
        }
    }
}
</script>

<style scoped>

</style>
