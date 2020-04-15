<template>
    
        <div class="login">
            
            <h1>Gamma Sensor</h1>
            <h2>Login Page</h2>
            <form @submit.prevent="authenticate" method="post">
                <input type="text" name="login" placeholder="E-mail" required="required" v-model="form.email"/>
                <input type="password" name="password" placeholder="Password" required="required" v-model="form.password" />
                <button type="submit" class="btn btn-primary btn-block btn-large">Let me in</button>

            </form>
        </div>
    
</template>
<script>

import axios from 'axios'


    export default {
        data(){
            return {
                form: {
                    email: '',
                    password: '',
                }
            }
        },

        methods:{
            async authenticate () {
                this.$store.dispatch('userLogin', {
                    email: this.form.email,
                    password: this.form.password,
                });
               

            }
        }
    }
</script>
