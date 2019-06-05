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
        <tr v-for="(row) in rows">
            <td>{{ row.start_at }}</td>
            <td>{{ row.end_at }}</td>
            <td>{{ humanFormat(row.duration) }}</td>
            <td>{{ row.comment }}</td>
        </tr>

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
            <td>{{ humanFormat(totalDuration) }}</td>
        </tr>
        </tfoot>
    </table>
</template>

<script>
    export default {
        name: 'TrackingTable',
        props: {
            rows: Array
        },
        computed: {
            totalDuration: function () {
                return this.rows.reduce((total, row) => { return total += row.duration }, 0)
            },
            humanFormat: function () {
                return minutes => {
                    return `${Math.floor(minutes / 60).toString().padStart(2, '0')}:${(minutes % 60).toString().padStart(2, '0')}`
                }
            }
        }
    }
</script>
