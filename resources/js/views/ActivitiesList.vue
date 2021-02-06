<template>
    <div>
        <Header class="row">
            <input type="text" v-model="filter" placeholder="search by sender, recipient or subject">
        </Header>
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
</style>
