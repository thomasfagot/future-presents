import { reactive, readonly } from 'vue'
import axios from 'axios'

const instance = axios.create({
    baseURL: 'http://localhost/api',
    withCredentials: true,
})
instance.interceptors.request.use(
    function (config) {
        mutations.setLoading(true)
        return config
    },
    function (error) {
        mutations.setLoading(false)
        return Promise.reject(error)
    }
)

// Add a response interceptor
instance.interceptors.response.use(
    function (response) {
        mutations.setLoading(false)
        return response
    },
    function (error) {
        mutations.setLoading(false)
        return Promise.reject(error)
    }
)

const emptyUser = {
    id: null,
    email: null,
    userIdentifier: null,
    person: {
        firstname: null,
        lastname: null,
        dateOfBirth: null,
        avatar: null,
        networkCollection: [],
        wishCollection: [],
        reservationCollection: [],
    },
}

const state = reactive({
    user: emptyUser,
    isLoading: false,
    currentNetwork: null,
    currentEvent: null,
})

const mutations = {
    setUser(user) {
        state.user = user
    },
    setLoading(value) {
        state.isLoading = value
    },
}

const actions = {
    login: (data) =>
        new Promise((resolve, reject) => {
            instance
                .post('/login', data)
                .then(
                    (response) => resolve(response),
                    (error) => reject(error)
                )
                .catch((error) => reject(error))
        }),
    register: (data) =>
        new Promise((resolve, reject) => {
            instance
                .post('/register', data)
                .then(
                    (response) => resolve(response),
                    (error) => reject(error)
                )
                .catch((error) => reject(error))
        }),
    getUser: () =>
        new Promise((resolve, reject) => {
            instance.get('/users/me').then(
                (response) => resolve(response),
                (error) => reject(error)
            )
        }),
}

export default { state: readonly(state), actions, mutations }
