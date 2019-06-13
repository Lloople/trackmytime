export const timeFormat = {
    methods: {
        getElapsedTime: function (start) {
            return this.secondsForHumans(Math.floor((new Date() - new Date(start)) / 1000))
        },
        secondsForHumans: function (seconds) {
            return [
                this.pad(seconds / 60 / 60),
                this.pad((seconds / 60 ) % 60),
                this.pad(seconds % 60)
            ].join(':')
        },
        minutesForHumans: function (minutes) {
            return [
                this.pad(minutes / 60),
                this.pad(minutes % 60)
            ].join(':')
        },
        pad: function (number) {
            return Math.floor(number).toString().padStart(2, '0')
        },
    }
}
