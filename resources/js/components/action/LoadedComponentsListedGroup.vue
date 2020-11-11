<template>
    <b-list-group>
        <b-list-group-item v-for="item in list">{{ item }}</b-list-group-item>
    </b-list-group>
</template>

<script>
export default {
    name: "LoadedComponentsListedGroup",
    props: {
        list: {
            type: Array,
            require: false,
        }
    },
    data() {
        return {
            items: ['Core RDBMS', 'LDAP Connector', 'SSL', 'Application Express'],
        }
    },
}
</script>

<style scoped>

</style>
