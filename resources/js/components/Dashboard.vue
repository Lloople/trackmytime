<template>
    <div>
        <h2 class="text-3xl mt-8">
            <span v-if="rows.length">
                You've worked <span class="font-black text-teal-500">{{ totalInHours }}</span> hours today.
            </span>
            <span v-else>
                Today is empty. Maybe you forgot to track your time? 🤔
            </span>
        </h2>

        <tracking-table :rows="rows" :total="total" :day="day"></tracking-table>
    </div>
</template>

<script>
    export default {
        name: "Dashboard",
        props: {
            rows: Array,
            day: String
        },
        data() {
            return {
                total: this.rows.reduce((total, row) => { return total += row.duration }, 0),
            }
        },
        computed: {
            totalInHours: function () {
                return Math.floor(this.total / 60)
            }
        }
    }
</script>

<style scoped>

</style>
