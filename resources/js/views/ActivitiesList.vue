<template>
    <div>
        <Empty v-if="!activities.length && !loading"></Empty>
        <div v-else-if="!loading">
            <Header class="row">
                <input type="text" v-model="filter" placeholder="search by sender, recipient or subject">
            </Header>
            <div class="row activity-title">
                <div class="col-4  col-md-1  order-md-1">EVENT</div>
                <div class="col-8  col-md-3  order-md-5">DATE</div>
                <div class="col-12 col-md-2  order-md-2">SENDER</div>
                <div class="col-12 col-md-2  order-md-3">RECIPIENT</div>
                <div class="col-12 col-md-4  order-md-4">SUBJECT</div>
            </div>
            <ActivityItem
                class="row"
                v-for="activity in filtered"
                :key="activity.id"
                :activity-data="activity"
            ></ActivityItem>
        </div>
    </div>
</template>


<script>
    import axios from 'axios'
    import ActivityItem from '../components/ActivityItem'
    import Header from '../components/Header'
    import Empty from '../components/Empty'

    export default {
        components: {
            Header,
            Empty,
            ActivityItem
        },

        data: () => ({
            loading: true,
            activities: [],
            filter: ''
        }),

        computed: {
            filtered(){
                return this.activities.filter(item => {
                    return item.sender.includes(this.filter)    ||
                        item.recipient.includes(this.filter) ||
                        item.subject.includes(this.filter)
                })
            }
        },

        mounted() {
            axios.get('/api/activities')
                .then(response => {
                    this.activities = response.data.data;
                    this.loading = false;
                })
        }
    }
</script>
