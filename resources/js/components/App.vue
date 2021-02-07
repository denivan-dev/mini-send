<template>
    <div class="container-lg">
        <div class="row">
            <SideBar class="col-2"></SideBar>
            <router-view class="col-10 container content"></router-view>
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
