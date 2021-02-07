<template>
     <ul>
         <li><router-link to="/">ACTIVITY</router-link></li>
         <li><router-link to="/api-test">API TEST</router-link></li>
     </ul>
</template>

<style scoped>
    li{
        list-style: none;
    }

    a{
        font-size: 1.3em;
        padding: .3em 1em;
        color: #000000;
        display: block;
        transition: .3s;
    }

    a:hover{
        text-decoration: none;
        background: #f5f4f4;
        padding-left: 1.3em;
    }

    ul{
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100vh;
        padding: 0;
    }
</style>
