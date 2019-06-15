<template>
    <tr>
        <td><input class="form-input-table" :class="{ 'form-input-error' : errors.includes('start_at') }" ref="start_at" type="text" v-model="element.start_at"></td>
        <td><input class="form-input-table" :class="{ 'form-input-error' : errors.includes('end_at') }" ref="end_at" type="text" v-model="element.end_at"></td>
        <td>{{ duration }}</td>
        <td><input class="form-input-table" :class="{ 'form-input-error' : errors.includes('comment') }" ref="comment" type="text" v-model="element.comment"></td>
        <td @click="store"><button class="button text-xs text-blue-500 hover:text-blue-800 button-block">SAVE</button></td>
    </tr>
</template>

<script>
    import { timeFormat } from '../mixins/timeFormat'

    export default {
        name: "TrackingTableRowCreate",
        mixins: [timeFormat],
        props: {
            day: String
        },
        data() {
            return {
                element: {
                    start_at: '',
                    end_at: '',
                    comment: ''
                },
                errors: []
            }
        },
        computed: {
            duration: function () {
                if (this.element.start_at === '' || this.element.end_at === '' ) {
                    return '00:00'
                }

                // TODO: There's a bug here, S 21:34 & E 22:50 marks 99:16 instead of 01:16
                let minutesEndAt = (this.element.end_at.split(':')[0] * 60) + this.element.end_at.split(':')[1];
                let minutesStartAt = (this.element.start_at.split(':')[0] * 60) + this.element.start_at.split(':')[1];

                let duration = minutesEndAt - minutesStartAt;

                if (duration < 0 || duration == null || ! duration) {
                    return '00:00'
                }
                return this.minutesForHumans(duration)
            }
        },
        methods: {
            store: function () {
                if (! this.validateData()) {
                    return
                }

                axios.post(`timesheets`, {
                    start_at: `${this.day} ${this.element.start_at}:00`,
                    end_at: `${this.day} ${this.element.end_at}:00`,
                    comment: this.element.comment,
                }).then((response) => {
                    if (response.status === 201) {
                        window.location.reload()
                    }
                })
            },
            validateData: function () {
                /**
                 * TODO: Missing validations
                 * start_at
                 *      !== ''
                 *      > 00:00
                 * end_at
                 *      !== ''
                 *      < [25]:[60]
                 * start_at < end_at
                 *
                 */


                return this.errors.length === 0
            }
        }

    }
</script>
