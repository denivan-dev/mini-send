<template>
    <div>
        <div class="email-header">
            <div class="email-header__from">
                From: {{ email.sender_name }} &lt;{{ email.sender_email }}&gt;
            </div>
            <div>
                {{ email.created_at }}
            </div>
        </div>
        <div>To: {{ email.recipient }}</div>
        <div>Subject: {{ email.subject }}</div>
        <div v-html="email.content" class="email-content"></div>
        <pre style="padding: 5em;">{{ email }}</pre>
    </div>
</template>


<script>
    import axios from 'axios'

    export default {
        data: () => ({
            email: {}
        }),

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

    .email-header{
        display: flex;
        justify-content: space-between;
    }
</style>
