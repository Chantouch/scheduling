<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <table class="bordered">
        <thead class="back_color">
        <tr class="border">
            <th class="size">កាលបរិច្ឆេទ</th>
            <th class="size">ម៉ោង</th>
            <th class="size">កម្មវត្ថុ</th>
            <th class="size">មន្រ្តីអម/អង្គភាពពាក់ព័ន្ធ</th>
            <th class="size">ទីកន្លែង</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="meeting in meetings" v-bind:id="meeting.hashid"
            v-bind:class="{'meeting-now valid' : meeting.start_time >= new Date().getHours() + ':' + new Date().getMinutes(),
             'almost-meeting' : meeting.start_time <= addMinutes(new Date().getHours() + ':' + new Date().getMinutes(), '10') }">
            <td>{{ meeting.date }}</td>
            <td>{{ meeting.start_time + ' - ' + meeting.end_time }}</td>
            <td>{{ meeting.subject }}</td>
            <td>{{ meeting.related_org }}</td>
            <td>{{ meeting.location }}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['post', 'favorited'],

        data: function () {
            return {
                isFavorited: '',
                meetings: []
            }
        },

        mounted() {
            this.isFavorited = !!this.isFavorite;
            this.getMeeting();
        },

        computed: {
            isFavorite() {
                return this.favorited;
            },
        },

        methods: {
            getMeeting(){
                this.$http.get('/api/v1/meetings').then(function (response) {
                    this.meetings = response.body;
                    console.log(response.body);
                }, function (data) {
                    console.log(data)
                });
            },

            favorite(post) {
                axios.post('/favorite/' + post)
                    .then(response => this.isFavorited = true)
                    .catch(response => console.log(response.data));
            },

            unFavorite(post) {
                axios.post('/unfavorite/' + post)
                    .then(response => this.isFavorited = false)
                    .catch(response => console.log(response.data));
            },

            addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
                function z(n) {
                    return (n < 10 ? '0' : '') + n;
                }

                let bits = time.split(':');
                let mins = bits[0] * 60 + (+bits[1]) + (+minsToAdd);
                return z(mins % (24 * 60) / 60 | 0) + ':' + z(mins % 60);
            },
            time(){
                return new Date().getHours() + ':' + new Date().getMinutes();
            }
        }
    }
</script>