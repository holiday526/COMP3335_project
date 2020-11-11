<template>
    <b-card no-body class="mb-3">
        <b-card-header>Header</b-card-header>
        <b-card-body>body</b-card-body>
        <b-card-footer>
            <b-row>
                <b-col>
                    <b-button block @click="testing">Action</b-button>
                </b-col>
                <b-col>
                    <b-button block>Detail</b-button>
                </b-col>
            </b-row>
        </b-card-footer>
    </b-card>
</template>

<script>
export default {
    name: "SystemCard",
    methods: {
        testing() {
            alert("hi");
        },
    }
}
</script>

<style scoped>

</style>
