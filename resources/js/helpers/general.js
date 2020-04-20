
export function initialize(store, router){


    router.beforeEach((to, from, next) => {
    
        const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
       
        const userLoggedin = store.state.auth.userLoggedin;
        
        if (requiresAuth && !userLoggedin){
            next('/');
        }else{
            next();
        }
    }); 
    
    
    
    }