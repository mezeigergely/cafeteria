import './bootstrap'
import { createApp } from 'vue'
import form from './components/Form.vue'

const app = createApp({})
app.component('form-comp', form)
app.mount('#app')
