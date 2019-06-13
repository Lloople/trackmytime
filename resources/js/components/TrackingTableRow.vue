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
            }
        }

    }
</script>
