import { createApp } from 'vue'
import router from './router'
import App from './App.vue'
import WaveUI from 'wave-ui'
import 'wave-ui/dist/wave-ui.css'
import '@mdi/font/css/materialdesignicons.min.css'

const app = createApp(App).use(router)
new WaveUI(app)
app.mount('#app')
