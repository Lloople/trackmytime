export const timeFormat = {
    methods: {
        getElapsedTime: function (start) {
            let seconds = Math.floor((new Date() - new Date(start)) / 1000)

            return [
                this.pad(seconds / 60 / 60),
                this.pad((seconds / 60 ) % 60),
                this.pad(seconds % 60)
            ].join(':')
        },
        pad: function (number) {
            return Math.floor(number).toString().padStart(2, '0')
        }
    }
}
