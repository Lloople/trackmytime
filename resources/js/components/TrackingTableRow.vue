<template>
    <tr>
        <td @click="edit('start_at')">
            <div v-show="! editable">{{ element.start_at }}</div>
            <div v-show="editable">
                <input class="form-input-xs border border-gray-300 leading-normal bg-white"
                       :class="{ 'form-input-error' : errors.includes('start_at')}"
                       ref="start_at"
                       type="text"
                       v-model="element.start_at"
                       @keyup.enter.prevent="updateOrCreate">
            </div>
        </td>
        <td @click="edit('end_at')">
            <div v-show="! editable">{{ element.end_at }}</div>
            <div v-show="editable">
                <input class="form-input-xs border border-gray-300 leading-normal bg-white"
                       :class="{ 'form-input-error' : errors.includes('end_at')}"
                       ref="end_at"
                       type="text"
                       v-model="element.end_at"
                       @keyup.enter.prevent="updateOrCreate">
            </div>
        </td>
        <td>{{ duration }}</td>
        <td @click="edit('comment')">
            <div v-show="! editable">
                {{ element.comment }}
            </div>
            <div v-show="editable">
                <input class="form-input-xs border border-gray-300 leading-normal bg-white"
                       :class="{ 'form-input-error' : errors.includes('comment')}"
                       ref="comment"
                       type="text"
                       v-model="element.comment"
                       @keyup.enter.prevent="updateOrCreate">
            </div>
        </td>
        <td>
            <button v-if="! editable && element.start_at !== 'undefined'"
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
            element: Object,
            day: String
        },
        data() {
            return {
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
                if (this.element.hasOwnProperty('id')) {
                    method = 'PUT'
                    url += `/${this.element.id}`
                }

                axios.post(url, {
                    _method: method,
                    start_at: this.prepareDateForBackend(this.element.start_at),
                    end_at: this.prepareDateForBackend(this.element.end_at),
                    comment: this.element.comment,
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

                axios.post(`timesheets/${this.element.id}`, {
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

                if (! this.element.hasOwnProperty('id') ||
                    this.element.start_at === '' ||
                    this.element.end_at === '' ) {
                    return '00:00'
                }

                let [endAtHour, endAtMinutes] = this.element.end_at.split(':').map(time => parseInt(time))
                let [startAtHour, startAtMinutes] = this.element.start_at.split(':').map(time => parseInt(time))

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
