<template>
    <b-table
        striped
        hover
        :items="items"
    >
    </b-table>
</template>

<script>
export default {
    name: "GameLogsTable",
    props: ['items']
}
</script>

<style scoped>

</style>
