import { createApp } from 'vue'
import App from './App.vue'
import './index.css'
import router from './router'
import 'flowbite';

const app = createApp(App);
app.config.globalProperties.$api = 'http://127.0.0.1:8000';

router.beforeEach((to, from, next) => {
    let middlewares;

    if ((middlewares = to.meta.middleware)) {
        middlewares.map(middleware => {

            if (!middleware()) {
                next('/login');
            }
        }
        );
    }
    next();
})

app.use(router)
    .mount('#app')

