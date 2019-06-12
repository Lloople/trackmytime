<template>
    <div>
        <button @click="toggle" class="button text-sm float-right">{{ buttonText }}!</button>
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
                elapsedTime: null,
                buttonText: this.tracking === '' ? 'START' : 'STOP'
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
