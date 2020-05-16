<template>
    
        <div class="welcome">
            
            <div style="margin-top:5%; margin-left:10%; margin-right:10%;" >
                <div class="row">
                    <div class="col-md-12 text-center" id="user-welcome">
                        <h1>Welcome {{currentUser['name']}}!</h1>
                        
                    </div>
                </div>
                <div v-if="loading">
                    <div class="col-md-12 text-center" id="user-welcome">
                        <h3>Here's your data</h3>
                        <hr>
                    </div>
                    <div class="text-center" v-if="isEmpty">
                        <h3>Looks like you havn't uploaded any data yet!</h3>
                    </div>
                    <div v-else class="container">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No.</th>
                                    <th>Device Name</th>
                                    <th>Date</th>
                                    <th colspan="3" >Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <template v-for="(result,key) in results" >  
                                        <tr>
                                            <td>{{key}}</td>
                                            <td >{{result.device_name}}</td>
                                            <td >{{result.date_time}}</td>
                                            <!-- <td><a :href="'http://localhost:8000/api/downloadFile/'+result.filename" class="btn btn-outline-secondary btn-block" role="button">Download Raw</a></td> -->
                                            <td><a :href="'/api/downloadFile/'+result.filename" class="btn btn-outline-secondary btn-block" role="button">Download Raw</a></td>
                                            <td><a :href="'/api/downloadFile/'+result.filename+'_reconstructed'" class="btn btn-outline-secondary btn-block" role="button">Download full</a></td>
                                            <!-- <td><button class="btn btn-outline-secondary" @click="detailedData">Details</button></td> -->
                                            <td><router-link class="btn btn-outline-secondary btn-block" :to="`/detailed-data/${result.filename}_reconstructed`">Details</router-link></td>
                                        </tr>

                                    </template>
                            </tbody>

                        </table>
                    </div>
                </div>

                <div v-else>
                    <div class="text-center" v-if="isEmpty">
                        <h3>Looking for your data...</h3>
                    </div>
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
               loading : false,
               baseUrl : process.env.APP_URL,
           }
        },

        methods:{
	downloadFile(filename){
		//console.log(`/api/downloadFiles/${filename}`)
		 axios.get('sanctum/csrf-cookie').then(()=>{
                    axios.get(`/api/downloadFiles/${filename}`,{
			responseType: 'blob'
			}
			).then((response)=>{
			//console.log(response.data)
                         var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                 var fileLink = document.createElement('a');
                 fileLink.href = fileURL;
                    fileLink.setAttribute('download', filename+'.csv');
                    document.body.appendChild(fileLink);
                    fileLink.click();
                         
                        })
                    .catch((error) => {
                        console.log(error)
                        
                    });
                }); 
    },
    detailedData(){
       this.$router.push({ name: 'detailed-data' }).catch(err => {});
    },
    },
        computed:{
        currentUser(){
            return this.$store.getters.currentUser;
        },
	isEmpty(){
		return this.results.length == 0;
	}
        
    },
    mounted(){
        
        axios.get('sanctum/csrf-cookie').then(()=>{
                    axios.get(`/api/load-results/${this.currentUser['id']}`).then((response)=>{
                         
                         if (response.status == 200){
                            this.results = response.data.results;
                            this.loading = true;
                         }
                        })
                    .catch((error) => {
                        console.log(error)
                        this.loading = true;
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
