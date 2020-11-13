<template>
    <b-card no-body class="mb-3">
        <b-card-header>{{ machineName }}</b-card-header>
        <b-card-body>
            Status: <span v-bind:class="machineStatusTextVariant">{{ machineStatus }}</span><br>
            Alert: {{ machineAlert }} <br>
            Database Load: {{ databaseLoad }} <br>
            Current DB Patch Ver.: {{ currentPatch }}
        </b-card-body>
        <b-card-footer>
            <b-row>
                <b-col>
                    <a :href="actionRedirect" class="btn btn-block" :class="machineStatusButtonVariant">Action</a>
                </b-col>
<!--                <b-col>-->
<!--                    <b-button block>Detail</b-button>-->
<!--                </b-col>-->
            </b-row>
        </b-card-footer>
    </b-card>
</template>

<script>
export default {
    name: "SystemCard",
    methods: {

    },
    props: {
        machineName: {
            type: String,
            require: true
        },
        machineStatus: {
            type: String,
            require: true
        },
        machineAlert: {
            type: String,
            require: true
        },
        machineLoad: {
            type: Object,
            require: false
        },
        currentPatch: {
            type: String,
            require: true
        },
        databaseLoad: {
            type: String,
            require: true
        },
        machineId: {
            type: String,
            require: true
        }
    },
    computed: {
        machineStatusTextVariant() {
            let textVariant;
            if (this.machineStatus == "Up") {
                textVariant = 'text-success';
            } else if (this.machineStatus == "Busy") {
                textVariant = 'text-warning';
            } else if (this.machineStatus == "Down") {
                textVariant = 'text-danger';
            }
            return textVariant;
        },
        machineStatusButtonVariant() {
            let textVariant;
            if (this.machineStatus == "Up") {
                textVariant = 'btn-success';
            } else if (this.machineStatus == "Busy") {
                textVariant = 'btn-warning';
            } else if (this.machineStatus == "Down") {
                textVariant = 'btn-danger';
            }
            return textVariant;
        },
        actionRedirect() {
            return "/action/" + this.machineId;
        }
    }
}
</script>

<style scoped>

</style>
