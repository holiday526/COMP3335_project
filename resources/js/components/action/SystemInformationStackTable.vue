<template>
    <b-table stacked :items="items"></b-table>
</template>

<script>
export default {
    name: "SystemInformationStackTable",
    props: {
        systemOs: {
            type: String,
            require: true
        },
        systemLastPatchDate: {
            type: String,
            require: true
        },
        systemCurrentDbPatchVersion: {
            type: String,
            require: true
        }
    },
    computed: {
        items() {
            return [{OS: this.systemOs, last_patch_date: this.systemLastPatchDate, current_DB_patch_version: this.systemCurrentDbPatchVersion}];
        }
    }
}
</script>

<style scoped>

</style>
