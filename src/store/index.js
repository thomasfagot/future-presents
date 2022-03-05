import { computed, reactive, readonly } from 'vue'
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
        eventCollection: [],
    },
}

const state = reactive({
    isLoading: false,
    user: emptyUser,
    networks: [],
    events: [],
    currentNetwork: null,
    currentEvent: null,
})

const isAuthenticated = computed(() => !!state.user.id)

const mutations = {
    setUser(user) {
        state.user = user
        state.networks = user.person.networkCollection
        state.currentNetwork = user.person.networkCollection.find((n) => !!n)
        state.events = state.currentNetwork
            ? state.currentNetwork.eventCollection
            : []
        state.currentEvent = state.events ? state.events.find((e) => !!e) : null
    },
    setLoading(value) {
        state.isLoading = value
    },
    addNetwork(data) {
        state.networks.push(data)
        state.currentNetwork = data
    },
    editNetwork(data) {
        state.networks.splice(
            state.networks.findIndex((n) => n.id === state.currentNetwork.id),
            1,
            data
        )
        state.currentNetwork = data
    },
    addEvent(data) {
        state.events.push(data)
        state.currentEvent = data
    },
}

const actions = {
    login: (data) =>
        new Promise((resolve, reject) => {
            instance.post('/login', data).then(
                (response) => resolve(response),
                (error) => reject(error)
            )
        }),
    register: (data) =>
        new Promise((resolve, reject) => {
            instance.post('/register', data).then(
                (response) => resolve(response),
                (error) => reject(error)
            )
        }),
    logout: () =>
        new Promise((resolve, reject) => {
            instance.get('/logout').then(
                (response) => {
                    mutations.setUser(emptyUser)
                    resolve(response)
                },
                (error) => reject(error)
            )
        }),
    getUser: () =>
        new Promise((resolve, reject) => {
            instance.get('/users/me').then(
                (response) => resolve(response),
                (error) => reject(error)
            )
        }),
    addNetwork: (data) =>
        new Promise((resolve, reject) => {
            instance.post('/networks', data).then(
                (response) => resolve(response),
                (error) => reject(error)
            )
        }),
    editNetwork: (data) =>
        new Promise((resolve, reject) => {
            instance.put('/networks/' + state.currentNetwork.id, data).then(
                (response) => resolve(response),
                (error) => reject(error)
            )
        }),
    addEvent: (data) =>
        new Promise((resolve, reject) => {
            instance.post('/events', data).then(
                (response) => resolve(response),
                (error) => reject(error)
            )
        }),
}

export default {
    state: readonly(state),
    actions,
    mutations,
    isAuthenticated,
}
