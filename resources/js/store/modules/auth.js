


const state = {
    currentUser : '',
    userLoggedin : false,

};

const getters = {
    //currentUser: (state) => state.currentUser,
    userLoggedin: (state) => state.userLoggedin,
    currentUser: (state) => state.currentUser,
};

const actions = {
    // userLogin: ({commit}, payload) => {
    //     return new Promise((success, error) => {
    //             console.log(payload)
    //             axios.get('sanctum/csrf-cookie').then(()=>{
    //                 axios.post('/api/login', {
    //                 email: payload.email,
    //                 password: payload.password
    //                 }).then((response)=>{
    //                      console.log("logged in successfuly");
                         
    //                      console.log(response.data['name']);
                         
                         
    //                     })
    //                 .catch((error) => {
    //                     console.log(error)
    //                 });
    //             });   
            
    //     })
    // }
};

const mutations = {
 userLogin (state){
     state.userLoggedin = true;
 },
 updateUserInfo(state, payload){
     state.currentUser = payload;
    //console.log(state.currentUser);
 }
};

export default {
    state,
    getters,
    actions,
    mutations,
}