<template>
    <table class="table table-auto w-full mt-8 table-stripped">
        <thead>
        <tr>
            <th class="w-1/6">Begin</th>
            <th class="w-1/6">End</th>
            <th class="w-1/6">Duration</th>
            <th class="w-2/6">Comment</th>
            <th class="w-1/6"><button class="button text-xs button-block bg-white text-teal-500 hover:text-teal-800" @click="create">{{ newRecord ? 'HIDE' : 'CREATE' }}</button></th>
        </tr>
        </thead>
        <tbody>
        <tracking-table-row v-if="newRecord"
                            :day="day"></tracking-table-row>
        <tracking-table-row v-for="(row, index) in rows" :key="index"
                            :day="day"
                            :id="row.id"
                            :start="row.start_at"
                            :end="row.end_at"
                            :comment="row.comment"></tracking-table-row>
        <tr v-if="rows.length === 0">
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>

        </tbody>
        <tfoot v-if="rows.length">
        <tr>
            <td></td>
            <th>Total</th>
            <td>{{ minutesForHumans(total) }}</td>
        </tr>
        </tfoot>
    </table>
</template>

<script>
    import { timeFormat} from "../mixins/timeFormat"

    export default {
        name: 'TrackingTable',
        mixins: [timeFormat],
        props: {
            rows: Array,
            total: Number,
            day: String
        },
        data() {
            return {
                newRecord: false
            }
        },
        methods: {
            create: function () {
                this.newRecord = ! this.newRecord
            }
        }
    }
</script>
