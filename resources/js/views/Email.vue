<template>
    <div>
        <MailHeader :mail="email" :currentStatus="currentStatus">
            <div>
                To: <router-link :to="/emails-list/+ email.recipient">
                    {{ email.recipient }}
                </router-link>
            </div>
        </MailHeader>
        <div class="attachment-container">
            <a  class="attachment"
                v-for="attachment in email.files"
                :title="attachment.client_name"
                :href="attachment.path"
                :key="attachment.id"
                :download="attachment.client_name"
            >
                <span class="attachment-title overflow-ellipsis">{{ attachment.client_name }}</span>
                <span class="icon icon-download"></span>
            </a>
            <div class="icon icon-attach"></div>
        </div>
        <div v-html="email.content" class="email-content"></div>
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

    .attachment-container{
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
        align-items: center;
        margin-top: 1em;
    }

    .attachment{
        padding: .3em 1em;
        border: 1px solid black;
        color: black;
        display: flex;
        align-items: center;
        width: 9em;
        justify-content: space-between;
        margin: 0 1em;
    }

    .attachment:hover{
        color:black;
        text-decoration: none;
    }

    .attachment-title{
        max-width: 6em;
    }
</style>
