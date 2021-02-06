<template>
     <ul>
         <li><router-link to="/">ACTIVITIES LIST</router-link></li>
         <li><router-link to="/api-test">API TEST</router-link></li>
     </ul>
</template>

<style scoped>
    li{
        list-style: none;
    }

    a{
        font-size: 1.3em;
        padding: .3em 0;
        color: #000000;
        display: block;
    }

    a:hover{
        text-decoration: none;
        background: #f5f4f4;
    }

    ul{
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100vh;
        padding: 0;
    }
</style>
