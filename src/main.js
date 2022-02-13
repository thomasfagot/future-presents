import { createApp } from 'vue'
import App from './App.vue'

import BalmUI from 'balm-ui'
import BalmUIPlus from 'balm-ui/src/scripts/balm-ui-plus'
import 'balm-ui-css'

createApp(App).use(BalmUI).use(BalmUIPlus).mount('#app')
