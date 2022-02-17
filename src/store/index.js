import { reactive } from 'vue'
import axios from 'axios'

const instance = axios.create({
    baseURL: 'http://localhost/api',
})

const store = {
    state: reactive({
        user: null,
    }),
    actions: {
        login: (data) =>
            new Promise((resolve, reject) => {
                instance
                    .post('/login', data)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error))
            }),
        register: (data) =>
            new Promise((resolve, reject) => {
                instance
                    .post('/register', data)
                    .then((response) => resolve(response))
                    .catch((error) => reject(error))
            }),
    },
}

export default store
