<template>
    <div class="flex flex-col text-center">
        <button @click="toggle" class="ml-2 text-xs uppercase button button-info">{{ buttonText }} tracking</button>
        <span>{{ elapsedTime }}</span>
    </div>
</template>

<script>
    import { timeFormat } from '../mixins/timeFormat'

    export default {
        name: "ToggleButton",
        mixins: [timeFormat],
        props: {
            tracking: {
                type: String
            }
        },
        data() {
            return {
                elapsedTime: this.tracking === '' ? '00:00:00' : this.getElapsedTime(this.tracking),
                buttonText: this.tracking === '' ? 'Start' : 'Stop'
            }
        },
        mounted() {
            if (this.tracking !== '') {
                this.startElapsedTimeInterval();
            }
        },
        methods: {
            startElapsedTimeInterval: function () {
                setInterval(() => {
                    this.elapsedTime = this.getElapsedTime(this.tracking)
                }, 1000)
            },
            toggle: function () {
               axios.post('track/toggle').then(function (response) {
                   if (response.status === 201) {
                       window.location.reload()
                   }
               })
            }
        }
    }
</script>

<style scoped>

</style>
