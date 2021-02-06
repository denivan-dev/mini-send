<template>
    <div>
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
</template>


<script>
    import axios from 'axios'
    import ActivityItem from '../components/ActivityItem'
    import Header from '../components/Header'

    export default {
        components: {
            Header,
            ActivityItem
        },

        data: () => ({
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
                .then(response => this.activities = response.data.data)
        }
    }
</script>

<style scoped>
    input{
        width: 100%;
        padding: 12px 20px;
        box-sizing: border-box;
        border: none;
        border-bottom: 1px solid #ccc;
        transition: 0.2s;
        outline: none;
        background: rgba(248, 250, 252, 0);
    }

    input[type=text]:focus {
        border: none;
        border-bottom: 1px solid #555;
    }

    .activity-title{
        background: violet;
        position: -webkit-sticky;
        position: sticky;
        top: 81px;
        padding: .3em;
        margin: 1.2em 0 0 0;
        z-index: 100;
        border-radius: 3px;
    }
</style>
