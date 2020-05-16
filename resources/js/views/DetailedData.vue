<template>
    
        <div class="details">
            
            <div style="margin-top:5%; margin-left:10%; margin-right:10%;" >
                <div class="row">
                    <div class="col-md-12 text-center" id="user-welcome">
                        <h1>More Details</h1>
                        <hr>
                    </div>
                    
                </div>
                <div v-if="loaded" class="row">
                    <div class="col-md-6 text-center">
                            <h3>Melanopic lux vs Time</h3>
                            <LineChart v-if="loaded" :data="melanopic" :labelName="melGrpName" :styles="styles"/>
                    </div>
                    <div class="col-md-6 text-center">
                            <h3>Photopic lux vs Time</h3>
                            <LineChart v-if="loaded" :data="photopic" :labelName="phoGrphName" :styles="styles"/>
                    </div>
                    <div class="col-md-6 text-center">
                            <h3>L-cone lux vs Time</h3>
                            <LineChart v-if="loaded" :data="lCone" :labelName="lGrphName" :styles="styles"/>
                    </div>
                    <div class="col-md-6 text-center">
                            <h3>M-cone lux vs Time</h3>
                            <LineChart v-if="loaded" :data="mCone" :labelName="mGrphName" :styles="styles"/>
                    </div>
                    <div class="col-md-6 text-center">
                            <h3>S-cone lux vs Time</h3>
                            <LineChart v-if="loaded" :data="sCone" :labelName="sGrphName" :styles="styles"/>
                    </div>
                    <div class="col-md-6 text-center">
                            <h3>Rhodopic lux vs Time</h3>
                            <LineChart v-if="loaded" :data="rhodopic" :labelName="rhoGphName" :styles="styles"/>
                    </div>
                    <div class="col-md-6 text-center">
                            <h3>Activity vs Time</h3>
                            <LineChart v-if="loaded" :data="activity" :labelName="actGrpName" :styles="styles"/>
                    </div>
                    <div class="col-md-6 text-center">
                        <h3>Temperature vs Time</h3>
                        <LineChart v-if="loaded" :data="temperature" :labelName="tempGrphName" :styles="styles"/>
                    </div>
                </div>
                <div v-else>
                    <div class="text-center">
                        <h3>Loading...</h3>
                    </div>
                </div>
                
               
            </div>
            
        </div>
    
</template>
<script>

import axios from 'axios'
import LineChart from '../components/LineChart';

    export default {
        components: {
            LineChart,
        },
        beforeCreate: function() {
        document.body.className = 'home';
    },
        data(){
           return{
               results :[],
               tempGrphName: "Temperature Data",
               actGrpName : "Activity Data",
               melGrpName : "Melanopic Data",
               phoGrphName: "Photopic Data",
               lGrphName: "L-cone Data",
               sGrphName: "M-cone Data",
               mGrphName: "S-cone Data",
               rhoGphName: "Rhodopic Data",
                temperature: null,
                activity: null,
                melanopic: null,
                rhodopic: null,
                photopic: null,
                lCone: null,
                mCone: null,
                sCone: null,
                loaded: false,
                 styles: {
                    width: "650px",
                    height: "400px",
                    position: "relative"
                }
           }
        },

        methods:{
	
        },
        computed:{
        currentUser(){
            return this.$store.getters.currentUser;
        },
        
    },
    created(){
         axios.get('sanctum/csrf-cookie').then(()=>{
                    axios.get(`/api/load-results-details/${this.$route.params.filename}`).then((response)=>{
                         
                         if (response.status == 200){
                            this.results = response.data.detailedData;
                            console.log(response.data.detailedData[0])
                            var objects = [];
                            var activity =[];
                            var melanopic =[];
                            var rhodopic =[];
                            var photopic =[];
                            var sCone =[];
                            var lCone =[];
                            var mCone =[];
                            var i = 0;
                            response.data.detailedData[0].forEach(element => {
                                console.log(element)
                                objects[i] = {
                                    date: element,
                                    views: response.data.detailedData[1][i],
                                };
                                activity[i] = {
                                    date:element,
                                    views: response.data.detailedData[2][i],
                                };
                                melanopic[i] = {
                                    date:element,
                                    views: response.data.detailedData[4][i],
                                };
                                photopic[i] = {
                                    date:element,
                                    views: response.data.detailedData[3][i],
                                };
                                lCone[i] = {
                                    date:element,
                                    views: response.data.detailedData[5][i],
                                };
                                mCone[i] = {
                                    date:element,
                                    views: response.data.detailedData[6][i],
                                };
                                sCone[i] = {
                                    date:element,
                                    views: response.data.detailedData[7][i],
                                };
                                rhodopic[i] = {
                                    date:element,
                                    views: response.data.detailedData[8][i],
                                };
                                i++;
                            });
                            this.temperature = objects;
                            this.activity = activity;
                            this.melanopic = melanopic;
                            this.photopic = photopic;
                            this.rhodopic = rhodopic;
                            this.lCone = lCone;
                            this.mCone = mCone;
                            this.sCone =sCone;
                        
                            // this.temperature = [
                            //     { "date": "17:2:22 20/5/7", "views": 1 },
                            //     { "date": "17:2:22 20/5/7", "views": 2 },
                            // ];
                            this.loaded = true;
                            // for (var x = 0; x < 100; x++) {
                            // objects[x] = {name: etc};
                            // }
                         }
                        })
                    .catch((error) => {
                        console.log(error)
                    });
                }); 
        //console.log("test");
        //console.log(this.$route.params.filename);
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
