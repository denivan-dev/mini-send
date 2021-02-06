<template>
        <router-link
            class="activity-item"
            :to="/email/ + activityData.email_id">
            <div class="col-4  col-md-1  order-md-1">
                <span
                    class="activity-status"
                    :style="eventStyles[activityData.event]"
                >{{ activityData.event }}</span>
            </div>
            <div class="col-8  col-md-3  order-md-5">{{ activityData.created_at }}</div>
            <div class="col-12 col-md-2  order-md-2">{{ activityData.sender }}</div>
            <div class="col-12 col-md-2  order-md-3">{{ activityData.recipient }}</div>
            <div class="col-12 col-md-4  order-md-4">{{ activityData.subject }}</div>
        </router-link>
</template>

<script>
    export default {
        data: () =>({
            eventStyles: {
                posted: "color: #6161d5;background:#eaecf9",
                sent  : "color: #70b5b2;background:#eaecf9",
                failed: "color: #6161d5;background:#e6f5f4",
            }
        }),

        props: [
            'activityData'
        ]
    }
</script>
<style>
    .activity-item{
        border-bottom: 1px solid #c3c3c3;
        margin: 2px;
        padding: 1em;
        color: #000000;
        transition-duration: .3s;
    }

    .activity-item:hover{
        background: #e6e6e6;
        cursor: pointer;
        text-decoration: none;
        color: #000000;
    }

    .activity-status{
        padding: 3px;
    }
</style>
