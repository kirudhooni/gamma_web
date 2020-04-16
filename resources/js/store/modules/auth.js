


const state = {
    users : [
        {
            email : 'anaspltx@gmail.com',
            password : 'test',
        },

    ]
};

const getters = {
    allUsers: (state) => state.users
};

const actions = {
    userLogin: ({commit}, payload) => {
        return new Promise((success, error) => {
                console.log(payload)
                axios.get('sanctum/csrf-cookie').then(()=>{
                    axios.post('login', {
                    email: payload.email,
                    password: payload.password
                    }).then(()=>{ console.log("logged in successfuly")})
                    .catch((error) => {
                        console.log(error)
                    });
                });   
            
        })
    }
};

const mutations = {};

export default {
    state,
    getters,
    actions,
    mutations,
}