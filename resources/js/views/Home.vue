<template>
    
        <div class="welcome">
            
            <div style="margin-top:5%; margin-left:10%; margin-right:10%;" >
                <div class="row">
                    <div class="col-md-12 text-center" id="user-welcome">
                        <h1>Welcome {{currentUser['name']}}!</h1>
                        <h3>Here's your data</h3>
                        <hr>
                    </div>
                </div>
                <div class="container">
                    <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Device Name</th>
                            <th>Date</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                            <template v-for="(result,key) in results" >  
                                <tr>
                                    <td >{{result.device_name}}</td>
                                    <td >{{result.date_time}}</td>
                                    <td >{{result.filename}}</td>
                                </tr>

                            </template>
                        </tbody>

                    </table>
                </div>
            </div>
            
        </div>
    
</template>
<script>

import axios from 'axios'


    export default {
        beforeCreate: function() {
        document.body.className = 'home';
    },
        data(){
           return{
               results :[],
           }
        },

        methods:{
    },
        computed:{
        currentUser(){
            return this.$store.getters.currentUser;
        },
        
    },
    mounted(){
        axios.get('sanctum/csrf-cookie').then(()=>{
                    axios.get(`/api/load-results/${this.currentUser['id']}`).then((response)=>{
                         
                         if (response.status == 200){
                            this.results = response.data.results;
                         }
                        })
                    .catch((error) => {
                        console.log(error)
                    });
                }); 
    }
    }
</script>

<style lang="scss">
    body.home { 
        width: 100%;
        height:100%;
        font-family: 'Open Sans', sans-serif;
        background: #dae4f5;
    }
    #user-welcome{

    }

</style>