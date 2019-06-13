<template>
    <table class="table table-auto w-full mt-8 table-stripped">
        <thead>
        <tr>
            <th class="w-1/5">Begin</th>
            <th class="w-1/5">End</th>
            <th class="w-1/5">Duration</th>
            <th class="w-2/5">Comment</th>
        </tr>
        </thead>
        <tbody>
        <tracking-table-row v-for="(row, index) in rows" :key="index" :element="row"></tracking-table-row>
        <tr v-if="rows.length === 0">
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
            <td>{{ minutesForHumans(totalDuration) }}</td>
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
            rows: Array
        },
        computed: {
            totalDuration: function () {
                return this.rows.reduce((total, row) => { return total += row.duration }, 0)
            }
        }
    }
</script>
