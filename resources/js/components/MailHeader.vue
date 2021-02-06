<template>
    <div class="email-header__wrapper">
        <div class="email-header">
            <div class="email-header__from">
                From: {{ mail.sender_name }} &lt;{{ mail.sender_email }}&gt;
            </div>
            <div>
                {{ currentStatus.status }} at: {{ currentStatus.created_at }}
            </div>
        </div>

        <slot></slot>

        <div>Subject: {{ mail.subject }}</div>
    </div>
</template>

<script>
    export default {
        props: ['mail', 'currentStatus']
    }
</script>

<style>
    .email-header{
        display: flex;
        justify-content: space-between;
    }

    .email-header__wrapper{
        border-bottom: 1px solid #c3c3c3;
        padding-bottom: 5px;
    }
</style>
