<template>
    <div>
        <div class="form-wrapper">
            <div class="data-container">
                <div class="data-container__item">
                    <div>REQUEST DATA:</div>
                    <pre>{{ requestData }}</pre>
                </div>
                <div class="data-container__item">
                    <div>RESPONSE DATA:</div>
                    <pre>{{ responseData }}</pre>
                </div>
            </div>
            <input type="text" v-model="requestData.to.email" placeholder="recipient email">
            <input type="text" v-model="requestData.from.email" placeholder="sender email">
            <input type="text" v-model="requestData.from.name" placeholder="sender name">
            <input type="text" v-model="requestData.subject" placeholder="subject">
            <textarea
                v-model="requestData.content"
                placeholder="message"></textarea>

            <div class="buttons-container">
                <div class="button" @click="postMail()">SEND</div>
                <div class="button">
                    <input
                        multiple="multiple"
                        type="file"
                        @change="filesAttached"
                        class="attachments-button-real">ATTACH FILES
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import axios from 'axios'

    export default {
        data: () => ({
            requestData: {
                to: {
                    email: ''
                },

                from: {
                    email: '',
                    name: ''
                },

                subject: '',
                content: '',
                attachments: []
            },

            responseData: {},

            attachments: []
        }),

        methods: {
            postMail(){
                this.responseData = {};
                let requestData = this.composeData();

                axios.post('/api/emails', requestData)
                    .then(response => this.responseData = response.data)
                    .catch(error => this.responseData = error.response.data)
            },

            composeData(){
                let requestData = Object.assign({}, this.requestData);

                if(!requestData.from.name && !requestData.from.email)
                    requestData.from = null;

                requestData.attachments = this.attachments;

                return requestData
            },

            async filesAttached(event){
                const files = event.target.files;

                this.attachments = [];
                this.requestData.attachments = [];

                for(let file of files){
                    let content = await this.toBase64(file).catch(e => Error(e));

                    if(content instanceof Error) {
                        break;
                    }

                    let filename = file.name;

                    content = content.replace(/^data:image\/[a-z]+;base64,/, "");

                    this.attachments.push({filename, content});

                    content = `${content.substr(0, 30)}...`;
                    this.requestData.attachments.push({filename, content});
                }
            },

            toBase64(file){
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = error => reject(error);
                });
            }
        }
    }
</script>

<style scoped>
    .form-wrapper{
        max-width: 700px;
        margin: 0 auto 10em auto;
    }

    .buttons-container{
        display: flex;
        justify-content: space-between;
    }

    input:focus{
        border-bottom-color: #6c66ee;
        color: #6c66ee;
    }

    textarea {
        font-family: inherit;
        width: 100%;
        border: 0;
        border-bottom: 1px solid #d2d2d2;
        outline: 0;
        padding: 7px 20px;
        background: transparent;
        transition: border-color 0.2s;
        height: 8em;
    }

    textarea:focus{
        transition: 0.2s;
        border-bottom-color: #6c66ee;
        color: #6c66ee;
    }

    .button{
        border: 1px solid black;
        padding: .7em;
        width: 10em;
        text-align: center;
        transition: .2s;
        position: relative;
        overflow: hidden;
    }

    .button:hover{
        border-color: #6c66ee;
        background-color: #6c66ee;
        color: white;
    }

    .attachments-button-real{
        position: absolute;
        left: 0;
        top: 0;
        height: 200px;
        width: 1000px;
        opacity: 0;
        cursor: pointer;
    }

    .data-container{
        display: flex;
    }

    .data-container__item{
        width: 50%;
    }
</style>
