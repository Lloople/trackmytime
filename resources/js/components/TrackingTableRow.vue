<template>
    <tr>
        <td @click="edit('start')">
            <div v-show="! editable">{{ timesheet.start }}</div>
            <div v-show="editable">
                <input class="form-input-xs border border-gray-300 leading-normal bg-white"
                       :class="{ 'form-input-error' : errors.includes('start')}"
                       ref="start"
                       type="text"
                       v-model="timesheet.start"
                       @keyup.enter.prevent="updateOrCreate">
            </div>
        </td>
        <td @click="edit('end')">
            <div v-show="! editable">{{ timesheet.end }}</div>
            <div v-show="editable">
                <input class="form-input-xs border border-gray-300 leading-normal bg-white"
                       :class="{ 'form-input-error' : errors.includes('end')}"
                       ref="end"
                       type="text"
                       v-model="timesheet.end"
                       @keyup.enter.prevent="updateOrCreate">
            </div>
        </td>
        <td>{{ duration }}</td>
        <td @click="edit('comment')">
            <div v-show="! editable">
                {{ timesheet.comment }}
            </div>
            <div v-show="editable">
                <input class="form-input-xs border border-gray-300 leading-normal bg-white"
                       :class="{ 'form-input-error' : errors.includes('comment')}"
                       ref="comment"
                       type="text"
                       v-model="timesheet.comment"
                       @keyup.enter.prevent="updateOrCreate">
            </div>
        </td>
        <td>
            <button v-if="! editable && start !== ''"
                    @click="destroy"
                    class="button text-xs bg-transparent text-red-500 hover:text-red-800 button-block">
                DELETE
            </button>
            <button v-if="editable"
                    @click="updateOrCreate"
                    class="button text-xs bg-transparent text-teal-500 hover:text-teal-800 button-block">
                SAVE
            </button>
        </td>
    </tr>
</template>

<script>
    import { timeFormat } from '../mixins/timeFormat'

    export default {
        name: "TrackingTableRow",
        mixins: [timeFormat],
        props: {
            id: {
                type: Number,
                default: null
            },
            start: {
                type: String,
                default: ''
            },
            end: {
                type: String,
                default: ''
            },
            comment: String,
            day: String
        },
        data() {
            return {
                timesheet: {
                    start: this.start,
                    end: this.end,
                    comment: this.comment,
                },
                editable: false,
                errors: []
            }
        },
        methods: {
            edit: function (element) {
                this.editable = true
                this.$nextTick(() => { this.$refs[element].focus() })
            },
            updateOrCreate: function () {
                let method = 'POST'
                let url = 'timesheets'

                if (this.id !== null) {
                    method = 'PUT'
                    url += `/${this.id}`
                }

                axios.post(url, {
                    _method: method,
                    start_at: this.prepareDateForBackend(this.timesheet.start),
                    end_at: this.prepareDateForBackend(this.timesheet.end),
                    comment: this.timesheet.comment,
                }).then((response) => {
                    if (response.status === 201) {
                        window.location.reload()
                    }

                    if (response.status === 200) {
                        this.editable = false
                    }
                })
            },
            destroy: function () {
                if (!confirm("Are you sure you want to delete this record?")) {
                    return
                }

                axios.post(`timesheets/${this.id}`, {
                    _method: 'DELETE'
                }).then((response) => {
                    if (response.status === 200) {
                        window.location.reload()
                    }
                })
            },
            prepareDateForBackend: function (date) {
                let semicolons = (date.match(/:/g) || []).length

                if (semicolons === 0) {
                    date += ':00:00'
                } else if (semicolons === 1) {
                    date += ':00'
                }

                return `${this.day} ${date}`
            }
        },
        computed: {
            duration: function () {
                // TODO: Bug here, the current duration is not getting updated on the fly
                if (this.timesheet.start === '' || this.timesheet.end === '') {
                    return '00:00'
                }


                let [endAtHour, endAtMinutes] = this.timesheet.end.split(':').map(time => parseInt(time))
                let [startAtHour, startAtMinutes] = this.timesheet.start.split(':').map(time => parseInt(time))

                // Check for midnight
                if (endAtHour < startAtHour) {
                    return '00:00'
                }

                let duration = (endAtHour * 60 + (endAtMinutes || 0)) - (startAtHour * 60 + (startAtMinutes || 0));

                if (duration < 0 || duration == null || ! duration) {
                    return '00:00'
                }

                return this.minutesForHumans(duration)
            }
        }
    }
</script>
