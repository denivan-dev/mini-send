<template>
    <div class="container">
        <div class="row">
            <SideBar class="col-md-2"></SideBar>
            <router-view class="col-md-10 container content"></router-view>
        </div>
    </div>
</template>

<script>
    import SideBar from './SideBar'

    export default {
        name: 'App',
        components: {
            SideBar
        }
    }
</script>
