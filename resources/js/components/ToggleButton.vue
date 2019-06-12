<template>
    <div>
        <button class="button text-sm float-right">{{ buttonText }}!</button>
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
                required: false
            }
        },
        data() {
            return {
                elapsedTime: null,
                buttonText: this.tracking === null ? 'START' : 'STOP'
            }
        },
        mounted() {
            if (this.tracking !== null) {
                this.startElapsedTimeInterval();
            }
        },
        methods: {
            startElapsedTimeInterval: function () {
                setInterval(() => {
                    this.elapsedTime = this.getElapsedTime(this.tracking)
                }, 1000)
            }
        }
    }
</script>

<style scoped>

</style>
