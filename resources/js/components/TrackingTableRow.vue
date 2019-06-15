<template>
    <tr>
        <td>{{ element.start_at }}</td>
        <td>{{ element.end_at }}</td>
        <td>{{ minutesForHumans(element.duration) }}</td>
        <td @click="edit">
            <div v-show="! editable">
                {{ element.comment }}
            </div>
            <div v-show="editable">
                <input class="form-input-xs border border-gray-300 leading-normal bg-white"
                       :class="{ 'form-input-error' : commentHasError}"
                       ref="comment"
                       type="text"
                       v-model="element.comment"
                       @keyup.enter.prevent="update">
            </div>
        </td>
        <td @click="destroy"><button class="button text-xs bg-transparent text-red-500 hover:text-red-800 button-block">DELETE</button></td>
    </tr>
</template>

<script>
    import { timeFormat } from '../mixins/timeFormat'

    export default {
        name: "TrackingTableRow",
        mixins: [timeFormat],
        props: {
            element: Object
        },
        data() {
            return {
                editable: false,
                commentHasError : false
            }
        },
        methods: {
            edit: function () {
                this.editable = true
                this.$nextTick(() => { this.$refs.comment.focus() })
            },
            update: function () {
                axios.post(`timesheets/${this.element.id}/comment`, {
                    comment: this.element.comment,
                    _method: 'PUT'
                }).then((response) => {
                    if (response.status === 200) {
                        this.editable = false
                        this.commentHasError = false
                    } else {
                        this.commentHasError = true
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
            }
        }

    }
</script>
