export const timeFormat = {
    methods: {
        getElapsedTime: function (start) {
            let seconds = Math.floor((new Date() - new Date(start)) / 1000)

            return this.humanFormat(
                Math.floor(seconds / 60 / 60),
                Math.floor((seconds / 60 ) % 60),
                seconds % 60
            )
        },
        humanFormat: function (hours, minutes, seconds) {
            return `${this.pad(hours)}:${this.pad(minutes)}:${this.pad(seconds)}`;
        },
        pad: function (number) {
            return Math.floor(number).toString().padStart(2, '0')
        }
    }
}
