<template>
    <div>
        <b-table stacked :items="[JSON.parse(userInfo)]"></b-table>
    </div>
</template>

<script>
export default {
    name: "UserProfile",
    props: {
        userInfo: {
            required: true
        }
    },
    data() {
        return {};
    },
}
</script>

<style scoped>

</style>
