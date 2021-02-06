<template>
    <div>
        <MailHeader :mail="email" :currentStatus="currentStatus">
            <div>
                To: <router-link :to="/emails-list/+ email.recipient">
                    {{ email.recipient }}
                </router-link>
            </div>
        </MailHeader>
        <div v-html="email.content" class="email-content"></div>
        <pre style="padding: 5em;">{{ email }}</pre>
    </div>
</template>

<script>
    import axios from 'axios'
    import MailHeader from '../components/MailHeader'

    export default {
        components: {
            MailHeader
        },

        data: () => ({
            email: {}
        }),

        computed: {
            currentStatus(){
                if(this.email.activities)
                    return this.email.activities[this.email.activities.length - 1]

                return {}
            }
        },

        mounted() {
            const emailId = this.$route.params.id;

            axios.get('/api/emails/' + emailId)
                .then(response => this.email = response.data)
        }
    }
</script>

<style>
    .email-content{
        margin-top: 2em;
    }
</style>
