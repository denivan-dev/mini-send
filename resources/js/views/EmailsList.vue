<template>
    <div>
        <router-link
            class="email-list__item"
            v-for="email in mailsList"
            :key="email.id"
            :to="/email/ + email.id"
        >
            <MailHeader
                :mail="email"
                :currentStatus="currentStatus(email)"
            >
                <div>To: {{ email.recipient }}</div>
            </MailHeader>
        </router-link>
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
            mailsList: []
        }),

        methods: {
            currentStatus(email){
                return email.activities[email.activities.length - 1]
            }
        },

        mounted() {
            const recipient_id = this.$route.params.recipient_id;

            axios.get('/api/emails?recipient=' + recipient_id)
                .then(response => this.mailsList = response.data)
        }
    }
</script>

<style>
    .email-list__item{
        margin: 2px;
        color: #000000;
        transition-duration: .3s;
        display: block;
    }

    .email-list__item:hover{
        background: #e6e6e6;
        cursor: pointer;
        text-decoration: none;
        color: #000000;
    }
</style>
