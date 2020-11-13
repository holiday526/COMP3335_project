<template>
    <div>
        <h3 v-if="JSON.parse(items).length == 0">No Game History</h3>

        <b-table v-else :items="JSON.parse(items)">
        </b-table>
    </div>
</template>

<script>
export default {
    name: "HistoryTable",
    props: {
        items: {
            require: false,
        }
    }
}
</script>

<style scoped>

</style>
