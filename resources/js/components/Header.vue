<template>
    <div class="header">
        <div class="col-md-9">
            <slot></slot>
        </div>
        <div  class="col-md-3 header-title"><span>MiniSend</span></div>
    </div>
</template>

<style>
    .header{
        position: sticky;
        padding: 1em;
        width: 100%;
        top: 0;
        z-index: 1000;
        margin: 0;
        color: #000000;
        border-radius: 5px;
        background: #f8fafc;
    }

    .header-title{
        text-align: right;
        font-size: 2em;
        font-family: 'Times New Roman', sans-serif;
        letter-spacing: 1px;
        padding: .1em 1em;
    }
</style>
